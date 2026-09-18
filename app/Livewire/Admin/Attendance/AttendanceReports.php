<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Period;
use Carbon\Carbon;
use Livewire\Component;
use App\Services\SchoolDocumentBranding;

class AttendanceReports extends Component
{
    public $academicYearId;
    public $gradeId;
    public $subjectId;
    public $periodId;
    public $dateFrom;
    public $dateTo;
    public $showPreview = false;

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
        $this->gradeId = $this->allGrades->first()?->id;

        $this->allPeriods = Period::where('school_id', $schoolId)->orderBy('sort_order')->get();
        $this->periodId = $this->allPeriods->first()?->id;

        $this->loadSubjects();

        $this->dateFrom = now()->startOfMonth()->toDateString();
        $this->dateTo = now()->toDateString();
    }

    public function updatedGradeId()
    {
        $this->loadSubjects();
    }

    public function loadSubjects()
    {
        $user = auth()->user();
        if (! $this->gradeId) {
            $this->allSubjects = collect();
            return;
        }

        $level = Grade::resolveLevel(Grade::find($this->gradeId)->level);
        $query = AcademicSubject::where('school_id', $user->school_id)->where('level', $level);

        if ($user->hasRole('Teacher')) {
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            $query->whereIn('id', $allowedSubjectIds);
        }

        $this->allSubjects = $query->orderBy('name')->get();
        $this->subjectId = $this->allSubjects->first()?->id;
    }

    public function generate()
    {
        $this->showPreview = true;
    }

    public function render()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;


        $data = ['allAcademicYears' => $this->allAcademicYears, 'allGrades' => $this->allGrades, 'allSubjects' => $this->allSubjects, 'allPeriods' => $this->allPeriods];

        if (! $this->showPreview || ! $this->gradeId || ! $this->subjectId || ! $this->periodId) {
            return view('livewire.admin.attendance.attendance-reports', array_merge($data, ['showPreview' => false]));
        }

        if ($user->hasRole('Teacher')) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            if (! in_array((int) $this->gradeId, $allowedGradeIds) || ! in_array((int) $this->subjectId, $allowedSubjectIds)) {
                abort(403, 'You do not have access to this grade/subject combination.');
            }
        }

        $enrollments = Enrollment::where('school_id', $schoolId)
            ->where('grade_id', $this->gradeId)
            ->where('academic_year_id', $this->academicYearId)
            ->with('student')
            ->get();

        $records = Attendance::where('school_id', $schoolId)
            ->where('period_id', $this->periodId)
            ->where('academic_subject_id', $this->subjectId)
            ->whereIn('enrollment_id', $enrollments->pluck('id'))
            ->whereBetween('date', [$this->dateFrom, $this->dateTo])
            ->get()
            ->groupBy(fn($r) => $r->enrollment_id . '-' . $r->date->toDateString());

        $dates = collect();
        $cursor = Carbon::parse($this->dateFrom);
        $end = Carbon::parse($this->dateTo);
        while ($cursor <= $end) {
            if (! $cursor->isWeekend()) $dates->push($cursor->copy());
            $cursor->addDay();
        }

        $weeks = $dates->groupBy(fn($d) => 'Week ' . $d->weekOfMonth . ' (' . $d->format('M') . ')');

        $rows = $enrollments->map(function ($enrollment) use ($records, $dates) {
            $cellStatuses = [];
            $present = $absent = $late = 0;

            foreach ($dates as $date) {
                $record = ($records->get($enrollment->id . '-' . $date->toDateString()) ?? collect())->first();
                $status = $record?->status;
                $cellStatuses[$date->toDateString()] = $status;

                if ($status === 'present') $present++;
                elseif ($status === 'absent') $absent++;
                elseif ($status === 'late') $late++;
            }

            $marked = $present + $absent + $late;

            return [
                'enrollment' => $enrollment,
                'cells' => $cellStatuses,
                'present' => $present,
                'absent' => $absent,
                'late' => $late,
                'rate' => $marked ? round($present / $marked * 100) : 0,
            ];
        });

        $branding = SchoolDocumentBranding::for($schoolId);

        return view('livewire.admin.attendance.attendance-reports', array_merge($data, [
            'showPreview' => true,
            'weeks' => $weeks,
            'rows' => $rows,
            'grade' => Grade::find($this->gradeId),
            'subject' => AcademicSubject::find($this->subjectId),
            'period' => Period::find($this->periodId),
            'academicYear' => AcademicYear::find($this->academicYearId),
            'branding' => $branding,
            'forPdf' => false,
            'documentTitle' => 'Attendance Register',
            'documentCaption' => Grade::find($this->gradeId)->level
                . (Grade::find($this->gradeId)->section ? ' - ' . Grade::find($this->gradeId)->section : '')
                . ' · ' . AcademicSubject::find($this->subjectId)->name
                . ' · ' . Period::find($this->periodId)->name,
            'documentDate' => \Carbon\Carbon::parse($this->dateFrom)->format('M d, Y') . ' – ' . \Carbon\Carbon::parse($this->dateTo)->format('M d, Y'),
        ]));
    }
}
