<div class="px-2 py-2 space-y-5">
    @include('livewire.admin.attendance.partials.nav-tabs')

    @include('partials.notifications')

    <div>
        <h1 class="text-2xl font-bold text-slate-800">Attendance Audit Trail</h1>
        <p class="text-slate-500 text-sm mt-1">Every create and edit of a student's attendance mark, with who and when.
        </p>
    </div>

    {{-- Filters --}}
    <div
        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-xl p-4 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-6 gap-3">

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Grade</label>
            <select wire:model.live="gradeFilter" class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg">
                <option value="">All</option>
                @foreach ($gradeOptions as $g)
                    <option value="{{ $g->id }}">{{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Subject</label>
            <select wire:model.live="subjectFilter"
                class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg">
                <option value="">All</option>
                @foreach ($subjectOptions as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Period</label>
            <select wire:model.live="periodFilter"
                class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg">
                <option value="">All</option>
                @foreach ($periodOptions as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">Action</label>
            <select wire:model.live="actionFilter"
                class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg">
                <option value="">All</option>
                <option value="created">Created</option>
                <option value="updated">Updated</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-600 mb-1">From</label>
            <input type="date" wire:model.live="dateFrom"
                class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg">
        </div>

        <div class="flex items-end gap-2">
            <div class="flex-1">
                <label class="block text-xs font-semibold text-slate-600 mb-1">To</label>
                <input type="date" wire:model.live="dateTo"
                    class="w-full text-sm py-2 px-2.5 border border-slate-300 rounded-lg">
            </div>
            <button wire:click="resetFilters" type="button"
                class="h-[38px] px-3 rounded-lg border border-slate-300 text-slate-600 text-xs font-semibold hover:bg-slate-100">
                Clear
            </button>
        </div>

    </div>

    {{-- Table --}}
    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[950px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Date / Time</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Grade</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Period</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Subject</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Action</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">Changes</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase">By</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($audits as $audit)
                        <tr class="hover:bg-sky-50/60">
                            <td class="px-4 py-3 text-slate-500 whitespace-nowrap">
                                {{ $audit->performed_at?->format('M j, Y g:i A') }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800">
                                {{ $audit->enrollment->student->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-500">
                                {{ $audit->enrollment->grade->level ?? '—' }}{{ $audit->enrollment->grade->section ?? '' ? ' - ' . $audit->enrollment->grade->section : '' }}
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $audit->period->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-500">{{ $audit->subject->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badge = match ($audit->action) {
                                        'created' => 'bg-green-100 text-green-700',
                                        'updated' => 'bg-amber-100 text-amber-700',
                                        'deleted' => 'bg-red-100 text-red-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }} capitalize">{{ $audit->action }}</span>
                            </td>
                            <td class="px-4 py-3 text-slate-600">
                                @if ($audit->changes)
                                    <div class="space-y-0.5">
                                        @foreach ($audit->changes as $field => $vals)
                                            <div class="text-xs">
                                                <span class="font-semibold">{{ $field }}:</span>
                                                {{ $vals[0] ?? '—' }} → {{ $vals[1] ?? '—' }}
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <span class="text-slate-400 text-xs">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-500">{{ $audit->performedBy->name ?? 'Unknown' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-14">
                                <i class="fas fa-clock-rotate-left text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No audit records match these filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div>{{ $audits->links() }}</div>

</div>
