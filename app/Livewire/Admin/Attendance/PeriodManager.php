<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\Period;
use Livewire\Component;

class PeriodManager extends Component
{
    public $periods;
    public $showModal = false;
    public $editingId = null;
    public $name;
    public $sortOrder = 0;

    public function mount()
    {
        abort_unless(auth()->user()->can('manage periods'), 403);
        $this->loadPeriods();
    }

    public function loadPeriods()
    {
        $this->periods = Period::where('school_id', auth()->user()->school_id)
            ->orderBy('sort_order')
            ->get();
    }

    public function openCreateModal()
    {
        $this->reset(['editingId', 'name', 'sortOrder']);
        $this->showModal = true;
    }

    public function openEditModal($id)
    {
        $period = Period::where('school_id', auth()->user()->school_id)->findOrFail($id);
        $this->editingId = $period->id;
        $this->name = $period->name;
        $this->sortOrder = $period->sort_order;
        $this->showModal = true;
    }

    public function save()
    {
        $this->validate(['name' => 'required|string|max:50', 'sortOrder' => 'required|integer|min:0']);

        Period::updateOrCreate(
            ['id' => $this->editingId],
            ['school_id' => auth()->user()->school_id, 'name' => $this->name, 'sort_order' => $this->sortOrder]
        );

        $this->showModal = false;
        $this->loadPeriods();
        session()->flash('success', 'Period saved.');
    }

    public function delete($id)
    {
        Period::where('school_id', auth()->user()->school_id)->find($id)?->delete();
        $this->loadPeriods();
        session()->flash('success', 'Period deleted.');
    }

    public function render()
    {
        return view('livewire.admin.attendance.period-manager');
    }
}
