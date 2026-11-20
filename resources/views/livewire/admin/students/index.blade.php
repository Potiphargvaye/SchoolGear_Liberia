<div class="min-w-0 p-3 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    {{-- ADD THIS BLOCK --}}
    <div class="relative overflow-hidden rounded-xl px-5 py-4 border border-[#155E8A]/15 bg-gradient-to-r from-[#155E8A]/10 via-sky-50 to-[#155E8A]/5"
        x-data="{
            greeting: 'Hello',
            init() {
                const h = new Date().getHours();
                this.greeting = h < 12 ? 'Good morning' : (h < 17 ? 'Good afternoon' : 'Good evening');
            }
        }">
        <div class="flex min-w-0 items-center gap-3">
            <div class="h-9 w-9 shrink-0 rounded-lg bg-[#155E8A]/15 flex items-center justify-center">
                <i class="fas fa-hand-sparkles text-[#155E8A] text-sm"></i>
            </div>
            <p class="text-sm sm:text-base text-slate-700">
                <span x-text="greeting"></span>, {{ auth()->user()->name }} 👋 here's what's happening at
                <span class="font-bold text-[#155E8A]">{{ auth()->user()->school->school_name ?? 'your school' }}</span>
                today.
            </p>
        </div>
    </div>
    {{-- END ADDED BLOCK --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Students</h1>
            <p class="text-slate-500 text-sm mt-1">{{ $totalStudents }} student{{ $totalStudents === 1 ? '' : 's' }} on
                record.</p>
        </div>
        <a href="{{ route('admin.enrollments.index') }}"
            class="inline-flex min-h-11 w-full sm:w-auto items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
            <i class="fas fa-graduation-cap text-xs"></i> Manage Enrollments
        </a>
    </div>

    {{-- ADD THIS ENTIRE BLOCK --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-sky-100 text-[#155E8A] flex items-center justify-center shrink-0">
                <i class="fas fa-users text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Total Students</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">{{ number_format($totalStudents) }}
                </p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                <i class="fas fa-user-check text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Active</p>
                <p class="text-base sm:text-lg font-bold text-green-700 truncate">{{ number_format($activeCount) }}</p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-sky-100 text-[#155E8A] flex items-center justify-center shrink-0">
                <i class="fas fa-user-graduate text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Graduated</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">{{ number_format($graduatedCount) }}
                </p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-orange-100 text-orange-700 flex items-center justify-center shrink-0">
                <i class="fas fa-user-clock text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Suspended</p>
                <p class="text-base sm:text-lg font-bold text-orange-700 truncate">{{ number_format($suspendedCount) }}
                </p>
            </div>
        </div>

        <div
            class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0 col-span-2 sm:col-span-1">
            <div class="h-10 w-10 rounded-lg bg-red-100 text-[#B91C1C] flex items-center justify-center shrink-0">
                <i class="fas fa-user-xmark text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Other</p>
                <p class="text-base sm:text-lg font-bold text-[#B91C1C] truncate">{{ number_format($otherCount) }}</p>
            </div>
        </div>

    </div>
    {{-- END ADDED BLOCK --}}

    <div class="grid min-w-0 grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3">
        <input type="text" wire:model.live.debounce.400ms="search"
            placeholder="Search by name, email, or registration ID..."
            class="w-full min-w-0 px-3.5 py-3 rounded-lg border border-slate-300 text-base focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
        <select wire:model.live="gradeFilter" class="w-full min-w-0 rounded-lg border border-slate-300 px-3 py-3 text-base">
            <option value="">All Grades</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}</option>
            @endforeach
        </select>
        {{-- ADD THIS SELECT: STATUS FILTER --}}
        <select wire:model.live="statusFilter" class="w-full min-w-0 rounded-lg border border-slate-300 px-3 py-3 text-base">
            <option value="">All Statuses</option>
            <option value="active">Active</option>
            <option value="graduated">Graduated</option>
            <option value="suspended">Suspended</option>
            <option value="transferred">Transferred</option>
            <option value="dropped_out">Dropped Out</option>
            <option value="expelled">Expelled</option>
        </select>
        {{-- ADD THIS SELECT --}}
        <select wire:model.live="academicYearFilter" class="w-full min-w-0 rounded-lg border border-slate-300 px-3 py-3 text-base">
            <option value="">All Academic Years</option>
            @foreach ($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 gap-3 md:hidden">
        @forelse ($students as $student)
            @php $st = $student->enrollment?->status; @endphp
            <article class="min-w-0 rounded-xl border border-[#E2E8F0] bg-white p-3 shadow-sm">
                <div class="flex min-w-0 items-start gap-3">
                    <div class="h-12 w-12 shrink-0 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                        @if ($student->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($student->image))
                            <img src="{{ asset('storage/' . $student->image) }}" alt="{{ $student->name }}"
                                class="h-full w-full object-cover">
                        @else
                            <span class="text-sm font-semibold text-slate-500">{{ strtoupper(substr($student->name, 0, 1)) }}</span>
                        @endif
                    </div>
                    <div class="min-w-0 flex-1">
                        <div class="flex min-w-0 flex-wrap items-start justify-between gap-2">
                            <h2 class="min-w-0 flex-1 truncate font-semibold text-slate-800" title="{{ $student->name }}">{{ $student->name }}</h2>
                            @if ($st === 'active')
                                <span class="shrink-0 rounded-full bg-green-100 px-2.5 py-1 text-xs font-medium text-green-700">Active</span>
                            @elseif ($st === 'graduated')
                                <span class="shrink-0 rounded-full bg-sky-100 px-2.5 py-1 text-xs font-medium text-[#155E8A]">Graduated</span>
                            @elseif ($st === 'suspended')
                                <span class="shrink-0 rounded-full bg-orange-100 px-2.5 py-1 text-xs font-medium text-orange-700">Suspended</span>
                            @elseif (in_array($st, ['transferred', 'dropped_out', 'expelled']))
                                <span class="shrink-0 rounded-full bg-red-100 px-2.5 py-1 text-xs font-medium text-red-700 capitalize">{{ str_replace('_', ' ', $st) }}</span>
                            @else
                                <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-600">No enrollment</span>
                            @endif
                        </div>
                        <p class="mt-1 break-all font-mono text-xs text-slate-600">{{ $student->user->registration_id }}</p>
                        <p class="mt-1 break-words text-sm text-slate-600">
                            {{ optional($student->enrollment?->grade)->level }} {{ optional($student->enrollment?->grade)->section }}
                            <span class="text-slate-400">·</span>
                            {{ optional($student->enrollment?->academicYear)->name ?? 'No academic year' }}
                        </p>
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2 border-t border-slate-100 pt-3">
                    @if ($canView)
                        <a href="{{ route('admin.students.show', $student->id) }}" wire:navigate title="View" aria-label="View {{ $student->name }}"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-md bg-sky-100 px-3 text-sky-700 hover:bg-sky-700 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-eye text-xs"></i><span class="sr-only">View</span>
                        </a>
                    @endif
                    @if ($canEdit)
                        <a href="{{ route('admin.students.show', $student->id) }}?edit=1" wire:navigate title="Edit" aria-label="Edit {{ $student->name }}"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-md bg-amber-100 px-3 text-amber-700 hover:bg-amber-600 hover:text-white focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-pen text-xs"></i><span class="sr-only">Edit</span>
                        </a>
                    @endif
                    @if ($canDelete)
                        <button wire:click="confirmDelete({{ $student->id }})" wire:loading.attr="disabled"
                            wire:target="confirmDelete({{ $student->id }})" title="Delete" aria-label="Delete {{ $student->name }}"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-md bg-red-100 px-3 text-[#B91C1C] hover:bg-[#B91C1C] hover:text-white disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-trash text-xs" wire:loading.remove wire:target="confirmDelete({{ $student->id }})"></i>
                            <i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="confirmDelete({{ $student->id }})"></i>
                        </button>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-[#E2E8F0] bg-white px-4 py-10 text-center md:hidden">
                <i class="fas fa-user-graduate text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 text-sm">No students found.</p>
            </div>
        @endforelse
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[680px] text-sm lg:min-w-[900px]">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="sticky left-0 z-10 bg-[#155E8A] px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase w-12">No.</th>
                        {{-- ADD --}}
                        <th class="hidden px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase w-16 lg:table-cell">Photo</th>
                        <th class="hidden px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase lg:table-cell">Student ID</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Name</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Grade</th>
                        <th class="hidden px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase lg:table-cell">Academic Year</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Enrollment Status</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($students as $student)
                        <tr class="hover:bg-sky-50/60 transition-colors">
                            <td class="sticky left-0 z-10 bg-white px-4 sm:px-6 py-3 text-slate-500 text-sm">
                                {{ $students->firstItem() + $loop->index }}
                            </td>

                            {{-- ADD THIS TD --}}
                            <td class="hidden px-4 sm:px-6 py-3 lg:table-cell">
                                <div
                                    class="h-9 w-9 rounded-full bg-slate-100 border border-slate-200 overflow-hidden flex items-center justify-center">
                                    @if ($student->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($student->image))
                                        <img src="{{ asset('storage/' . $student->image) }}"
                                            alt="{{ $student->name }}" class="h-full w-full object-cover">
                                    @else
                                        <span class="text-xs font-semibold text-slate-500">
                                            {{ strtoupper(substr($student->name, 0, 1)) }}
                                        </span>
                                    @endif
                                </div>
                            </td>
                            <td class="hidden px-4 sm:px-6 py-3 font-mono text-xs text-slate-600 lg:table-cell">
                                {{ $student->user->registration_id }}</td>
                            <td class="px-4 sm:px-6 py-3 font-semibold text-slate-800">{{ $student->name }}</td>
                            <td class="hidden px-4 sm:px-6 py-3 text-slate-600 lg:table-cell">
                                {{ optional($student->enrollment?->grade)->level }}
                                {{ optional($student->enrollment?->grade)->section }}
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-slate-600">
                                {{ optional($student->enrollment?->academicYear)->name }}
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-center">
                                @php $st = $student->enrollment?->status; @endphp
                                @if ($st === 'active')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
                                @elseif ($st === 'graduated')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-sky-100 text-[#155E8A]">Graduated</span>
                                @elseif ($st === 'suspended')
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Suspended</span>
                                @elseif (in_array($st, ['transferred', 'dropped_out', 'expelled']))
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-700 capitalize">{{ str_replace('_', ' ', $st) }}</span>
                                @else
                                    <span
                                        class="px-2.5 py-1 rounded-full text-xs font-medium bg-slate-100 text-slate-500">—</span>
                                @endif
                            </td>
                            <td class="px-4 sm:px-6 py-3">
                                <div class="flex justify-center flex-wrap gap-2">
                                    @if ($canView)
                                        <a href="{{ route('admin.students.show', $student->id) }}" wire:navigate
                                            title="View"
                                            aria-label="View {{ $student->name }}"
                                            class="h-11 w-11 rounded-md bg-sky-100 hover:bg-sky-700 hover:text-white text-sky-700 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <i class="fas fa-eye text-xs"></i>
                                        </a>
                                    @endif

                                    @if ($canEdit)
                                        <a href="{{ route('admin.students.show', $student->id) }}?edit=1"
                                            wire:navigate title="Edit" aria-label="Edit {{ $student->name }}"
                                            class="h-11 w-11 rounded-md bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <i class="fas fa-pen text-xs"></i>
                                        </a>
                                    @endif

                                    @if ($canDelete)
                                        <button wire:click="confirmDelete({{ $student->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmDelete({{ $student->id }})"
                                            aria-label="Delete {{ $student->name }}"
                                            class="h-11 w-11 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <i class="fas fa-trash text-xs" wire:loading.remove
                                                wire:target="confirmDelete({{ $student->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="confirmDelete({{ $student->id }})"></i>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-14">
                                <i class="fas fa-user-graduate text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No students found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
            {{ $students->links() }}
        </div>
    </div>

    {{-- DELETE MODAL --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm max-h-[92dvh] overflow-y-auto rounded-xl shadow-xl border border-red-100">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">Delete Student</h3>
                    <button wire:click="closeDeleteModal"
                        aria-label="Close delete confirmation"
                        class="h-11 w-11 shrink-0 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="break-words p-4 text-sm text-gray-700">Delete <strong>{{ $deleteStudentName }}</strong>? This cannot
                    be
                    undone.</div>
                <div class="bg-gray-50 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                    <button wire:click="closeDeleteModal"
                        class="min-h-11 px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Cancel</button>
                    <button wire:click="deleteStudent"
                        class="min-h-11 px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                        <span wire:loading.remove wire:target="deleteStudent">Delete</span>
                        <span wire:loading wire:target="deleteStudent">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
