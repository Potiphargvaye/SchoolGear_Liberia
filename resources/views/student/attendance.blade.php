@extends('layouts.student')

@section('title', 'Attendance')

@push('styles')
<style>
    .attendance-page { display: grid; min-width: 0; gap: 20px; color: var(--ink); }
    .attendance-page > * { min-width: 0; }
    .attendance-heading { display: flex; min-width: 0; flex-wrap: wrap; align-items: flex-start; justify-content: space-between; gap: 12px; }
    .attendance-heading h1 { margin: 0; font-size: clamp(24px, 4vw, 32px); font-weight: 600; letter-spacing: -.01em; }
    .attendance-intro { margin: 6px 0 0; color: var(--muted); font-size: 13px; }
    .attendance-context { display: flex; flex-wrap: wrap; gap: 8px; margin-top: 12px; }
    .attendance-context span { display: inline-flex; align-items: center; gap: 7px; max-width: 100%; padding: 6px 12px; border-radius: 999px; background: var(--surface); color: var(--purple); font-size: 12px; overflow-wrap: anywhere; }
    .attendance-summary { display: grid; grid-template-columns: repeat(5, minmax(0, 1fr)); gap: 12px; }
    .attendance-card { min-width: 0; padding: 16px; border: 1px solid var(--line); border-radius: 15px; background: #fff; }
    .attendance-card-label { display: block; color: var(--muted); font-size: 12px; }
    .attendance-card-value { display: block; margin-top: 5px; font-size: 24px; font-weight: 600; line-height: 1.2; font-variant-numeric: tabular-nums; overflow-wrap: anywhere; }
    .attendance-card--present .attendance-card-value { color: #14703B; }
    .attendance-card--absent .attendance-card-value { color: #B42318; }
    .attendance-card--late .attendance-card-value { color: #7A5200; }
    .attendance-card--excused .attendance-card-value { color: #0B6AA2; }
    .attendance-card--rate-low .attendance-card-value { color: #B42318; }
    .attendance-card--rate-medium .attendance-card-value { color: #7A5200; }
    .attendance-card--rate-high .attendance-card-value { color: #14703B; }
    .attendance-panel { min-width: 0; overflow: hidden; border: 1px solid var(--line); border-radius: 18px; background: #fff; }
    .attendance-panel-head { display: flex; min-width: 0; flex-wrap: wrap; align-items: center; justify-content: space-between; gap: 12px; padding: 18px 20px; border-bottom: 1px solid var(--line); }
    .attendance-panel-head h2 { margin: 0; font-size: 16px; font-weight: 600; }
    .attendance-month-nav { display: flex; min-width: 0; flex-wrap: wrap; align-items: center; gap: 8px; }
    .attendance-month-nav a, .attendance-filter-button { display: inline-flex; min-height: 36px; align-items: center; justify-content: center; gap: 7px; padding: 0 11px; border: 1px solid var(--line); border-radius: 9px; background: #fff; color: var(--purple); font: inherit; font-size: 12px; text-decoration: none; cursor: pointer; }
    .attendance-month-nav a:hover, .attendance-filter-button:hover { border-color: #BDB1FF; background: var(--surface); }
    .attendance-month-label { min-width: 108px; color: var(--ink); font-size: 13px; font-weight: 600; text-align: center; }
    .attendance-calendar { padding: 16px 20px 20px; }
    .attendance-calendar-grid { display: grid; grid-template-columns: repeat(7, minmax(0, 1fr)); gap: 6px; }
    .attendance-weekday { padding: 3px 0 6px; color: var(--muted); font-size: 11px; font-weight: 600; text-align: center; }
    .attendance-day { display: flex; min-width: 0; min-height: 58px; flex-direction: column; align-items: center; justify-content: center; gap: 5px; border: 1px solid #F0EFF6; border-radius: 10px; background: #fff; color: var(--ink); font-size: 12px; }
    .attendance-day--empty { border-color: transparent; background: transparent; }
    .attendance-day-number { font-weight: 500; }
    .attendance-marker { display: inline-flex; min-width: 22px; height: 20px; align-items: center; justify-content: center; padding: 0 5px; border-radius: 6px; background: #F3F3F8; color: #777488; font-size: 11px; font-weight: 700; line-height: 1; }
    .attendance-marker--present { background: #DCF4E4; color: #14703B; }
    .attendance-marker--absent { background: #FEE4E2; color: #B42318; }
    .attendance-marker--late { background: #FFF1CC; color: #7A5200; }
    .attendance-marker--excused { background: #DDF1FB; color: #0B6AA2; }
    .attendance-mobile-calendar { display: none; }
    .attendance-note { margin: 0; padding: 0 20px 16px; color: var(--muted); font-size: 11.5px; }
    .attendance-legend { display: flex; flex-wrap: wrap; gap: 8px 16px; padding: 0 20px 16px; }
    .attendance-legend-item { display: inline-flex; align-items: center; gap: 7px; color: var(--muted); font-size: 11.5px; }
    .attendance-filter { display: flex; flex-wrap: wrap; align-items: end; gap: 9px; }
    .attendance-filter label { display: grid; gap: 4px; color: var(--muted); font-size: 11px; }
    .attendance-filter input, .attendance-filter select { min-height: 36px; max-width: 100%; padding: 6px 9px; border: 1px solid var(--line); border-radius: 9px; background: #fff; color: var(--ink); font: inherit; font-size: 12px; }
    .attendance-shared-filter { display: flex; min-width: 0; flex-wrap: wrap; align-items: end; gap: 10px; padding: 14px 16px; border: 1px solid var(--line); border-radius: 14px; background: #fff; }
    .attendance-shared-filter label { display: grid; min-width: 0; flex: 1 1 140px; gap: 5px; color: var(--muted); font-size: 11.5px; }
    .attendance-shared-filter input, .attendance-shared-filter select { width: 100%; min-width: 0; min-height: 38px; padding: 7px 10px; border: 1px solid var(--line); border-radius: 9px; background: #fff; color: var(--ink); font: inherit; font-size: 12px; }
    .attendance-filter-actions { display: flex; align-items: center; gap: 10px; }
    .attendance-reset { min-height: 36px; display: inline-flex; align-items: center; color: var(--purple); font-size: 12px; text-decoration: none; white-space: nowrap; }
    .attendance-reset:hover { text-decoration: underline; }
    .attendance-showing { margin: -8px 0 0; color: var(--muted); font-size: 12px; overflow-wrap: anywhere; }
    .attendance-records { display: grid; min-width: 0; }
    .attendance-record { display: grid; min-width: 0; grid-template-columns: minmax(100px, .8fr) minmax(100px, .8fr) minmax(100px, .8fr) minmax(120px, 1fr) minmax(0, 1.6fr); align-items: start; gap: 12px; padding: 13px 20px; border-bottom: 1px solid #F0EFF6; }
    .attendance-record:last-child { border-bottom: 0; }
    .attendance-record-date { font-size: 12px; font-weight: 500; }
    .attendance-record-subject, .attendance-record-note { min-width: 0; color: var(--muted); font-size: 12px; overflow-wrap: anywhere; }
    .attendance-record-note--empty { color: #A09DAF; }
    .score { display: inline-flex; min-width: 62px; align-items: center; justify-content: center; padding: 4px 10px; border: 1px solid transparent; border-radius: 8px; font-size: 12px; font-weight: 600; white-space: nowrap; }
    .score--present { border-color: #9ADBB4; background: #DCF4E4; color: #14703B; }
    .score--absent { border-color: #FDC5C0; background: #FEE4E2; color: #B42318; }
    .score--late { border-color: #F6D88A; background: #FFF1CC; color: #7A5200; }
    .score--excused { border-color: #A6D9F3; background: #DDF1FB; color: #0B6AA2; }
    .score--none { background: #F3F3F8; color: #8A889C; font-weight: 500; }
    .attendance-empty { padding: 34px 18px; color: var(--muted); text-align: center; }
    .attendance-empty i { display: block; margin-bottom: 10px; color: var(--purple-bright); font-size: 24px; }
    .attendance-empty strong { display: block; color: var(--ink); font-size: 14px; }
    .attendance-pagination { display: flex; flex-wrap: wrap; justify-content: space-between; gap: 10px; padding: 12px 20px; border-top: 1px solid var(--line); }
    .attendance-pagination a { color: var(--purple); font-size: 12px; text-decoration: none; }
    .attendance-pagination a[aria-disabled="true"] { color: #A09DAF; pointer-events: none; }
    @media (max-width: 900px) { .attendance-summary { grid-template-columns: repeat(3, minmax(0, 1fr)); } }
    @media (max-width: 640px) {
        .attendance-page { gap: 14px; }
        .attendance-summary { grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 8px; }
        .attendance-card { padding: 12px; }
        .attendance-card-value { font-size: 21px; }
        .attendance-panel-head, .attendance-calendar { padding-right: 14px; padding-left: 14px; }
        .attendance-note, .attendance-legend { padding-right: 14px; padding-left: 14px; }
        .attendance-record { grid-template-columns: minmax(0, 1fr) minmax(0, 1fr); gap: 7px 10px; padding: 12px 14px; }
        .attendance-record-note { grid-column: 1 / -1; }
    }
    @media (max-width: 480px) {
        .attendance-calendar-grid { display: none; }
        .attendance-mobile-calendar { display: grid; gap: 6px; }
        .attendance-mobile-day { display: flex; min-width: 0; align-items: center; justify-content: space-between; gap: 8px; padding: 7px 9px; border-radius: 9px; background: #FAF9FD; font-size: 11.5px; }
        .attendance-mobile-day-label { min-width: 0; overflow-wrap: anywhere; }
        .attendance-mobile-day .score { min-width: 58px; padding: 3px 7px; font-size: 10.5px; }
        .attendance-month-nav { gap: 6px; }
        .attendance-month-nav a { padding: 0 8px; }
        .attendance-month-label { min-width: 0; }
        .attendance-filter { width: 100%; }
        .attendance-filter label { flex: 1 1 100px; }
        .attendance-filter input, .attendance-filter select { width: 100%; }
        .attendance-shared-filter { gap: 8px; padding: 12px; }
        .attendance-shared-filter label { flex-basis: calc(50% - 8px); }
        .attendance-shared-filter label:first-child { flex-basis: 100%; }
        .attendance-filter-actions { flex: 1 1 100%; justify-content: flex-start; }
        .attendance-marker { min-width: 20px; height: 19px; padding: 0 4px; font-size: 10px; }
    }
</style>
@endpush

@section('content')
<div class="attendance-page">
    <header class="attendance-heading">
        <div>
            <h1>Attendance</h1>
            <p class="attendance-intro">Your recorded attendance for {{ $monthStart->format('F Y') }}.</p>
            <div class="attendance-context">
                @if($enrollment?->grade)
                    <span><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i>{{ $enrollment->grade->full_name }}</span>
                @endif
                @if($academicYear)
                    <span><i class="fa-regular fa-calendar" aria-hidden="true"></i>{{ $academicYear->name }}</span>
                @endif
            </div>
        </div>
    </header>

    <form class="attendance-shared-filter" method="GET" action="{{ route('student.attendance') }}">
        <label>Month
            <input type="month" name="month" value="{{ $monthStart->format('Y-m') }}">
        </label>
        <label>Period
            <select name="period">
                <option value="">All periods</option>
                @foreach($periods as $period)
                    <option value="{{ $period->id }}" @selected($periodFilter === (int) $period->id)>{{ $period->name }}</option>
                @endforeach
            </select>
        </label>
        <label>Subject
            <select name="subject">
                <option value="">All subjects</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}" @selected($subjectFilter === (int) $subject->id)>{{ $subject->name }}</option>
                @endforeach
            </select>
        </label>
        @if($statusFilter)
            <input type="hidden" name="status" value="{{ $statusFilter }}">
        @endif
        <div class="attendance-filter-actions">
            <button class="attendance-filter-button" type="submit">Apply</button>
            <a class="attendance-reset" href="{{ route('student.attendance', ['month' => $monthStart->format('Y-m')]) }}">Reset</a>
        </div>
    </form>
    @if($activeFilters)
        <p class="attendance-showing"><strong>Showing:</strong> {{ implode(', ', $activeFilters) }}</p>
    @endif

    <section class="attendance-summary" aria-label="Attendance summary for {{ $monthStart->format('F Y') }}">
        <article class="attendance-card attendance-card--present"><span class="attendance-card-label">Days present</span><strong class="attendance-card-value">{{ $daysPresent }}</strong></article>
        <article class="attendance-card attendance-card--absent"><span class="attendance-card-label">Days absent</span><strong class="attendance-card-value">{{ $daysAbsent }}</strong></article>
        <article class="attendance-card attendance-card--late"><span class="attendance-card-label">Days late</span><strong class="attendance-card-value">{{ $daysLate }}</strong></article>
        <article class="attendance-card attendance-card--excused"><span class="attendance-card-label">Days excused</span><strong class="attendance-card-value">{{ $daysExcused }}</strong></article>
        <article class="attendance-card attendance-card--rate-{{ $rateClass }}"><span class="attendance-card-label">Attendance rate</span><strong class="attendance-card-value">{{ $attendanceRate }}%</strong></article>
    </section>

    <section class="attendance-panel" aria-labelledby="attendance-calendar-title">
        <div class="attendance-panel-head">
            <h2 id="attendance-calendar-title">Monthly attendance</h2>
            <nav class="attendance-month-nav" aria-label="Attendance month">
                <a href="{{ route('student.attendance', array_merge($monthQuery, ['month' => $previousMonth])) }}" aria-label="Previous month"><i class="fa-solid fa-chevron-left" aria-hidden="true"></i><span class="sr-only">Previous month</span></a>
                <span class="attendance-month-label">{{ $monthStart->format('F Y') }}</span>
                <a href="{{ route('student.attendance', array_merge($monthQuery, ['month' => $nextMonth])) }}" aria-label="Next month"><i class="fa-solid fa-chevron-right" aria-hidden="true"></i><span class="sr-only">Next month</span></a>
                <a href="{{ route('student.attendance', array_merge($monthQuery, ['month' => now()->format('Y-m')])) }}">This month</a>
            </nav>
        </div>
        <div class="attendance-calendar">
            <div class="attendance-calendar-grid" role="grid" aria-label="{{ $monthStart->format('F Y') }} calendar">
                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $weekday)
                    <span class="attendance-weekday" role="columnheader">{{ $weekday }}</span>
                @endforeach
                @foreach($calendarWeeks as $week)
                    @foreach($week as $day)
                        @if($day)
                            @php
                                $dayLabel = $day['status'] ? ucfirst($day['status']) : 'No record';
                                $dayBadge = ['present' => 'P', 'absent' => 'A', 'late' => 'L'][$day['status'] ?? ''] ?? 'null';
                            @endphp
                            <div class="attendance-day" role="gridcell" aria-label="{{ $day['date']->format('l, F j') }}, {{ $dayLabel }}">
                                <span class="attendance-day-number">{{ $day['date']->day }}</span>
                                <span class="attendance-marker {{ $day['status'] ? 'attendance-marker--'.$day['status'] : '' }}" aria-hidden="true">{{ $dayBadge }}</span>
                            </div>
                        @else
                            <span class="attendance-day attendance-day--empty" aria-hidden="true"></span>
                        @endif
                    @endforeach
                @endforeach
            </div>
            <div class="attendance-mobile-calendar" aria-label="{{ $monthStart->format('F Y') }} attendance calendar">
                @foreach($days as $day)
                    <div class="attendance-mobile-day">
                        <span class="attendance-mobile-day-label">{{ $day['date']->format('D, M j') }}</span>
                        @if($day['status'])
                            <span class="score score--{{ $day['status'] }}">{{ ucfirst($day['status']) }}</span>
                        @else
                            <span class="score score--none">No record</span>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        <div class="attendance-legend" aria-label="Attendance status legend">
            <span class="attendance-legend-item"><span class="attendance-marker attendance-marker--present" aria-label="Present">P</span>Present</span>
            <span class="attendance-legend-item"><span class="attendance-marker attendance-marker--absent" aria-label="Absent">A</span>Absent</span>
            <span class="attendance-legend-item"><span class="attendance-marker attendance-marker--late" aria-label="Late">L</span>Late</span>
            <span class="attendance-legend-item"><span class="attendance-marker" aria-label="No record">null</span>No record</span>
        </div>
        <p class="attendance-note">A day with multiple period marks is summarized as absent if any mark is absent; otherwise late if any mark is late.</p>
    </section>

    <section class="attendance-panel" aria-labelledby="attendance-records-title">
        <div class="attendance-panel-head">
            <div>
                <h2 id="attendance-records-title">Attendance records</h2>
                <p class="attendance-intro">Period and subject marks recorded for this month.</p>
            </div>
            <form class="attendance-filter" method="GET" action="{{ route('student.attendance') }}">
                <input type="hidden" name="month" value="{{ $monthStart->format('Y-m') }}">
                @if($periodFilter)
                    <input type="hidden" name="period" value="{{ $periodFilter }}">
                @endif
                @if($subjectFilter)
                    <input type="hidden" name="subject" value="{{ $subjectFilter }}">
                @endif
                <label>Status
                    <select name="status">
                        <option value="">All statuses</option>
                        @foreach(['present', 'absent', 'late'] as $status)
                            <option value="{{ $status }}" @selected($statusFilter === $status)>{{ ucfirst($status) }}</option>
                        @endforeach
                    </select>
                </label>
                <button class="attendance-filter-button" type="submit">Apply</button>
            </form>
        </div>

        @if($monthRecordCount === 0)
            <div class="attendance-empty">
                <i class="fa-regular fa-calendar-xmark" aria-hidden="true"></i>
                <strong>No attendance has been recorded for this period yet</strong>
                <span>Records will appear here when your school marks attendance.</span>
            </div>
        @elseif($daysRecorded === 0)
            <div class="attendance-empty">
                <i class="fa-solid fa-filter-circle-xmark" aria-hidden="true"></i>
                <strong>No attendance matches the selected filters</strong>
                <a class="attendance-reset" href="{{ route('student.attendance', ['month' => $monthStart->format('Y-m')]) }}">Reset filters</a>
            </div>
        @elseif($records->isEmpty())
            <div class="attendance-empty">
                <strong>No records match this status filter.</strong>
                <a class="attendance-reset" href="{{ route('student.attendance', ['month' => $monthStart->format('Y-m'), 'period' => $periodFilter, 'subject' => $subjectFilter]) }}">Reset status filter</a>
            </div>
        @else
            <div class="attendance-records">
                @foreach($records as $record)
                    <article class="attendance-record">
                        <span class="attendance-record-date">{{ $record->date->format('M j, Y') }}<br><span class="attendance-intro">{{ $record->date->format('l') }}</span></span>
                        <span><span class="score score--{{ $record->status }}">{{ ucfirst($record->status) }}</span></span>
                        <span class="attendance-record-subject">{{ $record->period?->name ?? 'Period' }}</span>
                        <span class="attendance-record-subject">{{ $record->subject?->name ?? 'Subject' }}</span>
                        @if($record->remarks)
                            <span class="attendance-record-note"><strong>Teacher's note:</strong> {{ $record->remarks }}</span>
                        @else
                            <span class="attendance-record-note attendance-record-note--empty">No note</span>
                        @endif
                    </article>
                @endforeach
            </div>
            @if($records->hasPages())
                <nav class="attendance-pagination" aria-label="Attendance record pages">
                    <a href="{{ $records->previousPageUrl() ?: '#' }}" @if(!$records->previousPageUrl()) aria-disabled="true" @endif>Previous</a>
                    <span class="attendance-intro">Page {{ $records->currentPage() }} of {{ $records->lastPage() }}</span>
                    <a href="{{ $records->nextPageUrl() ?: '#' }}" @if(!$records->nextPageUrl()) aria-disabled="true" @endif>Next</a>
                </nav>
            @endif
        @endif
    </section>
</div>
@endsection
