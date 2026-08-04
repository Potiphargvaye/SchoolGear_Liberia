<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Kindergarten-edmol</title>
    <style>
        body {
            font-family: 'Times New Roman', Times, serif;
            font-size: 17px;
            margin: 20px;
        }

        /* HEADER */
        .school-header {
            text-align: center;
        }

        .school-header h2 {
            margin: 0;
            font-weight: bold;
            color: navy;
            /* 🔥 CHANGE COLOR HERE */
        }

        .school-header p {
            margin: 2px 0;
        }

        .school-header a {
            color: blue;
            text-decoration: underline;
        }

        h3.report-title {
            text-align: center;
            color: navy;
            font-weight: bold;
            margin: 10px 0;
        }

        .student-info {
            margin: 15px 0;
            font-weight: bold;
        }

        /* ================= TABLE (MAIN FIX) ================= */

        /* Default = compact (fixes spacing issue) */
        table {
            width: auto;
            /* 🔥 prevents stretching */
            margin: 0 auto;
            /* center table */
            border-collapse: collapse;
            table-layout: fixed;
        }

        /* Full width only for large tables */
        .full-width-table {
            width: 100%;
        }

        /* Borders */
        table,
        th,
        td {
            border: 2px solid black;
        }

        /* Cell spacing */
        th,
        td {
            padding: 6px 8px;
            text-align: center;
        }

        /* First column (Subject) */
        table tr th:first-child,
        table tr td:first-child {
            min-width: 120px;
            max-width: 110px;
            white-space: normal;
            word-wrap: break-word;
            text-align: left;
            padding-left: 10px;
        }

        /* Other columns (grades) */
        table tr th:not(:first-child),
        table tr td:not(:first-child) {
            min-width: 45px;
            white-space: nowrap;
            font-size: 17px;
        }

        /* Period view (few columns) */
        .period-view th:first-child,
        .period-view td:first-child {
            width: 70%;
        }

        .period-view th:last-child,
        .period-view td:last-child {
            width: 30%;
        }

        /* ================= COLORS ================= */

        .red-grade {
            color: rgb(236, 3, 3);
            font-weight: bold;
        }

        .blue-grade {
            color: #0267fd;
            font-weight: bold;
        }

        /* ================= BUTTON ================= */

        .print-button {
            margin-bottom: 20px;
            padding: 8px 16px;
            background-color: #002966;
            color: white;
            border: none;
            cursor: pointer;
            font-weight: bold;
        }

        .print-button:hover {
            background-color: #063dac;
        }

        /* ================= SIGNATURE ================= */

        .signature {
            display: flex;
            justify-content: space-between;
            margin-top: 40px;
        }

        .signature div {
            text-align: center;
            width: 200px;
        }

        /* ================= PROFESSIONAL FOOTER CONTAINER ================= */
        .footer-info-container {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            max-width: 520px;
            margin: 45px auto 0 auto;
            gap: 20px;
        }

        /* Left Side: Grading Card Layout */
        .grading-method-box {
            flex: 1;
        }

        .grading-method-box .brand-title {
            font-size: 15px;
            color: navy;
            font-weight: bold;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin: 0 0 8px 0;
            border-bottom: 2px solid navy;
            padding-bottom: 3px;
        }

        .grade-scale-row {
            display: flex;
            justify-content: space-between;
            padding: 3px 0;
            font-size: 14px;
            border-bottom: 1px dashed #e5e7eb;
        }

        .grade-range {
            font-weight: bold;
            color: #333;
        }

        .grade-label {
            font-style: italic;
            font-weight: 500;
        }

        /* Right Side: QR Code Frame */
        .qr-code-box {
            display: flex;
            flex-direction: column;
            align-items: center;
        }

        .qr-frame {
            width: 90px;
            height: 90px;
            border: 2px solid navy;
            /* Branded frame color */
            padding: 4px;
            background: #ffffff;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
        }

        .qr-image {
            width: 100%;
            height: 100%;
            object-fit: contain;
        }

        .qr-caption {
            font-size: 11px;
            font-style: italic;
            color: navy;
            margin: 4px 0 0 0;
            font-weight: bold;
        }

        /* ================= PRINT CONFIGURATION ================= */

        @media print {

            body {
                margin: 0;
                font-size: 17px !important;
                /* Global scale down to ensure components don't roll onto page 2 */
                color: #000;
                -webkit-print-color-adjust: exact;
            }

            /* 🔥 Prevent auto shrink */
            html,
            body {
                zoom: 1;
            }

            .print-button {
                display: none;
            }

            /* 🔥 CRITICAL FIX FOR PRINT */
            table {
                width: auto !important;
                /* prevents stretching */
                margin: 4px auto !important;
                font-size: 20px !important;
            }

            /* 🔥 TARGET ONLY THE HEADER CELLS FOR SHRINKING */
            table thead tr th {
                font-size: 14px !important;
                /* Makes header text smaller */
                padding: 2px 4px !important;
                /* Tighter padding on the header row */
                line-height: 1.1 !important;
                /* Prevents tall header row spacing */
            }

            /* Keeps the Subject header left-aligned but allows it to stay smaller */
            table thead tr th:first-child {
                text-align: left;
            }

            th,
            td {
                padding: 3px 5px !important;
                /* Tighten up row spaces to fit elements on shorter paper */
                text-align: center;
                white-space: nowrap;
                font-size: 18px !important;
            }

            /* Allow subject wrapping without stretching excessively */
            th:first-child,
            td:first-child {
                white-space: normal;
                width: auto !important;
                /* 🔥 Lets the column fit the text size naturally */
                max-width: 140px !important;
                /* Prevents it from getting too wide */
                min-width: 90px !important;
                /* Ensures it doesn't get squeezed too tiny */
                text-align: left;
            }

            /* Prevent row breaking */
            tr {
                page-break-inside: avoid;
            }

            .school-header {
                margin-bottom: 2px !important;
                min-height: 65px !important;
                /* Shrunk from 80px to prevent header from eating vertical room */
            }

            .school-header h2 {
                font-size: 13px !important;
            }

            .school-header p {
                font-size: 11px !important;
                margin: 1px 0 !important;
            }

            .header-left,
            .header-right {
                top: 50%;
                transform: translateY(-50%);
            }

            .school-logo {
                width: 60px !important;
                /* Clean size reduction to ensure 1-page limits */
                height: 60px !important;
                object-fit: cover;
                object-position: center;
                border-radius: 45%;
                display: block;
                border: 2px solid #0e0e14;
                overflow: hidden;
                /* 🔥 prevents cut-off */
            }

            .report-title-box {
                border: 3px solid #990000 !important;
                padding: 3px !important;
                font-size: 12px !important;
                width: 60% !important;
                margin: 5px auto !important;
            }

            .student-info {
                margin: 4px 0 !important;
                font-size: 12px !important;
            }

            .signature {
                margin-top: 15px !important;
                /* Pull elements upwards snugly */
            }

            .signature div {
                page-break-inside: avoid;
                font-size: 12px !important;
                width: 150px !important;
            }

            /* Target the grading section wrapper directly to enforce single page bounds */
            .grading-method-box {
                margin-top: 10px !important;
                page-break-inside: avoid;
            }

            .grading-method-box h1 {
                font-size: 13px !important;
                margin: 2px 0 !important;
            }

            .grading-method-box h2 {
                font-size: 11px !important;
                margin: 1px 0 !important;
            }

            .footer-note {
                font-size: 11px !important;
                margin-top: 8px !important;
                padding-top: 4px !important;
                max-width: 400px !important;
            }

            /* Enforce tight single page margins inside your @media print query */
            .footer-info-container {
                margin-top: 25px !important;
                max-width: 440px !important;
                gap: 15px !important;
                page-break-inside: avoid;
            }

            .grading-method-box .brand-title {
                font-size: 12px !important;
                margin-bottom: 4px !important;
            }

            .grade-scale-row {
                font-size: 11px !important;
                padding: 1px 0 !important;
            }

            .qr-code-box {
                display: flex;
                flex-direction: column;
                align-items: center;
                justify-content: center;
            }

            .qr-frame {
                width: 70px !important;
                height: 70px !important;

                display: flex;
                align-items: center;
                justify-content: center;

                border: 1.5px solid navy;
                padding: 2px;
            }

            .qr-frame svg {
                display: block;
                width: 100%;
                height: 100%;
            }

            .qr-caption {
                display: block;
                margin-top: 4px !important;
                font-size: 10px !important;
                font-weight: bold;
                color: #000 !important;
                line-height: 1.2;
            }

        }

        /* ================= NO-PRINTING SCREEN ENGINE BASE STYLES ================= */

        /* HEADER LAYOUT for logo and image*/
        .school-header {
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            margin-bottom: 10px;
            min-height: 110px;
            /* 🔥 IMPORTANT: controls space for images */
        }

        /* LEFT LOGO */
        .header-left {
            position: absolute;
            left: 0;
            top: 50%;
            /* 🔥 vertical center */
            transform: translateY(-50%);
        }

        /* RIGHT IMAGE (STUDENT PHOTO) */
        .header-right {
            position: absolute;
            right: 0;
            top: 50%;
            /* 🔥 vertical center */
            transform: translateY(-50%);
        }

        /* CENTER TEXT */
        .header-center {
            text-align: center;
            width: 100%;
        }

        /* LOGO + STUDENT IMAGE STYLE */
        .school-logo {
            width: 80px;
            height: 80px;
            object-fit: cover;
            object-position: center;
            /* 🔥 FIX 1: centers image properly */
            border-radius: 45%;
            border: 2px solid #0e0e14;
            display: block;
            /* 🔥 FIX 2: prevents inline distortion */
        }

        /* REPORT TITLE BOX */
        .report-title-box {
            text-align: center;
            border: 5px solid #990000;
            /* 🔥 CHANGE COLOR HERE */
            padding: 6px;
            font-weight: bold;
            font-size: 15px;
            width: 70%;
            margin: 10px auto;
        }

        /* MOBILE RESPONSIVENESS */
        @media (max-width: 768px) {
            .school-logo {
                width: 50px;
                height: 50px;
            }

            .report-title-box {
                width: 90%;
                font-size: 14px;
            }
        }

        /* FOOTER LEGAL NOTE */
        .footer-note {
            text-align: center;
            font-size: 16px;
            margin-top: 15px;
            font-style: italic;
            color: #242323;
            border-top: 1px solid #999;
            padding-top: 6px;
            max-width: 500px;
            margin-left: auto;
            margin-right: auto;
            font-weight: 500;
            letter-spacing: 0.3px;
        }

        .grade-A {
            color: #2563eb;
            /* blue */
            font-weight: 600;
        }

        .grade-B {
            color: #2563eb;
            /* blue */
            font-weight: 600;
        }

        .grade-C {
            color: #2563eb;
            /* blue */
            font-weight: 600;
        }

        .grade-F {
            color: #dc2626;
            /* red */
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="report-card">

        <!-- Print button -->
        <button class="print-button" onclick="window.print()">🖨 Print Report Card</button>

        <!-- School header -->
        <!-- School header -->
        @php
            if (!isset($grades)) {
                $grades = \App\Models\StudentGrade::where('student_id', $student->id)->get();
                // Default report period if not provided
                $period = $period ?? 'yearly';
            }
        @endphp

        @if (request()->query('showHeader', 1))
            {{-- default to 1 if missing --}}
            <div class="school-header">

                <!-- LEFT: SCHOOL LOGO -->
                <div class="header-left">
                    <img src="{{ asset('kiddos-school-master/images/School_logo_reciept.jpeg') }}" alt="School Logo"
                        class="school-logo">
                </div>

                <!-- CENTER: SCHOOL TEXT -->
                <div class="header-center">
                    <h2>ED MOL MEMORIAL MATADI BAPTIST HIGH SCHOOL</h2>
                    <p class="school-address">New Matadi Estate Drive, Opposite Don Bosco Youth Center</p>
                    <p>P.O. Box: 4330 - Monrovia, Liberia</p>
                    <p>
                        <a href="mailto:emmmbhs@gmail.com">emmmbhs@gmail.com</a>
                        - +231555472972 / +231776597201
                    </p>
                </div>
                <!-- RIGHT: STUDENT IMAGE -->
                <div class="header-right">
                    <img src="{{ $student->image
                        ? asset('storage/' . $student->image)
                        : asset('kiddos-school-master/images/user-default-avatar.jpg') }}"
                        avatardefault_92824 alt="Student Photo" class="school-logo"
                        onerror="this.onerror=null;this.src='{{ asset('kiddos-school-master/images/user-default-avatar.jpg') }}';">
                </div>
            </div>

            <!-- REPORT TITLE -->
            <div class="report-title-box">
                KINDERGARTEN GRADE SHEET
            </div>
        @endif
        <!-- Student information -->
        <div class="student-info">
            <span>STUDENT'S NAME: {{ $student->name }}</span>
            <span style="float: right;">GRADE: {{ $student->class_applying_for }}</span>
        </div>

        <div class="student-info">
            <span style="float: right;">ID: {{ $student->student_id }}</span>
            <span>ACADEMIC YEAR: {{ $grades->first()->academic_year ?? 'N/A' }}</span>

        </div>

        <!-- function to convert grade into letter  -->
        @php
            function gradeLetter($score)
            {
                if ($score === null || $score === '') {
                    return 'NG';
                }

                if ($score >= 90) {
                    return 'A';
                }
                if ($score >= 80) {
                    return 'B';
                }
                if ($score >= 70) {
                    return 'C';
                }
                if ($score >= 65) {
                    return 'F';
                }

                return 'F';
            }
        @endphp

        <!-- Report card table -->
        <table class="{{ in_array($period, ['p1', 'p2', 'p3', 'p4', 'p5', 'p6']) ? 'period-view' : '' }}">
            <thead>
                <tr>
                    <th>Subject</th>
                    <!-- Display columns dynamically based on selected period -->
                    @if (in_array($period, ['p1', 'semester1', 'yearly']))
                        <th>1st Pd</th>
                    @endif
                    @if (in_array($period, ['p2', 'semester1', 'yearly']))
                        <th>2nd Pd</th>
                    @endif
                    @if (in_array($period, ['p3', 'semester1', 'yearly']))
                        <th>3rd Pd</th>
                    @endif
                    @if (in_array($period, ['semester1', 'yearly']))
                        <th>1st Exam</th>
                        <th>1st Sem.Avg</th>
                    @endif
                    @if (in_array($period, ['p4', 'semester2', 'yearly']))
                        <th>4th Pd</th>
                    @endif
                    @if (in_array($period, ['p5', 'semester2', 'yearly']))
                        <th>5th Pd</th>
                    @endif
                    @if (in_array($period, ['p6', 'semester2', 'yearly']))
                        <th>6th Pd</th>
                    @endif
                    @if (in_array($period, ['semester2', 'yearly']))
                        <th>2nd Exam</th>
                        <th>2nd Sem.Avg</th>
                    @endif
                    @if ($period === 'yearly')
                        <th>Yearly Avg</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    // Initialize totals and subject count
                    $firstSemTotal = 0;
                    $secondSemTotal = 0;
                    $subjectCount = $grades->count();

                    // Grade color logic: red if score

                    function gradeColor($score)
                    {
                        if ($score === null || $score === '') {
                            return 'NG';
                        }

                        if ($score >= 90) {
                            return 'grade-A';
                        }
                        if ($score >= 80) {
                            return 'grade-B';
                        }
                        if ($score >= 70) {
                            return 'grade-C';
                        }

                        return 'grade-F';
                    }

                @endphp

                @foreach ($grades as $grade)
                    @php
                        // Calculate semester and yearly averages
                        $periodAvg1 = ($grade->period1 + $grade->period2 + $grade->period3) / 3;
                        $firstSemAvg = round(($periodAvg1 + $grade->exam1) / 2);

                        $periodAvg2 = ($grade->period4 + $grade->period5 + $grade->period6) / 3;
                        $secondSemAvg = round(($periodAvg2 + $grade->exam2) / 2);

                        $yearAvg = round(($firstSemAvg + $secondSemAvg) / 2, 2);

                        // ---------------- PERIOD AVERAGE CALCULATION ----------------

                        // If the report is P1 → add Period1 score
                        if ($period === 'p1') {
                            $firstSemTotal += $grade->period1; // P1 average = sum(period1 scores) / subject count
                        }

                        // If the report is P2 → add Period2 score
                        elseif ($period === 'p2') {
                            $firstSemTotal += $grade->period2; // P2 average = sum(period2 scores) / subject count
                        }

                        // If the report is P3 → add Period3 score
                        elseif ($period === 'p3') {
                            $firstSemTotal += $grade->period3; // P3 average = sum(period3 scores) / subject count
                        }

                        // Semester 1 → use calculated semester average
                        elseif ($period === 'semester1') {
                            $firstSemTotal += $firstSemAvg; // Semester1 average = ((P1+P2+P3)/3 + Exam1)/2
                        }

                        // If the report is P4
                        elseif ($period === 'p4') {
                            $firstSemTotal += $grade->period4;
                        }

                        // If the report is P5
                        elseif ($period === 'p5') {
                            $firstSemTotal += $grade->period5;
                        }

                        // If the report is P6
                        elseif ($period === 'p6') {
                            $firstSemTotal += $grade->period6;
                        }

                        // Semester 2
                        elseif ($period === 'semester2') {
                            $firstSemTotal += $secondSemAvg; // Semester2 average = ((P4+P5+P6)/3 + Exam2)/2
                        }

                        // Yearly report
                        elseif ($period === 'yearly') {
                            $firstSemTotal += $yearAvg; // Yearly average = (Semester1 + Semester2) / 2
                        }

                    @endphp

                    <tr>
                        <td>{{ $grade->subject->name }}</td>

                        <!-- Dynamic period columns -->
                        @if (in_array($period, ['p1', 'semester1', 'yearly']))
                            <td> <span class="{{ gradeColor($grade->period1) }}">
                                    {{ gradeLetter($grade->period1) }}</span></td>
                        @endif
                        @if (in_array($period, ['p2', 'semester1', 'yearly']))
                            <td> <span class="{{ gradeColor($grade->period2) }}">
                                    {{ gradeLetter($grade->period2) }}</span></td>
                        @endif
                        @if (in_array($period, ['p3', 'semester1', 'yearly']))
                            <td> <span class="{{ gradeColor($grade->period3) }}">
                                    {{ gradeLetter($grade->period3) }}</span></td>
                        @endif
                        @if (in_array($period, ['semester1', 'yearly']))
                            <td> <span
                                    class="{{ gradeColor($grade->exam1) }}"><strong>{{ gradeLetter($grade->exam1) }}</strong></span>
                            </td>
                            <td><span
                                    class="{{ gradeColor($firstSemAvg) }}"><strong>{{ gradeLetter($firstSemAvg) }}</strong></span>
                            </td>
                        @endif
                        @if (in_array($period, ['p4', 'semester2', 'yearly']))
                            <td> <span class="{{ gradeColor($grade->period4) }}">
                                    {{ gradeLetter($grade->period4) }}</span></td>
                        @endif
                        @if (in_array($period, ['p5', 'semester2', 'yearly']))
                            <td> <span class="{{ gradeColor($grade->period5) }}">
                                    {{ gradeLetter($grade->period5) }}</span></td>
                        @endif
                        @if (in_array($period, ['p6', 'semester2', 'yearly']))
                            <td> <span class="{{ gradeColor($grade->period6) }}">
                                    {{ gradeLetter($grade->period6) }}</span></td>
                        @endif
                        @if (in_array($period, ['semester2', 'yearly']))
                            <td> <span
                                    class="{{ gradeColor($grade->exam2) }}"><strong>{{ gradeLetter($grade->exam2) }}</strong></span>
                            </td>
                            <td><span
                                    class="{{ gradeColor($secondSemAvg) }}"><strong>{{ gradeLetter($secondSemAvg) }}</strong></span>
                            </td>
                        @endif
                        @if ($period === 'yearly')
                            <td><span
                                    class="{{ gradeColor($yearAvg) }}"><strong>{{ gradeLetter($yearAvg) }}</strong></span>
                            </td>
                        @endif
                    </tr>
                @endforeach

                @php
                    // 1. Calculate the values you want to show
                    $firstSemTotal = $firstSemTotal ?? 0;
                    $subjectCount = $subjectCount ?? 1; // Division by zero check
                    $overallAverage = round($firstSemTotal / $subjectCount, 2);

                    // 2. Calculate how many columns are actually displayed in the current view
                    $totalCols = 1; // The "Subject" column

                    if (in_array($period, ['p1', 'p2', 'p3', 'p4', 'p5', 'p6'])) {
                        $totalCols += 1;
                    } elseif (in_array($period, ['semester1', 'semester2'])) {
                        $totalCols += 5; // 3 periods + 1 exam + 1 average
                    } elseif ($period === 'yearly') {
                        $totalCols += 11; // All columns
                    }
                @endphp
                <tr style="background:#f3f4f6; font-weight: bold;">
                    <td>Average</td>

                    @if (in_array($period, ['p1', 'semester1', 'yearly']))
                        @php $score = $periodAverages['p1'][$student->id] ?? 0; @endphp
                        <td><span class="{{ gradeColor($score) }}"><strong>{{ gradeLetter($score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['p2', 'semester1', 'yearly']))
                        @php $score = $periodAverages['p2'][$student->id] ?? 0; @endphp
                        <td><span class="{{ gradeColor($score) }}"><strong>{{ gradeLetter($score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['p3', 'semester1', 'yearly']))
                        @php $score = $periodAverages['p3'][$student->id] ?? 0; @endphp
                        <td><span class="{{ gradeColor($score) }}"><strong>{{ gradeLetter($score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['semester1', 'yearly']))
                        @php $exam1Score = $periodAverages['exam1'][$student->id] ?? 0; @endphp
                        @php $sem1Score = $periodAverages['semester1'][$student->id] ?? 0; @endphp
                        <td><span
                                class="{{ gradeColor($exam1Score) }}"><strong>{{ gradeLetter($exam1Score) }}</strong></span>
                        </td>
                        <td><span
                                class="{{ gradeColor($sem1Score) }}"><strong>{{ gradeLetter($sem1Score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['p4', 'semester2', 'yearly']))
                        @php $score = $periodAverages['p4'][$student->id] ?? 0; @endphp
                        <td><span class="{{ gradeColor($score) }}"><strong>{{ gradeLetter($score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['p5', 'semester2', 'yearly']))
                        @php $score = $periodAverages['p5'][$student->id] ?? 0; @endphp
                        <td><span class="{{ gradeColor($score) }}"><strong>{{ gradeLetter($score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['p6', 'semester2', 'yearly']))
                        @php $score = $periodAverages['p6'][$student->id] ?? 0; @endphp
                        <td><span class="{{ gradeColor($score) }}"><strong>{{ gradeLetter($score) }}</strong></span>
                        </td>
                    @endif

                    @if (in_array($period, ['semester2', 'yearly']))
                        @php $exam2Score = $periodAverages['exam2'][$student->id] ?? 0; @endphp
                        @php $sem2Score = $periodAverages['semester2'][$student->id] ?? 0; @endphp
                        <td><span
                                class="{{ gradeColor($exam2Score) }}"><strong>{{ gradeLetter($exam2Score) }}</strong></span>
                        </td>
                        <td><span
                                class="{{ gradeColor($sem2Score) }}"><strong>{{ gradeLetter($sem2Score) }}</strong></span>
                        </td>
                    @endif

                    @if ($period === 'yearly')
                        @php $yearlyScore = $periodAverages['yearly'][$student->id] ?? 0; @endphp
                        <td><span
                                class="{{ gradeColor($yearlyScore) }}"><strong>{{ gradeLetter($yearlyScore) }}</strong></span>
                        </td>
                    @endif
                </tr>

                <tr style="background:#f3f4f6; font-weight: bold;">
                    <td>Rank</td>

                    @if (in_array($period, ['p1', 'semester1', 'yearly']))
                        <td>{{ $periodRanks['p1'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['p2', 'semester1', 'yearly']))
                        <td>{{ $periodRanks['p2'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['p3', 'semester1', 'yearly']))
                        <td>{{ $periodRanks['p3'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['semester1', 'yearly']))
                        {{-- ✅ FIXED: exam1 rank --}}
                        <td>{{ $periodRanks['exam1'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>

                        <td>{{ $periodRanks['semester1'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['p4', 'semester2', 'yearly']))
                        <td>{{ $periodRanks['p4'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['p5', 'semester2', 'yearly']))
                        <td>{{ $periodRanks['p5'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['p6', 'semester2', 'yearly']))
                        <td>{{ $periodRanks['p6'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if (in_array($period, ['semester2', 'yearly']))
                        {{-- ✅ FIXED: exam2 rank --}}
                        <td>{{ $periodRanks['exam2'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>

                        <td>{{ $periodRanks['semester2'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif

                    @if ($period === 'yearly')
                        <td>{{ $periodRanks['yearly'][$student->id] ?? '-' }} / {{ $totalStudents }}</td>
                    @endif
                </tr>

                <tr style="background:#f3f4f6; font-weight: bold;">
                    <td>Conduct</td>
                    @for ($i = 0; $i < $totalCols - 2; $i++)
                        <td></td>
                    @endfor
                    <td style="text-align: center;">{{ $conduct ?? '-' }}</td>
                </tr>

                {{-- Repeat same logic for Rank and Conduct --}}

            </tbody>
        </table>

        <!-- Signature / Footer -->
        @if (request()->query('showFooter', 1))
            <div class="signature">
                <div>
                    Signed: ______________________<br>
                    Class Sponsor
                </div>

                <div>
                    Approved: ______________________<br>
                    Principal
                </div>
            </div>

            <div class="footer-note">
                Any alteration of this document renders it invalid. <br>
                Invalid without school stamp.
            </div>
        @endif

        <div class="footer-info-container">

            <div class="grading-method-box">
                <h1 class="brand-title">Grading Method</h1>
                <div class="grade-scale-row">
                    <span class="grade-range">90 - 100%:</span>
                    <span class="grade-label label-excellent">Excellent</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-range">80 - 89%:</span>
                    <span class="grade-label label-vgood">V. Good</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-range">69 - 79%:</span>
                    <span class="grade-label label-good">Good</span>
                </div>
                <div class="grade-scale-row">
                    <span class="grade-range">67 - 69%:</span>
                    <span class="grade-label label-fail">Fail</span>
                </div>
            </div>

            <div class="qr-code-box">
                <div class="qr-frame">
                    {!! QrCode::size(90)->backgroundColor(255, 255, 255)->color(0, 0, 128)->generate(route('public.verify.report_card', ['id' => $student->student_id])) !!}
                </div>

                <div class="qr-caption">
                    Scan to Verify
                </div>
            </div>

        </div>
</body>

</html>
