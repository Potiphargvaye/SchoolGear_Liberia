<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">
    @include('partials.notifications')

    <div class="flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Attendance Periods</h1>
            <p class="text-slate-500 text-sm mt-1">Define the daily periods teachers can record attendance against.</p>
        </div>
        <button wire:click="openCreateModal" class="px-4 py-2.5 rounded-lg bg-[#155E8A] text-white font-semibold text-sm">
            <i class="fas fa-plus text-xs mr-1"></i> New Period
        </button>
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-[#155E8A] text-white">
                <tr>
                    <th class="px-4 py-3 text-left text-xs uppercase">Order</th>
                    <th class="px-4 py-3 text-left text-xs uppercase">Name</th>
                    <th class="px-4 py-3 text-center text-xs uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($periods as $period)
                    <tr>
                        <td class="px-4 py-3 text-slate-500">{{ $period->sort_order }}</td>
                        <td class="px-4 py-3 font-semibold text-slate-800">{{ $period->name }}</td>
                        <td class="px-4 py-3 text-center">
                            <button wire:click="openEditModal({{ $period->id }})"
                                class="h-8 w-8 rounded-md bg-amber-100 text-amber-700 inline-flex items-center justify-center">
                                <i class="fas fa-pen text-xs"></i>
                            </button>
                            <button wire:click="delete({{ $period->id }})" wire:confirm="Delete this period?"
                                class="h-8 w-8 rounded-md bg-red-100 text-[#B91C1C] inline-flex items-center justify-center">
                                <i class="fas fa-trash text-xs"></i>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center py-12 text-slate-400">No periods defined yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/70 flex items-center justify-center p-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-sm overflow-hidden">
                <div class="bg-[#155E8A] px-5 py-4">
                    <h3 class="text-white font-bold">{{ $editingId ? 'Edit' : 'New' }} Period</h3>
                </div>
                <form wire:submit.prevent="save" class="p-5 space-y-4 bg-[#F8FAFC]">
                    <div>
                        <label class="text-xs font-semibold text-slate-600 mb-1.5 block">Name *</label>
                        <input type="text" wire:model="name" placeholder="e.g. 1st Period"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-xs font-semibold text-slate-600 mb-1.5 block">Sort Order *</label>
                        <input type="number" wire:model="sortOrder"
                            class="w-full px-3 py-2 border border-slate-300 rounded-lg text-sm">
                    </div>
                    <div class="flex justify-end gap-2">
                        <button type="button" wire:click="$set('showModal', false)"
                            class="px-4 py-2 border border-slate-300 rounded-lg text-sm">Cancel</button>
                        <button type="submit"
                            class="px-5 py-2 bg-[#155E8A] text-white rounded-lg text-sm font-semibold">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
