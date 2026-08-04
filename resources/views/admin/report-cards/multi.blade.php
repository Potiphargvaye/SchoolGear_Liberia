@foreach($students as $index => $student)
    @php
        $grades = $gradesData[$student->id];
        $overallAverage = $overallAverages[$student->id];
        $rank = $ranks[$student->id];
        $totalStudentsCount = $totalStudents;

        $period = explode(',', request()->query('periods', 'yearly'))[$index] ?? 'yearly';
        $showHeader = explode(',', request()->query('headers', '1'))[$index] ?? 1;
        $showFooter = explode(',', request()->query('footers', '1'))[$index] ?? 1;

        // ✅ NEW: handle level
        $levels = explode(',', request()->query('levels', 'senior'));
        $level = $levels[$index] ?? 'senior';

        request()->merge([
            'showHeader' => $showHeader,
            'showFooter' => $showFooter,
            'period' => $period
        ]);
    @endphp

    {{-- ✅ Dynamic blade --}}
    @include("admin.report-cards.$level", [
        'student' => $student,
        'grades' => $grades,
        'overallAverage' => $overallAverage,  
        'rank' => $rank,
        'totalStudents' => $totalStudentsCount
    ])
@endforeach
<style>

@media print {

    body{
        margin: 0;
        
    }

    /* 🔥 Each card MUST behave like a full page */
    .report-card{
        page-break-after: always;

        /* 🔥 IMPORTANT: force proper page sizing */
        width: 100%;
        height: 100vh;

        /* keep spacing controlled */
        padding: 5mm;

        box-sizing: border-box;

        /* 🔥 THIS prevents overflow breaking */
        overflow: hidden;
    }

    /* last one no extra blank page */
    .report-card:last-child{
        page-break-after: auto;
    }

    /* 🔥 CRITICAL: prevent content splitting */
    table, tr, td, th{
        page-break-inside: avoid;
    }

    /* 🔥 Prevent browser auto shrinking */
    html, body{
        zoom: 1;
    }

    .school-address {
    margin-top: 2px;     /* reduce top space */
    margin-bottom: 2px;  /* reduce bottom space */
    line-height: 1.1;    /* 🔥 tighter lines (KEY FIX) */
    font-size: 16px;     /* optional: slightly smaller */
}

}
</style>











