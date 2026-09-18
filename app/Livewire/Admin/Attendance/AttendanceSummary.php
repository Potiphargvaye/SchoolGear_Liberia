<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Period;
use Livewire\Component;

class AttendanceSummary extends Component
{
    public $academicYearId;
    public $gradeId = '';
    public $subjectId = '';
    public $periodId = '';
    public $dateFrom;
    public $dateTo;

    public $allAcademicYears = [];
    public $allGrades = [];
    public $allSubjects = [];
    public $allPeriods = [];

    public function mount()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $this->allAcademicYears = AcademicYear::where('school_id', $schoolId)->ordered()->get();
        $active = $this->allAcademicYears->firstWhere('is_active', true) ?? $this->allAcademicYears->first();
        $this->academicYearId = $active?->id;

        $this->allGrades = $user->hasRole('Teacher')
            ? $user->teacherGrades()->orderBy('grades.level')->get()
            : Grade::orderBy('level')->get();

        $this->allPeriods = Period::where('school_id', $schoolId)->orderBy('sort_order')->get();

        $this->loadSubjects();

        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
    }

    public function updatedGradeId()
    {
        $this->loadSubjects();
    }

    /**
     * Subjects are scoped to the selected Grade's level bucket
     * (kindergarten/elementary/junior/senior) via Grade::resolveLevel()
     * — the same source of truth Grade Entry and Attendance Entry use.
     * "All Grades" shows the union of levels across every grade the
     * user can actually see (already Teacher-scoped via $allGrades).
     */
    public function loadSubjects()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        if ($this->gradeId) {
            $grade = Grade::find($this->gradeId);
            $levels = $grade ? [Grade::resolveLevel($grade->level)] : [];
        } else {
            $levels = $this->allGrades
                ->map(fn($g) => Grade::resolveLevel($g->level))
                ->unique()
                ->values()
                ->toArray();
        }

        $query = AcademicSubject::where('school_id', $schoolId)->whereIn('level', $levels);

        if ($user->hasRole('Teacher')) {
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            $query->whereIn('id', $allowedSubjectIds);
        }

        $this->allSubjects = $query->orderBy('name')->get();

        // Previously selected subject may no longer belong to the new
        // grade's level bucket — drop it rather than silently querying
        // a subject the dropdown no longer even offers.
        if ($this->subjectId && ! $this->allSubjects->contains('id', $this->subjectId)) {
            $this->subjectId = '';
        }
    }

    public function resetFilters()
    {
        $this->gradeId = '';
        $this->subjectId = '';
        $this->periodId = '';
        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
        $this->loadSubjects();
    }

    public function render()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $gradeIds = $this->gradeId ? [$this->gradeId] : $this->allGrades->pluck('id');

        $enrollmentIds = Enrollment::where('school_id', $schoolId)
            ->whereIn('grade_id', $gradeIds)
            ->where('academic_year_id', $this->academicYearId)
            ->pluck('id');

        $query = Attendance::where('school_id', $schoolId)
            ->whereIn('enrollment_id', $enrollmentIds)
            ->whereBetween('date', [$this->dateFrom, $this->dateTo]);

        if ($this->subjectId) {
            $query->where('academic_subject_id', $this->subjectId);
        }

        if ($this->periodId) {
            $query->where('period_id', $this->periodId);
        }

        $records = $query->get();

        $totalMarks = $records->count();
        $presentCount = $records->where('status', 'present')->count();
        $absentCount = $records->where('status', 'absent')->count();
        $lateCount = $records->where('status', 'late')->count();
        $presentRate = $totalMarks ? round($presentCount / $totalMarks * 100, 1) : 0;
        $absentRate = $totalMarks ? round($absentCount / $totalMarks * 100, 1) : 0;
        $lateRate = $totalMarks ? round($lateCount / $totalMarks * 100, 1) : 0;

        $trend = $records->groupBy(fn($r) => $r->date->toDateString())
            ->map(function ($dayRecords) {
                $total = $dayRecords->count();
                $present = $dayRecords->where('status', 'present')->count();
                return $total ? round($present / $total * 100, 1) : 0;
            })
            ->sortKeys();

        $riskList = $records->where('status', 'absent')
            ->groupBy('enrollment_id')
            ->map(fn($g) => $g->count())
            ->filter(fn($c) => $c >= 3)
            ->sortDesc()
            ->take(10);

        $riskEnrollments = Enrollment::whereIn('id', $riskList->keys())->with('student', 'grade')->get()->keyBy('id');

        $riskData = $riskList->map(function ($absences, $enrollmentId) use ($riskEnrollments, $records) {
            $enrollment = $riskEnrollments->get($enrollmentId);
            $enrollmentRecords = $records->where('enrollment_id', $enrollmentId);
            $total = $enrollmentRecords->count();
            $present = $enrollmentRecords->where('status', 'present')->count();
            $late = $enrollmentRecords->where('status', 'late')->count();

            return [
                'name' => $enrollment?->student?->name ?? 'Unknown',
                'grade' => $enrollment ? ($enrollment->grade->level . ($enrollment->grade->section ? ' - ' . $enrollment->grade->section : '')) : '',
                'absences' => $absences,
                'late' => $late,
                'rate' => $total ? round($present / $total * 100) : 0,
                'enrollment_id' => $enrollmentId,
            ];
        })->values();

        return view('livewire.admin.attendance.attendance-summary', [
            'totalStudents' => $enrollmentIds->count(),
            'presentRate' => $presentRate,
            'absentRate' => $absentRate,
            'lateRate' => $lateRate,
            'presentCount' => $presentCount,
            'absentCount' => $absentCount,
            'lateCount' => $lateCount,
            'trend' => $trend,
            'riskData' => $riskData,
        ]);
    }
}
