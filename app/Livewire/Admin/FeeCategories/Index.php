<?php

namespace App\Livewire\Admin\FeeCategories;

use App\Models\FeeCategory;
use Illuminate\Support\Str;
use Livewire\Component;

class Index extends Component
{
    public bool $showModal = false;
    public $editingId = null;
    public $name = '';
    public $code = '';
    public $isActive = true;
    public $sortOrder = 0;

    public $deleteId = null;
    public bool $showDeleteModal = false;

    public function openCreateModal()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $this->editingId = null;
        $this->name = '';
        $this->code = '';
        $this->isActive = true;
        $this->sortOrder = FeeCategory::max('sort_order') + 1;
        $this->showModal = true;
    }

    public function openEditModal(int $id)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $category = FeeCategory::findOrFail($id);

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

        $this->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|alpha_dash|unique:fee_categories,code,' . $this->editingId,
            'isActive' => 'boolean',
            'sortOrder' => 'integer|min:0',
        ]);

        FeeCategory::updateOrCreate(
            ['id' => $this->editingId],
            [
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

        $category = FeeCategory::findOrFail($id);

        if (! $category->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete — fees have already been assigned under this category.', type: 'error');
            return;
        }

        $this->deleteId = $id;
        $this->showDeleteModal = true;
    }

    public function delete()
    {
        $category = FeeCategory::findOrFail($this->deleteId);

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
        return view('livewire.admin.fee-categories.index', [
            'categories' => FeeCategory::orderBy('sort_order')->get(),
        ]);
    }
}
