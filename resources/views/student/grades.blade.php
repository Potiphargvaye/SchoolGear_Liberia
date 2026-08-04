<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Grades - WKG Student Portal</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* ── Reset & Base ─────────────────────────────────────────── */
        * { margin: 0; padding: 0; box-sizing: border-box; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }

        body { background-color: #f7fafc; color: #2d3748; line-height: 1.6; }

        .container { max-width: 1200px; margin: 0 auto; padding: 0 20px; }

   

   /* ── Banner ──────────────────────────────────────────────────────── */
.banner {
    background: linear-gradient(135deg, #0a2a66 0%, #1e40af 60%, #2563eb 100%);
    color: white;
    padding: 16px 26px;
    border-radius: 14px;
    box-shadow: 0 6px 20px rgba(10, 42, 102, 0.35);
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin: 16px 0;
    gap: 14px;
    flex-wrap: wrap;
    border: 1px solid rgba(255,255,255,0.10);
}

.school-info {
    display: flex;
    align-items: center;
    gap: 14px;
    min-width: 0;
}

.school-logo {
    width: 56px;
    height: 56px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    overflow: hidden;
    background: white;
    box-shadow: 0 0 0 3px rgba(255,255,255,0.25), 0 4px 12px rgba(0,0,0,0.25);
}

.school-logo-img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    border-radius: 50%;
}

.school-logo-text {
    font-weight: 800;
    font-size: 12px;
    color: #0a2a66;
    letter-spacing: 0.5px;
}

.school-text { min-width: 0; }

.school-name {
    font-weight: 800;
    font-size: 19px;
    letter-spacing: 0.6px;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
    text-shadow: 0 1px 3px rgba(0,0,0,0.2);
}

.school-tagline {
    font-size: 11.5px;
    opacity: 0.78;
    font-weight: 400;
    margin-top: 2px;
    letter-spacing: 0.8px;
}

.portal-tag {
    background: rgba(255, 255, 255, 0.2);
    padding: 8px 18px;
    border-radius: 20px;
    font-weight: 600;
    font-size: 15px;
    backdrop-filter: blur(10px);
    display: flex;
    align-items: center;
    gap: 7px;
    white-space: nowrap;
    flex-shrink: 0;
}

/* ── Banner responsive ───────────────────────────────────────────── */

/* Tablet landscape — start scaling down */
@media (max-width: 1024px) {
    .school-name  { font-size: 16px; }
    .clock-time   { font-size: 19px; }
    .banner-clock { min-width: 136px; padding: 8px 16px; }
    .portal-tag   { font-size: 13px; padding: 8px 15px; }
}

/* Tablet portrait — compress but keep single row */
@media (max-width: 768px) {
    .banner {
        padding: 14px 18px;
        gap: 10px;
        justify-content: space-between;
    }
    .school-info  { justify-content: flex-start; }
    .school-logo  { width: 46px; height: 46px; }
    .school-name  { font-size: 15px; }
    .school-tagline { display: none; }
    .banner-clock { min-width: 120px; padding: 8px 14px; }
    .clock-time   { font-size: 17px; letter-spacing: 1.5px; }
    .clock-date   { font-size: 10.5px; }
    .portal-tag   { font-size: 12.5px; padding: 7px 14px; }
}

/* Large phones — wrap into 2 clean rows */
@media (max-width: 600px) {
    .banner {
        flex-wrap: wrap;
        padding: 14px 16px;
        gap: 10px;
        border-radius: 12px;
        justify-content: space-between;
        align-items: center;
    }

    /* Row 1: school info left, portal tag right */
    .school-info { order: 1; flex: 1 1 auto; }
    .portal-tag  { order: 2; flex-shrink: 0; }

    /* Row 2: clock spans full width, contents centered */
    .banner-clock {
        order: 3;
        width: 100%;
        flex-direction: row;
        justify-content: center;
        align-items: center;
        gap: 12px;
        padding: 8px 16px;
        min-width: 0;
        border-radius: 10px;
    }

    .clock-date { margin-top: 0; }
}

/* Small phones */
@media (max-width: 480px) {
    .banner       { gap: 8px; border-radius: 10px; padding: 12px 14px; }
    .school-logo  { width: 40px; height: 40px; }
    .school-name  { font-size: 13.5px; }
    .clock-time   { font-size: 15px; letter-spacing: 1px; }
    .clock-date   { font-size: 10px; }
    .portal-tag   { font-size: 11.5px; padding: 6px 11px; gap: 5px; }
    form.button   { justify-content: center; }
}

/* Very small phones (≤360px) */
@media (max-width: 360px) {
    .school-name        { font-size: 12.5px; }
    .portal-tag span    { display: none; }   /* icon only — saves space */
    .clock-time         { font-size: 14px; }
    .clock-date         { font-size: 9.5px; }
}

/* ── Live Clock ──────────────────────────────────────────────────── */
.banner-clock {
    display: flex;
    flex-direction: column;
    align-items: center;
    background: rgba(255,255,255,0.10);
    border: 1px solid rgba(255,255,255,0.18);
    backdrop-filter: blur(10px);
    border-radius: 12px;
    padding: 10px 20px;
    min-width: 120px;
    text-align: center;
}

.clock-time {
    font-size: 22px;
    font-weight: 700;
    letter-spacing: 2px;
    color: #ffffff;
    font-variant-numeric: tabular-nums;
    text-shadow: 0 2px 6px rgba(0,0,0,0.2);
    line-height: 1.2;
}

.clock-date {
    font-size: 11.5px;
    color: rgba(255,255,255,0.80);
    font-weight: 500;
    margin-top: 3px;
    letter-spacing: 0.4px;
    white-space: nowrap;
}

    /* ── Back button ──────────────────────────────────────────── */
    .back-btn {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        color: #3b82f6;
        font-weight: 600;
        font-size: 14px;
        text-decoration: none;
        margin-bottom: 20px;
        padding: 8px 14px;
        border-radius: 8px;
        border: 1px solid #bfdbfe;
        background: white;
        transition: all 0.2s ease;
    }
    .back-btn:hover {
        background: #eff6ff;
        color: #1e40af;
        transform: translateX(-2px);
    }

    /* ── Student info bar ─────────────────────────────────────── */
    .student-bar {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        padding: 18px 25px;
        margin-bottom: 22px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        border-left: 4px solid #3b82f6;
    }
    .student-bar-left { display: flex; align-items: center; gap: 14px; }
    .student-avatar {
        width: 52px; height: 52px;
        border-radius: 50%; object-fit: cover;
        border: 3px solid #3b82f6; flex-shrink: 0;
    }
    .student-bar-name { font-size: 17px; font-weight: 700; color: #1a202c; }
    .student-bar-meta { font-size: 13px; color: #718096; margin-top: 2px; }
    .student-bar-right { display: flex; gap: 10px; flex-wrap: wrap; }
    .info-pill {
        display: inline-flex; align-items: center; gap: 6px;
        background: #eff6ff; color: #1e40af;
        padding: 5px 13px; border-radius: 20px;
        font-size: 13px; font-weight: 600;
        border: 1px solid #bfdbfe;
    }

    /* ── Student Info Card ───────────────────────────────────────────── */
    .bg-white    { background: white; }
    .shadow      { box-shadow: 0 4px 12px rgba(0,0,0,0.08); }
    .rounded-lg  { border-radius: 12px; }
    .p-6         { padding: 24px; }
    .mb-6        { margin-bottom: 24px; }

    .flex        { display: flex; }
    .flex-col    { flex-direction: column; }
    .items-center { align-items: center; }

    .space-y-4 > * + * { margin-top: 16px; }

    .border           { border: 1px solid #e2e8f0; }
    .border-blue-100  { border-color: #dbeafe; }

    .text-center  { text-align: center; }
    .text-lg      { font-size: 18px; }
    .font-bold    { font-weight: 700; }
    .text-gray-800 { color: #1a202c; }
    .text-sm      { font-size: 14px; }
    .text-gray-600 { color: #4a5568; }

    @media (min-width: 768px) {
        .md\:flex-row          { flex-direction: row; }
        .md\:text-left         { text-align: left; }
        .md\:space-y-0 > * + * { margin-top: 0; }
        .md\:space-x-6 > * + * { margin-left: 24px; }
    }

    .student-image {
        width: 110px;
        height: 110px;
        border-radius: 50%;
        object-fit: cover;
        border: 4px solid #3b82f6;
        flex-shrink: 0;
    }

    .student-info-container {
        position: static;
        padding-right: 0;
        min-height: auto;
        width: 100%;
    }

    /* ── Page title area ──────────────────────────────────────── */
    .page-header {
        display: flex; align-items: center; justify-content: space-between;
        margin-bottom: 20px; flex-wrap: wrap; gap: 10px;
    }
    .page-title {
        font-size: 22px; font-weight: 700; color: #1e40af;
        display: flex; align-items: center; gap: 10px;
    }
    .page-title i { color: #3b82f6; }
    .academic-year-badge {
        background: #dbeafe; color: #1e40af;
        padding: 5px 14px; border-radius: 20px;
        font-size: 13px; font-weight: 600;
    }

    /* ── Period filter tabs ───────────────────────────────────── */
    .period-tabs {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        background: white;
        padding: 16px 20px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        margin-bottom: 22px;
    }
    .period-tab {
        display: inline-flex; align-items: center; gap: 6px;
        padding: 8px 16px;
        border-radius: 8px;
        font-size: 13.5px;
        font-weight: 600;
        text-decoration: none;
        color: #64748b;
        background: #f8fafc;
        border: 1.5px solid #e2e8f0;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    .period-tab:hover {
        background: #eff6ff;
        border-color: #93c5fd;
        color: #1e40af;
        transform: translateY(-1px);
    }
    .period-tab.active {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        color: white;
        border-color: transparent;
        box-shadow: 0 3px 10px rgba(59,130,246,0.35);
    }
    .tab-group-label {
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        letter-spacing: 0.8px;
        display: flex;
        align-items: center;
        padding: 0 4px;
        white-space: nowrap;
    }
    .tab-divider {
        width: 1px;
        background: #e2e8f0;
        align-self: stretch;
        margin: 0 4px;
    }

    /* ── Grades card ──────────────────────────────────────────── */
    .grades-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0,0,0,0.08);
        overflow: hidden;
        margin-bottom: 30px;
    }
    .grades-card-header {
        background: linear-gradient(135deg, #1e40af 0%, #3b82f6 100%);
        padding: 16px 24px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 8px;
    }
    .grades-card-title {
        color: white; font-size: 16px; font-weight: 700;
        display: flex; align-items: center; gap: 8px;
    }
    .period-label-badge {
        background: rgba(255,255,255,0.22);
        color: white;
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12.5px;
        font-weight: 600;
        backdrop-filter: blur(6px);
    }

    /* ── Table ────────────────────────────────────────────────── */
    .grades-table-wrapper { overflow-x: auto; -webkit-overflow-scrolling: touch; }

    table { width: 100%; border-collapse: collapse; font-size: 14px; }

    thead tr { background: #f0f7ff; }
    thead th {
        padding: 13px 16px;
        text-align: center;
        font-weight: 700;
        font-size: 12.5px;
        color: #1e40af;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        border-bottom: 2px solid #bfdbfe;
        white-space: nowrap;
    }
    thead th:first-child { text-align: left; min-width: 160px; }

    tbody tr { border-bottom: 1px solid #e2e8f0; transition: background 0.15s ease; }
    tbody tr:last-child { border-bottom: none; }
    tbody tr:hover { background: #f8faff; }

    tbody td { padding: 13px 16px; text-align: center; color: #374151; }
    tbody td:first-child { text-align: left; font-weight: 600; color: #1a202c; }

    /* ── Score colors ─────────────────────────────────────────── */
    .score-cell { display: inline-block; min-width: 38px; }
    .score-high { color: #065f46; background: #d1fae5; padding: 3px 10px; border-radius: 20px; font-weight: 700; font-size: 13px; }
    .score-mid  { color: #92400e; background: #fef3c7; padding: 3px 10px; border-radius: 20px; font-weight: 700; font-size: 13px; }
    .score-low  { color: #991b1b; background: #fee2e2; padding: 3px 10px; border-radius: 20px; font-weight: 700; font-size: 13px; }
    .score-na   { color: #94a3b8; font-size: 13px; }

    /* ── Calculated columns ──────────────────────────────────── */
    thead th.calc-col { background: #dbeafe; }
    tbody td.calc-col { background: #f0f7ff; }

    /* ── Empty state ──────────────────────────────────────────── */
    .empty-state { text-align: center; padding: 60px 20px; color: #94a3b8; }
    .empty-state i    { font-size: 48px; margin-bottom: 16px; color: #cbd5e1; }
    .empty-state p    { font-size: 16px; font-weight: 600; }
    .empty-state span { font-size: 14px; }

    /* ── Legend ───────────────────────────────────────────────── */
    .legend {
        display: flex; gap: 16px; flex-wrap: wrap;
        padding: 14px 20px;
        background: #f8fafc;
        border-top: 1px solid #e2e8f0;
    }
    .legend-item { display: flex; align-items: center; gap: 7px; font-size: 12.5px; color: #64748b; }
    .legend-dot  { width: 22px; height: 22px; border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 10px; font-weight: 700; }

    /* ── Footer ───────────────────────────────────────────────── */
    footer { text-align: center; padding: 20px; margin-top: 20px; color: #718096; font-size: 14px; border-top: 1px solid #e2e8f0; }

    /* ── Responsive ───────────────────────────────────────────── */
    @media (max-width: 640px) {
        .student-bar  { flex-direction: column; align-items: flex-start; }
        .page-header  { flex-direction: column; align-items: flex-start; }
        .period-tabs  { gap: 6px; }
        .period-tab   { padding: 7px 12px; font-size: 12.5px; }
        thead th, tbody td { padding: 10px 12px; }
    }

    @media (max-width: 480px) {
        .student-image { width: 90px; height: 90px; }
        .p-6           { padding: 16px; }
        .student-bar-right { justify-content: center; }
        .tab-divider   { display: none; }
    }
</style>
    </style>
</head>
<body>
<div class="container">

    {{-- ── Banner ─────────────────────────────────────────────────────── --}}
    <div class="banner">
    <div class="school-info">
        <div class="school-logo">
            <img src="{{ asset('kiddos-school-master/images/logo-images/new-school-logo (1).jpg') }}"
                 alt="EDMOL Logo"
                 class="school-logo-img"
                 onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
            <span class="school-logo-text" style="display:none;">EDMOL</span>
        </div>
        <div class="school-text">
            <div class="school-name">EDMOL HIGH SCHOOL</div>
            <div class="school-tagline">Excellence · Discipline · Integrity</div>
        </div>
    </div>

    <!-- Live Clock -->
    <div class="banner-clock">
        <div class="clock-time" id="bannerTime">00:00:00</div>
        <div class="clock-date" id="bannerDate">Loading...</div>
    </div>

    <div class="portal-tag">
        <i class="fas fa-user-graduate"></i>
        <span>Student Portal</span>
    </div>
</div>

    {{-- ── Back to dashboard ───────────────────────────────────────────── --}}
    <a href="{{ route('student.dashboard') }}" class="back-btn">
        <i class="fas fa-arrow-left"></i> Back to Dashboard
    </a>

   {{-- ── Student info bar ────────────────────────────────────────────── --}}
@php
    $initials = implode('', array_map(function($word) {
        return strtoupper(substr(trim($word), 0, 1));
    }, array_slice(explode(' ', $user->name), 0, 2)));

    $svgFallback = 'data:image/svg+xml;utf8,'.rawurlencode(
        '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">'
        .'<rect width="100" height="100" fill="#0c61ebff"/>'
        .'<text x="50" y="60" font-size="40" text-anchor="middle" fill="white" font-weight="bold">'
        .($initials ?: '?')
        .'</text></svg>'
    );
@endphp

<div class="bg-white shadow rounded-lg p-6 mb-6 flex flex-col md:flex-row items-center space-y-4 md:space-y-0 md:space-x-6 border border-blue-100">

    {{-- Avatar --}}
    <img src="{{ $user->image ? asset('storage/'.$user->image).'?v='.time() : $svgFallback }}"
         class="student-image"
         onerror="this.onerror=null;this.src='{{ $svgFallback }}'"
         alt="{{ $user->name }} avatar">

    {{-- Info + pills --}}
    <div class="student-info-container text-center md:text-left">
        <div class="text-center md:text-left">
            <h2 class="text-lg font-bold text-gray-800">{{ $user->name }}</h2>
            <p class="text-sm text-gray-600">ID: {{ $user->registration_id }}</p>
            <p class="text-sm text-gray-600">Grade:
                @if($user->grade)
                    {{ $user->grade->level }}{{ $user->grade->section }}
                @else
                    Not assigned
                @endif
            </p>
            <p class="text-sm text-gray-600">Email: {{ $user->email }}</p>
            <p class="text-sm text-gray-600">Role: {{ ucfirst($user->role) }}</p>

            {{-- Info pills row --}}
            <div class="student-bar-right" style="margin-top: 12px; justify-content: center;">
                @if($gradeLevel)
                    <span class="info-pill">
                        <i class="fas fa-graduation-cap"></i> {{ $gradeLevel }}
                    </span>
                @endif
                @if($academicYear)
                    <span class="info-pill">
                        <i class="fas fa-calendar"></i> {{ $academicYear }}
                    </span>
                @endif
                <span class="info-pill">
                    <i class="fas fa-book-open"></i> {{ $grades->count() }} Subjects
                </span>
            </div>
        </div>
    </div>

</div>

    {{-- ── Page header ─────────────────────────────────────────────────── --}}
    <div class="page-header">
        <div class="page-title">
            <i class="fas fa-chart-bar"></i>
            My Academic Grades
        </div>
        @if($academicYear)
            <span class="academic-year-badge">
                <i class="fas fa-calendar-alt"></i> {{ $academicYear }}
            </span>
        @endif
    </div>

    {{-- ── Period filter tabs ──────────────────────────────────────────── --}}
    <div class="period-tabs">

        <span class="tab-group-label"><i class="fas fa-layer-group" style="margin-right:4px"></i> Sem 1</span>

        @foreach([
            'p1' => '1st Period',
            'p2' => '2nd Period',
            'p3' => '3rd Period',
            'semester1' => 'Sem 1',
        ] as $key => $label)
            <a href="{{ route('student.grades', ['period' => $key]) }}"
               class="period-tab {{ $period === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach

        <div class="tab-divider"></div>

        <span class="tab-group-label"><i class="fas fa-layer-group" style="margin-right:4px"></i> Sem 2</span>

        @foreach([
            'p4' => '4th Period',
            'p5' => '5th Period',
            'p6' => '6th Period',
            'semester2' => 'Sem 2',
        ] as $key => $label)
            <a href="{{ route('student.grades', ['period' => $key]) }}"
               class="period-tab {{ $period === $key ? 'active' : '' }}">
                {{ $label }}
            </a>
        @endforeach

        <div class="tab-divider"></div>

        <a href="{{ route('student.grades', ['period' => 'yearly']) }}"
           class="period-tab {{ $period === 'yearly' ? 'active' : '' }}">
            <i class="fas fa-star" style="font-size:11px"></i> Yearly
        </a>
    </div>

    {{-- ── Grades card ─────────────────────────────────────────────────── --}}
    <div class="grades-card">

        {{-- Card header --}}
        <div class="grades-card-header">
            <div class="grades-card-title">
                <i class="fas fa-table"></i>
                Grades Report
            </div>
            <span class="period-label-badge">
                @php
                    $periodLabels = [
                        'p1' => '1st Period', 'p2' => '2nd Period', 'p3' => '3rd Period',
                        'p4' => '4th Period', 'p5' => '5th Period', 'p6' => '6th Period',
                        'semester1' => '1st Semester', 'semester2' => '2nd Semester',
                        'yearly' => 'Yearly Report',
                    ];
                @endphp
                {{ $periodLabels[$period] ?? ucfirst($period) }}
            </span>
        </div>

        {{-- Table --}}
        <div class="grades-table-wrapper">

            @if($grades->isEmpty())
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <p>No grades available yet</p>
                    <span>Your grades will appear here once your teacher uploads them.</span>
                </div>

            @else
                @php
                    // Score color helper: >=85 green, 70-84 amber, <70 red
                    $scoreClass = function($val) {
                        if ($val === null) return 'score-na';
                        if ($val >= 85)   return 'score-high';
                        if ($val >= 70)   return 'score-mid';
                        return 'score-low';
                    };
                @endphp

                <table>
                    <thead>
                        <tr>
                            <th>Subject</th>

                            {{-- Semester 1 period columns --}}
                            @if(in_array($period, ['p1','semester1','yearly']))
                                <th>1st Period</th>
                            @endif
                            @if(in_array($period, ['p2','semester1','yearly']))
                                <th>2nd Period</th>
                            @endif
                            @if(in_array($period, ['p3','semester1','yearly']))
                                <th>3rd Period</th>
                            @endif
                            @if(in_array($period, ['semester1','yearly']))
                                <th>Sem 1 Exam</th>
                                <th class="calc-col">Sem 1 Avg</th>
                            @endif

                            {{-- Semester 2 period columns --}}
                            @if(in_array($period, ['p4','semester2','yearly']))
                                <th>4th Period</th>
                            @endif
                            @if(in_array($period, ['p5','semester2','yearly']))
                                <th>5th Period</th>
                            @endif
                            @if(in_array($period, ['p6','semester2','yearly']))
                                <th>6th Period</th>
                            @endif
                            @if(in_array($period, ['semester2','yearly']))
                                <th>Sem 2 Exam</th>
                                <th class="calc-col">Sem 2 Avg</th>
                            @endif

                            {{-- Yearly --}}
                            @if($period === 'yearly')
                                <th class="calc-col">Yearly Avg</th>
                            @endif
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($grades as $grade)
                            <tr>
                                <td>{{ $grade->subject->name ?? '—' }}</td>

                                @if(in_array($period, ['p1','semester1','yearly']))
                                    <td><span class="{{ $scoreClass($grade->period1) }}">{{ $grade->period1 ?? 'N/B' }}</span></td>
                                @endif
                                @if(in_array($period, ['p2','semester1','yearly']))
                                    <td><span class="{{ $scoreClass($grade->period2) }}">{{ $grade->period2 ?? 'N/B' }}</span></td>
                                @endif
                                @if(in_array($period, ['p3','semester1','yearly']))
                                    <td><span class="{{ $scoreClass($grade->period3) }}">{{ $grade->period3 ?? 'N/B' }}</span></td>
                                @endif
                                @if(in_array($period, ['semester1','yearly']))
                                    <td><span class="{{ $scoreClass($grade->exam1) }}">{{ $grade->exam1 ?? 'N/B' }}</span></td>
                                    <td class="calc-col"><span class="{{ $scoreClass($grade->firstSemAvg) }}">{{ $grade->firstSemAvg ?? 'N/B' }}</span></td>
                                @endif

                                @if(in_array($period, ['p4','semester2','yearly']))
                                    <td><span class="{{ $scoreClass($grade->period4) }}">{{ $grade->period4 ?? 'N/B' }}</span></td>
                                @endif
                                @if(in_array($period, ['p5','semester2','yearly']))
                                    <td><span class="{{ $scoreClass($grade->period5) }}">{{ $grade->period5 ?? 'N/B' }}</span></td>
                                @endif
                                @if(in_array($period, ['p6','semester2','yearly']))
                                    <td><span class="{{ $scoreClass($grade->period6) }}">{{ $grade->period6 ?? 'N/B' }}</span></td>
                                @endif
                                @if(in_array($period, ['semester2','yearly']))
                                    <td><span class="{{ $scoreClass($grade->exam2) }}">{{ $grade->exam2 ?? 'N/B' }}</span></td>
                                    <td class="calc-col"><span class="{{ $scoreClass($grade->secondSemAvg) }}">{{ $grade->secondSemAvg ?? 'N/B' }}</span></td>
                                @endif

                                @if($period === 'yearly')
                                    <td class="calc-col"><span class="{{ $scoreClass($grade->yearlyAvg) }}">{{ $grade->yearlyAvg ?? 'N/B' }}</span></td>
                                @endif
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- Legend --}}
                <div class="legend">
                    <div class="legend-item">
                        <span class="legend-dot score-high">85</span>
                        Excellent (85–100)
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot score-mid">75</span>
                        Good (70–84)
                    </div>
                    <div class="legend-item">
                        <span class="legend-dot score-low">60</span>
                        Needs Improvement (&lt; 70)
                    </div>
                    <div class="legend-item" style="margin-left: auto; color: #94a3b8; font-size: 12px;">
                        <i class="fas fa-lock" style="margin-right:4px"></i>
                        View only — grades are managed by your teacher
                    </div>
                </div>
            @endif

        </div>
    </div>{{-- /grades-card --}}

    {{-- ── Footer ──────────────────────────────────────────────────────── --}}
    <footer>
        <p>&copy; <span id="currentYear"></span> EDMOL SCHOOL. All rights reserved.</p>
        <p>Developed by <a href="#" style="color:#3b82f6;">||Potiphar G Vaye||</a></p>
    </footer>

</div>{{-- /container --}}

<script>
    document.getElementById('currentYear').textContent = new Date().getFullYear();



     // Simple JavaScript to demonstrate interactivity
        document.addEventListener('DOMContentLoaded', function() {
            const cards = document.querySelectorAll('.dashboard-card');
            
            cards.forEach(card => {
                card.addEventListener('click', function() {
                    const title = this.querySelector('.card-title').textContent;
                    alert(`You clicked on ${title}`);
                });
            });
            
            // Update the banner with a greeting based on time of day
            const updateBannerGreeting = () => {
                const hour = new Date().getHours();
                let greeting = "Welcome";
                
                if (hour < 12) greeting = "Good Morning";
                else if (hour < 18) greeting = "Good Afternoon";
                else greeting = "Good Evening";
                
                const portalTag = document.querySelector('.portal-tag');
                portalTag.textContent = `${greeting}, Student!`;
            };
            
            updateBannerGreeting();
        });

         // Live clock for banner
function updateBannerClock() {
    const now  = new Date();

    // Time — HH:MM:SS
    const time = now.toLocaleTimeString('en-US', {
        hour:   '2-digit',
        minute: '2-digit',
        second: '2-digit',
        hour12: true
    });

    // Date — Mon, May 29 2026
    const date = now.toLocaleDateString('en-US', {
        weekday: 'short',
        month:   'short',
        day:     'numeric',
        year:    'numeric'
    });

    const timeEl = document.getElementById('bannerTime');
    const dateEl = document.getElementById('bannerDate');
    if (timeEl) timeEl.textContent = time;
    if (dateEl) dateEl.textContent = date;
}

updateBannerClock();                    // run immediately
setInterval(updateBannerClock, 1000);   // then every second
</script>
</body>
</html>