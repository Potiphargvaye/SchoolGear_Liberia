@extends('layouts.admin')
@include('partials.notifications')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">


        <!-- Search + Grade Filter -->
        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            @php
                $displayLevel = $level ?? null;
            @endphp
            <h2 class="text-2xl font-bold text-gray-800 flex items-center gap-2">
                📄 Report Card Center

                @if ($displayLevel)
                    <span
                        class="px-3 py-1 rounded-full text-sm font-semibold
            {{ in_array($displayLevel, ['junior']) ? 'bg-green-100 text-green-700' : '' }}
            {{ in_array($displayLevel, ['elementary']) ? 'bg-orange-100 text-orange-700' : '' }}
            {{ in_array($displayLevel, ['senior']) ? 'bg-blue-100 text-blue-700' : '' }}
            {{ in_array($displayLevel, ['kindergarten']) ? 'bg-pink-100 text-pink-700' : '' }}
        ">
                        {{ ucfirst($displayLevel) }}
                    </span>
                @endif
            </h2>
            <div class="flex gap-2 w-full md:w-auto">
                <!-- Search Box -->
                <input type="text" id="studentSearch" placeholder="Search student name or ID..."
                    class="w-full md:w-80 border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <!-- Grade Filter -->
                <select id="gradeFilter"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">All Grades</option>
                    @php
                        $grades = $students->pluck('class_applying_for')->unique()->sort();
                    @endphp
                    @foreach ($grades as $grade)
                        <option value="{{ $grade }}">{{ $grade }}</option>
                    @endforeach
                </select>
            </div>

        </div>


        <div class="mb-4 flex justify-between">

            <button id="printSelected"
                class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-md text-sm font-semibold">
                🖨 Print Selected (1 per page)
            </button>

        </div>
        <!-- Table Container -->
        <div class="bg-white shadow-md rounded-lg border border-gray-200 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full text-sm text-left text-gray-700" id="studentsTable">

                    <thead class="bg-gray-100 border-b">
                        <tr>
                            <th class="px-6 py-3 font-semibold bg-blue-900 text-white text-left pl-3">Row:#</th>
                            <th class="px-6 py-3 font-semibold">Student Name</th>
                            <th class="px-6 py-3 font-semibold">Registration ID</th>
                            <th class="px-6 py-3 font-semibold">Grade Level</th>
                            <th class="px-6 py-3 font-semibold text-center">Select Report Period</th>
                            <th class="px-6 py-3 font-semibold text-center">Action</th>
                            <th class="px-6 py-3 font-semibold text-center">Select</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">

                        @forelse($students as $student)
                            @php
                                $gradeLevel = $student->class_applying_for;

                                if (in_array($gradeLevel, ['K-3', 'K-4', 'K-5'])) {
                                    $level = 'kindergarten';
                                } elseif (
                                    in_array($gradeLevel, [
                                        'Grade 1',
                                        'Grade 2',
                                        'Grade 3',
                                        'Grade 4',
                                        'Grade 5',
                                        'Grade 6',
                                    ])
                                ) {
                                    $level = 'elementary';
                                } elseif (in_array($gradeLevel, ['Grade 7', 'Grade 8', 'Grade 9'])) {
                                    $level = 'junior';
                                } else {
                                    $level = 'senior';
                                }
                            @endphp

                            <tr class="hover:bg-gray-50 transition">

                                <!-- Row Number -->
                                <td class="px-6 py-3 font-semibold bg-white text-black text-left pl-3">
                                    {{ $loop->index + 1 }}
                                </td>

                                <!-- Student Name -->
                                <td class="px-6 py-3 font-medium text-gray-900">
                                    {{ $student->name }}
                                </td>

                                <!-- Registration ID -->
                                <td class="px-6 py-3 text-gray-700">
                                    {{ $student->student_id ?? 'N/A' }}
                                </td>

                                <!-- Grade Level -->
                                <td class="px-6 py-3 text-gray-700">
                                    {{ $student->class_applying_for ?? 'N/A' }}
                                </td>

                                <!-- Period Selector -->
                                <td class="px-6 py-3 text-center">
                                    <select
                                        class="period-select border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                                        data-student="{{ $student->id }}">
                                        <option value="yearly">Yearly Report Card</option>
                                        <option value="p1">1st Period (P1)</option>
                                        <option value="p2">2nd Period (P2)</option>
                                        <option value="p3">3rd Period (P3)</option>
                                        <option value="semester1">1st Semester Exam</option>
                                        <option value="p4">4th Period (P4)</option>
                                        <option value="p5">5th Period (P5)</option>
                                        <option value="p6">6th Period (P6)</option>
                                        <option value="semester2">2nd Semester Exam</option>
                                    </select>
                                </td>

                                <!-- Print Button + Header/Footer Checkboxes -->
                                <td class="px-6 py-3 text-center flex items-center justify-center gap-2">

                                    <!-- Print Button -->
                                    <a href="#" target="_blank" data-student="{{ $student->id }}"
                                        data-level="{{ Str::slug($level, '-') }}"
                                        class="print-btn inline-flex items-center gap-2 bg-blue-900 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                        Print-Card
                                    </a>

                                    <!-- Delete Button -->
                                    <div x-data="{ showDeleteModal: false }" class="flex flex-col items-center gap-2">

                                        <button @click="showDeleteModal = true"
                                            class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-red-700 transition"
                                            title="Delete Grades">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>

                                        <!-- Confirm Modal -->
                                        <div x-show="showDeleteModal" x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-2">
                                            <div x-show="showDeleteModal" x-transition
                                                class="bg-white w-full max-w-xs rounded-lg shadow-xl overflow-hidden">
                                                <!-- Header -->
                                                <div
                                                    class="flex items-center justify-between px-3 py-2 bg-red-600 text-white">
                                                    <h3 class="text-xs font-semibold">Confirm Delete</h3>
                                                    <button @click="showDeleteModal = false"
                                                        class="p-1 rounded-full hover:bg-red-500 transition">
                                                        <i class="ri-close-line text-sm"></i>
                                                    </button>
                                                </div>

                                                <!-- Body -->
                                                <div class="p-3 space-y-2 text-xs">
                                                    <p class="text-gray-700">
                                                        Are you sure you want to delete all grades for
                                                        <strong>{{ $student->name }}</strong>?
                                                    </p>
                                                </div>

                                                <!-- Footer -->
                                                <div class="px-3 py-2 bg-gray-50 border-t flex justify-end gap-1">
                                                    <button @click="showDeleteModal = false"
                                                        class="px-2 py-1 text-xs rounded border hover:bg-gray-100">
                                                        Cancel
                                                    </button>
                                                    </button>

                                                    <form method="POST"
                                                        action="{{ route('student.grades.delete', $student->id) }}"
                                                        x-data="{ submitting: false }" @submit="submitting = true">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs font-semibold bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-2 !bg-red-600 !text-white"
                                                            :disabled="submitting">
                                                            <!-- Spinner -->
                                                            <svg x-show="submitting"
                                                                class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"
                                                                viewBox="0 0 24 24"></svg>

                                                            <!-- Button text -->
                                                            <span x-show="!submitting">Delete</span>
                                                            <span x-show="submitting">Deleting…</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Header/Footer Checkboxes -->
                                    <div class="flex gap-2 mt-1 text-sm">
                                        <label>
                                            <input type="checkbox" class="show-header" checked> Header
                                        </label>
                                        <label>
                                            <input type="checkbox" class="show-footer" checked> Footer
                                        </label>
                                    </div>

                                </td>

                                <td class="px-6 py-3 text-center">
                                    <input type="checkbox" class="student-check" value="{{ $student->id }}">
                                </td>
                            </tr>

                        @empty

                            <tr>
                                <td colspan="7" class="px-6 py-4 text-center text-gray-500">
                                    No students available.
                                </td>
                            </tr>
                        @endforelse

                    </tbody>

                    <!-- JS to handle dynamic print links -->
                    <!-- JS to handle dynamic print links -->
                    <script>
                        document.querySelectorAll('.print-btn').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();

                                const row = this.closest('tr');
                                const studentId = this.dataset.student;

                                // ✅ Get dynamic level from data attribute, fallback to 'senior'
                                const level = this.dataset.level || 'senior';

                                const periodSelect = row.querySelector('.period-select');
                                const period = periodSelect ? periodSelect.value : 'yearly';

                                const showHeader = row.querySelector('.show-header')?.checked ? 1 : 0;
                                const showFooter = row.querySelector('.show-footer')?.checked ? 1 : 0;

                                // ✅ Use dynamic level in the URL
                                const url =
                                    `/report-card/${level}/${studentId}?period=${period}&showHeader=${showHeader}&showFooter=${showFooter}`;

                                window.open(url, '_blank');
                            });
                        });
                    </script>
                    </script>


                </table>


            </div>

        </div>


    </div>

    <script>
        /// <!-- Search Script -->
        function filterTable() {
            let searchValue = document.getElementById("studentSearch").value.toLowerCase().trim();
            let gradeValue = document.getElementById("gradeFilter")?.value.toLowerCase().trim() || "";

            let rows = document.querySelectorAll("#studentsTable tbody tr");

            rows.forEach(function(row) {

                // Shifted by 1 because of the new # column
                let name = row.cells[1].innerText.toLowerCase().trim(); // was cells[0]
                let studentId = row.cells[2].innerText.toLowerCase().trim(); // was cells[1]
                let grade = row.cells[3].innerText.toLowerCase().trim(); // was cells[2]

                let matchesSearch = name.includes(searchValue) || studentId.includes(searchValue);
                let matchesGrade = gradeValue === "" || grade.includes(gradeValue);

                row.style.display = (matchesSearch && matchesGrade) ? "" : "none";
            });
        }

        // Events
        document.getElementById("studentSearch").addEventListener("keyup", filterTable);
        document.getElementById("gradeFilter")?.addEventListener("change", filterTable);

        //  Script to Attach Period to the URL
        document.querySelectorAll('.print-btn').forEach(button => {

            button.addEventListener('click', function(e) {

                e.preventDefault();

                let studentId = this.dataset.student;

                let select = document.querySelector(
                    '.period-select[data-student="' + studentId + '"]'
                );

                let period = select.value;

                let baseUrl = this.href;

                let finalUrl = baseUrl + '?period=' + period;

                window.open(finalUrl, '_blank');

            });

        });

        // script for selected period  to dynamic load the columns
        const periodSelect = document.getElementById('periodSelect');

        if (periodSelect) {

            const printButtons = document.querySelectorAll('.print-btn');

            periodSelect.addEventListener('change', function() {
                const selectedPeriod = this.value;

                printButtons.forEach(btn => {
                    const studentId = btn.dataset.student;
                    const level = btn.dataset.level || 'senior'; // ✅ FIX

                    btn.href = `/report-card/${level}/${studentId}?period=${selectedPeriod}`; // ✅ FIX
                });
            });

        }
        // Set initial href on page load
        window.addEventListener('DOMContentLoaded', () => {
            const periodSelect = document.getElementById('periodSelect'); // ✅ ensure defined
            const printButtons = document.querySelectorAll('.print-btn'); // ✅ ensure defined

            if (periodSelect) {
                const selectedPeriod = periodSelect.value;

                printButtons.forEach(btn => {
                    const studentId = btn.dataset.student;
                    const level = btn.dataset.level || 'senior'; // ✅ FIX

                    btn.href = `/report-card/${level}/${studentId}?period=${selectedPeriod}`; // ✅ FIX
                });
            }
        });

        // for multipl students printing
        document.getElementById('printSelected').addEventListener('click', function() {

            let selected = [];
            let headers = [];
            let footers = [];
            let periods = [];
            let levels = []; // ✅ NEW (future use, no breaking change)

            document.querySelectorAll('.student-check:checked').forEach(cb => {
                let row = cb.closest('tr');
                let studentId = cb.value;
                selected.push(studentId);

                // Grab period select
                let periodSelect = row.querySelector('.period-select');
                let period = periodSelect ? periodSelect.value : 'yearly';
                periods.push(period);

                // Grab header/footer checkbox values
                let showHeader = row.querySelector('.show-header').checked ? 1 : 0;
                let showFooter = row.querySelector('.show-footer').checked ? 1 : 0;

                headers.push(showHeader);
                footers.push(showFooter);

                // ✅ NEW (safe: optional, won't break anything if not present)
                let level = row.querySelector('.print-btn')?.dataset.level || 'senior';
                levels.push(level);
            });

            if (selected.length === 0) {
                alert('Please select at least one student');
                return;
            }

            // Build URL with per-student params
            let url = `/report-cards/print-multiple?students=${selected.join(',')}` +
                `&periods=${periods.join(',')}` +
                `&headers=${headers.join(',')}` +
                `&footers=${footers.join(',')}` +
                `&levels=${levels.join(',')}`; // ✅ NEW (not used yet, safe)

            window.open(url, '_blank');
        });
    </script>
@endsection
