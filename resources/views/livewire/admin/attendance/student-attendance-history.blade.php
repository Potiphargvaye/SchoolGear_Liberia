<div class="min-w-0 max-w-full space-y-5 overflow-x-clip px-2 py-2 text-slate-800 dark:text-slate-200">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="px-2 py-2 space-y-5">
        @include('partials.notifications')

        @if ($pickerMode)
            <div class="min-w-0 rounded-xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <h2 class="mb-3 font-semibold text-slate-800 dark:text-slate-100">Select a student to view their attendance history</h2>
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search by student name..."
                    class="mb-4 min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-4 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                <div class="divide-y divide-slate-100">
                    @forelse ($students as $enrollment)
                        <button wire:click="selectStudent({{ $enrollment->id }})"
                            class="flex min-h-11 w-full min-w-0 items-center justify-between gap-3 rounded-lg px-3 py-3 text-left hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 dark:hover:bg-slate-800">
                            <div>
                                <p class="truncate font-semibold text-slate-800 dark:text-slate-100">{{ $enrollment->student->name }}</p>
                                <p class="text-xs text-slate-500 dark:text-slate-300">
                                    {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' - ' . $enrollment->grade->section : '' }}
                                </p>
                            </div>
                            <i class="fas fa-arrow-right shrink-0 text-slate-400" aria-hidden="true"></i>
                        </button>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-500 dark:text-slate-300">No students found.</p>
                    @endforelse
                </div>
            </div>
        @else
            <div class="min-w-0 overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="h-1 bg-[#155E8A]"></div>
                <div class="px-3 py-4 sm:px-6 sm:py-5">
                    <div class="flex min-w-0 flex-col items-start justify-between gap-4 lg:flex-row lg:flex-wrap">
                        <div class="min-w-0">
                            <button wire:click="$set('enrollmentId', null)"
                                class="mb-1 inline-flex min-h-11 items-center text-xs text-slate-500 hover:text-[#155E8A] focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 dark:text-slate-300">
                                <i class="fas fa-arrow-left mr-1"></i> Back to search
                            </button>
                            <h2 class="max-w-full break-words text-xl font-bold text-slate-800 dark:text-slate-100 sm:text-2xl">{{ $enrollment->student->name }}</h2>
                            <p class="mt-1 text-sm text-slate-500 dark:text-slate-300">
                                {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' - ' . $enrollment->grade->section : '' }}
                            </p>
                        </div>
                        <div class="grid w-full grid-cols-2 gap-2 sm:grid-cols-4 sm:gap-3 lg:w-auto">
                            <div class="rounded-xl bg-slate-50 px-3 py-3 text-center dark:bg-slate-800 sm:px-4">
                                <p class="mb-1 text-xs text-slate-600 dark:text-slate-300">Rate</p>
                                <p
                                    class="text-xl font-bold {{ $attendanceRate >= 80 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                    {{ $attendanceRate }}%</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-3 text-center dark:bg-slate-800 sm:px-4">
                                <p class="mb-1 text-xs text-slate-600 dark:text-slate-300">Present</p>
                                <p class="text-xl font-bold text-green-700 dark:text-green-300">{{ $daysPresent }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-3 text-center dark:bg-slate-800 sm:px-4">
                                <p class="mb-1 text-xs text-slate-600 dark:text-slate-300">Absent</p>
                                <p class="text-xl font-bold text-red-700 dark:text-red-300">{{ $daysAbsent }}</p>
                            </div>
                            <div class="rounded-xl bg-slate-50 px-3 py-3 text-center dark:bg-slate-800 sm:px-4">
                                <p class="mb-1 text-xs text-slate-600 dark:text-slate-300">Late</p>
                                <p class="text-xl font-bold text-amber-700 dark:text-amber-300">{{ $timesLate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="min-w-0 rounded-xl border border-slate-200 bg-white px-3 py-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:px-5">
                <div class="grid min-w-0 grid-cols-1 items-end gap-3 sm:grid-cols-2">
                    <div class="flex min-w-0 flex-col gap-1">
                        <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Period</label>
                        <select wire:model.live="periodFilter"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                            <option value="">All Periods</option>
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
                                    class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-md font-semibold">My
                                    Subjects</span>
                            @endif
                        </label>
                        <select wire:model.live="subjectFilter"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                            <option value="">All Subjects</option>
                            @foreach ($allSubjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($periodFilter || $subjectFilter)
                        <button wire:click="resetFilters"
                            class="min-h-11 rounded-xl border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800 sm:col-span-2 sm:justify-self-start">
                            <i class="fas fa-xmark mr-1"></i> Clear Filters
                        </button>
                    @endif
                </div>

                @if ($periodFilter || $subjectFilter)
                    <p class="mt-2 text-xs text-slate-600 dark:text-slate-300">
                        Showing records for
                        @if ($periodFilter)
                            <span
                                class="font-semibold text-slate-700 dark:text-slate-200">{{ $allPeriods->firstWhere('id', $periodFilter)?->name }}</span>
                        @endif
                        @if ($periodFilter && $subjectFilter)
                            +
                        @endif
                        @if ($subjectFilter)
                            <span
                                class="font-semibold text-slate-700 dark:text-slate-200">{{ $allSubjects->firstWhere('id', $subjectFilter)?->name }}</span>
                        @endif
                        only Summary, Monthly Pattern, and All Records below are synced to this.
                    </p>
                @endif
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-white p-3 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">Monthly Attendance Pattern</h2>
                    <div class="flex items-center gap-1">
                        <button wire:click="changeMonth('prev')"
                            aria-label="Previous month"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-slate-200 text-xs hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 dark:border-slate-600 dark:hover:bg-slate-800">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span class="px-2 text-sm font-semibold text-slate-700 dark:text-slate-200 sm:px-3">{{ $monthLabel }}</span>
                        <button wire:click="changeMonth('next')"
                            aria-label="Next month"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-lg border border-slate-200 text-xs hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 dark:border-slate-600 dark:hover:bg-slate-800">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    @foreach ($weeks as $weekNumber => $days)
                        <div class="flex min-w-0 items-center gap-1.5 sm:gap-2">
                            <span class="w-11 shrink-0 text-[10px] font-semibold text-slate-500 dark:text-slate-300 sm:w-14 sm:text-xs">Week
                                {{ $weekNumber }}</span>
                            <div class="grid min-w-0 flex-1 grid-cols-7 gap-1 sm:gap-1.5">
                                @foreach ($days as $cell)
                                    @php
                                        $cls = match ($cell['status']) {
                                            'present' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-200',
                                            'absent' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-200',
                                            'late' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
                                            default => $cell['isWeekend']
                                                ? 'bg-slate-50 text-slate-500 dark:bg-slate-800 dark:text-slate-400'
                                                : 'bg-slate-100 text-slate-600 dark:bg-slate-700 dark:text-slate-300',
                                        };
                                        $icon = match ($cell['status']) {
                                            'present' => '✓',
                                            'absent' => '✕',
                                            'late' => '⏰',
                                            default => '',
                                        };
                                    @endphp
                                    <div title="{{ $cell['remark'] ?? '' }}"
                                        aria-label="{{ $cell['status'] ? ucfirst($cell['status']) : 'No record' }} on {{ $cell['date'] }}"
                                        class="{{ $cls }} min-w-0 rounded-lg p-1 text-center text-[10px] font-bold sm:p-2 sm:text-xs">
                                        {{ $cell['date'] }}<div class="text-xs">{{ $icon ?: 'N/R' }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="min-w-0 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-3 py-4 dark:border-slate-700 sm:px-5">
                    <h2 class="font-semibold text-slate-800 dark:text-slate-100">All Records</h2>
                    <select wire:model.live="statusFilter" class="min-h-11 min-w-0 rounded-lg border border-slate-200 px-3 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                        <option value="">All Statuses</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>
                <div class="space-y-2 p-3 md:hidden">
                    @forelse ($records as $rec)
                        @php
                            $recordBadge = match ($rec->status) {
                                'present' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-200',
                                'absent' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-200',
                                'late' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
                            };
                        @endphp
                        <article class="min-w-0 rounded-xl border border-slate-200 p-3 dark:border-slate-700">
                            <div class="flex min-w-0 items-start justify-between gap-2">
                                <div class="min-w-0">
                                    <h3 class="font-semibold text-slate-800 dark:text-slate-100">{{ $rec->date->format('d M Y') }}</h3>
                                    <p class="mt-1 break-words text-xs text-slate-600 dark:text-slate-300">
                                        {{ $rec->period->name ?? '—' }} · {{ $rec->subject->name ?? '—' }}
                                    </p>
                                </div>
                                <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $recordBadge }}">{{ $rec->status }}</span>
                            </div>
                            <dl class="mt-3 grid min-w-0 grid-cols-1 gap-2 text-xs">
                                <div class="min-w-0"><dt class="font-semibold text-slate-500 dark:text-slate-300">Remarks</dt><dd class="break-words text-slate-700 dark:text-slate-200">{{ $rec->remarks ?: 'N/R' }}</dd></div>
                                <div class="min-w-0"><dt class="font-semibold text-slate-500 dark:text-slate-300">Recorded by</dt><dd class="break-words text-slate-700 dark:text-slate-200">{{ $rec->markedBy->name ?? 'Unknown' }}</dd></div>
                            </dl>
                        </article>
                    @empty
                        <p class="py-8 text-center text-sm text-slate-500 dark:text-slate-300">No records match this filter.</p>
                    @endforelse
                </div>
                <div class="hidden max-w-full overflow-x-auto md:block">
                    <table class="w-full min-w-[780px] text-sm">
                        <thead>
                            <tr class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                                <th class="sticky left-0 bg-slate-50 px-3 py-3 text-left dark:bg-slate-800 sm:px-5">Date</th>
                                <th class="px-4 py-3 text-left">Period</th>
                                <th class="px-4 py-3 text-left">Subject</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-left">Remarks</th>
                                <th class="px-4 py-3 text-left">Recorded By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($records as $rec)
                                <tr class="hover:bg-slate-50 dark:hover:bg-slate-800">
                                    <td class="sticky left-0 bg-white px-3 py-3 font-medium text-slate-800 dark:bg-slate-900 dark:text-slate-100 sm:px-5">{{ $rec->date->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-700 dark:text-slate-200">{{ $rec->period->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-700 dark:text-slate-200">{{ $rec->subject->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $badge = match ($rec->status) {
                                                'present' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-200',
                                                'absent' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-200',
                                                'late' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
                                            };
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }} capitalize">{{ $rec->status }}</span>
                                    </td>
                                    <td class="break-words px-4 py-3 text-xs text-slate-700 dark:text-slate-200">{{ $rec->remarks ?: 'null' }}</td>
                                    <td class="px-4 py-3 text-xs text-slate-700 dark:text-slate-200">
                                        {{ $rec->markedBy->name ?? 'Unknown' }}
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="text-center py-12 text-slate-400">No records match this
                                        filter.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
                <div class="max-w-full overflow-x-auto border-t border-slate-100 px-3 py-3 dark:border-slate-700 sm:px-5">{{ $records->links() }}</div>
            </div>
        @endif
    </div>
