@extends('layouts.student')

@section('title', 'Grades')

@push('styles')
    <style>
        .grades-page { display: grid; min-width: 0; grid-template-columns: minmax(0, 1fr); gap: 22px; }
        .grades-page > * { min-width: 0; }

        /* ---------- Heading ---------- */
        .grades-heading h1 { margin: 0; font-size: clamp(24px, 4vw, 32px); font-weight: 600; letter-spacing: -.01em; }
        .grades-intro { margin: 6px 0 0; color: var(--muted); font-size: 14px; }
        .grades-context { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 16px; }
        .grades-context span {
            display: inline-flex; align-items: center; gap: 8px;
            padding: 6px 13px;
            border-radius: 999px;
            background: var(--surface); color: var(--purple);
            font-size: 12.5px; font-weight: 500;
            overflow-wrap: anywhere;
        }
        .grades-context i { color: var(--purple-bright); }

        /* ---------- Period selector ---------- */
        .period-nav {
            display: flex; flex-wrap: wrap; gap: 14px 26px;
            min-width: 0;
            padding: 16px 18px;
            border: 1px solid var(--line);
            border-radius: 18px;
            background: #fff;
        }
        .period-group { display: flex; min-width: 0; max-width: 100%; flex-wrap: wrap; align-items: center; gap: 8px 10px; }
        .period-group-label { color: var(--muted); font-size: 12.5px; font-weight: 500; }
        .period-tabs { display: flex; min-width: 0; flex-wrap: wrap; gap: 6px; }
        .period-tab {
            display: inline-flex; min-height: 36px; align-items: center;
            padding: 0 13px;
            border: 1px solid var(--line);
            border-radius: 10px;
            background: #fff; color: #4B4766;
            font-size: 12.5px; font-weight: 500; text-decoration: none;
            transition: border-color .15s ease, color .15s ease;
        }
        .period-tab:hover { border-color: #BDB1FF; color: var(--purple); }
        .period-tab.is-active {
            border-color: var(--purple-bright);
            background: var(--purple-bright); color: #fff;
            box-shadow: inset 0 -3px 0 var(--yellow);
        }

        /* ---------- Panel ---------- */
        .grades-panel { min-width: 0; overflow: hidden; border: 1px solid var(--line); border-radius: 20px; background: #fff; }
        .grades-panel-header {
            display: flex; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 6px 14px;
            min-width: 0;
            padding: 20px 24px 0;
        }
        .grades-panel-title { margin: 0; font-size: 17px; font-weight: 600; }
        .grades-panel-count { color: var(--muted); font-size: 12.5px; }

        /* Summary */
        .grades-summary { display: flex; min-width: 0; flex-wrap: wrap; align-items: stretch; gap: 12px; padding: 18px 24px 0; }
        .grades-figure {
            display: flex; min-width: 150px; flex: 1 1 150px; flex-direction: column; gap: 2px;
            padding: 13px 16px;
            border-radius: 14px;
            background: var(--surface);
        }
        .grades-figure-value { font-size: 24px; font-weight: 600; line-height: 1.2; font-variant-numeric: tabular-nums; }
        .grades-figure-label { color: var(--muted); font-size: 12.5px; }
        .grades-figure--poor { background: #FEF0EE; }
        .grades-figure--poor .grades-figure-value { color: #B42318; }
        .grades-figure--top { background: #E8F7EE; }
        .grades-figure--top .grades-figure-value { color: #14703B; }
        .grades-basis { width: 100%; margin: 0; color: var(--muted); font-size: 12px; }

        /* Legend */
        .grades-legend { display: flex; min-width: 0; flex-wrap: wrap; align-items: center; gap: 8px 14px; padding: 16px 24px 18px; }
        .grades-legend-title { color: var(--muted); font-size: 12.5px; font-weight: 500; }
        .legend-item { display: inline-flex; align-items: center; gap: 8px; color: #4B4766; font-size: 12.5px; }

        /* Score chips: red below 70, then fair, good and excellent */
        .score {
            position: relative;
            display: inline-flex; min-width: 46px;
            align-items: center; justify-content: center;
            padding: 4px 10px;
            border: 1px solid transparent;
            border-radius: 8px;
            font-size: 13px; font-weight: 600;
            font-variant-numeric: tabular-nums;
            white-space: nowrap;
        }
        .score--poor { border-color: #FDC5C0; background: #FEE4E2; color: #B42318; }
        .score--fair { border-color: #F6D88A; background: #FFF1CC; color: #7A5200; }
        .score--good { border-color: #A6D9F3; background: #DDF1FB; color: #0B6AA2; }
        .score--excellent { border-color: #9ADBB4; background: #DCF4E4; color: #14703B; }
        .score--none { background: #F3F3F8; color: #8A889C; font-weight: 500; }
        .is-average .score { font-weight: 700; }

        /* Table */
        .grades-table-wrap {
            position: relative;
            min-width: 0;
            max-width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            overscroll-behavior-x: contain;
            border-top: 1px solid var(--line);
        }
        .grades-table { width: 100%; min-width: 640px; border-collapse: separate; border-spacing: 0; }
        .grades-table th {
            padding: 13px 16px;
            background: #FAF9FD; color: var(--muted);
            border-bottom: 1px solid var(--line);
            font-size: 12px; font-weight: 600; text-align: left; white-space: nowrap;
        }
        .grades-table td { padding: 13px 16px; border-bottom: 1px solid #F0EFF6; background: #fff; vertical-align: middle; }
        .grades-table tbody tr:last-child td { border-bottom: 0; }
        .grades-table tbody tr:hover td { background: #FBFAFF; }
        .grades-table th:first-child, .grades-table td:first-child {
            position: sticky; left: 0; z-index: 1;
            min-width: 170px;
            box-shadow: 1px 0 0 var(--line);
        }
        .grades-table td:first-child { color: var(--ink); font-weight: 600; }
        .grades-table th:first-child { z-index: 2; }
        .grades-table tr.is-poor td:first-child { box-shadow: inset 4px 0 0 #D92D20, 1px 0 0 var(--line); }

        /* Mobile cards */
        .grade-cards { display: none; min-width: 0; padding: 14px; border-top: 1px solid var(--line); }
        .grade-card { min-width: 0; padding: 16px; border: 1px solid var(--line); border-radius: 14px; background: #fff; }
        .grade-card + .grade-card { margin-top: 10px; }
        .grade-card.is-poor { border-left: 4px solid #D92D20; }
        .grade-card-head { display: flex; min-width: 0; align-items: center; justify-content: space-between; gap: 10px; margin-bottom: 14px; }
        .grade-card-name { min-width: 0; margin: 0; font-size: 15px; font-weight: 600; overflow-wrap: anywhere; }
        .grade-card-head .score { flex: 0 0 auto; }
        .grade-tiles { display: grid; min-width: 0; grid-template-columns: repeat(auto-fill, minmax(92px, 1fr)); gap: 8px; }
        .grade-tile { display: flex; min-width: 0; flex-direction: column; gap: 3px; padding: 10px 12px; border-radius: 10px; }
        .grade-tile-label { color: inherit; font-size: 11.5px; opacity: .85; overflow-wrap: anywhere; }
        .grade-tile-value { position: relative; font-size: 16px; font-weight: 600; font-variant-numeric: tabular-nums; overflow-wrap: anywhere; }
        .grade-tile.is-average .grade-tile-value { font-weight: 700; }
        .grade-tile--poor { background: #FEE4E2; color: #B42318; }
        .grade-tile--fair { background: #FFF1CC; color: #7A5200; }
        .grade-tile--good { background: #DDF1FB; color: #0B6AA2; }
        .grade-tile--excellent { background: #DCF4E4; color: #14703B; }
        .grade-tile--none { background: #F3F3F8; color: #8A889C; }

        .grades-readonly {
            display: flex; min-width: 0; align-items: center; gap: 9px;
            padding: 14px 24px;
            border-top: 1px solid var(--line);
            color: var(--muted); font-size: 12.5px;
        }
        .grades-readonly i { color: var(--purple-bright); }

        /* Empty */
        .grades-empty { padding: 56px 22px 60px; border-top: 1px solid var(--line); text-align: center; margin-top: 18px; }
        .grades-empty-icon {
            display: inline-flex; width: 54px; height: 54px;
            align-items: center; justify-content: center;
            border-radius: 50%;
            background: var(--yellow-soft); color: var(--yellow-ink); font-size: 20px;
        }
        .grades-empty h2 { margin: 16px 0 6px; font-size: 17px; font-weight: 600; }
        .grades-empty p { max-width: 420px; margin: 0 auto; color: var(--muted); font-size: 13.5px; }

        @media (max-width: 860px) {
            .grades-table-wrap { display: none; }
            .grade-cards { display: block; }
        }
        @media (max-width: 600px) {
            .grades-page { gap: 14px; }
            .period-nav { padding: 10px; gap: 8px 12px; }
            .period-group { gap: 6px 8px; }
            .period-group-label { font-size: 11.5px; }
            .period-tabs { gap: 5px; }
            .period-tab { min-height: 36px; padding-inline: 9px; font-size: 11.5px; }
            .grades-panel { border-radius: 16px; }
            .grades-panel-header { padding: 14px 12px 0; }
            .grades-panel-title { font-size: 15px; }
            .grades-summary { padding: 12px 12px 0; gap: 8px; }
            .grades-figure { min-width: 0; flex-basis: calc(50% - 4px); padding: 9px 10px; }
            .grades-figure:first-child { flex-basis: 100%; }
            .grades-figure-value { font-size: 20px; }
            .grades-figure-label, .grades-basis { font-size: 11.5px; }
            .grades-legend { gap: 6px 10px; padding: 11px 12px 13px; }
            .grades-legend-title, .legend-item { font-size: 11.5px; }
            .legend-item { gap: 6px; }
            .score { min-width: 40px; padding: 3px 8px; font-size: 11.5px; }
            .grade-cards { padding: 12px; }
            .grade-card { padding: 12px; border-radius: 12px; }
            .grade-card-head { gap: 8px; margin-bottom: 9px; }
            .grade-card-name { font-size: 14px; }
            .grade-card-head .score { min-width: 36px; padding: 3px 7px; font-size: 11.5px; }
            .grade-tiles { grid-template-columns: repeat(auto-fill, minmax(92px, 1fr)); gap: 6px; }
            .grade-tile { gap: 2px; padding: 7px 9px; border-radius: 8px; }
            .grade-tile-label { font-size: 10.5px; }
            .grade-tile-value { font-size: 14px; }
            .grades-readonly { gap: 7px; padding: 11px 12px; font-size: 11.5px; }
            .grades-empty { margin-top: 12px; padding: 32px 14px 36px; }
            .grades-empty-icon { width: 46px; height: 46px; }
            .grades-empty h2 { margin-top: 12px; font-size: 15px; }
            .grades-empty p { font-size: 12.5px; overflow-wrap: anywhere; }
        }
    </style>
@endpush

@section('content')
    @php
        $periodGroups = [
            'Sem 1' => [
                'p1' => 'Period 1',
                'p2' => 'Period 2',
                'p3' => 'Period 3',
                'semester1' => 'Semester 1',
            ],
            'Sem 2' => [
                'p4' => 'Period 4',
                'p5' => 'Period 5',
                'p6' => 'Period 6',
                'semester2' => 'Semester 2',
            ],
        ];
        $scoreColumns = match ($period) {
            'p1' => [['field' => 'period1', 'label' => 'Period 1']],
            'p2' => [['field' => 'period2', 'label' => 'Period 2']],
            'p3' => [['field' => 'period3', 'label' => 'Period 3']],
            'p4' => [['field' => 'period4', 'label' => 'Period 4']],
            'p5' => [['field' => 'period5', 'label' => 'Period 5']],
            'p6' => [['field' => 'period6', 'label' => 'Period 6']],
            'semester1' => [
                ['field' => 'period1', 'label' => 'Period 1'],
                ['field' => 'period2', 'label' => 'Period 2'],
                ['field' => 'period3', 'label' => 'Period 3'],
                ['field' => 'exam1', 'label' => 'Exam 1'],
                ['field' => 'firstSemAvg', 'label' => 'Semester 1 average', 'average' => true],
            ],
            'semester2' => [
                ['field' => 'period4', 'label' => 'Period 4'],
                ['field' => 'period5', 'label' => 'Period 5'],
                ['field' => 'period6', 'label' => 'Period 6'],
                ['field' => 'exam2', 'label' => 'Exam 2'],
                ['field' => 'secondSemAvg', 'label' => 'Semester 2 average', 'average' => true],
            ],
            default => [
                ['field' => 'period1', 'label' => 'Period 1'],
                ['field' => 'period2', 'label' => 'Period 2'],
                ['field' => 'period3', 'label' => 'Period 3'],
                ['field' => 'exam1', 'label' => 'Exam 1'],
                ['field' => 'firstSemAvg', 'label' => 'Sem 1 average', 'average' => true],
                ['field' => 'period4', 'label' => 'Period 4'],
                ['field' => 'period5', 'label' => 'Period 5'],
                ['field' => 'period6', 'label' => 'Period 6'],
                ['field' => 'exam2', 'label' => 'Exam 2'],
                ['field' => 'secondSemAvg', 'label' => 'Sem 2 average', 'average' => true],
                ['field' => 'yearlyAvg', 'label' => 'Yearly average', 'average' => true],
            ],
        };
        $periodLabel = $period === 'yearly' ? 'Yearly' : ucfirst(str_replace(['p', 'semester'], ['Period ', 'Semester '], $period));

        // Performance band for a score: 0-69 is poor (red), 70-79 fair, 80-89 good, 90-100 excellent.
        $scoreBand = function ($score) {
            if ($score === null || $score === '' || ! is_numeric($score)) {
                return 'none';
            }
            $value = (float) $score;

            if ($value < 70) {
                return 'poor';
            }
            if ($value < 80) {
                return 'fair';
            }
            if ($value < 90) {
                return 'good';
            }

            return 'excellent';
        };
        $bandHint = [
            'poor' => 'below 70, needs attention',
            'fair' => '70 to 79, fair',
            'good' => '80 to 89, good',
            'excellent' => '90 and above, excellent',
            'none' => 'not published',
        ];

        // Summary is based on the last column shown (the period score, or the average for semester and yearly views).
        $focusColumn = collect($scoreColumns)->last();
        $focusScores = $grades->map(fn ($grade) => data_get($grade, $focusColumn['field']))->filter(fn ($score) => is_numeric($score));
        $poorCount = $focusScores->filter(fn ($score) => (float) $score < 70)->count();
        $excellentCount = $focusScores->filter(fn ($score) => (float) $score >= 90)->count();
    @endphp

    <div class="grades-page">
        <header class="grades-heading">
            <h1>Grades</h1>
            <p class="grades-intro">Review the scores recorded for your enrollment.</p>
            <div class="grades-context">
                @if($school ?? null)
                    <span><i class="fa-solid fa-school" aria-hidden="true"></i>{{ $school->school_name }}</span>
                @endif
                @if($enrollment && $enrollment->grade)
                    <span><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>Class: {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' '.$enrollment->grade->section : '' }}</span>
                @endif
                @if($academicYear)
                    <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>Academic year: {{ $academicYear->name }}</span>
                @endif
            </div>
        </header>

        <nav class="period-nav" aria-label="Select grading period">
            @foreach($periodGroups as $group => $options)
                <div class="period-group">
                    <span class="period-group-label">{{ $group }}</span>
                    <div class="period-tabs">
                        @foreach($options as $key => $label)
                            <a
                                href="{{ route('student.grades', ['period' => $key]) }}"
                                class="period-tab {{ $period === $key ? 'is-active' : '' }}"
                                @if($period === $key) aria-current="page" @endif
                            >{{ $label }}</a>
                        @endforeach
                    </div>
                </div>
            @endforeach
            <div class="period-group">
                <span class="period-group-label">Year</span>
                <div class="period-tabs">
                    <a
                        href="{{ route('student.grades', ['period' => 'yearly']) }}"
                        class="period-tab {{ $period === 'yearly' ? 'is-active' : '' }}"
                        @if($period === 'yearly') aria-current="page" @endif
                    >Yearly</a>
                </div>
            </div>
        </nav>

        <section class="grades-panel" aria-labelledby="grades-panel-title">
            <div class="grades-panel-header">
                <h2 class="grades-panel-title" id="grades-panel-title">{{ $periodLabel }} grades</h2>
                <span class="grades-panel-count">{{ $grades->count() }} {{ $grades->count() === 1 ? 'subject' : 'subjects' }}</span>
            </div>

            @if($grades->isEmpty())
                <div class="grades-empty">
                    <span class="grades-empty-icon"><i class="fa-solid fa-book-open" aria-hidden="true"></i></span>
                    <h2>No grades have been published for you yet.</h2>
                    <p>Published grades will appear here for your current enrollment.</p>
                </div>
            @else
                <div class="grades-summary">
                    <div class="grades-figure">
                        <span class="grades-figure-value">{{ $grades->count() }}</span>
                        <span class="grades-figure-label">{{ $grades->count() === 1 ? 'Subject' : 'Subjects' }}</span>
                    </div>
                    <div class="grades-figure grades-figure--poor">
                        <span class="grades-figure-value">{{ $poorCount }}</span>
                        <span class="grades-figure-label">Below 70</span>
                    </div>
                    <div class="grades-figure grades-figure--top">
                        <span class="grades-figure-value">{{ $excellentCount }}</span>
                        <span class="grades-figure-label">90 and above</span>
                    </div>
                    <p class="grades-basis">Counts use the {{ strtolower($focusColumn['label']) }} score.</p>
                </div>

                <div class="grades-legend" role="list" aria-label="Score colors">
                    <span class="grades-legend-title">Score colors</span>
                    <span class="legend-item" role="listitem"><span class="score score--poor">0-69</span>Needs attention</span>
                    <span class="legend-item" role="listitem"><span class="score score--fair">70-79</span>Fair</span>
                    <span class="legend-item" role="listitem"><span class="score score--good">80-89</span>Good</span>
                    <span class="legend-item" role="listitem"><span class="score score--excellent">90-100</span>Excellent</span>
                    <span class="legend-item" role="listitem"><span class="score score--none">-</span>Not published</span>
                </div>

                <div class="grades-table-wrap">
                    <table class="grades-table">
                        <thead>
                            <tr>
                                <th scope="col">Subject</th>
                                @foreach($scoreColumns as $column)
                                    <th scope="col">{{ $column['label'] }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                @php($focusBand = $scoreBand(data_get($grade, $focusColumn['field'])))
                                <tr class="{{ $focusBand === 'poor' ? 'is-poor' : '' }}">
                                    <td>{{ $grade->subject->name ?? '—' }}</td>
                                    @foreach($scoreColumns as $column)
                                        @php($score = data_get($grade, $column['field']))
                                        @php($band = $scoreBand($score))
                                        <td class="{{ !empty($column['average']) ? 'is-average' : '' }}">
                                            <span class="score score--{{ $band }}">{{ $score === null ? '-' : (((!isset($column['average']) || $column['average'] !== true) && is_numeric($score) && (float) $score == 0) ? 'I' : $score) }}<span class="sr-only"> ({{ $bandHint[$band] }})</span></span>
                                        </td>
                                    @endforeach
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="grade-cards">
                    @foreach($grades as $grade)
                        @php($focusScore = data_get($grade, $focusColumn['field']))
                        @php($focusBand = $scoreBand($focusScore))
                        <article class="grade-card {{ $focusBand === 'poor' ? 'is-poor' : '' }}">
                            <div class="grade-card-head">
                                <h3 class="grade-card-name">{{ $grade->subject->name ?? '—' }}</h3>
                                <span class="score score--{{ $focusBand }}">{{ $focusScore === null ? '-' : ((!isset($focusColumn['average']) || $focusColumn['average'] !== true) && is_numeric($focusScore) && (float) $focusScore == 0 ? 'I' : $focusScore) }}<span class="sr-only"> ({{ $bandHint[$focusBand] }})</span></span>
                            </div>
                            <div class="grade-tiles">
                                @foreach($scoreColumns as $column)
                                    @php($score = data_get($grade, $column['field']))
                                    @php($band = $scoreBand($score))
                                    <div class="grade-tile grade-tile--{{ $band }} {{ !empty($column['average']) ? 'is-average' : '' }}">
                                        <span class="grade-tile-label">{{ $column['label'] }}</span>
                                        <span class="grade-tile-value">{{ $score === null ? '-' : (((!isset($column['average']) || $column['average'] !== true) && is_numeric($score) && (float) $score == 0) ? 'I' : $score) }}<span class="sr-only"> ({{ $bandHint[$band] }})</span></span>
                                    </div>
                                @endforeach
                            </div>
                        </article>
                    @endforeach
                </div>

                <div class="grades-readonly">
                    <i class="fa-solid fa-lock" aria-hidden="true"></i>
                    Read only. Grades are managed by authorized school staff.
                </div>
            @endif
        </section>
    </div>
@endsection
