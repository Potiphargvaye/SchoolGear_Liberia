<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\AcademicSubject;
use App\Models\AttendanceAudit;
use App\Models\Grade;
use App\Models\Period;
use Livewire\Component;
use Livewire\WithPagination;

class AttendanceAuditTrail extends Component
{
    use WithPagination;

    public $gradeFilter = '';
    public $subjectFilter = '';
    public $periodFilter = '';
    public $actionFilter = '';
    public $dateFrom = '';
    public $dateTo = '';

    public $gradeOptions = [];
    public $subjectOptions = [];
    public $periodOptions = [];

    public function mount()
    {
        abort_unless(auth()->user()->can('view attendance audit trail'), 403);

        $user = auth()->user();
        $schoolId = $user->school_id;

        if ($user->hasRole('Teacher')) {
            $this->gradeOptions = $user->teacherGrades()->orderBy('grades.level')->get();
            $this->subjectOptions = $user->teacherSubjects()->orderBy('name')->get();
        } else {
            $this->gradeOptions = Grade::orderBy('level')->get();
            $this->subjectOptions = AcademicSubject::where('school_id', $schoolId)->orderBy('name')->get();
        }

        $this->periodOptions = Period::where('school_id', $schoolId)->orderBy('sort_order')->get();
    }

    public function updatingGradeFilter()
    {
        $this->resetPage();
    }
    public function updatingSubjectFilter()
    {
        $this->resetPage();
    }
    public function updatingPeriodFilter()
    {
        $this->resetPage();
    }
    public function updatingActionFilter()
    {
        $this->resetPage();
    }
    public function updatingDateFrom()
    {
        $this->resetPage();
    }
    public function updatingDateTo()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['gradeFilter', 'subjectFilter', 'periodFilter', 'actionFilter', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function render()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $query = AttendanceAudit::where('school_id', $schoolId)
            ->with(['enrollment.student', 'enrollment.grade', 'subject', 'period', 'performedBy']);

        if ($user->hasRole('Teacher')) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();

            $query->whereIn('academic_subject_id', $allowedSubjectIds)
                ->whereHas('enrollment', fn($q) => $q->whereIn('grade_id', $allowedGradeIds));
        }

        if ($this->gradeFilter) {
            $query->whereHas('enrollment', fn($q) => $q->where('grade_id', $this->gradeFilter));
        }

        if ($this->subjectFilter) {
            $query->where('academic_subject_id', $this->subjectFilter);
        }

        if ($this->periodFilter) {
            $query->where('period_id', $this->periodFilter);
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('date', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('date', '<=', $this->dateTo);
        }

        $audits = $query->orderByDesc('performed_at')->paginate(20);

        return view('livewire.admin.attendance.attendance-audit-trail', compact('audits'));
    }
}
