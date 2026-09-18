<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Grades</h1>
            <p class="text-slate-500 text-sm mt-1">
                Grades are shared across every school on SchoolGear. Assign your school's teachers to any grade below.
            </p>
        </div>

        @can('manage grades')
            <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors disabled:opacity-60">
                <i class="fas fa-plus text-xs" wire:loading.remove wire:target="openCreateModal"></i>
                <i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="openCreateModal"></i>
                New Grade
            </button>
        @endcan
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[600px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Level</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Section</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($grades as $grade)
                        <tr class="hover:bg-sky-50/60 transition-colors">
                            <td class="px-4 sm:px-6 py-3 font-semibold text-slate-800">{{ $grade->level }}</td>
                            <td class="px-4 sm:px-6 py-3 text-slate-500">{{ $grade->section ?? '—' }}</td>
                            <td class="px-4 sm:px-6 py-3">
                                <div class="flex justify-center flex-wrap gap-2">

                                    @can('assign grade teachers')
                                        <button wire:click="openTeacherModal({{ $grade->id }})"
                                            wire:loading.attr="disabled" wire:target="openTeacherModal({{ $grade->id }})"
                                            class="px-3 py-1.5 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] text-xs font-semibold transition-colors disabled:opacity-60 flex items-center gap-1.5">
                                            <i class="fas fa-chalkboard-teacher text-xs"></i>
                                            Assign Teachers
                                        </button>
                                    @endcan

                                    @can('manage grades')
                                        <button wire:click="openEditModal({{ $grade->id }})" wire:loading.attr="disabled"
                                            wire:target="openEditModal({{ $grade->id }})"
                                            class="h-8 w-8 rounded-md bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 flex items-center justify-center transition-colors disabled:opacity-60">
                                            <i class="fas fa-pen text-xs"></i>
                                        </button>

                                        <button wire:click="confirmDelete({{ $grade->id }})" wire:loading.attr="disabled"
                                            wire:target="confirmDelete({{ $grade->id }})"
                                            class="h-8 w-8 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center transition-colors disabled:opacity-60">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    @endcan

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center py-14">
                                <i class="fas fa-layer-group text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No grades yet.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- ===================== CREATE / EDIT MODAL ===================== --}}
    @can('manage grades')
        @if ($showFormModal)
            <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
                <div
                    class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden">

                    <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                        <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                        <div class="flex items-center justify-between">
                            <h3 class="text-white font-bold text-lg">{{ $editingId ? 'Edit' : 'New' }} Grade</h3>
                            <button type="button" wire:click="closeFormModal"
                                class="h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="save" class="flex flex-col flex-1 min-h-0">
                        <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">

                            <div class="rounded-lg bg-amber-50 border border-amber-200 px-3 py-2.5 text-xs text-amber-700">
                                <i class="fas fa-triangle-exclamation mr-1"></i>
                                This grade is shared across every school on SchoolGear. Changes here affect all schools.
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Level *</label>
                                <input type="text" wire:model="level" placeholder="e.g. Grade 4"
                                    class="w-full text-sm py-2.5 px-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                @error('level')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Section</label>
                                <input type="text" wire:model="section" placeholder="e.g. A (optional)"
                                    class="w-full text-sm py-2.5 px-3 border border-slate-300 rounded-lg focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                                @error('section')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                        </div>

                        <div
                            class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                            <button type="button" wire:click="closeFormModal"
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
    @endcan

    {{-- ===================== DELETE MODAL ===================== --}}
    @can('manage grades')
        @if ($showDeleteModal)
            <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
                <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">
                    <div
                        class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                        <h3 class="text-sm font-semibold text-white">Delete Grade</h3>
                        <button wire:click="closeDeleteModal"
                            class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    </div>
                    <div class="p-4 text-sm text-slate-700 space-y-2">
                        <p>Are you sure? This cannot be undone.</p>
                        <p class="text-xs text-amber-700 bg-amber-50 border border-amber-200 rounded-lg px-3 py-2">
                            <i class="fas fa-triangle-exclamation mr-1"></i>
                            This grade is global. If any school still has enrollments or grade locks against it, deletion is
                            blocked automatically.
                        </p>
                    </div>
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
    @endcan

    {{-- ===================== TEACHER ASSIGNMENT MODAL ===================== --}}
    @can('assign grade teachers')
        @if ($showTeacherModal)
            <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
                <div
                    class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                    <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                        <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                        <div class="flex items-start justify-between gap-3">
                            @include('partials.modal-school-header', ['title' => 'Assign Teachers'])
                            <button type="button" wire:click="closeTeacherModal"
                                class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <form wire:submit.prevent="saveTeachers" class="flex-1 overflow-y-auto bg-[#F8FAFC] p-6 space-y-5">

                        <div class="rounded-xl border-2 border-sky-100 bg-sky-50/40 overflow-hidden">

                            <div class="flex items-start gap-3 px-5 py-4 border-b border-sky-100 bg-sky-50">
                                <div
                                    class="h-10 w-10 shrink-0 rounded-lg bg-[#155E8A] text-white flex items-center justify-center shadow-sm">
                                    <i class="fas fa-chalkboard-teacher"></i>
                                </div>
                                <div>
                                    <h3 class="text-sm font-bold text-[#155E8A]">Teachers for this Grade</h3>
                                    <p class="text-xs text-slate-500 mt-0.5">Only teachers from your school are shown here.
                                    </p>
                                </div>
                            </div>

                            <div class="p-5">
                                @if (count($teacherOptions))
                                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                        @foreach ($teacherOptions as $teacher)
                                            <label
                                                class="relative flex items-center gap-3 p-3 rounded-xl border cursor-pointer transition
                                                {{ in_array($teacher->id, $teacherIds ?? [])
                                                    ? 'border-[#155E8A] bg-sky-100 shadow-sm'
                                                    : 'border-slate-200 bg-white hover:border-sky-300 hover:bg-sky-50' }}">

                                                <input type="checkbox" value="{{ $teacher->id }}"
                                                    wire:model="teacherIds"
                                                    class="h-4 w-4 rounded border-slate-300 text-[#155E8A] focus:ring-[#155E8A]">

                                                <div
                                                    class="h-10 w-10 rounded-full flex items-center justify-center shrink-0 overflow-hidden
                                                    {{ in_array($teacher->id, $teacherIds ?? []) ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-500' }}">
                                                    @if ($teacher->image)
                                                        <img src="{{ Storage::url($teacher->image) }}"
                                                            alt="{{ $teacher->name }}"
                                                            class="h-full w-full object-cover">
                                                    @else
                                                        <i class="fas fa-user-tie text-sm"></i>
                                                    @endif
                                                </div>

                                                <div class="min-w-0 flex-1">
                                                    <p class="text-sm font-semibold text-slate-800 truncate">
                                                        {{ $teacher->name }}</p>
                                                    <p class="text-xs text-slate-400">Teacher</p>
                                                </div>

                                                @if (in_array($teacher->id, $teacherIds ?? []))
                                                    <div
                                                        class="h-7 w-7 rounded-full bg-[#155E8A] text-white flex items-center justify-center shrink-0">
                                                        <i class="fas fa-check text-xs"></i>
                                                    </div>
                                                @endif
                                            </label>
                                        @endforeach
                                    </div>
                                @else
                                    <div class="py-8 text-center">
                                        <div
                                            class="mx-auto mb-3 h-12 w-12 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
                                            <i class="fas fa-user-tie"></i>
                                        </div>
                                        <p class="text-sm font-medium text-slate-600">No teachers available.</p>
                                        <p class="text-xs text-slate-400 mt-1">Create a user with the Teacher role first.
                                        </p>
                                    </div>
                                @endif
                            </div>

                            <div class="px-5 py-3 bg-white border-t border-sky-100">
                                <p class="text-xs font-medium text-[#155E8A] flex items-center gap-2">
                                    <i class="fas fa-check-circle"></i>
                                    {{ count($teacherIds ?? []) }}
                                    {{ count($teacherIds ?? []) === 1 ? 'teacher assigned' : 'teachers assigned' }}
                                </p>
                            </div>
                        </div>

                        <div class="flex flex-col-reverse sm:flex-row justify-end gap-2">
                            <button type="button" wire:click="closeTeacherModal"
                                class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Cancel</button>
                            <button type="submit"
                                class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm">
                                <span wire:loading.remove wire:target="saveTeachers">Save Assignments</span>
                                <span wire:loading wire:target="saveTeachers">Saving...</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        @endif
    @endcan

</div>
