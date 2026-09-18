<?php

namespace App\Livewire\Admin\AcademicYears;

use App\Models\AcademicYear;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    public $showModal = false;
    public $showDeleteModal = false;

    public $editingId;
    public $deleteId;

    public $name = '';
    public $isActive = false;
    public $sortOrder = 0;

    /**
     * Every action in this component is confined to the logged-in user's
     * own school. Super Admin (school_id === null) has no academic-year
     * context of its own — this module is school-only by design.
     */
    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    protected function ensureSchoolContext(): bool
    {
        if (! $this->currentSchoolId()) {
            $this->dispatch(
                'notify',
                message: 'Academic years are managed per school. Log in as a school account to continue.',
                type: 'error'
            );
            return false;
        }

        return true;
    }

    public function openCreateModal()
    {
        if (! auth()->user()->can('manage academic years')) {
            abort(403);
        }

        if (! $this->ensureSchoolContext()) {
            return;
        }

        $this->reset(['editingId', 'name', 'isActive', 'sortOrder']);
        $this->sortOrder = 0;
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        if (! auth()->user()->can('manage academic years')) {
            abort(403);
        }

        $year = AcademicYear::where('school_id', $this->currentSchoolId())->findOrFail($id);

        $this->editingId = $year->id;
        $this->name = $year->name;
        $this->isActive = $year->is_active;
        $this->sortOrder = $year->sort_order;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    public function save()
    {
        if (! auth()->user()->can('manage academic years')) {
            abort(403);
        }

        if (! $this->ensureSchoolContext()) {
            return;
        }

        $schoolId = $this->currentSchoolId();

        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('academic_years', 'name')
                    ->where(fn($q) => $q->where('school_id', $schoolId))
                    ->ignore($this->editingId),
            ],
            'isActive' => 'boolean',
            'sortOrder' => 'integer|min:0',
        ]);

        AcademicYear::updateOrCreate(
            ['id' => $this->editingId, 'school_id' => $schoolId],
            [
                'school_id' => $schoolId,
                'name' => $this->name,
                'is_active' => $this->isActive,
                'sort_order' => $this->sortOrder,
            ]
        );

        $this->showModal = false;

        $this->dispatch('notify', message: $this->editingId ? 'Academic year updated.' : 'Academic year created.', type: 'success');
    }

    public function confirmDelete(int $id)
    {
        if (! auth()->user()->can('manage academic years')) {
            abort(403);
        }

        AcademicYear::where('school_id', $this->currentSchoolId())->findOrFail($id);

        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if (! auth()->user()->can('manage academic years')) {
            abort(403);
        }

        $year = AcademicYear::where('school_id', $this->currentSchoolId())->find($this->deleteId);

        if ($year) {
            $year->delete();
        }

        $this->showDeleteModal = false;

        $this->dispatch('notify', message: 'Academic year deleted.', type: 'success');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    /**
     * Quick "make this the active year" action — deactivates every other
     * academic year in the same school so only one is active at a time.
     */
    public function setActive(int $id)
    {
        if (! auth()->user()->can('manage academic years')) {
            abort(403);
        }

        $schoolId = $this->currentSchoolId();

        $year = AcademicYear::where('school_id', $schoolId)->findOrFail($id);

        AcademicYear::where('school_id', $schoolId)->update(['is_active' => false]);
        $year->update(['is_active' => true]);

        $this->dispatch('notify', message: "\"{$year->name}\" is now the active academic year.", type: 'success');
    }

    public function render()
    {
        $academicYears = AcademicYear::where('school_id', $this->currentSchoolId())
            ->ordered()
            ->get();

        return view('livewire.admin.academic-years.index', [
            'academicYears' => $academicYears,
        ]);
    }
}
