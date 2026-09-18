<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Academic Years</h1>
            <p class="text-slate-500 text-sm mt-1">Manage your school's academic year calendar.</p>
        </div>
        <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors disabled:opacity-60">
            <i class="fas fa-plus text-xs" wire:loading.remove wire:target="openCreateModal"></i>
            <i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="openCreateModal"></i>
            New Academic Year
        </button>
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Order</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Academic Year</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Status</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($academicYears as $year)
                        <tr class="hover:bg-sky-50/60 transition-colors">
                            <td class="px-4 sm:px-6 py-3 text-slate-500">{{ $year->sort_order }}</td>
                            <td class="px-4 sm:px-6 py-3 font-semibold text-slate-800">{{ $year->name }}</td>
                            <td class="px-4 sm:px-6 py-3 text-center">
                                @if ($year->is_active)
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">Inactive</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-3">
                                <div class="flex justify-center flex-wrap gap-2">

                                    @unless ($year->is_active)
                                        <button wire:click="setActive({{ $year->id }})" wire:loading.attr="disabled"
                                            wire:target="setActive({{ $year->id }})"
                                            class="px-3 py-1.5 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] text-xs font-semibold transition-colors disabled:opacity-60 flex items-center gap-1.5">
                                            <span wire:loading.remove wire:target="setActive({{ $year->id }})">Set
                                                Active</span>
                                            <span wire:loading
                                                wire:target="setActive({{ $year->id }})">Setting...</span>
                                        </button>
                                    @endunless

                                    <button wire:click="openEditModal({{ $year->id }})" wire:loading.attr="disabled"
                                        wire:target="openEditModal({{ $year->id }})"
                                        class="h-8 w-8 rounded-md bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 flex items-center justify-center transition-colors disabled:opacity-60">
                                        <i class="fas fa-pen text-xs" wire:loading.remove
                                            wire:target="openEditModal({{ $year->id }})"></i>
                                        <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                            wire:target="openEditModal({{ $year->id }})"></i>
                                    </button>

                                    <button wire:click="confirmDelete({{ $year->id }})"
                                        wire:loading.attr="disabled" wire:target="confirmDelete({{ $year->id }})"
                                        class="h-8 w-8 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition-colors disabled:opacity-60">
                                        <i class="fas fa-trash text-xs" wire:loading.remove
                                            wire:target="confirmDelete({{ $year->id }})"></i>
                                        <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                            wire:target="confirmDelete({{ $year->id }})"></i>
                                    </button>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-14">
                                <i class="fas fa-calendar-alt text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No academic years yet. Create your first one to get
                                    started.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ========================= CREATE / EDIT MODAL ========================= --}}
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-center justify-between">
                        <h3 class="text-white font-bold text-lg">{{ $editingId ? 'Edit' : 'New' }} Academic Year</h3>
                        <button type="button" wire:click="closeModal"
                            class="h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="flex flex-col flex-1 min-h-0">
                    <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Academic Year Name
                                *</label>
                            <input type="text" wire:model="name" placeholder="e.g. 2026/2027"
                                class="w-full text-sm py-2.5 px-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Sort Order</label>
                                <input type="number" wire:model="sortOrder"
                                    class="w-full text-sm py-2.5 px-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>
                            <div class="flex items-center gap-2 pt-7">
                                <input type="checkbox" wire:model="isActive" id="isActive"
                                    class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]">
                                <label for="isActive" class="text-sm text-slate-700">Active</label>
                            </div>
                        </div>
                    </div>

                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors">
                            <span wire:loading.remove wire:target="save">Save</span>
                            <span wire:loading wire:target="save">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ========================= DELETE MODAL ========================= --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">Delete Academic Year</h3>
                    <button wire:click="closeDeleteModal"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="p-4 text-sm text-slate-700">Are you sure? This cannot be undone.</div>
                <div class="bg-slate-50 px-4 py-3 flex justify-end gap-2 border-t border-slate-200">
                    <button wire:click="closeDeleteModal"
                        class="px-3 py-2 text-sm rounded-md border border-slate-300 hover:bg-slate-100 transition-colors">Cancel</button>
                    <button wire:click="delete" wire:loading.attr="disabled" wire:target="delete"
                        class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700 transition-colors disabled:opacity-60">
                        <span wire:loading.remove wire:target="delete">Delete</span>
                        <span wire:loading wire:target="delete">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
