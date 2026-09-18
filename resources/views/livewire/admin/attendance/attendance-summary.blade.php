<div class="px-2 py-2 space-y-5">
    @include('livewire.admin.attendance.partials.nav-tabs')

    <div class="px-2 py-2 space-y-5">
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
                    <label class="text-xs font-semibold text-slate-500 uppercase">Grade / Class</label>
                    <select wire:model.live="gradeId" class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        <option value="">All Grades</option>
                        @foreach ($allGrades as $g)
                            <option value="{{ $g->id }}">
                                {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Subject</label>
                    <select wire:model.live="subjectId" class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        <option value="">All Subjects</option>
                        @foreach ($allSubjects as $s)
                            <option value="{{ $s->id }}">{{ $s->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Period</label>
                    <select wire:model.live="periodId" class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        <option value="">All Periods</option>
                        @foreach ($allPeriods as $p)
                            <option value="{{ $p->id }}">{{ $p->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex flex-col gap-1">
                    <label class="text-xs font-semibold text-slate-500 uppercase">Date Range</label>
                    <div class="flex items-center gap-2">
                        <input type="date" wire:model.live="dateFrom"
                            class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                        <span class="text-slate-400 text-sm">to</span>
                        <input type="date" wire:model.live="dateTo"
                            class="px-3 py-2.5 border border-slate-200 rounded-xl text-sm">
                    </div>
                </div>
                <button wire:click="resetFilters"
                    class="px-4 py-2.5 text-sm text-slate-600 border border-slate-200 rounded-xl hover:bg-slate-50">Reset</button>
            </div>
        </div>

        <div class="grid grid-cols-2 xl:grid-cols-4 gap-4">
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 uppercase">Total Students</p>
                <p class="text-3xl font-bold text-slate-800 mt-1">{{ $totalStudents }}</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 uppercase">Present Rate</p>
                <p class="text-3xl font-bold text-green-600 mt-1">{{ $presentRate }}<span class="text-lg">%</span></p>
                <div class="mt-3 w-full bg-slate-100 rounded-full h-1.5">
                    <div class="bg-green-500 h-1.5 rounded-full" style="width: {{ $presentRate }}%"></div>
                </div>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 uppercase">Absent</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ $absentCount }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $absentRate }}% of marks</p>
            </div>
            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <p class="text-xs font-semibold text-slate-500 uppercase">Late</p>
                <p class="text-3xl font-bold text-amber-600 mt-1">{{ $lateCount }}</p>
                <p class="text-xs text-slate-400 mt-1">{{ $lateRate }}% of marks</p>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-4">
            <div class="xl:col-span-2 bg-white border border-slate-200 rounded-xl shadow-sm p-5">
                <h2 class="font-semibold text-slate-800 mb-4">Daily Present Rate Trend</h2>
                @if ($trend->isEmpty())
                    <p class="text-sm text-slate-400 text-center py-10">No attendance data in this range.</p>
                @else
                    <div class="flex items-end gap-1 h-40">
                        @foreach ($trend as $date => $rate)
                            <div class="flex-1 flex flex-col items-center gap-1"
                                title="{{ $date }}: {{ $rate }}%">
                                <div class="w-full bg-[#155E8A] rounded-t" style="height: {{ max($rate, 3) }}%"></div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

            <div class="bg-white border border-slate-200 rounded-xl shadow-sm p-5 flex flex-col items-center">
                <h2 class="font-semibold text-slate-800 mb-4 self-start">Status Breakdown</h2>
                <div class="w-36 h-36 rounded-full"
                    style="background: conic-gradient(#16A34A 0% {{ $presentRate }}%, #DC2626 {{ $presentRate }}% {{ $presentRate + $absentRate }}%, #D97706 {{ $presentRate + $absentRate }}% 100%, #E2E8F0 100%);">
                    <div class="w-24 h-24 bg-white rounded-full mx-auto mt-6 flex flex-col items-center justify-center">
                        <span class="text-xl font-bold text-slate-800">{{ $presentRate }}%</span>
                        <span class="text-xs text-slate-400">Present</span>
                    </div>
                </div>
                <div class="mt-4 space-y-1.5 w-full text-sm">
                    <div class="flex justify-between"><span class="flex items-center gap-2"><span
                                class="w-3 h-3 rounded-sm bg-green-600 inline-block"></span>Present</span><span
                            class="font-semibold">{{ $presentCount }}</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2"><span
                                class="w-3 h-3 rounded-sm bg-red-600 inline-block"></span>Absent</span><span
                            class="font-semibold">{{ $absentCount }}</span></div>
                    <div class="flex justify-between"><span class="flex items-center gap-2"><span
                                class="w-3 h-3 rounded-sm bg-amber-500 inline-block"></span>Late</span><span
                            class="font-semibold">{{ $lateCount }}</span></div>
                </div>
            </div>
        </div>

        <div class="bg-white border border-slate-200 rounded-xl shadow-sm">
            <div class="flex items-center justify-between px-5 py-4 border-b border-slate-100">
                <div>
                    <h2 class="font-semibold text-slate-800 flex items-center gap-2">
                        <i class="fas fa-triangle-exclamation text-amber-500"></i> Attendance Risk List
                    </h2>
                    <p class="text-xs text-slate-400 mt-0.5">Students with 3+ absences in this range — sorted worst
                        first
                    </p>
                </div>
                <span
                    class="px-2.5 py-1 bg-red-100 text-red-700 text-xs font-semibold rounded-full">{{ $riskData->count() }}
                    at risk</span>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-slate-50 text-xs uppercase text-slate-500 border-b border-slate-100">
                            <th class="px-5 py-3 text-left">Student</th>
                            <th class="px-4 py-3 text-left">Grade</th>
                            <th class="px-4 py-3 text-center">Absences</th>
                            <th class="px-4 py-3 text-center">Late</th>
                            <th class="px-4 py-3 text-center">Rate</th>
                            <th class="px-4 py-3 text-left">Action</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($riskData as $rs)
                            <tr class="hover:bg-slate-50">
                                <td class="px-5 py-3 font-semibold text-slate-800">{{ $rs['name'] }}</td>
                                <td class="px-4 py-3 text-slate-600">{{ $rs['grade'] }}</td>
                                <td class="px-4 py-3 text-center font-bold text-red-600">{{ $rs['absences'] }}</td>
                                <td class="px-4 py-3 text-center font-semibold text-amber-600">{{ $rs['late'] }}
                                </td>
                                <td
                                    class="px-4 py-3 text-center font-semibold {{ $rs['rate'] >= 80 ? 'text-green-600' : 'text-red-600' }}">
                                    {{ $rs['rate'] }}%</td>
                                <td class="px-4 py-3">
                                    <a href="{{ route('attendance.history', ['enrollment_id' => $rs['enrollment_id']]) }}"
                                        class="text-[#155E8A] text-xs font-semibold hover:underline">
                                        <i class="fas fa-arrow-right-long"></i> View History
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center py-12 text-slate-400">No at-risk students in
                                    this
                                    range.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
