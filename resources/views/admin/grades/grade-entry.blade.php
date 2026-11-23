@extends('layouts.admin')

@section('content')
    @include('partials.notifications') {{-- ✅ CORRECT PLACE --}}

    <div class="container-fluid min-w-0 max-w-full overflow-x-clip px-2 py-2 sm:px-4 md:px-6 lg:px-8">

        <div class="card-header flex min-w-0 flex-col gap-3 bg-transparent lg:flex-row lg:items-center lg:justify-between">
            <button class="w-full rounded bg-[#25D366] px-3 py-2 text-left text-xs font-bold text-white hover:bg-[#1ebe5d] cursor-default sm:w-auto">
                Grade Entry - {{ $grade->level }}{{ $grade->section ? ' - ' . $grade->section : '' }}
                ({{ $academicYear->name }})
            </button>

            <div class="grid min-w-0 grid-cols-1 gap-3 sm:grid-cols-2 lg:flex lg:items-center">

                <!-- Grade filter -->
                <div class="flex min-w-0 flex-col gap-1 sm:flex-row sm:items-center sm:gap-2">
                    <label class="shrink-0 text-xs font-semibold text-gray-600">Grade:</label>
                    <select id="gradeFilter"
                        class="min-h-11 w-full min-w-0 rounded border px-3 py-2.5 text-base focus:outline-none focus:ring-1 focus:ring-gray-400 sm:flex-1"
                        onchange="window.location.href = '{{ route('grades.load') }}?grade_id=' + this.value + '&academic_year_id={{ $academicYear->id }}';">
                        @foreach ($allGrades as $g)
                            <option value="{{ $g->id }}" {{ $g->id === $grade->id ? 'selected' : '' }}>
                                {{ $g->level }}{{ $g->section ? ' - ' . $g->section : '' }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Academic Year filter -->
                <div class="flex min-w-0 flex-col gap-1 sm:flex-row sm:items-center sm:gap-2">
                    <label class="shrink-0 text-xs font-semibold text-gray-600">Academic Year:</label>
                    <select id="academicYearFilter"
                        class="min-h-11 w-full min-w-0 rounded border px-3 py-2.5 text-base focus:outline-none focus:ring-1 focus:ring-gray-400 sm:flex-1"
                        onchange="window.location.href = '{{ route('grades.load') }}?grade_id={{ $grade->id }}&academic_year_id=' + this.value;">
                        @foreach ($allAcademicYears as $year)
                            <option value="{{ $year->id }}" {{ $year->id === $academicYear->id ? 'selected' : '' }}>
                                {{ $year->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        <section class="mb-4 rounded-lg border border-indigo-100 bg-indigo-50 p-4" aria-labelledby="grade-publication-heading">
            <div class="mb-3 flex flex-wrap items-center justify-between gap-2">
                <div>
                    <h2 id="grade-publication-heading" class="text-sm font-bold text-indigo-900">Student visibility</h2>
                    <p class="mt-1 text-xs text-indigo-700">Publish individual grade-entry slots for students. This does not change admin views, exports, locks, or report cards.</p>
                </div>
            </div>

            <div class="grid min-w-0 grid-cols-2 gap-2 sm:gap-3 sm:grid-cols-3 lg:grid-cols-4">
                @foreach ($publicationSlots as $slot => $slotLabel)
                    @php
                        $publication = $gradePublications->get($slot);
                    @endphp
                    @php
                        $isPublished = $publication?->isPublished() ?? false;
                    @endphp
                    <div class="flex min-w-0 min-h-[68px] flex-col gap-1 rounded-lg border border-indigo-100 bg-white p-2.5 sm:p-3">
                        <div class="flex min-w-0 items-start justify-between gap-2">
                            <span class="min-w-0 truncate text-sm font-medium text-gray-800">{{ $slotLabel }}</span>
                            @if ($isPublished)
                                <span class="min-w-0 flex-1 text-right text-[10px] font-semibold leading-4 text-green-700">
                                    <span class="inline-block max-w-full truncate rounded-full bg-green-100 px-1.5 py-0.5 text-[11px]">Published</span>
                                    <span class="block whitespace-normal break-words font-normal text-gray-500">
                                        Published on {{ $publication->published_at->format('M j, Y') }}
                                        @if ($publication->publisher)
                                            by {{ $publication->publisher->name }}
                                        @endif
                                    </span>
                                </span>
                            @else
                                <span class="shrink-0 rounded-full bg-gray-100 px-1.5 py-0.5 text-[11px] font-semibold text-gray-500">Unpublished</span>
                            @endif
                        </div>

                        @if ($isPublished)
                            @can('unpublish student grades')
                                <button type="button"
                                    class="publication-trigger relative z-0 mt-auto h-8 min-h-0 w-auto self-start rounded-md border border-gray-400 bg-transparent px-3 py-1 text-xs font-semibold text-gray-700 before:absolute before:-inset-2 before:-z-10 before:content-[''] hover:bg-gray-100 dark:border-gray-500 dark:text-gray-200 dark:hover:bg-gray-700"
                                    data-publication-action="{{ route('grades.unpublish') }}"
                                    data-publication-state="unpublish"
                                    data-publication-slot="{{ $slot }}"
                                    data-publication-slot-label="{{ $slotLabel }}"
                                    data-publication-grade-id="{{ $grade->id }}"
                                    data-publication-academic-year-id="{{ $academicYear->id }}"
                                    data-publication-school="{{ auth()->user()->school?->school_name ?? 'this school' }}"
                                    data-publication-grade="{{ $grade->level }}{{ $grade->section ? ' - '.$grade->section : '' }}"
                                    data-publication-academic-year="{{ $academicYear->name }}">
                                    Unpublish
                                </button>
                            @endcan
                        @else
                            @can('publish student grades')
                                <button type="button"
                                    class="publication-trigger relative z-0 mt-auto h-8 min-h-0 w-auto self-start rounded-md bg-indigo-600 px-3 py-1 text-xs font-semibold text-white before:absolute before:-inset-2 before:-z-10 before:content-[''] hover:bg-indigo-700"
                                    data-publication-action="{{ route('grades.publish') }}"
                                    data-publication-state="publish"
                                    data-publication-slot="{{ $slot }}"
                                    data-publication-slot-label="{{ $slotLabel }}"
                                    data-publication-grade-id="{{ $grade->id }}"
                                    data-publication-academic-year-id="{{ $academicYear->id }}"
                                    data-publication-school="{{ auth()->user()->school?->school_name ?? 'this school' }}"
                                    data-publication-grade="{{ $grade->level }}{{ $grade->section ? ' - '.$grade->section : '' }}"
                                    data-publication-academic-year="{{ $academicYear->name }}">
                                    Publish
                                </button>
                            @endcan
                        @endif
                    </div>
                @endforeach
            </div>
        </section>

        <div id="gradePublicationModal" class="fixed inset-0 z-[60] hidden bg-black/50 p-3" role="dialog"
            aria-modal="true" aria-labelledby="gradePublicationModalTitle">
            <div class="flex min-h-full items-center justify-center">
                <div id="gradePublicationModalContent"
                    class="max-h-[92dvh] w-full max-w-md overflow-y-auto rounded-lg border border-gray-200 bg-white shadow-xl dark:border-gray-700 dark:bg-gray-800">
                    <div class="flex items-center justify-between rounded-t-lg bg-indigo-700 px-4 py-3 text-white">
                        <h2 id="gradePublicationModalTitle" class="text-base font-semibold">Confirm publication change</h2>
                        <button type="button" id="closeGradePublicationModal"
                            class="min-h-[44px] min-w-[44px] rounded text-2xl leading-none hover:bg-indigo-600"
                            aria-label="Close confirmation">&times;</button>
                    </div>
                    <div class="space-y-3 p-4 text-sm text-gray-700 dark:text-gray-200">
                        <p id="gradePublicationModalMessage"></p>
                        <p class="text-xs text-gray-500 dark:text-gray-400">This changes student visibility only. Admin grades, exports, locks, audits, and report cards are not changed.</p>
                    </div>
                    <div class="flex flex-col-reverse gap-2 rounded-b-lg bg-gray-50 p-3 sm:flex-row sm:justify-end dark:bg-gray-900">
                        <button type="button" id="cancelGradePublicationModal"
                            class="min-h-[44px] rounded border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:text-gray-200 dark:hover:bg-gray-700">
                            Cancel
                        </button>
                        <form id="gradePublicationConfirmForm" method="POST">
                            @csrf
                            <input type="hidden" name="grade_id" id="publicationConfirmGradeId">
                            <input type="hidden" name="academic_year_id" id="publicationConfirmAcademicYearId">
                            <input type="hidden" name="slot" id="publicationConfirmSlot">
                            <button type="submit" id="confirmGradePublicationModal"
                                class="min-h-[44px] w-full rounded bg-indigo-600 px-4 py-2 text-sm font-semibold text-white hover:bg-indigo-700 sm:w-auto">
                                Confirm
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <form method="POST" action="{{ route('grades.store') }}" id="gradesForm">
            @csrf
            <input type="hidden" name="grades_json" id="grades_json">
            <input type="hidden" name="academic_year_id" value="{{ $academicYear->id }}">
            <input type="hidden" name="grade_id" value="{{ $grade->id }}">

            <div class="card-body p-0">



                <!-- Sticky Control Bar -->
                <div
                    class="sticky top-0 z-50 flex min-w-0 flex-col gap-3 border-b bg-white px-3 py-3 shadow-sm lg:flex-row lg:items-center lg:justify-between">

                    <!-- LEFT SIDE: Semester Status -->
                    <div class="flex min-w-0 flex-wrap gap-3 text-sm font-semibold">
                        <div>Semester 1:
                            @if ($sem1Locked)
                                <span class="text-red-600">🔒 LOCKED</span>
                            @else
                                <span class="text-green-600">OPEN</span>
                            @endif
                        </div>
                        <div>Semester 2:
                            @if ($sem2Locked)
                                <span class="text-red-600">🔒 LOCKED</span>
                            @else
                                <span class="text-green-600">OPEN</span>
                            @endif
                        </div>
                    </div>

                    <!-- RIGHT SIDE: Search + Buttons -->
                    <div class="grid min-w-0 grid-cols-1 gap-2 sm:grid-cols-2 lg:flex lg:items-center">

                        <!-- Search Input -->
                        <input type="text" id="studentSearch" placeholder="Search student..."
                            class="min-h-11 w-full min-w-0 rounded border px-3 py-2.5 text-base focus:outline-none focus:ring-1 focus:ring-gray-400 sm:col-span-2 lg:w-48">

                        <!-- Lock/Unlock Button. -->
                        @can('lock & unlock grade submission')
                            <button type="button"
                                class="min-h-11 w-full rounded bg-red-600 px-3 py-2 text-sm text-white shadow hover:bg-red-700 lg:w-auto"
                                onclick="document.getElementById('gradeLockModal').classList.remove('hidden')">
                                🔒 Lock / Unlock Semester
                            </button>
                        @endcan

                        <!-- Export Button -->
                        <button type="button" id="exportBtn" onclick="exportGradeSheet(this)"
                            class="inline-flex min-h-11 w-full items-center justify-center gap-1.5 rounded bg-[#155E8A] px-3 py-2 text-xs text-white hover:bg-[#0F4A6E] lg:w-auto">
                            <i class="fas fa-file-excel"></i> Export to Excel
                        </button>

                        @canany(['publish student grades', 'unpublish student grades'])
                            <a href="{{ route('grades.publication-history', ['grade_id' => $grade->id, 'academic_year_id' => $academicYear->id]) }}"
                                class="inline-flex min-h-11 w-full items-center justify-center gap-1.5 rounded border border-indigo-300 px-3 py-2 text-xs font-semibold text-indigo-700 hover:bg-indigo-50 dark:border-indigo-500 dark:text-indigo-300 dark:hover:bg-indigo-950/40 lg:w-auto"
                                title="Publication History">
                                <i class="fas fa-clock-rotate-left"></i> Publication History
                            </a>
                        @endcanany

                        <!-- Save Changes Button -->
                        <button type="button" onclick="submitGrades(this)"
                            class="inline-flex min-h-11 w-full items-center justify-center gap-1.5 rounded bg-[#25D366] px-3 py-2 text-xs text-white hover:bg-[#1ebe5d] lg:w-auto">
                            Save Changes
                        </button>

                    </div>
                </div>

                <!-- CHANGE #1: responsive scrolling -->
                <div class="min-w-0 max-w-full overflow-x-auto overflow-y-auto max-h-[70vh]">

                    <p class="mb-2 rounded bg-gray-100 px-3 py-2 text-center text-xs text-gray-600 dark:bg-gray-800 dark:text-gray-300 sm:hidden">
                        Swipe horizontally to view all grade columns.
                    </p>

                    <div id="noStudentMessage"
                        class="hidden bg-yellow-100 border border-yellow-400 text-yellow-800 px-4 py-3 rounded mb-3 text-center font-semibold">
                        ⚠️ No student found for your search.
                        <a href="#" id="resetSearchTop" class="text-blue-600 underline ml-2 font-bold">
                            🔄 Reset
                        </a>
                    </div>
                    <!-- CHANGE #2: thicker black borders for entire table -->
                    <table class="min-w-max bg-white border-2 border-black text-center">

                        <thead class="bg-gray-800 text-white sticky top-0 z-40">
                            <tr>


                                <!-- # Number Column -->
                                <th rowspan="2"
                                    class="p-1 font-medium text-left pl-1  bg-black text-white z-10 w-10 border-2 border-black"
                                    style="position: sticky; left: 0px; min-width: 40px;">
                                    row:#
                                </th>

                                <!-- Student Column -->
                                <th rowspan="2"
                                    class="p-3 font-medium text-left bg-gray-800 z-10 min-w-[180px] border-2 border-black"
                                    style="position: sticky; left: 40px;">
                                    Student
                                </th>

                                @foreach ($subjects as $subject)
                                    <!-- CHANGE #4: thicker borders -->
                                    <th colspan="11" class="p-3 font-bold bg-gray-700 border-2 border-black">
                                        Subject: {{ $subject->name }}
                                    </th>
                                @endforeach
                            </tr>

                            <tr>
                                @foreach ($subjects as $subject)
                                    <!-- CHANGE #5: thicker borders -->
                                    <th class="p-2 border-2 border-black">P1</th>
                                    <th class="p-2 border-2 border-black">P2</th>
                                    <th class="p-2 border-2 border-black">P3</th>
                                    <th class="p-2 border-2 border-black">1st Exam</th>

                                    <!-- CHANGE #6: NAVY BLUE for 1st Avg -->
                                    <th class="p-2 border-2 border-black bg-blue-900 text-white">
                                        1st Avg
                                    </th>

                                    <th class="p-2 border-2 border-black">P4</th>
                                    <th class="p-2 border-2 border-black">P5</th>
                                    <th class="p-2 border-2 border-black">P6</th>
                                    <th class="p-2 border-2 border-black">2nd Exam</th>

                                    <!-- CHANGE #7: NAVY BLUE for 2nd Avg -->
                                    <th class="p-2 border-2 border-black bg-blue-900 text-white">
                                        2nd Avg
                                    </th>

                                    <!-- CHANGE #8: GREEN for Year Avg -->
                                    <th class="p-2 border-2 border-black bg-green-600 text-white font-semibold">
                                        Year Avg
                                    </th>
                                @endforeach
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-200">


                            @foreach ($enrollments as $enrollment)
                                <tr class="studentRow {{ $loop->even ? 'bg-blue-50' : 'bg-white' }}">

                                    <!-- Row Number -->
                                    <td class="p-2 text-left pl-3 font-semibold bg-black text-white z-10 border-2 border-black text-sm"
                                        style="position: sticky; left: 0px; min-width: 40px;">
                                        {{ $loop->index + 1 }}
                                    </td>

                                    <!-- CHANGE #9: sticky student column student name -->
                                    <td class="studentName p-3 font-medium text-left bg-white z-10 border-2 border-black"
                                        style="position: sticky; left: 40px; min-width: 180px;">
                                        {{ $enrollment->student->name }}
                                    </td>

                                    @foreach ($subjects as $subject)
                                        @php
                                            $key = $enrollment->id . '-' . $subject->id;
                                            $studentGrade = $grades[$key] ?? null;
                                        @endphp

                                        <!-- PERIODS 1–3 and EXAM 1 -->
                                        @foreach (['period1', 'period2', 'period3', 'exam1'] as $period)
                                            <td class="p-1 border-2 border-black">
                                                <input type="number"
                                                    name="grades[{{ $enrollment->id }}][{{ $subject->id }}][{{ $period }}]"
                                                    value="{{ $studentGrade->$period ?? '' }}"
                                                     class="form-control form-control-sm min-h-11 w-20 text-center text-base score-input
           {{ isset($studentGrade->$period) ? ($studentGrade->$period < 70 ? 'text-red-600 font-semibold' : 'text-black') : 'text-black' }}
           @if ($sem1Locked || (isset($studentGrade->$period) && !auth()->user()->can('edit student grades'))) bg-red-100 cursor-not-allowed @endif"
                                                    @if ($sem1Locked || (isset($studentGrade->$period) && !auth()->user()->can('edit student grades'))) readonly
               title="This grade is locked by admin: you cannot edit it" @endif>
                                            </td>
                                        @endforeach

                                        <!-- 1st Semester Avg -->
                                        <td class="p-1 border-2 border-black bg-blue-100">
                                            <input type="text" readonly
                                                class="form-control form-control-sm min-h-11 w-20 text-center text-base sem1">
                                        </td>

                                        <!-- PERIODS 4–6 and EXAM 2 -->
                                        @foreach (['period4', 'period5', 'period6', 'exam2'] as $period)
                                            <td class="p-1 border-2 border-black">
                                                <input type="number"
                                                    name="grades[{{ $enrollment->id }}][{{ $subject->id }}][{{ $period }}]"
                                                    value="{{ $studentGrade->$period ?? '' }}"
                                                     class="form-control form-control-sm min-h-11 w-20 text-center text-base score-input
           {{ isset($studentGrade->$period) ? ($studentGrade->$period < 70 ? 'text-red-600 font-semibold' : 'text-black') : 'text-black' }}
           @if ($sem2Locked || (isset($studentGrade->$period) && !auth()->user()->can('edit student grades'))) bg-red-100 cursor-not-allowed @endif"
                                                    @if ($sem2Locked || (isset($studentGrade->$period) && !auth()->user()->can('edit student grades'))) readonly
               title="This grade is locked by admin: you cannot edit it" @endif>
                                            </td>
                                        @endforeach

                                        <!-- 2nd Semester Avg -->
                                        <td class="p-1 border-2 border-black bg-blue-100">
                                            <input type="text" readonly
                                                class="form-control form-control-sm min-h-11 w-20 text-center text-base sem2">
                                        </td>

                                        <!-- Year Avg -->
                                        <td class="p-1 border-2 border-black bg-green-200 font-semibold">
                                            <input type="text" readonly
                                                class="form-control form-control-sm min-h-11 w-20 text-center text-base yearly">
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                            <!-- 🔔 Fallback row -->
                            <tr id="noStudentRow" class="hidden">
                                <td colspan="{{ 2 + $subjects->count() * 11 }}"
                                    class="p-5 text-center bg-yellow-100 font-semibold">
                                    ⚠️ No student found for your search.
                                    <a href="#" id="resetSearch" class="text-blue-600 underline ml-3 font-bold">
                                        🔄 Reset
                                    </a>
                                </td>
                            </tr>

                        </tbody>
                    </table>
                </div>

            </div>

            <!-- Footer Save Button -->
            <div class="card-footer text-end">
                <!-- CHANGE #12: green save button -->
                <button type="button" onclick="submitGrades(this)"
                    class="bg-[#25D366] text-white px-3 py-2 hover:bg-[#1ebe5d] rounded text-xs inline-flex items-center gap-1.5">
                    Save Changes
                </button>
            </div>

        </form>
    </div>
    </div>

    <!-- Grade Lock Modal -->
    <div id="gradeLockModal"
        class="fixed inset-0 z-50 hidden items-center justify-center overflow-y-auto bg-black bg-opacity-40 p-3 sm:p-4 flex">

        <!-- Modal Container -->
        <div class="my-auto max-h-[92dvh] w-full max-w-md overflow-y-auto rounded-lg bg-white p-4 shadow-lg dark:bg-gray-800 sm:p-6">

            <div class="mb-4 flex items-center justify-between gap-3">
                <h2 class="text-lg font-bold text-gray-900 dark:text-white">Grade Lock Control</h2>
                <button type="button" aria-label="Close grade lock modal"
                    onclick="document.getElementById('gradeLockModal').classList.add('hidden')"
                    class="min-h-11 min-w-11 rounded text-2xl leading-none text-gray-500 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-700">
                    &times;
                </button>
            </div>

            <form method="POST" action="{{ route('grades.lock') }}">
                @csrf

                <input type="hidden" name="grade_id" value="{{ $grade->id }}">
                <input type="hidden" name="academic_year_id" value="{{ $academicYear->id }}">

                <div class="mb-4">
                    <label class="mb-2 block font-semibold text-gray-800 dark:text-gray-100">Select Semester</label>
                    <select name="semester" class="min-h-11 w-full rounded border p-2.5 text-base dark:border-gray-600 dark:bg-gray-700 dark:text-white">
                        <option value="sem1">Semester 1 (P1–Exam1)</option>
                        <option value="sem2">Semester 2 (P4–Exam2)</option>
                    </select>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row sm:justify-between">
                    <button type="submit" name="action" value="lock"
                        class="min-h-11 flex-1 rounded bg-red-600 px-4 py-2 text-white">
                        Lock
                    </button>
                    <button type="submit" name="action" value="unlock"
                        class="min-h-11 flex-1 rounded bg-green-600 px-4 py-2 text-white">
                        Unlock
                    </button>
                    <button type="button" onclick="document.getElementById('gradeLockModal').classList.add('hidden')"
                        class="min-h-11 flex-1 rounded bg-gray-400 px-4 py-2 text-white">
                        Cancel
                    </button>
                </div>

            </form>
        </div>

    </div>



    <script>
        //average calculations
        document.addEventListener('input', function(e) {

            if (!e.target.classList.contains('score-input')) return;

            let row = e.target.closest('tr');

            // get all td cells in this row
            let cells = row.querySelectorAll('td');

            /*
            |--------------------------------------------------------------------------
            | Table structure
            |--------------------------------------------------------------------------
            |
            | 0 = row number
            | 1 = student name
            |
            | then every subject block has 11 columns:
            |
            | P1
            | P2
            | P3
            | Exam1
            | Sem1 Avg
            | P4
            | P5
            | P6
            | Exam2
            | Sem2 Avg
            | Year Avg
            |
            */

            for (let i = 2; i < cells.length; i += 11) {

                // ───── SEMESTER 1 ─────
                let p1 = parseFloat(cells[i]?.querySelector('input')?.value) || 0;
                let p2 = parseFloat(cells[i + 1]?.querySelector('input')?.value) || 0;
                let p3 = parseFloat(cells[i + 2]?.querySelector('input')?.value) || 0;
                let exam1 = parseFloat(cells[i + 3]?.querySelector('input')?.value) || 0;

                let sem1Avg = (((p1 + p2 + p3) / 3) + exam1) / 2;

                // ───── SEMESTER 2 ─────
                let p4 = parseFloat(cells[i + 5]?.querySelector('input')?.value) || 0;
                let p5 = parseFloat(cells[i + 6]?.querySelector('input')?.value) || 0;
                let p6 = parseFloat(cells[i + 7]?.querySelector('input')?.value) || 0;
                let exam2 = parseFloat(cells[i + 8]?.querySelector('input')?.value) || 0;

                let sem2Avg = (((p4 + p5 + p6) / 3) + exam2) / 2;

                // ───── YEARLY ─────
                let yearlyAvg = (sem1Avg + sem2Avg) / 2;

                // ───── UPDATE UI ─────
                let sem1Field = cells[i + 4]?.querySelector('input');
                let sem2Field = cells[i + 9]?.querySelector('input');
                let yearlyField = cells[i + 10]?.querySelector('input');

                if (sem1Field) sem1Field.value = Math.round(sem1Avg);
                if (sem2Field) sem2Field.value = Math.round(sem2Avg);
                if (yearlyField) yearlyField.value = yearlyAvg.toFixed(2);
            }

        });
        // ─────────────────────────────────────────
        // LIVE GRADE COLOR — red if < 70, black if >= 70
        // ─────────────────────────────────────────
        function applyGradeColor(input) {
            const val = input.value.trim();
            if (val === '') {
                input.style.color = '';
                input.style.fontWeight = '';
                return;
            }
            const num = parseInt(val);
            if (!isNaN(num) && num < 70) {
                input.style.color = '#dc2626'; // red-600
                input.style.fontWeight = '600';
            } else {
                input.style.color = '#000000'; // black
                input.style.fontWeight = '600';
            }
        }

        // Apply on page load to all existing values
        document.querySelectorAll('input.score-input').forEach(function(input) {
            applyGradeColor(input);
        });

        // Apply live as user types
        document.addEventListener('input', function(e) {
            if (e.target.classList.contains('score-input')) {
                applyGradeColor(e.target);
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const searchInput = document.getElementById('studentSearch');
            const rows = document.querySelectorAll('tbody tr.studentRow');

            const fallbackRow = document.getElementById('noStudentRow');
            const messageBox = document.getElementById('noStudentMessage');

            const resetTop = document.getElementById('resetSearchTop');
            const resetRow = document.getElementById('resetSearch');

            function filterStudents() {

                const filter = searchInput.value.toLowerCase().trim();
                let anyVisible = false;

                rows.forEach(row => {

                    const studentName = row.querySelector('.studentName')
                        .textContent
                        .toLowerCase()
                        .trim();

                    if (studentName.includes(filter)) {
                        row.style.display = '';
                        anyVisible = true;
                    } else {
                        row.style.display = 'none';
                    }

                });

                if (anyVisible) {

                    fallbackRow.style.display = 'none';
                    messageBox.classList.add('hidden');

                } else {

                    fallbackRow.style.display = 'table-row';
                    messageBox.classList.remove('hidden');

                }
            }

            searchInput.addEventListener('keyup', filterStudents);

            function resetSearch(e) {

                e.preventDefault();
                searchInput.value = '';
                filterStudents();

            }

            resetTop.addEventListener('click', resetSearch);
            resetRow.addEventListener('click', resetSearch);

        });


        // ───── EXPORT STUDENT RECORDS  Function (Excel) ─────
        async function exportGradeSheet(btn) {
            const url = "{{ route('grades.export') }}" + window.location.search;
            const originalHtml = btn.innerHTML; // <-- add this line

            btn.disabled = true;
            btn.classList.add('opacity-70', 'cursor-not-allowed');
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Exporting...';


            try {
                const response = await fetch(url, {
                    credentials: 'same-origin',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                if (!response.ok) {
                    throw new Error('Export failed (' + response.status + ')');
                }

                const blob = await response.blob();

                // Use the server's filename if present
                let filename = 'grade-entry-export.xlsx';
                const disposition = response.headers.get('Content-Disposition');
                const match = disposition && disposition.match(/filename\*?=(?:UTF-8'')?"?([^";]+)"?/i);
                if (match) filename = decodeURIComponent(match[1]);

                const objectUrl = URL.createObjectURL(blob);
                const link = document.createElement('a');
                link.href = objectUrl;
                link.download = filename;
                document.body.appendChild(link);
                link.click();
                link.remove();
                URL.revokeObjectURL(objectUrl);
            } catch (error) {
                console.error(error);
                alert('Could not export the records. Please try again.');
            } finally {
                btn.disabled = false;
                btn.classList.remove('opacity-70', 'cursor-not-allowed');
                btn.innerHTML = originalHtml;
            }
        }
        // =====for my form submission to alow every data to be inserted insted of 10 rows only  ======
        function submitGrades(btn) {
            let gradesData = {};

            document.querySelectorAll('input[name]').forEach(function(input) {
                let match = input.name.match(/^grades\[(\d+)\]\[(\d+)\]\[(\w+)\]$/);
                if (match) {
                    let enrollmentId = match[1];
                    let subjectId = match[2];
                    let field = match[3];

                    if (!gradesData[enrollmentId]) gradesData[enrollmentId] = {};
                    if (!gradesData[enrollmentId][subjectId]) gradesData[enrollmentId][subjectId] = {};

                    // Store null for empty values, integer for filled ones
                    let val = input.value.trim();
                    gradesData[enrollmentId][subjectId][field] = val === '' ? null : val;
                }
            });

            // Check we actually collected data
            if (Object.keys(gradesData).length === 0) {
                alert('No grade data found. Please check the form.');
                return;
            }

            // Put into hidden field
            document.getElementById('grades_json').value = JSON.stringify(gradesData);

            // Disable all grade inputs so they don't submit alongside JSON
            document.querySelectorAll('input[name^="grades["]').forEach(function(input) {
                input.disabled = true;
            });

            // ───── NEW: "Saving..." state ─────
            if (btn) {
                btn.disabled = true;
                btn.classList.add('opacity-70', 'cursor-not-allowed');
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
            }

            console.log('Submitting grades for students:', Object.keys(gradesData).length);

            // Submit
            document.getElementById('gradesForm').submit();
        }

        // ─────────────────────────────────────────
        // ARROW KEY NAVIGATION (Excel-like)
        // ─────────────────────────────────────────
        document.addEventListener('keydown', function(e) {
            const arrowKeys = ['ArrowUp', 'ArrowDown', 'ArrowLeft', 'ArrowRight'];
            if (!arrowKeys.includes(e.key)) return;

            const active = document.activeElement;
            if (!active || !active.classList.contains('score-input')) return;

            e.preventDefault(); // prevent page scrolling

            // Build a 2D grid of all visible, non-readonly score-input cells
            // Group by row first
            const rows = Array.from(document.querySelectorAll('tr.studentRow'))
                .filter(row => !row.classList.contains('hidden'));

            let currentRow = -1;
            let currentCol = -1;

            // Build grid: grid[rowIndex] = [input, input, ...]
            const grid = rows.map((row, rIdx) => {
                const inputs = Array.from(row.querySelectorAll('input.score-input'))
                    .filter(inp => !inp.readOnly && !inp.disabled);

                inputs.forEach((inp, cIdx) => {
                    if (inp === active) {
                        currentRow = rIdx;
                        currentCol = cIdx;
                    }
                });

                return inputs;
            });

            if (currentRow === -1) return; // active input not found in grid

            let targetRow = currentRow;
            let targetCol = currentCol;

            if (e.key === 'ArrowRight') targetCol++;
            if (e.key === 'ArrowLeft') targetCol--;
            if (e.key === 'ArrowDown') targetRow++;
            if (e.key === 'ArrowUp') targetRow--;

            // Clamp to grid bounds
            targetRow = Math.max(0, Math.min(targetRow, grid.length - 1));

            const targetRowInputs = grid[targetRow];
            if (!targetRowInputs || targetRowInputs.length === 0) return;

            targetCol = Math.max(0, Math.min(targetCol, targetRowInputs.length - 1));

            const targetInput = targetRowInputs[targetCol];
            if (targetInput) {
                targetInput.focus();
                targetInput.select();

                // Scroll into view smoothly
                targetInput.scrollIntoView({
                    block: 'nearest',
                    inline: 'nearest'
                });
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('gradePublicationModal');
            const modalMessage = document.getElementById('gradePublicationModalMessage');
            const closeButton = document.getElementById('closeGradePublicationModal');
            const cancelButton = document.getElementById('cancelGradePublicationModal');
            const confirmForm = document.getElementById('gradePublicationConfirmForm');
            const confirmButton = document.getElementById('confirmGradePublicationModal');
            const triggerButtons = document.querySelectorAll('.publication-trigger');
            const gradeIdInput = document.getElementById('publicationConfirmGradeId');
            const academicYearIdInput = document.getElementById('publicationConfirmAcademicYearId');
            const slotInput = document.getElementById('publicationConfirmSlot');

            if (!modal || !confirmForm) return;

            let activeTrigger = null;

            function closePublicationModal() {
                modal.classList.add('hidden');
                activeTrigger?.focus();
                activeTrigger = null;
            }

            triggerButtons.forEach(function(button) {
                button.addEventListener('click', function() {
                    activeTrigger = button;
                    const isPublishing = button.dataset.publicationState === 'publish';
                    confirmForm.action = button.dataset.publicationAction;
                    gradeIdInput.value = button.dataset.publicationGradeId;
                    academicYearIdInput.value = button.dataset.publicationAcademicYearId;
                    slotInput.value = button.dataset.publicationSlot;
                    modalMessage.textContent = `${isPublishing ? 'Publish' : 'Unpublish'} ${button.dataset.publicationSlotLabel} for ${button.dataset.publicationSchool}, ${button.dataset.publicationGrade}, ${button.dataset.publicationAcademicYear}?`;
                    confirmButton.textContent = isPublishing ? 'Confirm Publish' : 'Confirm Unpublish';
                    modal.classList.remove('hidden');
                    confirmButton.focus();
                });
            });

            closeButton.addEventListener('click', closePublicationModal);
            cancelButton.addEventListener('click', closePublicationModal);
            modal.addEventListener('click', function(event) {
                if (event.target === modal) closePublicationModal();
            });

            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && !modal.classList.contains('hidden')) {
                    event.preventDefault();
                    closePublicationModal();
                }
            });

            confirmForm.addEventListener('submit', function() {
                const isPublishing = activeTrigger?.dataset.publicationState === 'publish';
                triggerButtons.forEach(function(button) {
                    button.disabled = true;
                    button.classList.add('cursor-not-allowed', 'opacity-70');
                });
                confirmButton.disabled = true;
                confirmButton.innerHTML = `<i class="fas fa-spinner fa-spin mr-1"></i>${isPublishing ? 'Publishing...' : 'Unpublishing...'}`;
            });
        });
    </script>
@endsection
