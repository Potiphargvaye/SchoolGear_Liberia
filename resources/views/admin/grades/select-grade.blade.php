@extends('layouts.admin')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-gray-800 flex items-center gap-3">
            🎓 Student Grade Entry
        </h1>

        <p class="mt-2 text-gray-500">
            Select an academic session and grade level to load students for grade entry.
        </p>
    </div>

    <!-- Security Notice -->
    <div class="mb-8">

        <div class="flex items-start rounded-xl border-l-4 border-amber-500 bg-amber-50 p-5 shadow-sm">

            <div class="mr-4 flex h-12 w-12 items-center justify-center rounded-full bg-amber-500 text-white text-xl">

                ⚠️

            </div>

            <div>

                <h3 class="text-lg font-semibold text-amber-900">
                    Grade Entry Security Notice
                </h3>

                <p class="mt-2 text-sm text-amber-800 leading-6">

                    Grade entry is a restricted operation within the School Management System.
                    Once grades have been submitted, they become locked to protect academic
                    integrity. Only authorized users with the required permissions can modify
                    submitted grades. All changes may be recorded for auditing purposes.

                </p>

            </div>

        </div>

    </div>

    <!-- Main Card -->

    <div class="bg-white rounded-2xl shadow-lg border border-gray-200 overflow-hidden">

        <!-- Card Header -->

        <div class="border-b bg-gray-50 px-6 py-5">

    <h2 class="text-xl font-semibold text-gray-800 flex items-center gap-2">

        <!-- Book / Academic Icon -->
        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M12 6.253v11.494m0-11.494A8.963 8.963 0 005.753 9.5M12 6.253A8.963 8.963 0 0118.247 9.5M5.753 9.5A8.963 8.963 0 0112 14.747M5.753 9.5v6.247A8.963 8.963 0 0012 20.494m6.247-4.747V9.5M12 14.747A8.963 8.963 0 0118.247 9.5M18.247 9.5v6.247A8.963 8.963 0 0112 20.494" />
        </svg>

        Load Students

    </h2>

    <p class="text-sm text-gray-500 mt-1">
        Choose the academic year and grade level before loading students.
    </p>

</div>

        <!-- Card Body -->

        <div class="p-6">

            <form id="gradeForm" action="{{ route('grades.load') }}" method="GET">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Academic Year -->

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Academic Year

                        </label>

                        <select
                            name="academic_year"
                            required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">

                            <option value="">
                                Choose Academic Year
                            </option>

                            <option value="2025/2026">
                                2025 / 2026
                            </option>

                            <option value="2026/2027">
                                2026 / 2027
                            </option>

                        </select>

                    </div>

                    <!-- Grade Level -->

                    <div>

                        <label class="block text-sm font-semibold text-gray-700 mb-2">

                            Grade Level

                        </label>

                        <select
                            name="grade_level"
                            required
                            class="w-full rounded-xl border border-gray-300 bg-white px-4 py-3 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition">

                            <option value="">
                                Choose Grade Level
                            </option>

                            <optgroup label="Kindergarten">

                                <option>Nursery</option>

                                <option>K-3</option>

                                <option>K-4</option>

                                <option>K-5</option>

                            </optgroup>

                            <optgroup label="Elementary">

                                <option value="Grade 1">Grade 1</option>

                                <option value="Grade 2">Grade 2</option>

                                <option value="Grade 3">Grade 3</option>

                                <option value="Grade 4">Grade 4</option>

                                <option value="Grade 5">Grade 5</option>

                                <option value="Grade 6">Grade 6</option>

                            </optgroup>

                            <optgroup label="Junior High">

                                <option value="Grade 7">Grade 7</option>

                                <option value="Grade 8">Grade 8</option>

                                <option value="Grade 9">Grade 9</option>

                            </optgroup>

                            <optgroup label="Senior High">

                                <option value="Grade 10">Grade 10</option>

                                <option value="Grade 11">Grade 11</option>

                                <option value="Grade 12">Grade 12</option>

                            </optgroup>

                        </select>

                    </div>

                </div>

                <!-- Divider -->

                <div class="my-8 border-t border-gray-200"></div>

                <!-- Action -->

                <div class="flex flex-col sm:flex-row sm:justify-end">

    <button
        id="loadBtn"
        type="submit"
        class="inline-flex items-center justify-center rounded-xl bg-blue-600 px-8 py-3 text-white font-semibold shadow-md transition duration-300 hover:bg-blue-700 hover:shadow-lg focus:outline-none focus:ring-4 focus:ring-blue-200">

        <!-- Spinner (hidden by default) -->
        <svg id="btnSpinner" class="hidden w-5 h-5 mr-2 animate-spin" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor"
                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
        </svg>

        <!-- Users Icon -->
        <svg id="btnIcon" class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M17 20h5v-2a4 4 0 00-3-3.87M9 20H4v-2a4 4 0 013-3.87m10-4a4 4 0 10-8 0 4 4 0 008 0z" />
        </svg>

        <!-- Text -->
        <span id="btnText" class="ml-2">
            Load Students
        </span>

    </button>

</div>
            </form>

        </div>

    </div>

</div>

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {

    const form = document.getElementById("gradeForm");
    const btn = document.getElementById("loadBtn");
    const spinner = document.getElementById("btnSpinner");
    const icon = document.getElementById("btnIcon");
    const text = document.getElementById("btnText");

    if (!form || !btn) {
        console.log("Missing elements");
        return;
    }

    form.addEventListener("submit", function (e) {

        // STOP immediate submit
        e.preventDefault();

        // UI update first
        btn.disabled = true;
        btn.classList.add("opacity-70", "cursor-not-allowed");

        icon.classList.add("hidden");
        spinner.classList.remove("hidden");

        text.innerText = "Loading students...";

        // THEN submit after UI renders
        setTimeout(() => {
            form.submit();
        }, 200);

    });

});
</script>
@endpush
@endsection








