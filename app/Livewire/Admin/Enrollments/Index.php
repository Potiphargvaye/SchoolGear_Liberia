<?php

namespace App\Livewire\Admin\Enrollments;

use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\AcademicYear;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $status = 'active';
    public string $search = '';
    public string $gradeFilter = '';

    public string $academicYearId = '';

    public function updatedAcademicYearId()
    {
        $this->resetPage();
    }

    public function updatedStatus()
    {
        $this->resetPage();
    }
    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedGradeFilter()
    {
        $this->resetPage();
    }

    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    /* -------------------------
        Promote
    --------------------------*/
    public bool $showPromoteModal = false;
    public $promoteEnrollmentId, $promoteStudentName;
    public $promoteToGradeId = '';
    public $promoteToAcademicYearId = '';
    public $promoteRemarks = '';

    public function confirmPromote(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())
            ->with('student')
            ->findOrFail($enrollmentId);

        if ($enrollment->status !== 'active') {
            $this->dispatch('notify', message: 'Only active enrollments can be promoted.', type: 'error');
            return;
        }

        $this->promoteEnrollmentId = $enrollment->id;
        $this->promoteStudentName = $enrollment->student->name;
        $this->promoteToGradeId = '';
        $this->promoteToAcademicYearId = '';
        $this->promoteRemarks = '';
        $this->showPromoteModal = true;
    }

    public function promoteStudent()
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        $this->validate([
            'promoteToGradeId' => 'required|exists:grades,id',
            'promoteToAcademicYearId' => 'required|exists:academic_years,id',
            'promoteRemarks' => 'nullable|string',
        ]);

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())->findOrFail($this->promoteEnrollmentId);
        $enrollment->promote($this->promoteToGradeId, $this->promoteToAcademicYearId, auth()->user(), $this->promoteRemarks ?: null);

        $this->showPromoteModal = false;
        $this->dispatch('notify', message: "{$this->promoteStudentName} Student promoted successfully.", type: 'success');
    }

    public function closePromoteModal()
    {
        $this->showPromoteModal = false;
    }

    /* -------------------------
        Status actions requiring a reason (transfer/dropout/suspend/expel)
    --------------------------*/
    public bool $showStatusModal = false;
    public $statusEnrollmentId, $statusStudentName, $statusAction = '';
    public $statusReason = '';

    public function confirmStatusAction(int $enrollmentId, string $action)
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        if (! in_array($action, ['transfer', 'dropOut', 'suspend', 'expel'])) return;

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())
            ->with('student')
            ->findOrFail($enrollmentId);

        if (! in_array($enrollment->status, ['active', 'suspended'])) {
            $this->dispatch('notify', message: 'This action is not available for the enrollment\'s current status.', type: 'error');
            return;
        }

        $this->statusEnrollmentId = $enrollment->id;
        $this->statusStudentName = $enrollment->student->name;
        $this->statusAction = $action;
        $this->statusReason = '';
        $this->showStatusModal = true;
    }

    public function applyStatusAction()
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        $this->validate(['statusReason' => 'required|string|min:3']);

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())->findOrFail($this->statusEnrollmentId);

        match ($this->statusAction) {
            'transfer' => $enrollment->transfer($this->statusReason, auth()->user()),
            'dropOut' => $enrollment->dropOut($this->statusReason, auth()->user()),
            'suspend' => $enrollment->suspend($this->statusReason, auth()->user()),
            'expel' => $enrollment->expel($this->statusReason, auth()->user()),
            default => null,
        };

        $this->showStatusModal = false;
        $this->dispatch('notify', message: "{$this->statusStudentName}'s enrollment status updated.", type: 'success');
    }

    public function closeStatusModal()
    {
        $this->showStatusModal = false;
    }

    /* -------------------------
        Direct single-step actions
    --------------------------*/
    public function graduateStudent(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())->with('student')->findOrFail($enrollmentId);

        if ($enrollment->status !== 'active') {
            $this->dispatch('notify', message: 'Only active enrollments can be graduated.', type: 'error');
            return;
        }

        $enrollment->graduate();

        $this->dispatch('notify', message: "{$enrollment->student->name} marked as graduated.", type: 'success');
    }

    public function reactivateStudent(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())->with('student')->findOrFail($enrollmentId);

        if ($enrollment->status !== 'suspended') {
            $this->dispatch('notify', message: 'Only suspended enrollments can be reactivated.', type: 'error');
            return;
        }

        $enrollment->reactivate();

        $this->dispatch('notify', message: "{$enrollment->student->name}'s enrollment reactivated.", type: 'success');
    }
    /* -------------------------
        Audit Trail — reason-based actions (transfer/dropOut/suspend/expel)
    --------------------------*/
    public bool $showAuditModal = false;
    public $audit_record;

    public function viewAudit(int $enrollmentId)
    {
        if (! auth()->user()->can('manage enrollments')) abort(403);

        $this->audit_record = Enrollment::where('school_id', $this->currentSchoolId())
            ->with(['student', 'grade', 'academicYear', 'statusChangedBy'])
            ->findOrFail($enrollmentId);

        $this->showAuditModal = true;
    }

    public function closeAuditModal()
    {
        $this->showAuditModal = false;
        $this->audit_record = null;
    }

    public function render()
    {
        $enrollments = Enrollment::where('school_id', $this->currentSchoolId())
            ->where('status', $this->status)
            ->when($this->gradeFilter, fn($q) => $q->where('grade_id', $this->gradeFilter))
            ->when($this->academicYearId, fn($q) => $q->where('academic_year_id', $this->academicYearId))
            ->when($this->search, function ($q) {
                $q->whereHas('student', function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q) {
                            $q->where('registration_id', 'like', "%{$this->search}%");
                        });
                });
            })
            ->with(['student.user', 'grade', 'academicYear'])
            ->latest()
            ->paginate(10);

        $grades = Grade::orderBy('level')->get();
        $academicYears = AcademicYear::where('school_id', $this->currentSchoolId())->ordered()->get();

        $statusCounts = Enrollment::where('school_id', $this->currentSchoolId())
            ->selectRaw('status, count(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        return view('livewire.admin.enrollments.index', [
            'enrollments' => $enrollments,
            'grades' => $grades,
            'academicYears' => $academicYears,
            'statusCounts' => $statusCounts,
            'canManage' => auth()->user()->can('manage enrollments'),
        ]);
    }
}
