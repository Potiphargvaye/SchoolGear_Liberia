@extends('layouts.admin')
@include('partials.notifications')

@section('content')
    <div class="max-w-7xl mx-auto px-4 py-6">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between mb-6 gap-4">
            @php $displayLevel = $level ?? null; @endphp
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
                <input type="text" id="studentSearch" placeholder="Search student name or ID..."
                    class="w-full md:w-80 border border-gray-300 rounded-md px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                <select id="gradeFilter"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500">
                    <option value="">All Grades</option>
                    @php
                        $gradeOptions = $enrollments
                            ->map(fn($e) => $e->grade->level . ($e->grade->section ? ' - ' . $e->grade->section : ''))
                            ->unique()
                            ->sort();
                    @endphp
                    @foreach ($gradeOptions as $gradeOption)
                        <option value="{{ $gradeOption }}">{{ $gradeOption }}</option>
                    @endforeach
                </select>

                <select id="academicYearFilter"
                    class="border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                    onchange="filterByAcademicYear(this.value)">
                    <option value="">All Academic Years</option>
                    @foreach ($academicYears as $year)
                        <option value="{{ $year->id }}"
                            {{ (string) $academicYearId === (string) $year->id ? 'selected' : '' }}>
                            {{ $year->name }}
                        </option>
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

                        @forelse($enrollments as $enrollment)
                            @php
                                $student = $enrollment->student;
                                $rowLevel = \App\Models\Grade::resolveLevel($enrollment->grade->level);
                            @endphp

                            <tr class="hover:bg-gray-50 transition">
                                <td class="px-6 py-3 font-semibold bg-white text-black text-left pl-3">
                                    {{ $loop->index + 1 }}
                                </td>

                                <td class="px-6 py-3 font-medium text-gray-900">
                                    {{ $student->name }}
                                </td>

                                <td class="px-6 py-3 text-gray-700">
                                    {{ $student->user->registration_id ?? 'N/A' }}
                                </td>

                                <td class="px-6 py-3 text-gray-700">
                                    {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' - ' . $enrollment->grade->section : '' }}
                                </td>

                                <td class="px-6 py-3 text-center">
                                    <select
                                        class="period-select border border-gray-300 rounded-md px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500"
                                        data-enrollment="{{ $enrollment->id }}">
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

                                <td class="px-6 py-3 text-center flex items-center justify-center gap-2">

                                    <a href="#" target="_blank" data-enrollment="{{ $enrollment->id }}"
                                        data-level="{{ Str::slug($rowLevel, '-') }}"
                                        class="print-btn inline-flex items-center gap-2 bg-blue-900 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-blue-700 transition">
                                        Print-Card
                                    </a>

                                    <div x-data="{ showDeleteModal: false }" class="flex flex-col items-center gap-2">
                                        <button @click="showDeleteModal = true"
                                            class="inline-flex items-center gap-2 bg-red-600 text-white text-sm font-semibold px-4 py-2 rounded-md hover:bg-red-700 transition"
                                            title="Delete Grades">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>

                                        <div x-show="showDeleteModal" x-cloak
                                            class="fixed inset-0 z-50 flex items-center justify-center bg-black/60 backdrop-blur-sm px-2">
                                            <div x-show="showDeleteModal" x-transition
                                                class="bg-white w-full max-w-xs rounded-lg shadow-xl overflow-hidden">
                                                <div
                                                    class="flex items-center justify-between px-3 py-2 bg-red-600 text-white">
                                                    <h3 class="text-xs font-semibold">Confirm Delete</h3>
                                                    <button @click="showDeleteModal = false"
                                                        class="p-1 rounded-full hover:bg-red-500 transition">
                                                        <i class="ri-close-line text-sm"></i>
                                                    </button>
                                                </div>

                                                <div class="p-3 space-y-2 text-xs">
                                                    <p class="text-gray-700">
                                                        Are you sure you want to delete all grades for
                                                        <strong>{{ $student->name }}</strong>?
                                                    </p>
                                                </div>

                                                <div class="px-3 py-2 bg-gray-50 border-t flex justify-end gap-1">
                                                    <button @click="showDeleteModal = false"
                                                        class="px-2 py-1 text-xs rounded border hover:bg-gray-100">
                                                        Cancel
                                                    </button>

                                                    <form method="POST"
                                                        action="{{ route('student.grades.delete', $enrollment->id) }}"
                                                        x-data="{ submitting: false }" @submit="submitting = true">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="px-2 py-1 text-xs font-semibold bg-red-600 text-white rounded hover:bg-red-700 flex items-center gap-2 !bg-red-600 !text-white"
                                                            :disabled="submitting">
                                                            <svg x-show="submitting"
                                                                class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"
                                                                viewBox="0 0 24 24"></svg>
                                                            <span x-show="!submitting">Delete</span>
                                                            <span x-show="submitting">Deleting…</span>
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

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
                                    <input type="checkbox" class="student-check" value="{{ $enrollment->id }}">
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

                    <script>
                        document.querySelectorAll('.print-btn').forEach(btn => {
                            btn.addEventListener('click', function(e) {
                                e.preventDefault();

                                const row = this.closest('tr');
                                const enrollmentId = this.dataset.enrollment;
                                const level = this.dataset.level || 'senior';

                                const periodSelect = row.querySelector('.period-select');
                                const period = periodSelect ? periodSelect.value : 'yearly';

                                const showHeader = row.querySelector('.show-header')?.checked ? 1 : 0;
                                const showFooter = row.querySelector('.show-footer')?.checked ? 1 : 0;

                                const url =
                                    `/admin/report-card/${level}/${enrollmentId}?period=${period}&showHeader=${showHeader}&showFooter=${showFooter}`;

                                window.open(url, '_blank');
                            });
                        });
                    </script>

                </table>
            </div>
        </div>
    </div>

    <script>
        function filterTable() {
            let searchValue = document.getElementById("studentSearch").value.toLowerCase().trim();
            let gradeValue = document.getElementById("gradeFilter")?.value.toLowerCase().trim() || "";

            let rows = document.querySelectorAll("#studentsTable tbody tr");

            rows.forEach(function(row) {
                let name = row.cells[1].innerText.toLowerCase().trim();
                let studentId = row.cells[2].innerText.toLowerCase().trim();
                let grade = row.cells[3].innerText.toLowerCase().trim();

                let matchesSearch = name.includes(searchValue) || studentId.includes(searchValue);
                let matchesGrade = gradeValue === "" || grade.includes(gradeValue);

                row.style.display = (matchesSearch && matchesGrade) ? "" : "none";
            });
        }

        document.getElementById("studentSearch").addEventListener("keyup", filterTable);
        document.getElementById("gradeFilter")?.addEventListener("change", filterTable);

        document.getElementById('printSelected').addEventListener('click', function() {

            let selected = [];
            let headers = [];
            let footers = [];
            let periods = [];
            let levels = [];

            document.querySelectorAll('.student-check:checked').forEach(cb => {
                let row = cb.closest('tr');
                let enrollmentId = cb.value;
                selected.push(enrollmentId);

                let periodSelect = row.querySelector('.period-select');
                let period = periodSelect ? periodSelect.value : 'yearly';
                periods.push(period);

                let showHeader = row.querySelector('.show-header').checked ? 1 : 0;
                let showFooter = row.querySelector('.show-footer').checked ? 1 : 0;

                headers.push(showHeader);
                footers.push(showFooter);

                let level = row.querySelector('.print-btn')?.dataset.level || 'senior';
                levels.push(level);
            });

            if (selected.length === 0) {
                alert('Please select at least one student');
                return;
            }

            let url = `/admin/report-cards/print-multiple?enrollments=${selected.join(',')}` +
                `&periods=${periods.join(',')}` +
                `&headers=${headers.join(',')}` +
                `&footers=${footers.join(',')}` +
                `&levels=${levels.join(',')}`;

            window.open(url, '_blank');
        });

        function filterByAcademicYear(yearId) {
            const url = new URL(window.location.href);
            if (yearId) {
                url.searchParams.set('academic_year_id', yearId);
            } else {
                url.searchParams.delete('academic_year_id');
            }
            window.location.href = url.toString();
        }
    </script>
@endsection
