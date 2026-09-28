<?php

namespace App\Livewire\Admin\DemoRequests;

use App\Models\DemoRequest;
use Illuminate\Validation\Rule;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Platform/Super Admin only (school_id === null).
 * The route is already behind EnsurePlatformAdmin; boot() repeats the check on
 * EVERY Livewire request so no action can be called by a school user directly.
 */
class Index extends Component
{
    use WithPagination;

    public string $search = '';
    public string $statusFilter = '';

    public bool $showDetails = false;
    public ?int $selectedId = null;
    public string $editStatus = 'pending';
    public string $editNotes = '';
    public bool $showDeleteConfirm = false;
    public ?int $deleteId = null;

    public function boot(): void
    {
        abort_unless(auth()->check() && auth()->user()->school_id === null, 403);
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function updatingStatusFilter(): void
    {
        $this->resetPage();
    }

    public function openDetails(int $id): void
    {
        $demo = DemoRequest::findOrFail($id);

        $this->selectedId = $demo->id;
        $this->editStatus = $demo->status;
        $this->editNotes = (string) $demo->admin_notes;
        $this->resetErrorBag();
        $this->showDetails = true;
    }

    public function closeDetails(): void
    {
        $this->showDetails = false;
        $this->selectedId = null;
        $this->resetErrorBag();
    }

    public function saveStatus(): void
    {
        $this->validate([
            'editStatus' => ['required', Rule::in(array_keys(DemoRequest::STATUSES))],
            'editNotes'  => ['nullable', 'string', 'max:2000'],
        ]);

        $demo = DemoRequest::findOrFail($this->selectedId);

        $statusChanged = $demo->status !== $this->editStatus;

        $demo->status = $this->editStatus;
        $demo->admin_notes = trim($this->editNotes) !== '' ? trim($this->editNotes) : null;

        if ($statusChanged) {
            $demo->status_changed_at = now();
        }

        $demo->save();

        $this->closeDetails();

        $this->dispatch('notify', message: "{$demo->reference} updated.", type: 'success');
    }


    public function confirmDelete(int $id): void
    {
        $demo = DemoRequest::findOrFail($id);

        $this->deleteId = $demo->id;
        $this->showDeleteConfirm = true;
    }

    public function cancelDelete(): void
    {
        $this->showDeleteConfirm = false;
        $this->deleteId = null;
    }

    public function deleteRequest(): void
    {
        $demo = DemoRequest::findOrFail($this->deleteId);
        $reference = $demo->reference;

        $demo->delete();

        // Close the details modal if it was showing this record
        if ($this->selectedId === $this->deleteId) {
            $this->closeDetails();
        }

        $this->cancelDelete();

        $this->dispatch('notify', message: "{$reference} deleted.", type: 'success');
    }

    public function render()
    {
        $requests = DemoRequest::query()
            ->search($this->search)
            ->withStatus($this->statusFilter)
            ->orderByDesc('created_at')
            ->paginate(15);

        $counts = DemoRequest::query()
            ->selectRaw('status, COUNT(*) as total')
            ->groupBy('status')
            ->pluck('total', 'status');

        $selected = $this->showDetails && $this->selectedId
            ? DemoRequest::find($this->selectedId)
            : null;

        $toDelete = $this->showDeleteConfirm && $this->deleteId
            ? DemoRequest::find($this->deleteId)
            : null;

        return view('livewire.admin.demo-requests.index', [
            'requests' => $requests,
            'counts'   => $counts,
            'selected' => $selected,
            'toDelete' => $toDelete,
        ]);
    }
}
