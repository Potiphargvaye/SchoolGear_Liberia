@foreach ($enrollments as $index => $enrollment)
    @php
        $grades = $gradesData[$enrollment->id];
        $overallAverage = $overallAverages[$enrollment->id] ?? null;
        $rank = $ranks[$enrollment->id] ?? null;
        $totalStudentsCount = $totalStudents;

        $period = explode(',', request()->query('periods', 'yearly'))[$index] ?? 'yearly';
        $showHeader = (explode(',', request()->query('headers', '1'))[$index] ?? 1) == 1;
        $showFooter = (explode(',', request()->query('footers', '1'))[$index] ?? 1) == 1;

        $levels = explode(',', request()->query('levels', 'senior'));
        $level = $levels[$index] ?? 'senior';
    @endphp

    @include("admin.report-cards.$level", [
        'enrollment' => $enrollment,
        'grades' => $grades,
        'overallAverage' => $overallAverage,
        'rank' => $rank,
        'totalStudents' => $totalStudentsCount,
        'period' => $period,
        'periodAverages' => $periodAverages,
        'periodRanks' => $periodRanks,
        'showHeader' => $showHeader,
        'showFooter' => $showFooter,
        'branding' => $branding,
    ])
@endforeach
<style>
    @media print {

        body {
            margin: 0;
        }

        .report-card {
            page-break-after: always;
            width: 100%;
            height: 100vh;
            padding: 5mm;
            box-sizing: border-box;
            overflow: hidden;
        }

        .report-card:last-child {
            page-break-after: auto;
        }

        table,
        tr,
        td,
        th {
            page-break-inside: avoid;
        }

        html,
        body {
            zoom: 1;
        }

        .school-address {
            margin-top: 2px;
            margin-bottom: 2px;
            line-height: 1.1;
            font-size: 16px;
        }
    }
</style>
