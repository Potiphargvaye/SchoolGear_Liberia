<div class="min-w-0 max-w-full space-y-5 overflow-x-clip px-2 py-2 text-slate-800 dark:text-slate-200">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="px-2 py-2 space-y-5">
        @include('partials.notifications')

        <div class="min-w-0 rounded-xl border border-slate-200 bg-white px-3 py-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:px-5">
            <div class="grid min-w-0 grid-cols-1 items-end gap-3 sm:grid-cols-2 lg:grid-cols-7">
                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Academic Year</label>
                    <select wire:model.live="academicYearId"
                        class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        @foreach ($allAcademicYears as $year)
                            <option value="{{ $year->id }}">{{ $year->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Grade / Class</label>
                    <select wire:model.live="gradeId" class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        <option value="">All Grades</option>
                        @foreach ($allGrades as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Subject</label>
                    <select wire:model.live="subjectId" class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        <option value="">All Subjects</option>
                        @foreach ($allSubjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex min-w-0 flex-col gap-1">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Period</label>
                    <select wire:model.live="periodId" class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-3 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        <option value="">All Periods</option>
                        @foreach ($allPeriods as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex min-w-0 flex-col gap-1 lg:col-span-2">
                    <label class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Date Range</label>
                    <div class="grid min-w-0 grid-cols-[minmax(0,1fr)_auto_minmax(0,1fr)] items-center gap-2">
                        <input type="date" wire:model.live="dateFrom"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-2 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                        <span class="text-sm text-slate-400">to</span>
                        <input type="date" wire:model.live="dateTo"
                            class="min-h-11 w-full min-w-0 rounded-xl border border-slate-200 px-2 py-2.5 text-base dark:border-slate-600 dark:bg-slate-800">
                    </div>
                </div>
                <button wire:click="resetFilters"
                    class="min-h-11 rounded-xl border border-slate-200 px-4 py-2.5 text-sm text-slate-700 hover:bg-slate-50 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Reset</button>
            </div>
        </div>

        <div class="grid min-w-0 grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-4 sm:gap-4">
            <div class="min-w-0 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Total Students</p>
                <p class="mt-1 text-3xl font-bold text-slate-800 dark:text-slate-100">{{ $totalStudents }}</p>
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Present Rate</p>
                <p class="mt-1 text-3xl font-bold text-green-700 dark:text-green-300">{{ $presentRate }}<span class="text-lg">%</span></p>
                <div class="mt-3 h-1.5 w-full rounded-full bg-slate-100 dark:bg-slate-700">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $presentRate }}%"></div>
                </div>
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Absent</p>
                <p class="mt-1 text-3xl font-bold text-red-700 dark:text-red-300">{{ $absentCount }}</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-300">{{ $absentRate }}% of marks</p>
            </div>
            <div class="min-w-0 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <p class="text-xs font-semibold uppercase text-slate-500 dark:text-slate-300">Late</p>
                <p class="mt-1 text-3xl font-bold text-amber-700 dark:text-amber-300">{{ $lateCount }}</p>
                <p class="mt-1 text-xs text-slate-500 dark:text-slate-300">{{ $lateRate }}% of marks</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="min-w-0 overflow-hidden rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 xl:col-span-2 sm:p-5">
                <h2 class="mb-4 font-semibold text-slate-800 dark:text-slate-100">Daily Present Rate Trend</h2>
                @if ($trend->isEmpty())
                    <p class="text-sm text-slate-400 text-center py-10">No attendance data in this range.</p>
                @else
                    <div class="flex h-40 min-w-0 items-end gap-1 overflow-hidden">
                        @foreach ($trend as $date => $rate)
                            <div class="flex min-w-0 flex-1 flex-col items-center gap-1"
                                title="{{ $date }}: {{ $rate }}%">
                                <div class="w-full bg-[#155E8A] rounded-t" style="height: {{ max($rate, 3) }}%"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="flex min-w-0 flex-col items-center rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:p-5">
                <h2 class="mb-4 self-start font-semibold text-slate-800 dark:text-slate-100">Status Breakdown</h2>
                <div class="w-36 h-36 rounded-full"
                    style="background: conic-gradient(#16A34A 0% {{ $presentRate }}%, #DC2626 {{ $presentRate }}% {{ $presentRate + $absentRate }}%, #D97706 {{ $presentRate + $absentRate }}% 100%, #E2E8F0 100%);">
                    <div class="mx-auto mt-6 flex h-24 w-24 flex-col items-center justify-center rounded-full bg-white dark:bg-slate-900">
                        <span class="text-xl font-bold text-slate-800 dark:text-slate-100">{{ $presentRate }}%</span>
                        <span class="text-xs text-slate-500 dark:text-slate-300">Present</span>
                    </div>
                </div>
                <div class="mt-4 space-y-1.5 w-full text-sm">
                    <div class="flex justify-between"><span class="flex items-center gap-2 text-green-800 dark:text-green-300"><span
                                class="w-3 h-3 rounded-sm bg-green-600 inline-block"></span>Present</span><span
                            class="font-semibold">{{ $presentCount }}</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2 text-red-800 dark:text-red-300"><span
                                class="w-3 h-3 rounded-sm bg-red-600 inline-block"></span>Absent</span><span
                            class="font-semibold">{{ $absentCount }}</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2 text-amber-800 dark:text-amber-300"><span
                                class="w-3 h-3 rounded-sm bg-amber-600 inline-block"></span>Late</span><span
                            class="font-semibold">{{ $lateCount }}</span></div>
                </div>
            </div>
        </div>

        <div class="min-w-0 rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
            <div class="flex flex-wrap items-center justify-between gap-3 border-b border-slate-100 px-3 py-4 dark:border-slate-700 sm:px-5">
                <div>
                    <h2 class="flex items-center gap-2 font-semibold text-slate-800 dark:text-slate-100">
                        <i class="fas fa-triangle-exclamation text-amber-500"></i> Attendance Risk List
                    </h2>
                    <p class="mt-0.5 text-xs text-slate-500 dark:text-slate-300">Students with 3+ absences in this range — sorted worst
                        first
                    </p>
                </div>
                <span
                    class="rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-800 dark:bg-red-950 dark:text-red-200">{{ $riskData->count() }}
                    at risk</span>
            </div>
            <div class="max-w-full overflow-x-auto">
                <table class="w-full min-w-[700px] text-sm">
                    <thead>
                        <tr class="border-b border-slate-100 bg-slate-50 text-xs uppercase text-slate-700 dark:border-slate-700 dark:bg-slate-800 dark:text-slate-200">
                            <th class="sticky left-0 bg-slate-50 px-3 py-3 text-left dark:bg-slate-800 sm:px-5">Student</th>
                            <th class="px-4 py-3 text-left">Grade</th>
                            <th class="px-4 py-3 text-center">Absences</th>
                            <th class="px-4 py-3 text-center">Late</th>
                            <th class="px-4 py-3 text-center">Rate</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($riskData as $rs)
                            <tr class="hover:bg-slate-50 dark:hover:bg-slate-800">
                                <td class="sticky left-0 max-w-[190px] truncate bg-white px-3 py-3 font-semibold text-slate-800 dark:bg-slate-900 dark:text-slate-100 sm:px-5" title="{{ $rs['name'] }}">{{ $rs['name'] }}</td>
                                <td class="px-4 py-3 text-slate-700 dark:text-slate-200">{{ $rs['grade'] }}</td>
                                <td class="px-4 py-3 text-center font-bold text-red-700 dark:text-red-300">{{ $rs['absences'] }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-amber-700 dark:text-amber-300">{{ $rs['late'] }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center font-semibold {{ $rs['rate'] >= 80 ? 'text-green-700 dark:text-green-300' : 'text-red-700 dark:text-red-300' }}">
                                    {{ $rs['rate'] }}%</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('attendance.history', ['enrollment_id' => $rs['enrollment_id']]) }}"
                                        class="text-[#155E8A] text-xs font-semibold hover:underline dark:text-sky-300">
                                        <i class="fas fa-arrow-right-long"></i> View History
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-600 dark:text-slate-300">No at-risk students in
                                    this
                                    range.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
