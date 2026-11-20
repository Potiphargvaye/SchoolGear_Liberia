<div class="min-w-0 max-w-full space-y-5 overflow-x-clip px-2 py-2 text-slate-800 dark:text-slate-200">
    @include('livewire.admin.attendance.partials.nav-tabs')

    @include('partials.notifications')

    <div>
        <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100 sm:text-2xl">Attendance Audit Trail</h1>
        <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">Every create and edit of a student's attendance mark, with who and when.
        </p>
    </div>

    {{-- Filters --}}
    <div
        class="grid min-w-0 grid-cols-1 gap-3 rounded-xl border border-slate-200 bg-slate-50 p-3 dark:border-slate-700 dark:bg-slate-900 sm:grid-cols-2 sm:p-4 lg:grid-cols-6">

        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">Grade</label>
            <select wire:model.live="gradeFilter" class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 px-2.5 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                <option value="">All</option>
                @foreach ($gradeOptions as $g)
                    <option value="{{ $g->id }}">{{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">Subject</label>
            <select wire:model.live="subjectFilter"
                class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 px-2.5 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                <option value="">All</option>
                @foreach ($subjectOptions as $s)
                    <option value="{{ $s->id }}">{{ $s->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">Period</label>
            <select wire:model.live="periodFilter"
                class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 px-2.5 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                <option value="">All</option>
                @foreach ($periodOptions as $p)
                    <option value="{{ $p->id }}">{{ $p->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">Action</label>
            <select wire:model.live="actionFilter"
                class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 px-2.5 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
                <option value="">All</option>
                <option value="created">Created</option>
                <option value="updated">Updated</option>
                <option value="deleted">Deleted</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">From</label>
            <input type="date" wire:model.live="dateFrom"
                class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 px-2.5 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
        </div>

        <div class="flex items-end gap-2">
            <div class="flex-1">
                <label class="mb-1 block text-xs font-semibold text-slate-700 dark:text-slate-300">To</label>
                <input type="date" wire:model.live="dateTo"
                    class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 px-2.5 py-2 text-base dark:border-slate-600 dark:bg-slate-800">
            </div>
            <button wire:click="resetFilters" type="button"
                class="min-h-11 shrink-0 rounded-lg border border-slate-300 px-3 text-xs font-semibold text-slate-700 hover:bg-slate-100 focus-visible:outline focus-visible:outline-2 focus-visible:outline-sky-600 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">
                Clear
            </button>
        </div>

    </div>

    {{-- Table --}}
    <div class="min-w-0 overflow-hidden rounded-xl border border-slate-200 bg-white dark:border-slate-700 dark:bg-slate-900">
        <div class="space-y-3 p-3 md:hidden">
            @forelse ($audits as $audit)
                @php
                    $cardBadge = match ($audit->action) {
                        'created' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-200',
                        'updated' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
                        'deleted' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-200',
                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                    };
                @endphp
                <article class="min-w-0 rounded-xl border border-slate-200 p-3 dark:border-slate-700">
                    <div class="flex min-w-0 items-start justify-between gap-2">
                        <div class="min-w-0">
                            <h2 class="break-words font-semibold text-slate-800 dark:text-slate-100">{{ $audit->enrollment->student->name ?? '—' }}</h2>
                            <p class="mt-1 break-words text-xs text-slate-600 dark:text-slate-300">
                                {{ $audit->enrollment->grade->level ?? '—' }}{{ $audit->enrollment->grade->section ?? '' ? ' - ' . $audit->enrollment->grade->section : '' }}
                            </p>
                        </div>
                        <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold capitalize {{ $cardBadge }}">{{ $audit->action }}</span>
                    </div>
                    <dl class="mt-3 grid min-w-0 grid-cols-1 gap-2 text-xs">
                        <div class="grid grid-cols-2 gap-2">
                            <div class="min-w-0"><dt class="font-semibold text-slate-500 dark:text-slate-300">When</dt><dd class="break-words text-slate-700 dark:text-slate-200">{{ $audit->performed_at?->format('M j, Y g:i A') }}</dd></div>
                            <div class="min-w-0"><dt class="font-semibold text-slate-500 dark:text-slate-300">Period</dt><dd class="break-words text-slate-700 dark:text-slate-200">{{ $audit->period->name ?? '—' }}</dd></div>
                        </div>
                        <div class="grid grid-cols-2 gap-2">
                            <div class="min-w-0"><dt class="font-semibold text-slate-500 dark:text-slate-300">Subject</dt><dd class="break-words text-slate-700 dark:text-slate-200">{{ $audit->subject->name ?? '—' }}</dd></div>
                            <div class="min-w-0"><dt class="font-semibold text-slate-500 dark:text-slate-300">By</dt><dd class="break-words text-slate-700 dark:text-slate-200">{{ $audit->performedBy->name ?? 'Unknown' }}</dd></div>
                        </div>
                        <div class="min-w-0">
                            <dt class="font-semibold text-slate-500 dark:text-slate-300">Changes (before → after)</dt>
                            <dd class="mt-1 break-words text-slate-700 dark:text-slate-200">
                                @if ($audit->changes)
                                    @foreach ($audit->changes as $field => $vals)
                                        <div><span class="font-semibold">{{ $field }}:</span> {{ $vals[0] ?? '—' }} → {{ $vals[1] ?? '—' }}</div>
                                    @endforeach
                                @else
                                    —
                                @endif
                            </dd>
                        </div>
                    </dl>
                </article>
            @empty
                <p class="py-8 text-center text-sm text-slate-600 dark:text-slate-300">No audit records match these filters.</p>
            @endforelse
        </div>
        <div class="hidden max-w-full overflow-x-auto md:block">
            <table class="w-full min-w-[950px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="sticky left-0 bg-[#155E8A] px-4 py-3 text-left text-xs font-semibold uppercase">Date / Time</th>
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
                            <td class="sticky left-0 max-w-[150px] bg-white px-4 py-3 text-slate-700 dark:bg-slate-900 dark:text-slate-200">
                                {{ $audit->performed_at?->format('M j, Y g:i A') }}</td>
                            <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">
                                {{ $audit->enrollment->student->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-700 dark:text-slate-200">
                                {{ $audit->enrollment->grade->level ?? '—' }}{{ $audit->enrollment->grade->section ?? '' ? ' - ' . $audit->enrollment->grade->section : '' }}
                            </td>
                            <td class="px-4 py-3 text-slate-700 dark:text-slate-200">{{ $audit->period->name ?? '—' }}</td>
                            <td class="px-4 py-3 text-slate-700 dark:text-slate-200">{{ $audit->subject->name ?? '—' }}</td>
                            <td class="px-4 py-3">
                                @php
                                    $badge = match ($audit->action) {
                                        'created' => 'bg-green-100 text-green-800 dark:bg-green-950 dark:text-green-200',
                                        'updated' => 'bg-amber-100 text-amber-800 dark:bg-amber-950 dark:text-amber-200',
                                        'deleted' => 'bg-red-100 text-red-800 dark:bg-red-950 dark:text-red-200',
                                        default => 'bg-slate-100 text-slate-700 dark:bg-slate-700 dark:text-slate-200',
                                    };
                                @endphp
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium {{ $badge }} capitalize">{{ $audit->action }}</span>
                            </td>
                            <td class="max-w-[360px] break-words px-4 py-3 text-slate-700 dark:text-slate-200">
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
                                    <span class="text-xs text-slate-600 dark:text-slate-300">—</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-slate-700 dark:text-slate-200">{{ $audit->performedBy->name ?? 'Unknown' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-14">
                                <i class="fas fa-clock-rotate-left mb-3 text-4xl text-slate-400"></i>
                                <p class="text-sm text-slate-600 dark:text-slate-300">No audit records match these filters.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="max-w-full overflow-x-auto">{{ $audits->links() }}</div>

</div>
