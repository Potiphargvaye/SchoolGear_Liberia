<?php

namespace App\Livewire\Admin\Students;

use App\Models\Student;
use App\Models\Grade;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\AcademicYear;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    public string $search = '';
    public string $gradeFilter = '';
    public string $academicYearFilter = '';

    public function updatedSearch()
    {
        $this->resetPage();
    }
    public function updatedGradeFilter()
    {
        $this->resetPage();
    }

    public function updatedAcademicYearFilter()
    {
        $this->resetPage();
    }

    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    protected function statusCount(string|array|null $status = null): int
    {
        return Student::where('school_id', $this->currentSchoolId())
            ->whereHas('enrollment', function ($q) use ($status) {
                if ($status) {
                    if (is_array($status)) {
                        $q->whereIn('status', $status);
                    } else {
                        $q->where('status', $status);
                    }
                }
                if ($this->academicYearFilter) {
                    $q->where('academic_year_id', $this->academicYearFilter);
                }
            })
            ->count();
    }
    /* -------------------------
        Delete — deleting the User cascades to Student, which cascades to
        Enrollment/Promotions.
    --------------------------*/
    public $showDeleteModal = false;
    public $deleteStudentId;
    public $deleteStudentName;

    public function confirmDelete($id)
    {
        if (! auth()->user()->can('delete students')) abort(403);

        $student = Student::where('school_id', $this->currentSchoolId())->findOrFail($id);

        $this->deleteStudentId = $student->id;
        $this->deleteStudentName = $student->name;
        $this->showDeleteModal = true;
    }

    public function deleteStudent()
    {
        if (! auth()->user()->can('delete students')) abort(403);

        $student = Student::where('school_id', $this->currentSchoolId())->with('user')->findOrFail($this->deleteStudentId);

        $student->user?->delete();

        $this->showDeleteModal = false;
        $this->deleteStudentId = null;
        $this->deleteStudentName = null;

        $this->dispatch('notify', message: 'Student record deleted successfully!', type: 'success');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteStudentId = null;
        $this->deleteStudentName = null;
    }

    public function render()
    {
        $students = Student::where('school_id', $this->currentSchoolId())
            ->when($this->gradeFilter, function ($q) {
                $q->whereHas('enrollment', fn($q) => $q->where('grade_id', $this->gradeFilter));
            })
            ->when($this->academicYearFilter, function ($q) {              // ← ADD THIS BLOCK
                $q->whereHas('enrollment', fn($q) => $q->where('academic_year_id', $this->academicYearFilter));
            })
            ->when($this->search, function ($q) {
                $q->where(function ($q) {
                    $q->where('name', 'like', "%{$this->search}%")
                        ->orWhere('parent_phone', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($q) {
                            $q->where('email', 'like', "%{$this->search}%")
                                ->orWhere('registration_id', 'like', "%{$this->search}%");
                        });
                });
            })
            ->with(['user', 'enrollment.grade', 'enrollment.academicYear'])
            ->orderBy('name')
            ->paginate(10);

        $grades = Grade::orderBy('level')->get();
        $academicYears = AcademicYear::orderByDesc('id')->get();   // ← ADD THIS LINE

        return view('livewire.admin.students.index', [
            'students' => $students,
            'grades' => $grades,
            'academicYears' => $academicYears,   // ← ADD THIS LINE
            'totalStudents' => Student::where('school_id', $this->currentSchoolId())
                ->when($this->academicYearFilter, function ($q) {                              // ← CHANGED
                    $q->whereHas('enrollment', fn($q) => $q->where('academic_year_id', $this->academicYearFilter));
                })->count(),
            'activeCount' => $this->statusCount('active'),          // ← ADD
            'graduatedCount' => $this->statusCount('graduated'),    // ← ADD
            'suspendedCount' => $this->statusCount('suspended'),    // ← ADD
            'otherCount' => $this->statusCount(['transferred', 'dropped_out', 'expelled']),   // ← ADD
            'canView' => auth()->user()->can('view student details'),
            'canEdit' => auth()->user()->can('edit students'),
            'canDelete' => auth()->user()->can('delete students'),
        ]);
    }
}
