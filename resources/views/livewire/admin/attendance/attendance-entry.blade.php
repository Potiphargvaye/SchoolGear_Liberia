<div class="min-w-0 max-w-full space-y-5 overflow-x-clip px-2 py-2 pb-36 text-slate-800 dark:text-slate-200 sm:pb-2">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="space-y-5">

        @include('partials.notifications')

        <div class="min-w-0 rounded-xl border border-slate-200 bg-white px-3 py-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:px-5">
            <div class="grid min-w-0 grid-cols-1 items-end gap-3 sm:grid-cols-2 lg:grid-cols-[repeat(4,minmax(0,1fr))_minmax(0,1.3fr)_minmax(0,1.5fr)]">
                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Academic Year</label>
                    <select wire:model.live="academicYearId"
                        class="min-h-11 min-w-0 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        @foreach ($allAcademicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex min-w-0 flex-col gap-1">
                    <label class="flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">
                        Grade / Class
                        @if (auth()->user()->hasRole('Teacher'))
                            <span
                                class="rounded-md bg-emerald-100 px-1.5 py-0.5 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">My
                                Classes</span>
                        @endif
                    </label>
                    <select wire:model.live="gradeId"
                        class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        @foreach ($allGrades as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Period</label>
                    <select wire:model.live="periodId" class="min-h-11 min-w-0 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        @foreach ($allPeriods as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex min-w-0 flex-col gap-1">
                    <label class="flex items-center gap-1.5 text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">
                        Subject
                        @if (auth()->user()->hasRole('Teacher'))
                            <span
                                class="rounded-md bg-emerald-100 px-1.5 py-0.5 text-xs font-semibold text-emerald-800 dark:bg-emerald-950 dark:text-emerald-200">My
                                Subjects</span>
                        @endif
                    </label>
                    <select wire:model.live="subjectId"
                        class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        @foreach ($allSubjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Date</label>
                    <div class="flex min-w-0 gap-1">
                        <input type="date" wire:model.live="date"
                            class="min-h-11 min-w-0 w-full rounded-xl border border-slate-200 px-2 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        <button wire:click="$set('date', '{{ now()->toDateString() }}')"
                            class="min-h-11 shrink-0 rounded-xl bg-[#EBF4FA] px-3 py-2.5 text-xs font-semibold text-[#155E8A] focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600">Today</button>
                    </div>
                </div>

                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Find Student</label>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search by name…"
                        class="min-h-11 min-w-0 w-full rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                </div>
            </div>

            <div class="mt-3">
                @if ($isLocked)
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1.5 text-xs font-semibold text-red-800 dark:bg-red-950 dark:text-red-200">
                        <i class="fa-solid fa-lock"></i> Locked by administrator for this date
                    </span>
                @elseif ($lastSaved)
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-800 dark:bg-green-950 dark:text-green-200">
                        <i class="fa-solid fa-circle-check"></i> Recorded last saved by {{ $lastSaved['name'] }} at
                        {{ $lastSaved['time'] }}
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 rounded-full bg-amber-100 px-3 py-1.5 text-xs font-semibold text-amber-800 dark:bg-amber-950 dark:text-amber-200">
                        <i class="fa-solid fa-clock"></i> Not yet recorded for this date
                    </span>
                @endif
            </div>
        </div>

        <div class="min-w-0 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">

            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-3 py-3 dark:border-slate-700 sm:px-5">
                <button wire:click="markAllPresent" @if ($isLocked) disabled @endif
                    class="min-h-11 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs font-semibold text-green-800 disabled:opacity-40 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-green-600 dark:border-green-800 dark:bg-green-950 dark:text-green-200">
                    <i class="fa-solid fa-user-check mr-1"></i> Mark All Present
                </button>

                <div class="hidden items-center gap-3 text-sm font-medium sm:flex">
                    <span class="text-green-700 dark:text-green-300">{{ $this->counts['present'] }} Present</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-red-700 dark:text-red-300">{{ $this->counts['absent'] }} Absent</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-amber-700 dark:text-amber-300">{{ $this->counts['late'] }} Late</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-slate-400">{{ $this->counts['unmarked'] }} Unmarked</span>
                </div>
            </div>

            <div class="hidden grid-cols-[2rem_minmax(0,1.15fr)_minmax(280px,1.8fr)_minmax(170px,1fr)_2.75rem] items-center gap-3 bg-[#155E8A] px-4 py-3 text-xs font-semibold uppercase text-white lg:grid">
                <span class="text-center">#</span>
                <span>Student</span>
                <span class="text-center">Mark Attendance</span>
                <span>Remarks</span>
                <span class="text-center">History</span>
            </div>
            <div class="space-y-2 p-2 sm:p-3 lg:space-y-0 lg:p-0">
                @forelse ($this->filteredEnrollments as $i => $enrollment)
                    @php $status = $marks[$enrollment->id]['status'] ?? null; @endphp
                    <div class="grid min-w-0 grid-cols-1 gap-3 rounded-xl border border-slate-200 p-3 dark:border-slate-700
                        {{ $status === 'absent' ? 'bg-red-50 dark:bg-red-950/30' : ($status === 'late' ? 'bg-amber-50 dark:bg-amber-950/30' : 'bg-white dark:bg-slate-900') }}
                        lg:grid-cols-[2rem_minmax(0,1.15fr)_minmax(280px,1.8fr)_minmax(170px,1fr)_2.75rem] lg:items-center lg:gap-3 lg:rounded-none lg:border-0 lg:border-b lg:border-slate-100 lg:px-4 lg:py-3">
                        <span class="hidden text-center text-slate-400 lg:block">{{ $i + 1 }}</span>
                        <div class="flex min-w-0 items-center gap-2">
                            <span class="inline-flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-[#F2F1FA] text-sm font-semibold text-[#3A2A99] dark:bg-slate-700 dark:text-white lg:hidden">
                                {{ strtoupper(substr($enrollment->student->name, 0, 1)) }}
                            </span>
                            <span class="min-w-0 truncate font-semibold text-slate-800 dark:text-slate-100" title="{{ $enrollment->student->name }}">{{ $enrollment->student->name }}</span>
                            <span class="ml-auto shrink-0 text-xs text-slate-400 lg:hidden">#{{ $i + 1 }}</span>
                        </div>
                        <div class="min-w-0">
                            <span class="mb-1 block text-[11px] font-semibold uppercase text-slate-500 dark:text-slate-300 lg:hidden">Mark attendance</span>
                            <div class="grid grid-cols-3 gap-1 sm:gap-2 lg:flex lg:items-center lg:justify-center">
                                        @foreach (['present' => ['green', 'user-check'], 'absent' => ['red', 'user-xmark'], 'late' => ['amber', 'clock']] as $s => [$color, $icon])
                                            <button wire:click="mark({{ $enrollment->id }}, '{{ $s }}')"
                                                @if ($isLocked) disabled @endif
                                                aria-pressed="{{ $status === $s ? 'true' : 'false' }}"
                                                class="flex min-h-11 min-w-0 items-center justify-center gap-1 rounded-full border-2 px-1 py-2 text-[10px] font-semibold sm:px-3 sm:text-xs
                                                border-{{ $color }}-500 text-{{ $color }}-700 bg-{{ $color }}-50
                                                {{ $status === $s ? 'ring-2 ring-' . $color . '-400 ring-offset-1 shadow-md' : 'opacity-50' }}
                                                disabled:cursor-not-allowed focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 dark:bg-slate-800 dark:text-{{ $color }}-300 lg:min-w-[88px] lg:px-3">
                                                <i class="fa-solid fa-{{ $icon }}"></i> {{ ucfirst($s) }}
                                            </button>
                                        @endforeach
                            </div>
                        </div>
                        <div class="min-w-0">
                                    @if (in_array($status, ['absent', 'late']))
                                        <label class="mb-1 block text-[11px] font-semibold uppercase text-slate-500 dark:text-slate-300 lg:hidden">Remarks</label>
                                        <input type="text" wire:model.blur="marks.{{ $enrollment->id }}.remarks"
                                            placeholder="Add a note…" @if ($isLocked) disabled @endif
                                            class="min-h-11 w-full min-w-0 rounded-lg border border-slate-200 px-3 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                                    @endif
                        </div>
                        <div class="min-w-0">
                            <span class="mb-1 block text-[11px] font-semibold uppercase text-slate-500 dark:text-slate-300 lg:hidden">History</span>
                            <div class="flex lg:justify-center">
                                    <a href="{{ route('attendance.history', ['enrollment_id' => $enrollment->id]) }}"
                                        title="View attendance history"
                                        aria-label="View attendance history for {{ $enrollment->student->name }}"
                                        class="inline-flex min-h-11 w-full items-center justify-center gap-2 rounded-lg bg-slate-100 px-3 text-slate-600 transition-colors hover:bg-[#155E8A] hover:text-white focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 dark:bg-slate-800 dark:text-slate-200 lg:w-11 lg:px-0">
                                        <i class="fa-solid fa-clock-rotate-left text-xs" aria-hidden="true"></i><span class="lg:hidden">History</span>
                                    </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="py-12 text-center text-slate-500 dark:text-slate-300">
                        <i class="fa-solid fa-users-slash mb-2 block text-3xl" aria-hidden="true"></i>
                        No students found for this Grade and Academic Year.
                    </div>
                @endforelse
            </div>

            @if ($this->filteredEnrollments->isNotEmpty())
                <div
                    class="fixed inset-x-0 bottom-0 z-[60] grid grid-cols-1 gap-2 border-t border-slate-200 bg-white/95 px-3 pt-3 pb-[calc(0.75rem+env(safe-area-inset-bottom))] shadow-[0_-8px_24px_rgba(15,23,42,0.12)] backdrop-blur dark:border-slate-700 dark:bg-slate-900/95 sm:static sm:flex sm:items-center sm:justify-end sm:gap-3 sm:px-5 sm:py-4 sm:shadow-none sm:backdrop-blur-none lg:sticky lg:bottom-0">
                    <div class="grid grid-cols-4 gap-1 text-center text-[10px] font-semibold sm:hidden">
                        <span class="text-green-700 dark:text-green-300">{{ $this->counts['present'] }}<span class="block font-normal">Present</span></span>
                        <span class="text-red-700 dark:text-red-300">{{ $this->counts['absent'] }}<span class="block font-normal">Absent</span></span>
                        <span class="text-amber-700 dark:text-amber-300">{{ $this->counts['late'] }}<span class="block font-normal">Late</span></span>
                        <span class="text-slate-600 dark:text-slate-300">{{ $this->counts['unmarked'] }}<span class="block font-normal">Unmarked</span></span>
                    </div>
                    <button wire:click="save" @if ($isLocked) disabled @endif
                        class="min-h-11 w-full rounded-xl bg-[#155E8A] px-6 py-2.5 text-sm font-semibold text-white hover:bg-[#0F4A6E] disabled:opacity-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 sm:w-auto">
                        <span wire:loading.remove wire:target="save"><i class="fa-solid fa-floppy-disk mr-1"></i> Save
                            Attendance</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
