<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Fee Categories</h1>
            <p class="text-gray-500 text-sm mt-1">Add, rename, or deactivate categories — no code changes needed.</p>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.fees.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-gray-300 text-gray-600 font-semibold text-sm hover:bg-gray-100">
                <i class="fas fa-arrow-left text-xs"></i> Back to Fees
            </a>
            <button wire:click="openCreateModal"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#0a1f44] text-white font-semibold text-sm hover:opacity-90">
                <i class="fas fa-plus text-xs"></i> New Category
            </button>
        </div>
    </div>

    <div class="bg-white rounded-md border border-gray-200 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                <tr>
                    <th class="px-4 py-3 text-left">Order</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Code</th>
                    <th class="px-4 py-3 text-center">Status</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @foreach ($categories as $category)
                    <tr>
                        <td class="px-4 py-3 text-gray-500">{{ $category->sort_order }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $category->name }}</td>
                        <td class="px-4 py-3 font-mono text-xs text-gray-500">{{ $category->code }}</td>
                        <td class="px-4 py-3 text-center">
                            <span
                                class="px-2.5 py-1 rounded-full text-xs font-medium {{ $category->is_active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">
                                {{ $category->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex justify-center gap-2">
                                <button wire:click="openEditModal({{ $category->id }})"
                                    class="h-8 w-8 rounded-md bg-yellow-100 hover:bg-yellow-600 hover:text-white text-yellow-700 flex items-center justify-center">
                                    <i class="fas fa-pen text-xs"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $category->id }})"
                                    class="h-8 w-8 rounded-md bg-red-100 hover:bg-red-700 hover:text-white text-red-700 flex items-center justify-center">
                                    <i class="fas fa-trash text-xs"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    @if ($showModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-md overflow-hidden">
                <div class="bg-[#0a1f44] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold">{{ $editingId ? 'Edit' : 'New' }} Category</h3>
                    <button wire:click="closeModal" class="text-white/80 hover:text-white">&times;</button>
                </div>
                <form wire:submit.prevent="save" class="p-4 space-y-3">
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Name</label>
                        <input type="text" wire:model.live="name"
                            class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                        @error('name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Code</label>
                        <input type="text" wire:model="code"
                            class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                        @error('code')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Sort Order</label>
                            <input type="number" wire:model="sortOrder"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                        </div>
                        <div class="flex items-center gap-2 pt-6">
                            <input type="checkbox" wire:model="isActive" id="isActive"
                                class="rounded border-gray-300 text-[#0a1f44]">
                            <label for="isActive" class="text-sm text-gray-700">Active</label>
                        </div>
                    </div>
                    <div class="bg-gray-50 -mx-4 -mb-4 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                        <button type="button" wire:click="closeModal"
                            class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-md bg-[#0a1f44] text-white font-semibold hover:opacity-90">Save</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-xs overflow-hidden">
                <div class="bg-red-600 text-white px-4 py-3">
                    <h3 class="font-semibold text-sm">Delete Category</h3>
                </div>
                <div class="p-4 text-sm text-gray-700">Are you sure? This cannot be undone.</div>
                <div class="bg-gray-50 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                    <button wire:click="closeDeleteModal"
                        class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                    <button wire:click="delete"
                        class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>
