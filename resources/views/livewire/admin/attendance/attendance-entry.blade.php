<div class="px-2 py-2 space-y-5">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="space-y-5">

        @include('partials.notifications')

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm px-5 py-4">
            <div class="flex flex-wrap gap-3 items-end">
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Academic Year</label>
                    <select wire:model.live="academicYearId"
                        class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        @foreach ($allAcademicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase flex items-center gap-1.5">
                        Grade / Class
                        @if (auth()->user()->hasRole('Teacher'))
                            <span
                                class="px-1.5 py-0.5 bg-emerald-100 text-emerald-700 text-xs rounded-md font-semibold">My
                                Classes</span>
                        @endif
                    </label>
                    <select wire:model.live="gradeId" class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        @foreach ($allGrades as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Period</label>
                    <select wire:model.live="periodId" class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
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
                    <select wire:model.live="subjectId" class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        @foreach ($allSubjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Date</label>
                    <div class="flex gap-1">
                        <input type="date" wire:model.live="date"
                            class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        <button wire:click="$set('date', '{{ now()->toDateString() }}')"
                            class="px-3 py-2.5 bg-[#EBF4FA] text-[#155E8A] rounded-xl text-xs font-semibold">Today</button>
                    </div>
                </div>

                <div class="flex flex-col gap-1 flex-1 min-w-[180px]">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Find Student</label>
                    <input type="search" wire:model.live.debounce.300ms="search" placeholder="Search by name…"
                        class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                </div>
            </div>

            <div class="mt-3">
                @if ($isLocked)
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-red-100 text-red-700 text-xs font-semibold">
                        <i class="fa-solid fa-lock"></i> Locked by administrator for this date
                    </span>
                @elseif ($lastSaved)
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-green-100 text-green-700 text-xs font-semibold">
                        <i class="fa-solid fa-circle-check"></i> Recorded — last saved by {{ $lastSaved['name'] }} at
                        {{ $lastSaved['time'] }}
                    </span>
                @else
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full bg-amber-100 text-amber-700 text-xs font-semibold">
                        <i class="fa-solid fa-clock"></i> Not yet recorded for this date
                    </span>
                @endif
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm">

            <div class="flex items-center justify-between gap-4 px-5 py-3 border-b border-slate-100 flex-wrap">
                <button wire:click="markAllPresent" @if ($isLocked) disabled @endif
                    class="px-3 py-1.5 text-xs font-semibold text-green-700 bg-green-50 border border-green-200 rounded-lg disabled:opacity-40">
                    <i class="fa-solid fa-user-check mr-1"></i> Mark All Present
                </button>

                <div class="flex items-center gap-3 text-sm font-medium">
                    <span class="text-green-700">{{ $this->counts['present'] }} Present</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-red-600">{{ $this->counts['absent'] }} Absent</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-amber-600">{{ $this->counts['late'] }} Late</span>
                    <span class="text-slate-300">·</span>
                    <span class="text-slate-400">{{ $this->counts['unmarked'] }} Unmarked</span>
                </div>
            </div>

            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-[#155E8A] text-white text-xs uppercase">
                            <th class="px-3 py-3 text-center w-12">#</th>
                            <th class="px-4 py-3 text-left min-w-[220px]">Student</th>
                            <th class="px-4 py-3 text-center min-w-[320px]">Mark Attendance</th>
                            <th class="px-4 py-3 text-left min-w-[220px]">Remarks</th>
                            <th class="px-4 py-3 text-center w-16">History</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($this->filteredEnrollments as $i => $enrollment)
                            @php $status = $marks[$enrollment->id]['status'] ?? null; @endphp
                            <tr
                                class="@if ($status === 'absent') bg-red-50 @elseif($status === 'late') bg-amber-50 @endif">
                                <td class="px-3 py-3 text-center text-slate-400">{{ $i + 1 }}</td>
                                <td class="px-4 py-3">
                                    <span class="font-semibold text-slate-800">{{ $enrollment->student->name }}</span>
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex items-center gap-2 justify-center">
                                        @foreach (['present' => ['green', 'user-check'], 'absent' => ['red', 'user-xmark'], 'late' => ['amber', 'clock']] as $s => [$color, $icon])
                                            <button wire:click="mark({{ $enrollment->id }}, '{{ $s }}')"
                                                @if ($isLocked) disabled @endif
                                                class="flex items-center gap-1.5 px-4 py-2 rounded-full text-xs font-semibold border-2
                                                border-{{ $color }}-500 text-{{ $color }}-700 bg-{{ $color }}-50
                                                {{ $status === $s ? 'ring-2 ring-' . $color . '-400 ring-offset-1 shadow-md' : 'opacity-50' }}
                                                disabled:cursor-not-allowed">
                                                <i class="fa-solid fa-{{ $icon }}"></i> {{ ucfirst($s) }}
                                            </button>
                                        @endforeach
                                    </div>
                                </td>
                                <td class="px-4 py-3">
                                    @if (in_array($status, ['absent', 'late']))
                                        <input type="text" wire:model.blur="marks.{{ $enrollment->id }}.remarks"
                                            placeholder="Add a note…" @if ($isLocked) disabled @endif
                                            class="w-full px-3 py-2 border border-slate-200 rounded-lg text-xs">
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('attendance.history', ['enrollment_id' => $enrollment->id]) }}"
                                        title="View attendance history"
                                        class="inline-flex items-center justify-center w-8 h-8 rounded-lg bg-slate-100 text-slate-500 hover:bg-[#155E8A] hover:text-white transition-colors">
                                        <i class="fa-solid fa-clock-rotate-left text-xs"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="text-center py-16 text-slate-400">
                                    <i class="fa-solid fa-users-slash text-3xl mb-2 block"></i>
                                    No students found for this Grade and Academic Year.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($this->filteredEnrollments->isNotEmpty())
                <div
                    class="sticky bottom-0 bg-white border-t border-slate-200 px-5 py-4 flex items-center justify-end gap-3">
                    <button wire:click="save" @if ($isLocked) disabled @endif
                        class="px-6 py-2.5 text-sm font-semibold text-white bg-[#155E8A] hover:bg-[#0F4A6E] rounded-xl disabled:opacity-50">
                        <span wire:loading.remove wire:target="save"><i class="fa-solid fa-floppy-disk mr-1"></i> Save
                            Attendance</span>
                        <span wire:loading wire:target="save">Saving...</span>
                    </button>
                </div>
            @endif
        </div>
    </div>
