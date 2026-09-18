<?php

namespace App\Livewire\Admin\Subjects;

use App\Models\AcademicSubject;
use App\Models\User;
use Livewire\Component;

class SubjectManager extends Component
{
    public $subjects;

    public $showFormModal = false;
    public $editingId = null;
    public $name;
    public $level;
    public $teacherIds = [];
    public $teacherOptions = [];

    public $showDeleteModal = false;
    public $deletingId = null;
    public $deletingName = null;

    protected function rules()
    {
        return [
            'name' => 'required|string|max:100',
            'level' => 'required|in:kindergarten,elementary,junior,senior',
        ];
    }

    public function mount()
    {
        abort_unless(auth()->user()->can('manage academic subjects'), 403);

        $this->loadSubjects();
        $this->loadTeacherOptions();
    }

    public function loadSubjects()
    {
        $this->subjects = AcademicSubject::where('school_id', auth()->user()->school_id)
            ->orderBy('level')
            ->orderBy('name')
            ->get();
    }

    protected function loadTeacherOptions()
    {
        $this->teacherOptions = User::role('Teacher')
            ->where('school_id', auth()->user()->school_id)
            ->orderBy('name')
            ->get();
    }

    public function openCreateModal()
    {
        $this->resetForm();
        $this->editingId = null;
        $this->showFormModal = true;
    }

    public function openEditModal($id)
    {
        $subject = AcademicSubject::where('school_id', auth()->user()->school_id)->findOrFail($id);

        $this->editingId = $subject->id;
        $this->name = $subject->name;
        $this->level = $subject->level;
        $this->teacherIds = $subject->teachers()->pluck('users.id')->toArray();

        $this->showFormModal = true;
    }

    public function save()
    {
        $this->validate();

        $schoolId = auth()->user()->school_id;

        $duplicate = AcademicSubject::where('school_id', $schoolId)
            ->where('name', $this->name)
            ->where('level', $this->level)
            ->when($this->editingId, fn($q) => $q->where('id', '!=', $this->editingId))
            ->exists();

        if ($duplicate) {
            $this->addError('name', 'This subject already exists for this level.');
            return;
        }

        $subject = AcademicSubject::updateOrCreate(
            ['id' => $this->editingId],
            [
                'school_id' => $schoolId,
                'name' => $this->name,
                'level' => $this->level,
            ]
        );

        // Subjects are already school-scoped, so a plain sync() here is
        // safe — unlike grade_teacher, there's no cross-school data to
        // accidentally wipe.
        $subject->teachers()->sync($this->teacherIds);

        $this->closeFormModal();
        $this->loadSubjects();
        session()->flash('success', $this->editingId ? 'Subject updated.' : 'Subject created.');
    }

    public function closeFormModal()
    {
        $this->showFormModal = false;
        $this->resetForm();
    }

    protected function resetForm()
    {
        $this->reset(['name', 'level', 'teacherIds', 'editingId']);
        $this->resetErrorBag();
    }

    public function confirmDelete($id)
    {
        $subject = AcademicSubject::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $this->deletingId = $subject->id;
        $this->deletingName = $subject->name;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $subject = AcademicSubject::where('school_id', auth()->user()->school_id)->find($this->deletingId);

        if ($subject) {
            // Cascades: this also deletes every student_grade and
            // grade_audit row recorded under this subject (FK
            // cascadeOnDelete on both tables) — the delete modal warns
            // about this explicitly.
            $subject->delete();
            session()->flash('success', 'Subject deleted.');
        }

        $this->showDeleteModal = false;
        $this->deletingId = null;
        $this->deletingName = null;
        $this->loadSubjects();
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deletingId = null;
        $this->deletingName = null;
    }

    public function render()
    {
        return view('livewire.admin.subjects.subject-manager');
    }
}
