@extends('layouts.admin')

@section('content')
    @include('partials.notifications')

    <div class="min-w-0 max-w-full overflow-x-clip px-3 py-3 sm:px-6 lg:px-8">
        <div class="mb-4 flex min-w-0 flex-col gap-3 sm:flex-row sm:items-start sm:justify-between">
            <div class="min-w-0">
                <h1 class="text-xl font-bold text-slate-800 dark:text-slate-100 sm:text-2xl">Publication History</h1>
                <p class="mt-1 text-sm text-slate-500 dark:text-slate-400">Review when student grade-entry slots were published or unpublished.</p>
            </div>
            @if ($selectedGradeId && $selectedAcademicYearId)
                <a href="{{ route('grades.load', ['grade_id' => $selectedGradeId, 'academic_year_id' => $selectedAcademicYearId]) }}"
                    class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Grade Entry
                </a>
            @else
                <a href="{{ route('grades.entry') }}"
                    class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg border border-slate-300 px-3 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">
                    <i class="fas fa-arrow-left mr-2 text-xs"></i> Back to Grade Entry
                </a>
            @endif
        </div>

        @if ($schoolRequired)
            <div class="rounded-xl border border-amber-200 bg-amber-50 p-5 text-sm font-medium text-amber-800 dark:border-amber-900/60 dark:bg-amber-950/30 dark:text-amber-200">
                School account required
            </div>
        @else
            <form method="GET" action="{{ route('grades.publication-history') }}"
                class="mb-5 grid min-w-0 grid-cols-1 gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm dark:border-slate-700 dark:bg-slate-900 sm:grid-cols-2 lg:grid-cols-5">
                <div class="min-w-0">
                    <label for="publicationHistoryAcademicYear" class="mb-1 block text-sm font-semibold text-slate-700 dark:text-slate-200">Academic Year</label>
                    <select id="publicationHistoryAcademicYear" name="academic_year_id"
                        class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-base text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <option value="">All years</option>
                        @foreach ($academicYears as $academicYear)
                            <option value="{{ $academicYear->id }}" @selected((string) $selectedAcademicYearId === (string) $academicYear->id)>{{ $academicYear->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0">
                    <label for="publicationHistoryGrade" class="mb-1 block text-sm font-semibold text-slate-700 dark:text-slate-200">Class</label>
                    <select id="publicationHistoryGrade" name="grade_id"
                        class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-base text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <option value="">All classes</option>
                        @foreach ($grades as $grade)
                            <option value="{{ $grade->id }}" @selected((string) $selectedGradeId === (string) $grade->id)>{{ $grade->level }}{{ $grade->section ? ' - ' . $grade->section : '' }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0">
                    <label for="publicationHistorySlot" class="mb-1 block text-sm font-semibold text-slate-700 dark:text-slate-200">Slot</label>
                    <select id="publicationHistorySlot" name="slot"
                        class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-base text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <option value="">All slots</option>
                        @foreach ($slotLabels as $slot => $label)
                            <option value="{{ $slot }}" @selected($selectedSlot === $slot)>{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="min-w-0">
                    <label for="publicationHistoryAction" class="mb-1 block text-sm font-semibold text-slate-700 dark:text-slate-200">Action</label>
                    <select id="publicationHistoryAction" name="action"
                        class="min-h-11 w-full min-w-0 rounded-lg border border-slate-300 bg-white px-3 py-2 text-base text-slate-800 focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-500/30 dark:border-slate-600 dark:bg-slate-800 dark:text-slate-100">
                        <option value="">All actions</option>
                        <option value="published" @selected($selectedAction === 'published')>Published</option>
                        <option value="unpublished" @selected($selectedAction === 'unpublished')>Unpublished</option>
                    </select>
                </div>

                <div class="flex items-end gap-2 sm:col-span-2 lg:col-span-1">
                    <button type="submit" class="min-h-11 flex-1 rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500">Filter</button>
                    <a href="{{ route('grades.publication-history') }}" class="inline-flex min-h-11 items-center justify-center rounded-lg border border-slate-300 px-4 py-2 text-sm font-semibold text-slate-700 transition hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-indigo-500 dark:border-slate-600 dark:text-slate-200 dark:hover:bg-slate-800">Reset</a>
                </div>
            </form>

            <div class="overflow-hidden rounded-xl border border-slate-200 bg-white shadow-sm dark:border-slate-700 dark:bg-slate-900">
                <div class="hidden overflow-x-auto md:block">
                    <table class="w-full min-w-[760px] text-sm">
                        <thead class="bg-[#155E8A] text-left text-xs font-semibold uppercase text-white">
                            <tr>
                                <th class="px-4 py-3">Date / Time</th>
                                <th class="px-4 py-3">Class</th>
                                <th class="px-4 py-3">Academic Year</th>
                                <th class="px-4 py-3">Slot</th>
                                <th class="px-4 py-3">Action</th>
                                <th class="px-4 py-3">Performed by</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 dark:divide-slate-700">
                            @forelse ($audits as $audit)
                                <tr class="transition hover:bg-sky-50/60 dark:hover:bg-slate-800/60">
                                    <td class="whitespace-nowrap px-4 py-3 text-slate-500 dark:text-slate-400">{{ $audit->performed_at?->format('M j, Y g:i A') ?? '—' }}</td>
                                    <td class="px-4 py-3 font-medium text-slate-800 dark:text-slate-100">{{ $audit->grade?->level ?? '—' }}{{ $audit->grade?->section ? ' - ' . $audit->grade->section : '' }}</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $audit->academicYear?->name ?? '—' }}</td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $slotLabels[$audit->slot] ?? $audit->slot }}</td>
                                    <td class="px-4 py-3">
                                        <span class="inline-flex rounded-full px-2.5 py-1 text-xs font-semibold {{ $audit->action === 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' }}">{{ ucfirst($audit->action) }}</span>
                                    </td>
                                    <td class="px-4 py-3 text-slate-500 dark:text-slate-400">{{ $audit->performedBy?->name ?? 'Unknown' }}</td>
                                </tr>
                            @empty
                                <tr><td colspan="6" class="px-4 py-14 text-center text-sm text-slate-500 dark:text-slate-400"><i class="fas fa-clock-rotate-left mb-3 block text-4xl text-slate-300 dark:text-slate-600"></i>No publication activity found.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="space-y-3 p-3 md:hidden">
                    @forelse ($audits as $audit)
                        <article class="min-w-0 rounded-lg border border-slate-200 p-3 dark:border-slate-700">
                            <div class="flex min-w-0 items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <p class="truncate font-semibold text-slate-800 dark:text-slate-100">{{ $audit->grade?->level ?? '—' }}{{ $audit->grade?->section ? ' - ' . $audit->grade->section : '' }}</p>
                                    <p class="mt-1 text-xs text-slate-500 dark:text-slate-400">{{ $audit->academicYear?->name ?? '—' }} · {{ $slotLabels[$audit->slot] ?? $audit->slot }}</p>
                                </div>
                                <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-semibold {{ $audit->action === 'published' ? 'bg-green-100 text-green-700 dark:bg-green-900/40 dark:text-green-300' : 'bg-amber-100 text-amber-800 dark:bg-amber-900/40 dark:text-amber-300' }}">{{ ucfirst($audit->action) }}</span>
                            </div>
                            <p class="mt-3 text-xs text-slate-500 dark:text-slate-400">{{ $audit->performed_at?->format('M j, Y g:i A') ?? '—' }} · {{ $audit->performedBy?->name ?? 'Unknown' }}</p>
                        </article>
                    @empty
                        <div class="py-12 text-center text-sm text-slate-500 dark:text-slate-400"><i class="fas fa-clock-rotate-left mb-3 block text-4xl text-slate-300 dark:text-slate-600"></i>No publication activity found.</div>
                    @endforelse
                </div>
            </div>

            <div class="mt-4">{{ $audits->links() }}</div>
        @endif
    </div>
@endsection
