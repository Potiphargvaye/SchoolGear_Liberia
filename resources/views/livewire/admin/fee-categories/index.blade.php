<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Fee Categories</h1>
            <p class="text-gray-500 text-sm mt-1">
                @if ($isPlatformAdmin)
                    Viewing fee categories across all schools.
                @else
                    Add, rename, or deactivate categories no code changes needed.
                @endif
            </p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.fees.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-gray-300 text-gray-600 font-semibold text-sm hover:bg-gray-100">
                <i class="fas fa-arrow-left text-xs"></i> Back to Fees
            </a>
            @unless ($isPlatformAdmin)
                <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#155E8A] text-white font-semibold text-sm hover:opacity-90 disabled:opacity-60">
                    <i class="fas fa-plus text-xs" wire:loading.remove wire:target="openCreateModal"></i>
                    <i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="openCreateModal"></i>
                    New Category
                </button>
            @endunless
        </div>
    </div>

    <div class="bg-white rounded-md border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Order</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Code</th>
                    @if ($isPlatformAdmin)
                        <th class="px-4 py-3 text-left">School</th>
                    @endif
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 text-gray-500">{{ $category->sort_order }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $category->name }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $category->code }}</td>
                        @if ($isPlatformAdmin)
                            <td class="px-4 py-3 text-gray-600">
                                {{ $category->school->school_name ?? '— unassigned —' }}
                            </td>
                        @endif
                        <td class="px-4 py-3 text-center">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                @if ($isPlatformAdmin)
                                    <button wire:click="viewCategory({{ $category->id }})" wire:loading.attr="disabled"
                                        wire:target="viewCategory({{ $category->id }})"
                                        class="h-8 w-8 rounded-md bg-sky-100 hover:bg-sky-700 hover:text-white text-sky-700 flex items-center justify-center disabled:opacity-60">
                                        <i class="fas fa-eye text-xs" wire:loading.remove
                                            wire:target="viewCategory({{ $category->id }})"></i>
                                        <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                            wire:target="viewCategory({{ $category->id }})"></i>
                                    </button>
                                @else
                                    <button wire:click="openEditModal({{ $category->id }})"
                                        wire:loading.attr="disabled" wire:target="openEditModal({{ $category->id }})"
                                        class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-600 hover:text-white text-yellow-700 flex items-center justify-center disabled:opacity-60">
                                        <i class="fas fa-pen text-xs" wire:loading.remove
                                            wire:target="openEditModal({{ $category->id }})"></i>
                                        <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                            wire:target="openEditModal({{ $category->id }})"></i>
                                    </button>
                                    <button wire:click="confirmDelete({{ $category->id }})"
                                        wire:loading.attr="disabled" wire:target="confirmDelete({{ $category->id }})"
                                        class="h-8 w-8 rounded-md bg-red-100 hover:bg-red-700 hover:text-white text-red-700 flex items-center justify-center disabled:opacity-60">
                                        <i class="fas fa-trash text-xs" wire:loading.remove
                                            wire:target="confirmDelete({{ $category->id }})"></i>
                                        <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                            wire:target="confirmDelete({{ $category->id }})"></i>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="{{ $isPlatformAdmin ? 6 : 5 }}" class="text-center py-10 text-gray-400 text-sm">
                            No fee categories found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- ========================= CREATE / EDIT MODAL ========================= --}} 
    @if ($showModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => $editingId ? 'Edit Category' : 'New Category',
                        ])
                        <button type="button" wire:click="closeModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="save" class="flex flex-col flex-1 min-h-0">
                    <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Name</label>
                            <input type="text" wire:model.live="name"
                                class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Code</label>
                            <input type="text" wire:model="code"
                                class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            @error('code')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Sort Order</label>
                                <input type="number" wire:model="sortOrder"
                                    class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>
                            <div class="flex items-center gap-2 pt-6">
                                <input type="checkbox" wire:model="isActive" id="isActive"
                                    class="rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]">
                                <label for="isActive" class="text-sm text-slate-700">Active</label>
                            </div>
                        </div>
                    </div>

                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">Cancel</button>
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
                    <h3 class="text-sm font-semibold text-white">Delete Category</h3>
                    <button wire:click="closeDeleteModal"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="px-4 py-3 text-sm text-gray-700">Are you sure? This cannot be undone.</div>
                <div class="bg-gray-50 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                    <button wire:click="closeDeleteModal"
                        class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                    <button wire:click="delete"
                        class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">
                        <span wire:loading.remove wire:target="delete">Delete</span>
                        <span wire:loading wire:target="delete">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ========================= VIEW MODAL (Super Admin — shows owning school) ========================= --}}
    @if ($showViewModal && $view_category)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden">

                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => $view_category->name])
                        <button wire:click="closeViewModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-6 bg-[#F8FAFC] space-y-3 text-sm overflow-y-auto flex-1 min-h-0">
                    <div>
                        <p class="text-xs text-slate-500">Code</p>
                        <p class="font-mono font-semibold text-slate-800">{{ $view_category->code }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Owning School</p>
                        <p class="font-semibold text-slate-800">
                            {{ $view_category->school->school_name ?? '— unassigned —' }}</p>
                        @if ($view_category->school)
                            <p class="text-xs text-slate-400 font-mono">{{ $view_category->school->registration_id }}
                            </p>
                        @endif
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Sort Order</p>
                        <p class="font-semibold text-slate-800">{{ $view_category->sort_order }}</p>
                    </div>
                    <div>
                        <p class="text-xs text-slate-500">Status</p>
                        <span
                            class="px-2.5 py-1 rounded-full text-xs font-medium {{ $view_category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                            {{ $view_category->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </div>
                </div>

                <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end shrink-0">
                    <button wire:click="closeViewModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">Close</button>
                </div>
            </div>
        </div>
    @endif

</div>
