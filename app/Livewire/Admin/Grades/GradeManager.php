<?php

namespace App\Livewire\Admin\Grades;

use App\Models\Grade;
use App\Models\User;
use Livewire\Component;

class GradeManager extends Component
{
    public $grades;

    // Create / Edit
    public $showFormModal = false;
    public $editingId = null;
    public $level;
    public $section;

    // Delete
    public $showDeleteModal = false;
    public $deletingId = null;

    // Teacher assignment (school-scoped)
    public $showTeacherModal = false;
    public $assigningGradeId = null;
    public $teacherOptions = [];
    public $teacherIds = [];

    protected function rules()
    {
        return [
            'level' => 'required|string|max:50',
            'section' => 'nullable|string|max:10',
        ];
    }

    public function mount()
    {
        $this->loadGrades();
    }

    public function loadGrades()
    {
        $this->grades = Grade::orderBy('level')->orderBy('section')->get();
    }

    // ---------- Create / Edit ----------

    public function openCreateModal()
    {
        abort_unless(auth()->user()->can('manage grades'), 403);

        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function openEditModal($id)
    {
        abort_unless(auth()->user()->can('manage grades'), 403);

        $grade = Grade::findOrFail($id);
        $this->editingId = $grade->id;
        $this->level = $grade->level;
        $this->section = $grade->section;
        $this->showFormModal = true;
    }

    public function save()
    {
        abort_unless(auth()->user()->can('manage grades'), 403);

        $this->validate();

        $duplicate = Grade::where('level', $this->level)
            ->where('section', $this->section)
            ->when($this->editingId, fn($q) => $q->where('id', '!=', $this->editingId))
            ->exists();

        if ($duplicate) {
            $this->addError('level', 'A grade with this level and section already exists.');
            return;
        }

        Grade::updateOrCreate(
            ['id' => $this->editingId],
            ['level' => $this->level, 'section' => $this->section]
        );

        $this->closeFormModal();
        $this->loadGrades();
        session()->flash('success', $this->editingId ? 'Grade updated.' : 'Grade created.');
    }

    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->reset(['level', 'section', 'editingId']);
        $this->resetErrorBag();
    }

    // ---------- Delete ----------

    public function confirmDelete($id)
    {
        abort_unless(auth()->user()->can('manage grades'), 403);

        $this->deletingId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        abort_unless(auth()->user()->can('manage grades'), 403);

        try {
            Grade::findOrFail($this->deletingId)->delete();
            session()->flash('success', 'Grade deleted.');
        } catch (\Illuminate\Database\QueryException $e) {
            // grade_locks.grade_id is restrictOnDelete — this is expected
            // and correct: a grade still in use anywhere must not vanish.
            session()->flash('error', 'This grade cannot be deleted — it is still referenced by enrollments or grade locks in one or more schools.');
        }

        $this->showDeleteModal = false;
        $this->deletingId = null;
        $this->loadGrades();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingId = null;
    }

    // ---------- Teacher assignment ----------

    public function openTeacherModal($gradeId)
    {
        abort_unless(auth()->user()->can('assign grade teachers'), 403);

        $schoolId = auth()->user()->school_id;
        $grade = Grade::findOrFail($gradeId);

        $this->assigningGradeId = $grade->id;

        $this->teacherOptions = User::role('Teacher')
            ->where('school_id', $schoolId)
            ->orderBy('name')
            ->get();

        $this->teacherIds = $grade->teachers()
            ->where('school_id', $schoolId)
            ->pluck('users.id')
            ->toArray();

        $this->showTeacherModal = true;
    }

    public function saveTeachers()
    {
        abort_unless(auth()->user()->can('assign grade teachers'), 403);

        $schoolId = auth()->user()->school_id;
        $grade = Grade::findOrFail($this->assigningGradeId);

        // This pivot has no school_id column (by design — grades are
        // global). A blind sync() here would silently wipe every other
        // school's teacher assignments to this same grade row. Instead,
        // preserve every other school's rows and only replace this
        // school's slice.
        $otherSchoolsTeacherIds = $grade->teachers()
            ->where('school_id', '!=', $schoolId)
            ->pluck('users.id')
            ->toArray();

        $grade->teachers()->sync(array_merge($otherSchoolsTeacherIds, $this->teacherIds));

        $this->closeTeacherModal();
        session()->flash('success', 'Teacher assignments updated.');
    }

    public function closeTeacherModal()
    {
        $this->showTeacherModal = false;
        $this->assigningGradeId = null;
        $this->teacherIds = [];
        $this->teacherOptions = [];
    }

    public function render()
    {
        return view('livewire.admin.grades.grade-manager');
    }
}
