<?php

namespace App\Livewire\Admin\Grades;

use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\Grade;
use App\Models\GradeAudit;
use Livewire\Component;
use Livewire\WithPagination;

class GradeAuditTrail extends Component
{
    use WithPagination;

    public $gradeFilter = '';
    public $subjectFilter = '';
    public $academicYearFilter = '';
    public $actionFilter = '';
    public $dateFrom = '';
    public $dateTo = '';

    public $gradeOptions = [];
    public $subjectOptions = [];
    public $academicYearOptions = [];

    public function mount()
    {
        abort_unless(auth()->user()->can('view grade audit trail'), 403);

        $schoolId = auth()->user()->school_id;
        $user = auth()->user();

        // If a Teacher somehow holds this permission, keep them scoped
        // to their own assignments rather than the whole school's trail.
        if ($user->hasRole('Teacher')) {
            $this->gradeOptions = $user->teacherGrades()->orderBy('grades.level')->get();
            $this->subjectOptions = $user->teacherSubjects()->orderBy('name')->get();
        } else {
            $this->gradeOptions = Grade::orderBy('level')->get();
            $this->subjectOptions = AcademicSubject::where('school_id', $schoolId)->orderBy('name')->get();
        }

        $this->academicYearOptions = AcademicYear::where('school_id', $schoolId)->ordered()->get();
    }

    public function updatingGradeFilter()
    {
        $this->resetPage();
    }
    public function updatingSubjectFilter()
    {
        $this->resetPage();
    }
    public function updatingAcademicYearFilter()
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
        $this->reset(['gradeFilter', 'subjectFilter', 'academicYearFilter', 'actionFilter', 'dateFrom', 'dateTo']);
        $this->resetPage();
    }

    public function render()
    {
        $schoolId = auth()->user()->school_id;
        $user = auth()->user();

        $query = GradeAudit::where('school_id', $schoolId)
            ->with(['enrollment.student', 'enrollment.grade', 'enrollment.academicYear', 'subject', 'performedBy']);

        if ($user->hasRole('Teacher')) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();

            $query->whereIn('academic_subject_id', $allowedSubjectIds)
                ->whereHas('enrollment', fn($q) => $q->whereIn('grade_id', $allowedGradeIds));
        }

        if ($this->gradeFilter) {
            $query->whereHas('enrollment', fn($q) => $q->where('grade_id', $this->gradeFilter));
        }

        if ($this->academicYearFilter) {
            $query->whereHas('enrollment', fn($q) => $q->where('academic_year_id', $this->academicYearFilter));
        }

        if ($this->subjectFilter) {
            $query->where('academic_subject_id', $this->subjectFilter);
        }

        if ($this->actionFilter) {
            $query->where('action', $this->actionFilter);
        }

        if ($this->dateFrom) {
            $query->whereDate('performed_at', '>=', $this->dateFrom);
        }

        if ($this->dateTo) {
            $query->whereDate('performed_at', '<=', $this->dateTo);
        }

        $audits = $query->orderByDesc('performed_at')->paginate(20);

        return view('livewire.admin.grades.grade-audit-trail', compact('audits'));
    }
}
