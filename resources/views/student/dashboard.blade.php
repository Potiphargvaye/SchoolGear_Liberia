@extends('layouts.student')

@section('title', 'Dashboard')

@push('styles')
    <style>
        .dash { display: grid; min-width: 0; gap: 26px; }
        .dash > * { min-width: 0; }

        /* ---------- Welcome ---------- */
        .hero {
            position: relative;
            overflow: hidden;
            padding: 36px 38px 34px 44px;
            border-radius: 22px;
            background: var(--purple);
            color: #fff;
        }
        .hero::before {
            content: "";
            position: absolute; left: 0; top: 0; bottom: 0;
            width: 8px;
            background: var(--yellow);
        }
        .hero-gear {
            position: absolute;
            top: 50%; right: 0;
            width: min(40%, 260px); height: auto;
            color: #fff; opacity: .08;
            transform: translateY(-50%);
            pointer-events: none;
        }
        .hero-copy { position: relative; max-width: 680px; min-width: 0; }
        .hero-lead { margin: 0 0 8px; color: #D9D4F5; font-size: 14px; }
        .hero-title {
            margin: 0;
            font-size: clamp(26px, 4.6vw, 40px);
            font-weight: 600;
            line-height: 1.15;
            letter-spacing: -.01em;
            overflow-wrap: anywhere;
        }
        .hero-school {
            display: flex; min-width: 0; align-items: flex-start; gap: 11px;
            margin: 16px 0 0;
            color: #F1EEFF; font-size: 16px; font-weight: 500; line-height: 1.4;
        }
        .hero-school i { margin-top: 3px; color: var(--yellow); }
        .hero-school > span { min-width: 0; overflow-wrap: anywhere; }
        .hero-facts { display: flex; flex-wrap: wrap; gap: 10px; margin-top: 26px; }
        .hero-fact {
            display: inline-flex; flex-wrap: wrap; align-items: baseline; gap: 4px 9px;
            min-width: 0; max-width: 100%;
            padding: 9px 15px;
            border-radius: 12px;
            background: rgba(255, 255, 255, .12);
            font-size: 13px;
        }
        .hero-fact span { color: #D9D4F5; }
        .hero-fact > span, .hero-fact strong { min-width: 0; max-width: 100%; overflow-wrap: anywhere; }

        /* ---------- At a glance ---------- */
        .glance { overflow: hidden; border: 1px solid var(--line); border-radius: 20px; background: #fff; }
        .section-head { padding: 22px 26px 0; }
        .section-title { margin: 0; font-size: 17px; font-weight: 600; }
        .section-copy { margin: 4px 0 0; color: var(--muted); font-size: 13px; }
        .glance-grid { display: grid; min-width: 0; grid-template-columns: repeat(3, minmax(0, 1fr)); margin-top: 20px; border-top: 1px solid var(--line); }
        .glance-item { display: flex; min-width: 0; align-items: flex-start; gap: 15px; padding: 22px 26px 24px; }
        .glance-item + .glance-item { border-left: 1px solid var(--line); }
        .glance-icon {
            display: inline-flex;
            width: 44px; height: 44px; flex: 0 0 44px;
            align-items: center; justify-content: center;
            border-radius: 13px; font-size: 17px;
        }
        .glance-icon--purple { background: #ECE8FF; color: var(--purple-bright); }
        .glance-icon--blue { background: #DDF1FB; color: #0B6AA2; }
        .glance-icon--yellow { background: var(--yellow-soft); color: var(--yellow-ink); }
        .glance-body { min-width: 0; }
        .glance-label { display: block; color: var(--muted); font-size: 12.5px; }
        .glance-value {
            display: block; margin-top: 4px;
            font-size: 20px; font-weight: 600; line-height: 1.3;
            overflow-wrap: anywhere;
        }
        .glance-detail { display: block; margin-top: 3px; color: var(--muted); font-size: 12.5px; line-height: 1.5; }

        /* ---------- Quick links ---------- */
        .quick-grid { display: grid; min-width: 0; grid-template-columns: repeat(4, minmax(0, 1fr)); gap: 14px; margin-top: 16px; }
        .quick-tile {
            display: flex; min-width: 0; flex-direction: column; gap: 18px;
            padding: 18px;
            border-radius: 16px;
            text-align: left; text-decoration: none;
        }
        .quick-tile--open {
            border: 1px solid var(--line);
            background: #fff; color: var(--ink);
            transition: border-color .15s ease, box-shadow .15s ease;
        }
        .quick-tile--open:hover { border-color: var(--purple-bright); box-shadow: 0 6px 20px rgba(58, 42, 153, .1); }
        .quick-tile--soon {
            border: 1px dashed #D3D0E3;
            background: transparent; color: var(--muted);
            cursor: not-allowed;
        }
        .quick-top { display: flex; align-items: center; justify-content: space-between; gap: 10px; }
        .quick-icon {
            display: inline-flex;
            width: 40px; height: 40px;
            align-items: center; justify-content: center;
            border-radius: 12px;
            background: #ECE8FF; color: var(--purple-bright);
        }
        .quick-tile--soon .quick-icon { background: #EEEDF4; color: #8D8AA3; }
        .quick-go { color: var(--purple-bright); font-size: 13px; }
        .quick-soon {
            padding: 3px 9px;
            border-radius: 20px;
            background: var(--yellow-soft); color: var(--yellow-ink);
            font-size: 11px; font-weight: 600;
        }
        .quick-title { display: block; font-size: 15px; font-weight: 600; }
        .quick-note { display: block; margin-top: 2px; color: var(--muted); font-size: 12.5px; line-height: 1.5; }

        /* ---------- Fees overview + announcements ---------- */
        .dash-split { display: grid; min-width: 0; grid-template-columns: minmax(0, 1.1fr) minmax(0, 1fr); gap: 22px; }
        .panel { display: flex; min-width: 0; flex-direction: column; border: 1px solid var(--line); border-radius: 20px; background: #fff; }
        .panel-head { display: flex; min-width: 0; align-items: flex-start; justify-content: space-between; gap: 12px; padding: 22px 26px 0; }
        .panel-head > div { min-width: 0; }
        .sample-tag {
            flex: 0 0 auto;
            padding: 3px 10px;
            border: 1px dashed var(--yellow-line);
            border-radius: 20px;
            background: var(--yellow-soft); color: var(--yellow-ink);
            font-size: 11px; font-weight: 600; white-space: nowrap;
        }
        .fees-body { display: flex; flex: 1 1 auto; flex-direction: column; gap: 18px; padding: 20px 26px 24px; }
        .fees-balance { display: flex; flex-wrap: wrap; align-items: center; gap: 6px 14px; }
        .fees-balance-label { flex: 0 0 100%; color: var(--muted); font-size: 12.5px; }
        .fees-balance-value { font-size: 30px; font-weight: 600; line-height: 1.15; letter-spacing: -.01em; font-variant-numeric: tabular-nums; }
        .fees-status { padding: 4px 11px; border-radius: 20px; font-size: 12px; font-weight: 600; }
        .fees-status--due { background: var(--yellow-soft); color: var(--yellow-ink); }
        .fees-status--clear { background: #DCF4E4; color: #14703B; }
        .fees-meter { height: 10px; overflow: hidden; border-radius: 999px; background: #ECEAF5; }
        .fees-meter span { display: block; height: 100%; border-radius: 999px; background: var(--purple-bright); }
        .fees-lines { display: grid; grid-template-columns: repeat(3, minmax(0, 1fr)); gap: 12px; margin: 0; }
        .fees-lines div { min-width: 0; padding: 12px 14px; border-radius: 12px; background: var(--surface); }
        .fees-lines dt { color: var(--muted); font-size: 12px; }
        .fees-lines dd { margin: 3px 0 0; font-size: 15px; font-weight: 600; font-variant-numeric: tabular-nums; overflow-wrap: anywhere; }
        .news-list { display: grid; margin: 0; padding: 8px 26px 12px; list-style: none; }
        .news-item { padding: 14px 0; border-bottom: 1px solid var(--line); }
        .news-item:last-child { border-bottom: 0; }
        .news-title { display: block; font-size: 14px; font-weight: 600; overflow-wrap: anywhere; }
        .news-date { display: block; margin-top: 2px; color: var(--muted); font-size: 12px; }
        .news-empty { display: flex; flex: 1 1 auto; flex-direction: column; align-items: center; justify-content: center; padding: 34px 26px 40px; text-align: center; }
        .news-empty-icon {
            display: inline-flex; width: 52px; height: 52px;
            align-items: center; justify-content: center;
            border-radius: 50%;
            background: var(--yellow-soft); color: var(--yellow-ink); font-size: 19px;
        }
        .news-empty h3 { margin: 14px 0 4px; font-size: 15px; font-weight: 600; }
        .news-empty p { max-width: 280px; margin: 0; color: var(--muted); font-size: 13px; }

        @media (max-width: 1100px) {
            .quick-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
            .dash-split { grid-template-columns: 1fr; }
        }
        @media (max-width: 820px) {
            .glance-grid { grid-template-columns: 1fr; }
            .glance-item + .glance-item { border-left: 0; border-top: 1px solid var(--line); }
        }
        @media (max-width: 600px) {
            .dash { gap: 20px; }
            .hero { padding: 26px 22px 26px 28px; border-radius: 18px; }
            .hero::before { width: 6px; }
            .hero-gear { right: 0; width: min(45%, 180px); }
            .hero-school { font-size: 14.5px; }
            .hero-facts { gap: 8px; margin-top: 20px; }
            .hero-fact { padding: 8px 12px; font-size: 12.5px; }
            .section-head { padding: 18px 18px 0; }
            .glance-item { padding: 18px; }
            .glance-value { font-size: 18px; }
            .panel-head { padding: 18px 18px 0; }
            .fees-body { padding: 18px; }
            .fees-balance-value { font-size: 26px; }
            .fees-lines { grid-template-columns: 1fr 1fr; }
            .fees-lines div:first-child { grid-column: 1 / -1; }
            .news-list { padding: 6px 18px 10px; }
            .news-empty { padding: 28px 18px 32px; }
            .quick-grid { gap: 10px; }
            .quick-tile { gap: 14px; padding: 14px; }
        }
        @media (max-width: 360px) {
            .quick-grid { grid-template-columns: 1fr; }
        }
    </style>
@endpush

@section('content')
    @php
        // Fees overview. Until the controller passes a real $feesOverview, sample figures are shown and tagged as sample data.
        // Expected shape when wired: ['symbol' => '$', 'total' => 1200.00, 'paid' => 750.00]
        $feesIsSample = ! isset($feesOverview);
        $fees = $feesOverview ?? ['symbol' => '$', 'total' => 1200.00, 'paid' => 750.00];
        $feesTotal = (float) $fees['total'];
        $feesPaid = (float) $fees['paid'];
        $feesBalance = max($feesTotal - $feesPaid, 0);
        $feesPercent = $feesTotal > 0 ? min(100, round($feesPaid / $feesTotal * 100)) : 0;

        // Recent announcements. Empty for now; pass a collection as $recentAnnouncements (items with title and created_at) to fill it.
        $announcements = $recentAnnouncements ?? collect();
    @endphp

    <div class="dash">
        <section class="hero" aria-labelledby="welcome-title">
            <svg class="hero-gear" viewBox="0 0 200 200" fill="none" stroke="currentColor" aria-hidden="true" focusable="false">
                <circle cx="100" cy="100" r="78" stroke-width="22" stroke-dasharray="20.42 20.42"/>
                <circle cx="100" cy="100" r="64" stroke-width="12"/>
                <circle cx="100" cy="100" r="30" stroke-width="12"/>
            </svg>
            <div class="hero-copy">
                <p class="hero-lead">Your learning overview</p>
                <h1 class="hero-title" id="welcome-title">Welcome, {{ $user->name }}</h1>
                <p class="hero-school">
                    <i class="fa-solid fa-school" aria-hidden="true"></i>
                    <span>
                        @if($school)
                            {{ $school->school_name }}
                        @else
                            Your school portal
                        @endif
                    </span>
                </p>
                <div class="hero-facts">
                    <span class="hero-fact"><span>Registration ID</span><strong>{{ $user->registration_id ?: 'Not available' }}</strong></span>
                    <span class="hero-fact">
                        <span>Class</span>
                        <strong>
                            @if($enrollment && $enrollment->grade)
                                {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' '.$enrollment->grade->section : '' }}
                            @else
                                Not assigned
                            @endif
                        </strong>
                    </span>
                    @if($academicYear)
                        <span class="hero-fact"><span>Academic year</span><strong>{{ $academicYear->name }}</strong></span>
                    @endif
                </div>
            </div>
        </section>

        <section class="glance" aria-labelledby="overview-title">
            <div class="section-head">
                <h2 class="section-title" id="overview-title">Overview</h2>
                <p class="section-copy">Your current class and recorded academic information.</p>
            </div>
            <div class="glance-grid">
                <article class="glance-item">
                    <span class="glance-icon glance-icon--purple"><i class="fa-solid fa-graduation-cap" aria-hidden="true"></i></span>
                    <div class="glance-body">
                        <span class="glance-label">Current class</span>
                        <span class="glance-value">
                            @if($enrollment && $enrollment->grade)
                                {{ $enrollment->grade->level }}{{ $enrollment->grade->section ? ' '.$enrollment->grade->section : '' }}
                            @else
                                Not assigned
                            @endif
                        </span>
                        <span class="glance-detail">
                            @if($academicYear)
                                {{ $academicYear->name }}
                            @else
                                No active academic year
                            @endif
                        </span>
                    </div>
                </article>
                <article class="glance-item">
                    <span class="glance-icon glance-icon--blue"><i class="fa-solid fa-book-open" aria-hidden="true"></i></span>
                    <div class="glance-body">
                        <span class="glance-label">Subjects with grades</span>
                        <span class="glance-value">{{ $grades->count() }}</span>
                        <span class="glance-detail">{{ $grades->count() === 1 ? 'Recorded subject' : 'Recorded subjects' }} for this enrollment</span>
                    </div>
                </article>
                <article class="glance-item">
                    <span class="glance-icon glance-icon--yellow"><i class="fa-solid fa-clock-rotate-left" aria-hidden="true"></i></span>
                    <div class="glance-body">
                        <span class="glance-label">Latest grade update</span>
                        @if($latestGrade)
                            <span class="glance-value">{{ $latestGrade->subject->name ?? 'Recorded grade' }}</span>
                            <span class="glance-detail">Published {{ $latestGradePublishedAt?->format('M j, Y') }}</span>
                        @else
                            <span class="glance-value">No grades yet</span>
                            <span class="glance-detail">Grade updates will appear here when recorded.</span>
                        @endif
                    </div>
                </article>
            </div>
        </section>

        <div class="dash-split">
            <section class="panel" aria-labelledby="fees-title">
                <div class="panel-head">
                    <div>
                        <h2 class="section-title" id="fees-title">Fees overview</h2>
                        <p class="section-copy">Your fees for this academic year.</p>
                    </div>
                    @if($feesIsSample)
                        <span class="sample-tag">Sample data</span>
                    @endif
                </div>
                <div class="fees-body">
                    <div class="fees-balance">
                        <span class="fees-balance-label">Balance</span>
                        <span class="fees-balance-value">{{ $fees['symbol'] }}{{ number_format($feesBalance, 2) }}</span>
                        @if($feesBalance > 0)
                            <span class="fees-status fees-status--due">Balance due</span>
                        @else
                            <span class="fees-status fees-status--clear">Fully paid</span>
                        @endif
                    </div>
                    <div class="fees-meter" role="img" aria-label="{{ $feesPercent }}% of fees paid">
                        <span style="width: {{ $feesPercent }}%"></span>
                    </div>
                    <dl class="fees-lines">
                        <div><dt>Total assigned</dt><dd>{{ $fees['symbol'] }}{{ number_format($feesTotal, 2) }}</dd></div>
                        <div><dt>Paid</dt><dd>{{ $fees['symbol'] }}{{ number_format($feesPaid, 2) }}</dd></div>
                        <div><dt>Paid so far</dt><dd>{{ $feesPercent }}%</dd></div>
                    </dl>
                </div>
            </section>

            <section class="panel" aria-labelledby="news-title">
                <div class="panel-head">
                    <div>
                        <h2 class="section-title" id="news-title">Recent announcements</h2>
                        <p class="section-copy">The latest news from your school.</p>
                    </div>
                </div>
                @if($announcements->isEmpty())
                    <div class="news-empty">
                        <span class="news-empty-icon"><i class="fa-solid fa-bullhorn" aria-hidden="true"></i></span>
                        <h3>No announcements yet</h3>
                        <p>When your school posts an announcement, it will appear here.</p>
                    </div>
                @else
                    <ul class="news-list">
                        @foreach($announcements as $announcement)
                            <li class="news-item">
                                <span class="news-title">{{ data_get($announcement, 'title') }}</span>
                                @if(data_get($announcement, 'created_at'))
                                    <span class="news-date">{{ \Illuminate\Support\Carbon::parse(data_get($announcement, 'created_at'))->format('M j, Y') }}</span>
                                @endif
                            </li>
                        @endforeach
                    </ul>
                @endif
            </section>
        </div>

        <section aria-labelledby="quick-title">
            <h2 class="section-title" id="quick-title">Quick links</h2>
            <p class="section-copy">Open a portal section.</p>
            <div class="quick-grid">
                <a class="quick-tile quick-tile--open" href="{{ route('student.grades') }}">
                    <span class="quick-top">
                        <span class="quick-icon"><i class="fa-solid fa-chart-column" aria-hidden="true"></i></span>
                        <i class="fa-solid fa-arrow-right quick-go" aria-hidden="true"></i>
                    </span>
                    <span>
                        <span class="quick-title">Grades</span>
                        <span class="quick-note">See your scores by period and semester.</span>
                    </span>
                </a>
                <a class="quick-tile quick-tile--open" href="{{ route('student.attendance') }}">
                    <span class="quick-top">
                        <span class="quick-icon"><i class="fa-solid fa-calendar-check" aria-hidden="true"></i></span>
                        <i class="fa-solid fa-arrow-right quick-go" aria-hidden="true"></i>
                    </span>
                    <span>
                        <span class="quick-title">Attendance</span>
                        <span class="quick-note">Your attendance record.</span>
                    </span>
                </a>
                @foreach([
                    ['label' => 'Fees', 'icon' => 'fa-wallet', 'note' => 'Fee balance and payments.'],
                    ['label' => 'Announcements', 'icon' => 'fa-bullhorn', 'note' => 'News from your school.'],
                ] as $item)
                    <button class="quick-tile quick-tile--soon" type="button" disabled aria-disabled="true">
                        <span class="quick-top">
                            <span class="quick-icon"><i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i></span>
                            <span class="quick-soon">Soon</span>
                        </span>
                        <span>
                            <span class="quick-title">{{ $item['label'] }}</span>
                            <span class="quick-note">{{ $item['note'] }}</span>
                        </span>
                    </button>
                @endforeach
            </div>
        </section>
    </div>
@endsection
