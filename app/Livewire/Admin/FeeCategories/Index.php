<?php

namespace App\Livewire\Admin\FeeCategories;

use App\Models\FeeCategory;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false;
    public bool $showViewModal = false;
    public $editingId = null;
    public $name = '';
    public $code = '';
    public $isActive = true;
    public $sortOrder = 0;

    public $deleteId = null;
    public bool $showDeleteModal = false;

    public $view_category;

    /**
     * Super Admin (school_id === null) sees every school's categories and
     * cannot create new ones (a category must belong to exactly one
     * school). School Owners/staff are confined to their own school.
     */
    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    protected function isPlatformAdmin(): bool
    {
        return $this->currentSchoolId() === null;
    }

    public function openCreateModal()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        if ($this->isPlatformAdmin()) {
            $this->dispatch('notify', message: 'Fee categories are created within a school. Log in as a school account to add one.', type: 'error');
            return;
        }

        $this->editingId = null;
        $this->name = '';
        $this->code = '';
        $this->isActive = true;
        $this->sortOrder = FeeCategory::where('school_id', $this->currentSchoolId())->max('sort_order') + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $category = $this->isPlatformAdmin()
            ? FeeCategory::findOrFail($id)
            : FeeCategory::where('school_id', $this->currentSchoolId())->findOrFail($id);

        $this->editingId = $category->id;
        $this->name = $category->name;
        $this->code = $category->code;
        $this->isActive = $category->is_active;
        $this->sortOrder = $category->sort_order;
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetErrorBag();
    }

    /* -------------------------
        View (Super Admin — shows the owning school)
    --------------------------*/
    public function viewCategory(int $id)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $this->view_category = FeeCategory::with('school')->findOrFail($id);
        $this->showViewModal = true;
    }

    public function closeViewModal()
    {
        $this->showViewModal = false;
        $this->view_category = null;
    }

    // Auto-suggest a code from the name for new categories only.
    public function updatedName($value)
    {
        if (! $this->editingId) {
            $this->code = Str::slug($value, '_');
        }
    }

    public function save()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        if ($this->isPlatformAdmin()) {
            $this->dispatch('notify', message: 'Fee categories are managed within a school. Log in as a school account to continue.', type: 'error');
            return;
        }

        $schoolId = $this->currentSchoolId();

        $this->validate([
            'name' => 'required|string|max:255',
            'code' => [
                'required',
                'string',
                'max:255',
                'alpha_dash',
                Rule::unique('fee_categories', 'code')
                    ->where(fn($q) => $q->where('school_id', $schoolId))
                    ->ignore($this->editingId),
            ],
            'isActive' => 'boolean',
            'sortOrder' => 'integer|min:0',
        ]);

        FeeCategory::updateOrCreate(
            ['id' => $this->editingId, 'school_id' => $schoolId],
            [
                'school_id' => $schoolId,
                'name' => $this->name,
                'code' => $this->code,
                'is_active' => $this->isActive,
                'sort_order' => $this->sortOrder,
            ]
        );

        $this->showModal = false;

        $this->dispatch('notify', message: $this->editingId ? 'Category updated.' : 'Category created.', type: 'success');
    }

    public function confirmDelete(int $id)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $category = $this->isPlatformAdmin()
            ? FeeCategory::findOrFail($id)
            : FeeCategory::where('school_id', $this->currentSchoolId())->findOrFail($id);

        if (! $category->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete fees have already been assigned under this category.', type: 'error');
            return;
        }

        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $category = $this->isPlatformAdmin()
            ? FeeCategory::findOrFail($this->deleteId)
            : FeeCategory::where('school_id', $this->currentSchoolId())->findOrFail($this->deleteId);

        if (! $category->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete — fees have already been assigned under this category.', type: 'error');
            $this->showDeleteModal = false;
            return;
        }

        $category->delete();
        $this->showDeleteModal = false;

        $this->dispatch('notify', message: 'Category deleted.', type: 'success');
    }

    public function closeDeleteModal()
    {
        $this->showDeleteModal = false;
        $this->deleteId = null;
    }

    public function render()
    {
        $query = $this->isPlatformAdmin()
            ? FeeCategory::with('school')
            : FeeCategory::where('school_id', $this->currentSchoolId());

        return view('livewire.admin.fee-categories.index', [
            'categories' => $query->orderBy('sort_order')->get(),
            'isPlatformAdmin' => $this->isPlatformAdmin(),
        ]);
    }
}
