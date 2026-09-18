<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\Attendance;
use App\Models\AttendanceAudit;
use App\Models\AttendanceLock;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Period;
use Carbon\Carbon;
use Livewire\Component;

class AttendanceEntry extends Component
{
    public $gradeId;
    public $academicYearId;
    public $periodId;
    public $subjectId;
    public $date;
    public $search = '';

    public $enrollments = [];
    public $marks = [];

    public $allGrades = [];
    public $allAcademicYears = [];
    public $allPeriods = [];
    public $allSubjects = [];
    public $isLocked = false;
    public $lastSaved = null;

    public function mount()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $this->allAcademicYears = AcademicYear::where('school_id', $schoolId)->ordered()->get();
        $activeYear = $this->allAcademicYears->firstWhere('is_active', true) ?? $this->allAcademicYears->first();
        $this->academicYearId = $activeYear?->id;

        $this->allGrades = $user->hasRole('Teacher')
            ? $user->teacherGrades()->orderBy('grades.level')->get()
            : Grade::orderBy('level')->get();

        $this->allPeriods = Period::where('school_id', $schoolId)->orderBy('sort_order')->get();

        $this->gradeId = $this->allGrades->first()?->id;
        $this->periodId = $this->allPeriods->first()?->id;
        $this->date = now()->toDateString();

        $this->loadSubjects();
        $this->loadRoster();
    }

    public function updatedGradeId()
    {
        $this->loadSubjects();
        $this->loadRoster();
    }
    public function updatedAcademicYearId()
    {
        $this->loadRoster();
    }
    public function updatedDate()
    {
        $this->loadRoster();
    }
    public function updatedPeriodId()
    {
        $this->loadRoster();
    }
    public function updatedSubjectId()
    {
        $this->loadRoster();
    }

    public function loadSubjects()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        if (! $this->gradeId) {
            $this->allSubjects = collect();
            return;
        }

        $grade = Grade::find($this->gradeId);
        $level = Grade::resolveLevel($grade->level);

        $query = AcademicSubject::where('school_id', $schoolId)->where('level', $level);

        if ($user->hasRole('Teacher')) {
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            $query->whereIn('id', $allowedSubjectIds);
        }

        $this->allSubjects = $query->orderBy('name')->get();
        $this->subjectId = $this->allSubjects->first()?->id;
    }

    public function loadRoster()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        if (! $this->gradeId || ! $this->academicYearId || ! $this->periodId || ! $this->subjectId) {
            $this->enrollments = collect();
            return;
        }

        // Hard backend guard — Teacher must be assigned to BOTH the
        // grade and the subject, not just one.
        if ($user->hasRole('Teacher')) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();

            if (! in_array((int) $this->gradeId, $allowedGradeIds)) {
                abort(403, 'You are not assigned to this grade.');
            }
            if (! in_array((int) $this->subjectId, $allowedSubjectIds)) {
                abort(403, 'You are not assigned to this subject.');
            }
        }

        $this->enrollments = Enrollment::where('school_id', $schoolId)
            ->where('grade_id', $this->gradeId)
            ->where('academic_year_id', $this->academicYearId)
            ->with('student')
            ->get();

        $existing = Attendance::where('school_id', $schoolId)
            ->where('date', $this->date)
            ->where('period_id', $this->periodId)
            ->where('academic_subject_id', $this->subjectId)
            ->whereIn('enrollment_id', $this->enrollments->pluck('id'))
            ->get()
            ->keyBy('enrollment_id');

        $this->marks = [];
        foreach ($this->enrollments as $enrollment) {
            $record = $existing->get($enrollment->id);
            $this->marks[$enrollment->id] = [
                'status' => $record?->status,
                'remarks' => $record?->remarks ?? '',
            ];
        }

        $this->isLocked = AttendanceLock::isDateLocked(
            $schoolId,
            (int) $this->academicYearId,
            (int) $this->gradeId,
            Carbon::parse($this->date),
            null
        );

        $first = $existing->first();
        $this->lastSaved = $first?->markedBy
            ? ['name' => $first->markedBy->name, 'time' => $first->updated_at->format('g:i A')]
            : null;
    }

    public function mark($enrollmentId, $status)
    {
        if ($this->isLocked) return;
        $this->marks[$enrollmentId]['status'] = $status;
        if (! in_array($status, ['absent', 'late'])) {
            $this->marks[$enrollmentId]['remarks'] = '';
        }
    }

    public function markAllPresent()
    {
        if ($this->isLocked) return;
        foreach ($this->enrollments as $enrollment) {
            $this->marks[$enrollment->id]['status'] = 'present';
            $this->marks[$enrollment->id]['remarks'] = '';
        }
    }

    public function save()
    {
        $this->authorize('mark attendance');

        if ($this->isLocked) {
            $this->dispatch('notify', message: 'This date is locked. Contact your administrator.', type: 'error');
            return;
        }

        $schoolId = auth()->user()->school_id;
        $performedBy = auth()->id();

        foreach ($this->marks as $enrollmentId => $data) {
            if (empty($data['status'])) continue;

            $existing = Attendance::where('enrollment_id', $enrollmentId)
                ->where('date', $this->date)
                ->where('period_id', $this->periodId)
                ->where('academic_subject_id', $this->subjectId)
                ->first();

            $before = $existing ? ['status' => $existing->status, 'remarks' => $existing->remarks] : null;

            $attendance = Attendance::updateOrCreate(
                [
                    'enrollment_id' => $enrollmentId,
                    'date' => $this->date,
                    'period_id' => $this->periodId,
                    'academic_subject_id' => $this->subjectId,
                ],
                [
                    'school_id' => $schoolId,
                    'status' => $data['status'],
                    'remarks' => $data['remarks'] ?: null,
                    'marked_by' => $performedBy,
                ]
            );

            $after = ['status' => $attendance->status, 'remarks' => $attendance->remarks];

            if ($before !== $after) {
                AttendanceAudit::record(
                    $schoolId,
                    $attendance->id,
                    (int) $enrollmentId,
                    (int) $this->periodId,
                    (int) $this->subjectId,
                    $this->date,
                    $before === null ? 'created' : 'updated',
                    ['status' => [$before['status'] ?? null, $after['status']], 'remarks' => [$before['remarks'] ?? null, $after['remarks']]],
                    $performedBy
                );
            }
        }

        $this->loadRoster();
        $this->dispatch('notify', message: 'Attendance saved successfully 🎉', type: 'success');
    }

    public function getFilteredEnrollmentsProperty()
    {
        if (! $this->search) return $this->enrollments;
        return $this->enrollments->filter(fn($e) => str_contains(strtolower($e->student->name), strtolower($this->search)));
    }

    public function getCountsProperty()
    {
        $counts = ['present' => 0, 'absent' => 0, 'late' => 0, 'unmarked' => 0];
        foreach ($this->marks as $m) {
            $status = $m['status'] ?? null;
            if ($status && isset($counts[$status])) $counts[$status]++;
            elseif (! $status) $counts['unmarked']++;
        }
        return $counts;
    }

    public function render()
    {
        return view('livewire.admin.attendance.attendance-entry');
    }
}
