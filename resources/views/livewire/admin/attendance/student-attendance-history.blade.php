<div class="px-2 py-2 space-y-5">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="px-2 py-2 space-y-5">
        @include('partials.notifications')

        @if ($pickerMode)
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <h2 class="font-semibold text-slate-800 mb-3">Select a student to view their attendance history</h2>
                <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search by student name..."
                    class="w-full px-4 py-2.5 border border-slate-200 rounded-xl text-sm mb-4">
                <div class="divide-y divide-slate-100">
                    @forelse ($students as $enrollment)
                        <button wire:click="selectStudent({{ $enrollment->id }})"
                            class="w-full text-left px-3 py-3 hover:bg-slate-50 rounded-lg flex items-center justify-between">
                            <div>
                                <p class="font-semibold text-slate-800">{{ $enrollment->student->name }}</p>
                                <p class="text-xs text-slate-400">
                                    {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' - ' . $enrollment->grade->section : '' }}
                                </p>
                            </div>
                            <i class="fas fa-arrow-right text-slate-300"></i>
                        </button>
                    @empty
                        <p class="text-sm text-slate-400 text-center py-8">No students found.</p>
                    @endforelse
                </div>
            </div>
        @else
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm overflow-hidden">
                <div class="h-1 bg-[#155E8A]"></div>
                <div class="px-6 py-5">
                    <div class="flex items-start justify-between gap-4 flex-wrap">
                        <div>
                            <button wire:click="$set('enrollmentId', null)"
                                class="text-xs text-slate-400 hover:text-[#155E8A] mb-1">
                                <i class="fas fa-arrow-left mr-1"></i> Back to search
                            </button>
                            <h2 class="text-2xl font-bold text-slate-800">{{ $enrollment->student->name }}</h2>
                            <p class="text-sm text-slate-500 mt-1">
                                {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' - ' . $enrollment->grade->section : '' }}
                            </p>
                        </div>
                        <div class="grid grid-cols-4 gap-3">
                            <div class="bg-slate-50 rounded-xl px-4 py-3 text-center">
                                <p class="text-xs text-slate-500 mb-1">Rate</p>
                                <p
                                    class="text-xl font-bold {{ $attendanceRate >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $attendanceRate }}%</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl px-4 py-3 text-center">
                                <p class="text-xs text-slate-500 mb-1">Present</p>
                                <p class="text-xl font-bold text-green-600">{{ $daysPresent }}</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl px-4 py-3 text-center">
                                <p class="text-xs text-slate-500 mb-1">Absent</p>
                                <p class="text-xl font-bold text-red-600">{{ $daysAbsent }}</p>
                            </div>
                            <div class="bg-slate-50 rounded-xl px-4 py-3 text-center">
                                <p class="text-xs text-slate-500 mb-1">Late</p>
                                <p class="text-xl font-bold text-amber-600">{{ $timesLate }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>




            <div class="bg-white border border-slate-200 rounded-xl shadow-sm px-5 py-4">
                <div class="flex flex-wrap items-end gap-3">
                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase">Period</label>
                        <select wire:model.live="periodFilter"
                            class="px-3 py-2 border border-slate-200 rounded-xl text-sm min-w-[160px]">
                            <option value="">All Periods</option>
                            @foreach ($allPeriods as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="flex flex-col gap-1">
                        <label class="text-xs font-semibold text-slate-500 uppercase flex items-center gap-1.5">
                            Subject
                            @if (auth()->user()->hasRole('Teacher'))
                                <span
                                    class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-md font-semibold">My
                                    Subjects</span>
                            @endif
                        </label>
                        <select wire:model.live="subjectFilter"
                            class="px-3 py-2 border border-slate-200 rounded-xl text-sm min-w-[160px]">
                            <option value="">All Subjects</option>
                            @foreach ($allSubjects as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    @if ($periodFilter || $subjectFilter)
                        <button wire:click="resetFilters"
                            class="px-3 py-2 text-xs font-semibold text-slate-500 border border-slate-200 rounded-xl hover:bg-slate-50">
                            <i class="fas fa-xmark mr-1"></i> Clear Filters
                        </button>
                    @endif
                </div>

                @if ($periodFilter || $subjectFilter)
                    <p class="text-xs text-slate-400 mt-2">
                        Showing records for
                        @if ($periodFilter)
                            <span
                                class="font-semibold text-slate-600">{{ $allPeriods->firstWhere('id', $periodFilter)?->name }}</span>
                        @endif
                        @if ($periodFilter && $subjectFilter)
                            +
                        @endif
                        @if ($subjectFilter)
                            <span
                                class="font-semibold text-slate-600">{{ $allSubjects->firstWhere('id', $subjectFilter)?->name }}</span>
                        @endif
                        only Summary, Monthly Pattern, and All Records below are synced to this.
                    </p>
                @endif
            </div>
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <div class="flex items-center justify-between mb-4 flex-wrap gap-3">
                    <h2 class="font-semibold text-slate-800">Monthly Attendance Pattern</h2>
                    <div class="flex items-center gap-1">
                        <button wire:click="changeMonth('prev')"
                            class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-slate-50 text-xs">
                            <i class="fas fa-chevron-left"></i>
                        </button>
                        <span class="px-3 font-semibold text-slate-700 text-sm">{{ $monthLabel }}</span>
                        <button wire:click="changeMonth('next')"
                            class="w-7 h-7 rounded-lg border border-slate-200 hover:bg-slate-50 text-xs">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <div class="space-y-2">
                    @foreach ($weeks as $weekNumber => $days)
                        <div class="flex items-center gap-2">
                            <span class="text-xs font-semibold text-slate-400 w-14 shrink-0">Week
                                {{ $weekNumber }}</span>
                            <div class="grid grid-cols-7 gap-1.5 flex-1">
                                @foreach ($days as $cell)
                                    @php
                                        $cls = match ($cell['status']) {
                                            'present' => 'bg-green-100 text-green-700',
                                            'absent' => 'bg-red-100 text-red-700',
                                            'late' => 'bg-amber-100 text-amber-700',
                                            default => $cell['isWeekend']
                                                ? 'bg-slate-50 text-slate-300'
                                                : 'bg-slate-100 text-slate-400',
                                        };
                                        $icon = match ($cell['status']) {
                                            'present' => '✓',
                                            'absent' => '✕',
                                            'late' => '⏰',
                                            default => '',
                                        };
                                    @endphp
                                    <div title="{{ $cell['remark'] ?? '' }}"
                                        class="{{ $cls }} rounded-lg p-2 text-center text-xs font-bold">
                                        {{ $cell['date'] }}<div class="text-xs">{{ $icon }}</div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
                <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100 flex-wrap gap-3">
                    <h2 class="font-semibold text-slate-800">All Records</h2>
                    <select wire:model.live="statusFilter" class="px-3 py-2 border border-slate-200 rounded-lg text-xs">
                        <option value="">All Statuses</option>
                        <option value="present">Present</option>
                        <option value="absent">Absent</option>
                        <option value="late">Late</option>
                    </select>
                </div>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-100">
                                <th class="px-5 py-3 text-left">Date</th>
                                <th class="px-4 py-3 text-left">Period</th>
                                <th class="px-4 py-3 text-left">Subject</th>
                                <th class="px-4 py-3 text-center">Status</th>
                                <th class="px-4 py-3 text-left">Remarks</th>
                                <th class="px-4 py-3 text-left">Recorded By</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @forelse ($records as $rec)
                                <tr class="hover:bg-slate-50">
                                    <td class="px-5 py-3 font-medium text-slate-800">{{ $rec->date->format('d M Y') }}
                                    </td>
                                    <td class="px-4 py-3 text-slate-500">{{ $rec->period->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-500">{{ $rec->subject->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-center">
                                        @php
                                            $badge = match ($rec->status) {
                                                'present' => 'bg-green-100 text-green-700',
                                                'absent' => 'bg-red-100 text-red-700',
                                                'late' => 'bg-amber-100 text-amber-700',
                                            };
                                        @endphp
                                        <span
                                            class="px-2.5 py-1 rounded-full text-xs font-semibold {{ $badge }} capitalize">{{ $rec->status }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 text-xs">{{ $rec->remarks ?: '—' }}</td>
                                    <td class="px-4 py-3 text-slate-500 text-xs">
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
                <div class="px-5 py-3 border-t border-slate-100">{{ $records->links() }}</div>
            </div>
        @endif
    </div>
