@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')
    {{-- ================================================================
         Admin Dashboard — Figma design (exact visual reproduction)
         Real data: students, fees, admissions, announcements, enrollments
         Mock data: attendance (module not yet implemented in the system)
         Theme: light / dark via body.sg-theme-* classes (navbar toggle)
         ================================================================ --}}

    <style>
        /* ---- Figma design tokens ---- */
        body.sg-theme-light {
            --sg-bg: #F4F6FE;
            --sg-surface: #FFFFFF;
            --sg-text-primary: #1E2438;
            --sg-text-secondary: #64748B;
            --sg-border: #E8ECF5;
            --sg-subtle: #F9FAFD;
            --sg-shadow: 0 2px 12px rgba(91, 61, 224, 0.06), 0 1px 3px rgba(0, 0, 0, 0.04);
        }

        body.sg-theme-dark {
            --sg-bg: #0B1526;
            --sg-surface: #111E33;
            --sg-text-primary: #F1F5FD;
            --sg-text-secondary: #94A6C4;
            --sg-border: rgba(255, 255, 255, 0.08);
            --sg-subtle: rgba(255, 255, 255, 0.04);
            --sg-shadow: 0 2px 16px rgba(0, 0, 0, 0.4);
        }

        body.sg-theme-light,
        body.sg-theme-dark {
            --sg-primary: #5B3DE0;
            --sg-violet: #6E4BF0;
            --sg-violet-light: #A78BFF;
            --sg-sky: #38BDF8;
            --sg-sky-light: #5FD0FA;
            --sg-accent: #FFE29A;
            --sg-success: #2E7D5B;
            --sg-danger: #F84525;
        }

        /*
                 * The page's <body> (in layouts/admin.blade.php) carries a fixed
                 * Tailwind class — bg-[#F8FAFC] — that never changes with the
                 * theme toggle, and the ".dashboard-glass" wrapper it's rendered
                 * inside can still inherit blur/background chrome from the old
                 * templatemo-glass-admin-style.css stylesheet that's linked in
                 * <head>. We don't touch the layout file — instead we repaint the
                 * body itself from here and strip any glass leftovers on every
                 * ancestor between <body> and our own .sg-dash container, in both
                 * themes, so only these Figma tokens ever decide the background.
                 */
        body.sg-theme-light,
        body.sg-theme-dark {
            background: var(--sg-bg) !important;
            transition: background 0.25s ease;
        }

        body.sg-theme-light .dashboard-glass,
        body.sg-theme-dark .dashboard-glass,
        body.sg-theme-light main.main,
        body.sg-theme-dark main.main,
        body.sg-theme-light section,
        body.sg-theme-dark section {
            background: transparent !important;
            backdrop-filter: none !important;
            -webkit-backdrop-filter: none !important;
            box-shadow: none !important;
            border: none !important;
        }

        /* Neutralize the old glass-admin dashboard chrome for this page */
        .sg-dash {
            background: transparent !important;
            padding: 0 !important;
        }

        .sg-dash .sg-card {
            background: var(--sg-surface);
            border: 1px solid var(--sg-border);
            border-radius: 16px;
            box-shadow: var(--sg-shadow);
            transition: background 0.25s ease, border-color 0.25s ease;
        }

        .sg-dash .sg-card-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            flex-wrap: wrap;
            padding: 20px 24px;
            border-bottom: 1px solid var(--sg-border);
        }

        .sg-dash .sg-card-title {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: var(--sg-text-primary);
        }

        .sg-dash .sg-text-primary {
            color: var(--sg-text-primary);
        }

        .sg-dash .sg-text-secondary {
            color: var(--sg-text-secondary);
        }

        .sg-dash .sg-page-title {
            font-size: 24px;
            font-weight: 800;
            color: var(--sg-text-primary);
            margin: 0;
            line-height: 1.25;
        }

        .sg-dash .sg-page-sub {
            font-size: 13px;
            color: var(--sg-text-secondary);
            margin: 4px 0 0;
        }

        .sg-dash .sg-hero {
            background: linear-gradient(120deg, rgba(91, 61, 224, 0.12) 0%, rgba(56, 189, 248, 0.08) 100%);
            border: 1px solid rgba(91, 61, 224, 0.12);
            border-radius: 20px;
            padding: 22px 24px;
            margin-bottom: 24px;
        }

        .sg-dash .sg-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 12.5px;
            font-weight: 600;
            border-radius: 8px;
            padding: 6px 12px;
            line-height: 1;
        }

        .sg-dash .sg-kicker {
            font-size: 11px;
            font-weight: 700;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: var(--sg-text-secondary);
            margin: 0;
        }

        .sg-dash .sg-big {
            font-size: 30px;
            font-weight: 900;
            line-height: 1;
            color: var(--sg-text-primary);
        }

        .sg-dash .sg-icon-box {
            width: 42px;
            height: 42px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .sg-dash .sg-trend {
            font-size: 11px;
            font-weight: 700;
            border-radius: 6px;
            padding: 2px 6px;
        }

        /* ---- Layout grids (mirrors the Figma responsive rules) ---- */
        .sg-dash .sg-kpi-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 16px;
            margin-bottom: 24px;
        }

        .sg-dash .sg-attend-grid {
            display: grid;
            grid-template-columns: 1fr 220px;
        }

        .sg-dash .sg-attend-grid .sg-rail {
            border-left: 1px solid var(--sg-border);
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .sg-dash .sg-fee-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
        }

        .sg-dash .sg-fee-grid .sg-fee-cell {
            padding: 20px;
        }

        .sg-dash .sg-fee-grid .sg-fee-cell+.sg-fee-cell {
            border-left: 1px solid var(--sg-border);
        }

        .sg-dash .sg-two-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 16px;
            margin-bottom: 24px;
        }

        .sg-dash .sg-fee-kpi-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            padding: 16px 24px;
            border-bottom: 1px solid var(--sg-border);
        }

        .sg-dash .sg-fee-kpi {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--sg-subtle);
            border: 1px solid var(--sg-border);
            border-radius: 12px;
            padding: 12px 16px;
        }

        .sg-dash .sg-bar-strip {
            height: 6px;
            border-radius: 99px;
            background: var(--sg-border);
            overflow: hidden;
        }

        .sg-dash .sg-bar-strip .sg-fill {
            height: 100%;
            border-radius: 99px;
            transition: width 0.3s ease;
        }

        .sg-dash .sg-pipeline-row {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .sg-dash .sg-pipeline-row .sg-dot {
            width: 8px;
            height: 8px;
            border-radius: 99px;
            flex-shrink: 0;
            display: inline-block;
        }

        .sg-dash .sg-pipeline-track {
            height: 6px;
            width: 120px;
            border-radius: 99px;
            background: var(--sg-border);
            overflow: hidden;
        }

        .sg-dash .sg-pipeline-track .sg-fill {
            height: 100%;
            border-radius: 99px;
        }

        .sg-dash .sg-list-row {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 0;
        }

        .sg-dash .sg-list-row+.sg-list-row {
            border-top: 1px solid var(--sg-border);
        }

        .sg-dash .sg-avatar {
            width: 32px;
            height: 32px;
            border-radius: 99px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 800;
            color: #fff;
            flex-shrink: 0;
        }

        .sg-dash .sg-status {
            font-size: 10px;
            font-weight: 700;
            border-radius: 99px;
            padding: 3px 8px;
            border: 1px solid transparent;
            flex-shrink: 0;
        }

        .sg-dash .sg-status-paid {
            background: rgba(46, 125, 91, 0.12);
            color: #2E7D5B;
            border-color: rgba(46, 125, 91, 0.2);
        }

        .sg-dash .sg-status-partial {
            background: rgba(56, 189, 248, 0.12);
            color: #0284C7;
            border-color: rgba(56, 189, 248, 0.2);
        }

        .sg-dash .sg-status-pending {
            background: rgba(167, 139, 255, 0.15);
            color: #7C3AED;
            border-color: rgba(167, 139, 255, 0.2);
        }

        .sg-dash .sg-status-overdue {
            background: rgba(248, 69, 37, 0.12);
            color: #F84525;
            border-color: rgba(248, 69, 37, 0.2);
        }

        .sg-dash .sg-tabs {
            display: inline-flex;
            background: var(--sg-subtle);
            border: 1px solid var(--sg-border);
            border-radius: 9px;
            padding: 3px;
            gap: 2px;
        }

        .sg-dash .sg-tabs button {
            font-size: 12px;
            font-weight: 600;
            padding: 5px 12px;
            border-radius: 7px;
            border: none;
            background: transparent;
            color: var(--sg-text-secondary);
            cursor: pointer;
            transition: all 0.15s;
        }

        .sg-dash .sg-tabs button.sg-active {
            background: var(--sg-primary);
            color: #fff;
        }

        .sg-dash .sg-quick-action {
            background: var(--sg-subtle);
            border: 1px solid var(--sg-border);
            border-radius: 12px;
            padding: 14px 10px;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 8px;
            text-decoration: none;
            transition: all 0.15s;
        }

        .sg-dash .sg-quick-action:hover {
            border-color: var(--sg-primary);
            background: rgba(91, 61, 224, 0.06);
        }

        .sg-dash .sg-quick-action span {
            font-size: 11px;
            font-weight: 600;
            color: var(--sg-text-primary);
            text-align: center;
            line-height: 1.3;
        }

        .sg-dash .sg-rail-stat {
            background: var(--sg-subtle);
            border: 1px solid var(--sg-border);
            border-radius: 12px;
            padding: 14px 16px;
        }

        .sg-dash .sg-rail-stat p.sg-rail-value {
            margin: 0;
            font-size: 26px;
            font-weight: 900;
            color: var(--sg-text-primary);
        }

        .sg-dash .sg-dot-legend {
            width: 10px;
            height: 10px;
            border-radius: 99px;
            display: inline-block;
            flex-shrink: 0;
        }

        .sg-dash .sg-footer {
            text-align: center;
            padding: 16px 0 24px;
            border-top: 1px solid var(--sg-border);
        }

        .sg-dash .sg-footer p {
            margin: 0;
            font-size: 11px;
            color: var(--sg-text-secondary);
        }

        @media (max-width: 1100px) {
            .sg-dash .sg-kpi-grid {
                grid-template-columns: repeat(2, 1fr) !important;
            }

            .sg-dash .sg-attend-grid {
                grid-template-columns: 1fr !important;
            }

            .sg-dash .sg-fee-grid {
                grid-template-columns: 1fr 1fr !important;
            }

            .sg-dash .sg-fee-grid>.sg-fee-cell:last-child {
                grid-column: 1 / 3 !important;
                border-left: none !important;
                border-top: 1px solid var(--sg-border);
            }

            .sg-dash .sg-fee-kpi-grid {
                grid-template-columns: 1fr !important;
            }

            .sg-dash .sg-attend-grid .sg-rail {
                border-left: none !important;
                border-top: 1px solid var(--sg-border);
            }
        }

        @media (max-width: 900px) {
            .sg-dash .sg-two-grid {
                grid-template-columns: 1fr !important;
            }
        }

        @media (max-width: 600px) {
            .sg-dash .sg-kpi-grid {
                grid-template-columns: 1fr !important;
            }

            .sg-dash .sg-fee-grid {
                grid-template-columns: 1fr !important;
            }

            .sg-dash .sg-fee-grid>.sg-fee-cell {
                grid-column: auto !important;
                border: none !important;
                border-bottom: 1px solid var(--sg-border) !important;
            }
        }
    </style>

    <div class="sg-dash" data-sg-dashboard>

        {{-- A. Greeting header --}}
        <div class="sg-hero flex items-center justify-between flex-wrap gap-4" x-data="{
            greeting: 'Good day',
            init() {
                const h = new Date().getHours();
                this.greeting = h < 12 ? 'Good morning' : (h < 17 ? 'Good afternoon' : 'Good evening');
            }
        }">
            <div>
                <h1 class="sg-page-title">
                    <span x-text="greeting"></span>, {{ auth()->user()->name }} &#128075;
                </h1>
                <p class="sg-page-sub">
                    {{ $school?->school_name ?? 'Your School' }} &middot;
                    Academic Year <strong>{{ $selectedYear?->name ?? 'All years' }}</strong>
                    &mdash; here's what's happening today.
                </p>
            </div>
            <div class="flex items-center gap-2.5">
                <span class="sg-chip"
                    style="background: rgba(255,255,255,0.6); color: #5B3DE0; border: 1px solid rgba(91,61,224,0.2);">
                    <i class="ri-calendar-event-line"></i> {{ $selectedYear?->name ?? 'All years' }}
                </span>
                <span class="sg-chip"
                    style="background: rgba(46,125,91,0.12); color: #2E7D5B; border: 1px solid rgba(46,125,91,0.2);">
                    {{ number_format($totalStudents) }} active enrollments
                </span>
            </div>
        </div>

        {{-- B. KPI cards --}}
        <div class="sg-kpi-grid">

            {{-- 1. Total Students (real) --}}
            <div class="sg-card">
                <div style="padding: 20px;">
                    <div class="flex items-start justify-between mb-3.5">
                        <div>
                            <p class="sg-kicker">Total Students</p>
                            <p class="sg-big" style="margin-top: 6px;" id="sg-student-count">
                                {{ number_format($totalStudents) }}</p>
                            <p class="sg-text-secondary" style="font-size: 12px; margin: 5px 0 0;">
                                {{ number_format($maleCount) }} male &middot; {{ number_format($femaleCount) }} female
                            </p>
                        </div>
                        <div class="sg-icon-box" style="background: rgba(91,61,224,0.1);">
                            <i class="ri-graduation-cap-line" style="color: #5B3DE0; font-size: 20px;"></i>
                        </div>
                    </div>

                    <div class="sg-tabs" id="sg-gender-tabs">
                        <button type="button" data-tab="all" class="flex-1 sg-active">All</button>
                        <button type="button" data-tab="male" class="flex-1">Male</button>
                        <button type="button" data-tab="female" class="flex-1">Female</button>
                    </div>

                    <div class="sg-bar-strip" style="margin-top: 10px; display: flex;">
                        <div
                            style="height: 100%; background: #38BDF8; width: {{ $totalStudents > 0 ? round(($maleCount / $totalStudents) * 100) : 0 }}%;">
                        </div>
                        <div style="flex: 1; background: #A78BFF;"></div>
                    </div>
                    <div class="flex justify-between" style="margin-top: 6px;">
                        <span class="sg-text-secondary"
                            style="font-size: 10px; display: inline-flex; align-items: center; gap: 4px;">
                            <span class="sg-dot-legend" style="width:7px;height:7px;background:#38BDF8;"></span> Male
                            {{ number_format($maleCount) }}
                        </span>
                        <span class="sg-text-secondary"
                            style="font-size: 10px; display: inline-flex; align-items: center; gap: 4px;">
                            <span class="sg-dot-legend" style="width:7px;height:7px;background:#A78BFF;"></span> Female
                            {{ number_format($femaleCount) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- 2. Fees Collected (real) --}}
            <div class="sg-card">
                <div style="padding: 20px;">
                    <div class="flex items-start justify-between">
                        <div style="flex: 1;">
                            <p class="sg-kicker">Fees Collected (LRD)</p>
                            <p class="sg-big" style="margin: 6px 0 0; font-size: 26px;">L$
                                {{ number_format($feesCollected) }}</p>
                            <p class="sg-text-secondary" style="font-size: 12px; margin: 5px 0 0;">
                                of L$ {{ number_format($feesAssigned) }} assigned
                            </p>
                            <div style="margin-top: 8px;">
                                <span class="sg-chip"
                                    style="background: rgba(46,125,91,0.1); color: #2E7D5B; padding: 2px 8px;">{{ $collectPct }}%
                                    collected</span>
                            </div>
                        </div>
                        <div style="position: relative; width: 56px; height: 56px; flex-shrink: 0;">
                            @php
                                $sgR = (56 - 5) / 2;
                                $sgCirc = 2 * pi() * $sgR;
                                $sgDash = ($collectPct / 100) * $sgCirc;
                            @endphp
                            <svg width="56" height="56" style="transform: rotate(-90deg);">
                                <defs>
                                    <linearGradient id="sgFeeGrad" x1="0" y1="0" x2="1"
                                        y2="1">
                                        <stop offset="0%" stop-color="#38BDF8" />
                                        <stop offset="100%" stop-color="#5B3DE0" />
                                    </linearGradient>
                                </defs>
                                <circle cx="28" cy="28" r="{{ $sgR }}" fill="none"
                                    stroke="rgba(91,61,224,0.12)" stroke-width="5" />
                                <circle cx="28" cy="28" r="{{ $sgR }}" fill="none"
                                    stroke="url(#sgFeeGrad)" stroke-width="5" stroke-linecap="round"
                                    stroke-dasharray="{{ $sgDash }} {{ $sgCirc }}" />
                            </svg>
                            <div
                                style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center;">
                                <span
                                    style="font-size: 11px; font-weight: 800; color: #5B3DE0;">{{ $collectPct }}%</span>
                            </div>
                        </div>
                    </div>
                    <div class="sg-bar-strip" style="margin-top: 16px;">
                        <div class="sg-fill"
                            style="width: {{ $collectPct }}%; background: linear-gradient(90deg,#38BDF8,#5B3DE0);"></div>
                    </div>
                    <div class="flex items-center gap-2" style="margin-top: 10px;">
                        <div
                            style="width: 32px; height: 32px; border-radius: 10px; background: rgba(56,189,248,0.1); display: flex; align-items: center; justify-content: center;">
                            <i class="ri-money-dollar-circle-line" style="color: #38BDF8; font-size: 16px;"></i>
                        </div>
                        <span class="sg-text-secondary" style="font-size: 12px;">
                            Outstanding: <strong style="color: #F84525;">L$ {{ number_format($feesOutstanding) }}</strong>
                        </span>
                    </div>
                </div>
            </div>

            {{-- 3. Attendance Rate (SAMPLE data — attendance module not yet implemented) --}}
            <div class="sg-card">
                <div style="padding: 20px;">
                    <div class="flex items-start justify-between mb-3.5">
                        <div>
                            <p class="sg-kicker">
                                Attendance Rate
                                <span class="sg-chip"
                                    style="background: rgba(255,226,154,0.25); color: #92660A; padding: 1px 6px; font-size: 9px; margin-left: 4px;">SAMPLE</span>
                            </p>
                            <p class="sg-big" style="margin-top: 6px;">93.4%</p>
                            <p class="sg-text-secondary" style="font-size: 12px; margin: 5px 0 0;">1,166 of 1,248 present
                            </p>
                            <div style="margin-top: 8px; display: flex; align-items: center; gap: 4px;">
                                <span class="sg-chip"
                                    style="background: rgba(46,125,91,0.1); color: #2E7D5B; padding: 2px 6px;">&#9650;
                                    1.1%</span>
                                <span class="sg-text-secondary" style="font-size: 11px;">vs yesterday</span>
                            </div>
                        </div>
                        <div class="sg-icon-box" style="background: rgba(56,189,248,0.1);">
                            <i class="ri-checkbox-circle-line" style="color: #38BDF8; font-size: 20px;"></i>
                        </div>
                    </div>
                    <div class="sg-bar-strip">
                        <div class="sg-fill" style="width: 93.4%; background: #38BDF8;"></div>
                    </div>
                    <div class="flex justify-between" style="margin-top: 8px;">
                        <span class="sg-text-secondary" style="font-size: 11px;">Target: 95%</span>
                        <span style="font-size: 11px; font-weight: 600; color: #F84525;">Absent: 82</span>
                    </div>
                </div>
            </div>

            {{-- 4. Pending Admissions (real) --}}
            <div class="sg-card">
                <div style="padding: 20px;">
                    <div class="flex items-start justify-between mb-3.5">
                        <div>
                            <p class="sg-kicker">Pending Admissions</p>
                            <p class="sg-big" style="margin-top: 6px;">{{ number_format($pendingAdmissions) }}</p>
                            <p class="sg-text-secondary" style="font-size: 12px; margin: 5px 0 0;">
                                {{ number_format($reviewedThisWeek) }} reviewed this week
                            </p>
                            <div style="margin-top: 8px;">
                                <span class="sg-chip"
                                    style="background: rgba(46,125,91,0.1); color: #2E7D5B; padding: 2px 6px;">
                                    &#9650; {{ number_format($reviewedThisWeek) }} new
                                </span>
                            </div>
                        </div>
                        <div class="sg-icon-box" style="background: rgba(255,226,154,0.2);">
                            <i class="ri-user-add-line" style="color: #D97706; font-size: 20px;"></i>
                        </div>
                    </div>
                    <a href="{{ route('admin.admissions.index') }}"
                        style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 7px;
                        background: rgba(91,61,224,0.1); border: 1px solid rgba(91,61,224,0.2); border-radius: 10px;
                        padding: 10px 0; font-size: 13px; font-weight: 600; color: #5B3DE0; text-decoration: none;">
                        <i class="ri-user-add-line"></i> Process Admissions
                    </a>
                </div>
            </div>
        </div>

        {{-- C. Attendance Overview (SAMPLE data — module not yet implemented) --}}
        <div class="sg-card" style="margin-bottom: 24px; overflow: hidden;">
            <div class="sg-card-head">
                <div class="flex items-center gap-2">
                    <h2 class="sg-card-title">Attendance Overview</h2>
                    <span class="sg-chip"
                        style="background: rgba(56,189,248,0.15); color: #0284C7; font-size: 10px; padding: 3px 8px; letter-spacing: 0.05em; text-transform: uppercase; font-weight: 700;">Sample
                        data</span>
                </div>
                <div class="flex items-center gap-3 flex-wrap">
                    <div class="sg-tabs" id="sg-attendance-tabs">
                        <button type="button" data-tab="today" class="sg-active">Today</button>
                        <button type="button" data-tab="week">This Week</button>
                        <button type="button" data-tab="month">This Month</button>
                    </div>
                </div>
            </div>
            <div class="sg-attend-grid">
                <div style="padding: 20px 24px;">
                    <div class="flex gap-5 flex-wrap" style="margin-bottom: 16px;">
                        <span class="sg-text-secondary"
                            style="font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                            <span class="sg-dot-legend" style="background:#5B3DE0;"></span> Present
                        </span>
                        <span class="sg-text-secondary"
                            style="font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                            <span class="sg-dot-legend" style="background:#38BDF8;"></span> Absent
                        </span>
                        <span class="sg-text-secondary"
                            style="font-size: 12px; font-weight: 500; display: inline-flex; align-items: center; gap: 6px;">
                            <span style="width:16px;height:0;border-top:2px dashed #F84525;display:inline-block;"></span>
                            Target 95%
                        </span>
                    </div>
                    <div style="height: 200px; position: relative;">
                        <canvas id="sg-attendance-chart"></canvas>
                    </div>

                    <div style="margin-top: 20px; padding-top: 16px; border-top: 1px solid var(--sg-border);">
                        <p class="sg-kicker" style="font-size: 11px; letter-spacing: 0.06em; margin-bottom: 10px;">
                            Attendance by Grade Level
                        </p>
                        <div class="flex flex-col" style="gap: 7px;">
                            @foreach ([['label' => 'Kindergarten', 'pct' => 95, 'color' => '#5B3DE0'], ['label' => 'Elementary', 'pct' => 93, 'color' => '#38BDF8'], ['label' => 'Junior', 'pct' => 92, 'color' => '#A78BFF'], ['label' => 'Senior', 'pct' => 90, 'color' => '#2E7D5B']] as $sgLevel)
                                <div class="flex items-center" style="gap: 10px;">
                                    <span class="sg-text-secondary"
                                        style="font-size: 11px; width: 88px; flex-shrink: 0;">{{ $sgLevel['label'] }}</span>
                                    <div class="sg-bar-strip" style="flex: 1;">
                                        <div class="sg-fill"
                                            style="width: {{ $sgLevel['pct'] }}%; background: {{ $sgLevel['color'] }};">
                                        </div>
                                    </div>
                                    <span class="sg-text-primary"
                                        style="font-size: 11px; font-weight: 700; width: 34px; text-align: right;">{{ $sgLevel['pct'] }}%</span>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="sg-rail">
                    <div class="sg-rail-stat">
                        <div class="flex items-center gap-2.5" style="margin-bottom: 8px;">
                            <div
                                style="width:32px;height:32px;border-radius:9px;background:rgba(46,125,91,0.12);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-checkbox-circle-line" style="color:#2E7D5B;font-size:16px;"></i>
                            </div>
                            <span class="sg-text-secondary" style="font-size: 12px; font-weight: 500;">Present
                                Today</span>
                        </div>
                        <p class="sg-rail-value">1,166</p>
                    </div>
                    <div class="sg-rail-stat">
                        <div class="flex items-center gap-2.5" style="margin-bottom: 8px;">
                            <div
                                style="width:32px;height:32px;border-radius:9px;background:rgba(248,69,37,0.12);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-close-circle-line" style="color:#F84525;font-size:16px;"></i>
                            </div>
                            <span class="sg-text-secondary" style="font-size: 12px; font-weight: 500;">Absent Today</span>
                        </div>
                        <p class="sg-rail-value">82</p>
                        <span class="sg-text-secondary" style="font-size: 11px;">6.6% of enrollment</span>
                    </div>
                    <div class="sg-rail-stat">
                        <div class="flex items-center gap-2.5" style="margin-bottom: 8px;">
                            <div
                                style="width:32px;height:32px;border-radius:9px;background:rgba(255,226,154,0.2);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-time-line" style="color:#D97706;font-size:16px;"></i>
                            </div>
                            <span class="sg-text-secondary" style="font-size: 12px; font-weight: 500;">Late
                                Arrivals</span>
                        </div>
                        <p class="sg-rail-value">37</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- D. Fee Management Overview (real) --}}
        <div class="sg-card" style="margin-bottom: 24px; overflow: hidden;">
            <div class="sg-card-head">
                <h2 class="sg-card-title">Fee Management Overview</h2>
                <div class="flex items-center gap-2.5">
                    <a href="{{ route('admin.fee-categories.index') }}" class="sg-text-secondary"
                        style="text-decoration: none; font-size: 12px; font-weight: 500; border: 1px solid var(--sg-border); border-radius: 8px; padding: 6px 12px;">
                        All Categories <i class="ri-arrow-down-s-line"></i>
                    </a>
                    <a href="{{ route('admin.fees.index') }}"
                        style="text-decoration: none; font-size: 12px; font-weight: 600; color: #5B3DE0; border: 1px solid var(--sg-border); border-radius: 8px; padding: 6px 12px;">
                        Manage Fees
                    </a>
                </div>
            </div>

            <div class="sg-fee-kpi-grid">
                <div class="sg-fee-kpi">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:rgba(91,61,224,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ri-file-list-3-line" style="color:#5B3DE0;font-size:18px;"></i>
                    </div>
                    <div>
                        <p class="sg-text-secondary" style="font-size: 11px; margin: 0;">Total Assigned</p>
                        <p class="sg-text-primary" style="margin: 2px 0 0; font-size: 14px; font-weight: 800;">
                            L$ {{ number_format($feesAssigned) }}
                        </p>
                    </div>
                </div>
                <div class="sg-fee-kpi">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:rgba(46,125,91,0.12);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ri-checkbox-circle-line" style="color:#2E7D5B;font-size:18px;"></i>
                    </div>
                    <div>
                        <p class="sg-text-secondary" style="font-size: 11px; margin: 0;">Collected</p>
                        <p style="margin: 2px 0 0; font-size: 14px; font-weight: 800; color: #2E7D5B;">
                            L$ {{ number_format($feesCollected) }}
                        </p>
                    </div>
                </div>
                <div class="sg-fee-kpi">
                    <div
                        style="width:36px;height:36px;border-radius:10px;background:rgba(248,69,37,0.1);display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                        <i class="ri-alarm-warning-line" style="color:#F84525;font-size:18px;"></i>
                    </div>
                    <div>
                        <p class="sg-text-secondary" style="font-size: 11px; margin: 0;">Outstanding</p>
                        <p style="margin: 2px 0 0; font-size: 14px; font-weight: 800; color: #F84525;">
                            L$ {{ number_format($feesOutstanding) }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="sg-fee-grid">
                {{-- Bar chart: Collection vs Assigned (real) --}}
                <div class="sg-fee-cell">
                    <p class="sg-text-primary" style="margin: 0 0 14px; font-size: 13px; font-weight: 700;">Collection vs
                        Assigned</p>
                    <div class="flex" style="gap: 14px; margin-bottom: 12px;">
                        <span class="sg-text-secondary"
                            style="font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                            <span class="sg-dot-legend"
                                style="width:9px;height:9px;border-radius:3px;background:#A78BFF;"></span> Assigned
                        </span>
                        <span class="sg-text-secondary"
                            style="font-size: 12px; display: inline-flex; align-items: center; gap: 6px;">
                            <span class="sg-dot-legend"
                                style="width:9px;height:9px;border-radius:3px;background:#5B3DE0;"></span> Collected
                        </span>
                    </div>
                    <div style="height: 190px; position: relative;">
                        <canvas id="sg-fee-bar-chart"></canvas>
                    </div>
                    <p class="sg-text-secondary" style="font-size: 10px; margin: 8px 0 0; text-align: right;">values in L$
                        millions</p>
                </div>

                {{-- Donut: status distribution (real) --}}
                <div class="sg-fee-cell">
                    <p class="sg-text-primary" style="margin: 0 0 14px; font-size: 13px; font-weight: 700;">Fee Status
                        Distribution</p>
                    <div style="height: 160px; position: relative;">
                        <canvas id="sg-fee-donut-chart"></canvas>
                        <div
                            style="position: absolute; inset: 0; display: flex; align-items: center; justify-content: center; pointer-events: none;">
                            <div style="text-align: center;">
                                <p class="sg-text-primary" style="margin: 0; font-size: 15px; font-weight: 800;">
                                    {{ number_format($feeStatusTotal) }}</p>
                                <p class="sg-text-secondary" style="margin: 0; font-size: 9px; font-weight: 600;">
                                    Assignments</p>
                            </div>
                        </div>
                    </div>
                    <div class="grid grid-cols-2" style="gap: 6px; margin-top: 10px;">
                        @foreach ($feeStatusDonut as $sgStatus)
                            <div class="flex items-center" style="gap: 6px;">
                                <span class="sg-dot-legend"
                                    style="width:8px;height:8px;background:{{ $sgStatus['color'] }};"></span>
                                <span class="sg-text-secondary" style="font-size: 11px;">
                                    {{ $sgStatus['name'] }}
                                    <strong
                                        class="sg-text-primary">{{ number_format(($sgStatus['value'] / $feeStatusTotal) * 100) }}%</strong>
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Recent Payments (real) --}}
                <div class="sg-fee-cell">
                    <p class="sg-text-primary" style="margin: 0 0 14px; font-size: 13px; font-weight: 700;">Recent
                        Payments</p>
                    <div class="flex flex-col">
                        @forelse ($recentPayments as $sgPayment)
                            <div class="sg-list-row">
                                <div class="sg-avatar"
                                    style="background: {{ ['#5B3DE0', '#38BDF8', '#6E4BF0', '#2E7D5B', '#F84525'][$loop->index % 5] }};">
                                    {{ $sgPayment['initials'] }}
                                </div>
                                <div style="flex: 1; min-width: 0;">
                                    <p class="sg-text-primary"
                                        style="margin: 0; font-size: 12px; font-weight: 600; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                        {{ $sgPayment['name'] }}
                                    </p>
                                    <p class="sg-text-secondary" style="margin: 0; font-size: 10px;">
                                        {{ $sgPayment['receipt'] }}</p>
                                </div>
                                <div style="text-align: right; flex-shrink: 0;">
                                    <p class="sg-text-primary" style="margin: 0; font-size: 12px; font-weight: 700;">L$
                                        {{ number_format($sgPayment['amount']) }}</p>
                                    <p class="sg-text-secondary" style="margin: 0; font-size: 10px;">
                                        {{ $sgPayment['date'] }}</p>
                                </div>
                                <span
                                    class="sg-status sg-status-{{ strtolower($sgPayment['status']) }}">{{ $sgPayment['status'] }}</span>
                            </div>
                        @empty
                            <p class="sg-text-secondary" style="font-size: 12px; padding: 10px 0;">No payments recorded
                                yet for the selected year.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        {{-- E. Enrollment & Admissions (real) --}}
        <div class="sg-two-grid">
            {{-- Students by Level (real) --}}
            <div class="sg-card">
                <div style="padding: 20px 24px;">
                    <div class="flex items-start justify-between" style="margin-bottom: 4px;">
                        <div>
                            <h3 class="sg-text-primary" style="margin: 0; font-size: 15px; font-weight: 700;">Students by
                                Level</h3>
                            <p class="sg-text-secondary" style="margin: 4px 0 0; font-size: 12px;">
                                {{ number_format($totalStudents) }} active enrollments
                            </p>
                        </div>
                        <div
                            style="width:36px;height:36px;border-radius:10px;background:rgba(91,61,224,0.1);display:flex;align-items:center;justify-content:center;">
                            <i class="ri-bar-chart-line" style="color:#5B3DE0;font-size:18px;"></i>
                        </div>
                    </div>
                    <div style="height: 200px; position: relative;">
                        <canvas id="sg-enrollment-chart"></canvas>
                    </div>
                    <div class="flex flex-wrap" style="gap: 12px; margin-top: 8px;">
                        @foreach ($studentsByLevel as $sgLevelBucket)
                            <div class="flex items-center" style="gap: 5px;">
                                <span class="sg-dot-legend"
                                    style="width:8px;height:8px;background:{{ $sgLevelBucket['color'] }};"></span>
                                <span class="sg-text-secondary" style="font-size: 11px;">
                                    {{ $sgLevelBucket['label'] }} &mdash; {{ number_format($sgLevelBucket['count']) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Admissions Pipeline (real) --}}
            <div class="sg-card">
                <div style="padding: 20px 24px;">
                    <div class="flex items-start justify-between" style="margin-bottom: 20px;">
                        <div>
                            <h3 class="sg-text-primary" style="margin: 0; font-size: 15px; font-weight: 700;">Admissions
                                Pipeline</h3>
                            <p class="sg-text-secondary" style="margin: 4px 0 0; font-size: 12px;">
                                {{ $selectedYear?->name ?? 'All years' }} &middot; all statuses
                            </p>
                        </div>
                        <div
                            style="width:36px;height:36px;border-radius:10px;background:rgba(56,189,248,0.1);display:flex;align-items:center;justify-content:center;">
                            <i class="ri-user-add-line" style="color:#38BDF8;font-size:18px;"></i>
                        </div>
                    </div>
                    <div class="flex flex-col" style="gap: 10px;">
                        @foreach ($admissionPipeline as $sgPipe)
                            <div class="sg-pipeline-row">
                                <span class="sg-dot" style="background: {{ $sgPipe['color'] }};"></span>
                                <span class="sg-text-secondary"
                                    style="font-size: 13px; flex: 1;">{{ $sgPipe['label'] }}</span>
                                <div class="sg-pipeline-track">
                                    <div class="sg-fill"
                                        style="width: {{ round(($sgPipe['count'] / $pipelineMax) * 100) }}%; background: {{ $sgPipe['color'] }};">
                                    </div>
                                </div>
                                <span class="sg-text-primary"
                                    style="font-size: 13px; font-weight: 700; width: 28px; text-align: right;">
                                    {{ number_format($sgPipe['count']) }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                    <div style="margin-top: 24px; padding-top: 16px; border-top: 1px solid var(--sg-border);">
                        <a href="{{ route('admin.admissions.index') }}"
                            style="width: 100%; display: flex; align-items: center; justify-content: center; gap: 7px;
                            background: rgba(91,61,224,0.1); border: 1px solid rgba(91,61,224,0.2); border-radius: 10px;
                            padding: 10px 0; font-size: 13px; font-weight: 600; color: #5B3DE0; text-decoration: none;">
                            <i class="ri-user-add-line"></i> Process Admissions
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- F. Announcements & Quick Actions --}}
        <div class="sg-two-grid">
            <div class="sg-card">
                <div style="padding: 20px 24px;">
                    <div class="flex justify-between items-center" style="margin-bottom: 16px;">
                        <h3 class="sg-text-primary" style="margin: 0; font-size: 15px; font-weight: 700;">Recent
                            Announcements</h3>
                        <a href="{{ route('admin.announcements.index') }}"
                            style="background: none; border: none; font-size: 12px; font-weight: 600; color: #5B3DE0; cursor: pointer; text-decoration: none;">
                            View all
                        </a>
                    </div>
                    <div class="flex flex-col">
                        @forelse ($announcements as $sgAnnouncement)
                            @php
                                $sgAnnIcons = [
                                    'fees' => [
                                        'icon' => 'ri-money-dollar-circle-line',
                                        'bg' => '#FFE29A',
                                        'tc' => '#92660A',
                                    ],
                                    'academic' => [
                                        'icon' => 'ri-file-list-3-line',
                                        'bg' => '#A78BFF',
                                        'tc' => '#5B3DE0',
                                    ],
                                    'event' => [
                                        'icon' => 'ri-calendar-event-line',
                                        'bg' => '#5FD0FA',
                                        'tc' => '#0369A1',
                                    ],
                                    'general' => ['icon' => 'ri-megaphone-line', 'bg' => '#5FD0FA', 'tc' => '#0369A1'],
                                ];
                                $sgAnnMeta =
                                    $sgAnnIcons[strtolower($sgAnnouncement->type ?? 'general')] ??
                                    $sgAnnIcons['general'];
                            @endphp
                            <div class="flex items-start"
                                style="gap: 12px; padding: 12px 0; {{ $loop->last ? '' : 'border-bottom: 1px solid var(--sg-border);' }}">
                                <div
                                    style="width:36px;height:36px;border-radius:10px;flex-shrink:0;background: {{ $sgAnnMeta['bg'] }}33;display:flex;align-items:center;justify-content:center;">
                                    <i class="{{ $sgAnnMeta['icon'] }}"
                                        style="color: {{ $sgAnnMeta['tc'] }}; font-size: 16px;"></i>
                                </div>
                                <div style="flex: 1;">
                                    <div class="flex items-center flex-wrap" style="gap: 6px;">
                                        <span
                                            style="font-size: 9px; font-weight: 700; letter-spacing: 0.06em;
                                            background: {{ $sgAnnMeta['bg'] }}33; color: {{ $sgAnnMeta['tc'] }};
                                            border-radius: 5px; padding: 2px 6px; text-transform: uppercase;">
                                            {{ $sgAnnouncement->type ?? 'General' }}
                                        </span>
                                        @if ($sgAnnouncement->is_pinned)
                                            <span style="font-size: 10px; color: #5B3DE0;"><i
                                                    class="ri-pushpin-line"></i></span>
                                        @endif
                                    </div>
                                    <p class="sg-text-primary"
                                        style="margin: 4px 0 2px; font-size: 13px; font-weight: 600;">
                                        {{ $sgAnnouncement->title }}
                                    </p>
                                    <p class="sg-text-secondary" style="margin: 0; font-size: 11px;">
                                        {{ $sgAnnouncement->start_date?->format('M d, Y') ?? '' }}
                                    </p>
                                </div>
                            </div>
                        @empty
                            <p class="sg-text-secondary" style="font-size: 12px;">No announcements yet.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            {{-- Quick Actions --}}
            <div class="sg-card">
                <div style="padding: 20px 24px;">
                    <h3 class="sg-text-primary" style="margin: 0 0 16px; font-size: 15px; font-weight: 700;">Quick Actions
                    </h3>
                    <div class="grid grid-cols-3" style="gap: 10px;">
                        <a href="{{ route('admin.fees.index') }}" class="sg-quick-action">
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:rgba(91,61,224,0.1);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-bill-line" style="color:#5B3DE0;font-size:20px;"></i>
                            </div>
                            <span>Assign Fee</span>
                        </a>
                        <a href="{{ route('admin.fees.index') }}" class="sg-quick-action">
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:rgba(46,125,91,0.12);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-secure-payment-line" style="color:#2E7D5B;font-size:20px;"></i>
                            </div>
                            <span>Record Payment</span>
                        </a>
                        <a href="{{ route('grades.entry') }}" class="sg-quick-action">
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:rgba(110,75,240,0.1);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-edit-box-line" style="color:#6E4BF0;font-size:20px;"></i>
                            </div>
                            <span>Enter Grades</span>
                        </a>
                        <a href="{{ route('admin.admissions.index') }}" class="sg-quick-action">
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:rgba(56,189,248,0.1);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-user-add-line" style="color:#38BDF8;font-size:20px;"></i>
                            </div>
                            <span>Add Admission</span>
                        </a>
                        <a href="{{ route('admin.enrollments.index') }}" class="sg-quick-action">
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:rgba(255,226,154,0.25);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-arrow-up-circle-line" style="color:#D97706;font-size:20px;"></i>
                            </div>
                            <span>Promote Students</span>
                        </a>
                        <a href="{{ route('admin.announcements.create') }}" class="sg-quick-action">
                            <div
                                style="width:40px;height:40px;border-radius:12px;background:rgba(248,69,37,0.1);display:flex;align-items:center;justify-content:center;">
                                <i class="ri-megaphone-line" style="color:#F84525;font-size:20px;"></i>
                            </div>
                            <span>New Announcement</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        {{-- G. Footer --}}
        <div class="sg-footer">
            <p>Powered by SchoolGear Liberia SaaS &middot; &copy; {{ now()->year }}</p>
        </div>
    </div>

    @push('scripts')
        {{-- Charts are rendered with Chart.js, which the admin layout already
             loads. They re-render whenever the Light/Dark theme toggles
             (see admin-navbar.blade.php, which dispatches 'sg-theme-changed'). --}}
        <script>
            (function() {
                var charts = {};

                function themeColors() {
                    var dark = document.body.classList.contains('sg-theme-dark');
                    return {
                        dark: dark,
                        text: dark ? '#94A6C4' : '#64748B',
                        grid: dark ? 'rgba(255,255,255,0.05)' : '#f0f0f0',
                        tooltipBg: dark ? '#1a2b47' : '#ffffff',
                        tooltipBorder: dark ? 'rgba(255,255,255,0.1)' : '#E8ECF5',
                        donutBorder: dark ? '#111E33' : '#ffffff'
                    };
                }

                var feeChart = @json($feeChart);
                var feeStatus = @json($feeStatusDonut);
                var studentsByLevel = @json($studentsByLevel->values());

                function baseTooltip(t) {
                    return {
                        backgroundColor: t.tooltipBg,
                        borderColor: t.tooltipBorder,
                        borderWidth: 1,
                        titleColor: t.text,
                        titleFont: {
                            family: 'Figtree, sans-serif',
                            size: 12,
                            weight: '600'
                        },
                        bodyFont: {
                            family: 'Figtree, sans-serif',
                            size: 12,
                            weight: '600'
                        },
                        padding: 10
                    };
                }

                function renderCharts() {
                    var t = themeColors();
                    Object.values(charts).forEach(function(c) {
                        c.destroy();
                    });
                    charts = {};

                    // ── Attendance area chart (SAMPLE data — mock, per design) ──
                    var attCtx = document.getElementById('sg-attendance-chart');
                    if (attCtx) {
                        charts.attendance = new Chart(attCtx, {
                            type: 'line',
                            data: {
                                labels: ['Mon', 'Tue', 'Wed', 'Thu', 'Fri'],
                                datasets: [{
                                        label: 'Present',
                                        data: [92.1, 94.0, 91.5, 93.4, 93.4],
                                        borderColor: '#5B3DE0',
                                        borderWidth: 2.5,
                                        pointBackgroundColor: '#5B3DE0',
                                        pointRadius: 4,
                                        pointHoverRadius: 6,
                                        fill: true,
                                        backgroundColor: function(ctx) {
                                            var gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
                                            gradient.addColorStop(0, 'rgba(91,61,224,0.25)');
                                            gradient.addColorStop(1, 'rgba(91,61,224,0.0)');
                                            return gradient;
                                        },
                                        tension: 0.4
                                    },
                                    {
                                        label: 'Absent',
                                        data: [7.9, 6.0, 8.5, 6.6, 6.6],
                                        borderColor: '#38BDF8',
                                        borderWidth: 2,
                                        pointRadius: 0,
                                        fill: true,
                                        backgroundColor: function(ctx) {
                                            var gradient = ctx.chart.ctx.createLinearGradient(0, 0, 0, 200);
                                            gradient.addColorStop(0, 'rgba(56,189,248,0.15)');
                                            gradient.addColorStop(1, 'rgba(56,189,248,0.0)');
                                            return gradient;
                                        },
                                        tension: 0.4
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: Object.assign(baseTooltip(t), {
                                        callbacks: {
                                            label: function(ctx) {
                                                return ' ' + ctx.dataset.label + ': ' + ctx.parsed.y +
                                                    '%';
                                            }
                                        }
                                    })
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: t.text,
                                            font: {
                                                family: 'Figtree, sans-serif',
                                                size: 11
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        min: 85,
                                        max: 100,
                                        grid: {
                                            color: t.grid
                                        },
                                        ticks: {
                                            color: t.text,
                                            font: {
                                                family: 'Figtree, sans-serif',
                                                size: 11
                                            },
                                            callback: function(v) {
                                                return v + '%';
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    }
                                }
                            },
                            plugins: [{
                                id: 'sgTargetLine',
                                afterDraw: function(chart) {
                                    var ctx = chart.ctx,
                                        chartArea = chart.chartArea,
                                        scales = chart.scales;
                                    if (!chartArea) return;
                                    var y = scales.y.getPixelForValue(95);
                                    ctx.save();
                                    ctx.setLineDash([5, 4]);
                                    ctx.strokeStyle = '#F84525';
                                    ctx.lineWidth = 1.5;
                                    ctx.beginPath();
                                    ctx.moveTo(chartArea.left, y);
                                    ctx.lineTo(chartArea.right, y);
                                    ctx.stroke();
                                    ctx.setLineDash([]);
                                    ctx.fillStyle = '#F84525';
                                    ctx.font = '10px Figtree, sans-serif';
                                    ctx.fillText('Target 95%', chartArea.right - 58, y - 4);
                                    ctx.restore();
                                }
                            }]
                        });
                    }

                    // ── Fees: Collection vs Assigned (real data) ──
                    var barCtx = document.getElementById('sg-fee-bar-chart');
                    if (barCtx) {
                        charts.feeBar = new Chart(barCtx, {
                            type: 'bar',
                            data: {
                                labels: feeChart.map(function(m) {
                                    return m.month;
                                }),
                                datasets: [{
                                        label: 'Assigned',
                                        data: feeChart.map(function(m) {
                                            return m.assigned;
                                        }),
                                        backgroundColor: '#A78BFF',
                                        borderRadius: 4,
                                        barPercentage: 0.75,
                                        categoryPercentage: 0.8
                                    },
                                    {
                                        label: 'Collected',
                                        data: feeChart.map(function(m) {
                                            return m.collected;
                                        }),
                                        backgroundColor: '#5B3DE0',
                                        borderRadius: 4,
                                        barPercentage: 0.75,
                                        categoryPercentage: 0.8
                                    }
                                ]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: Object.assign(baseTooltip(t), {
                                        callbacks: {
                                            label: function(ctx) {
                                                return ' ' + ctx.dataset.label + ': L$ ' + ctx.parsed.y
                                                    .toFixed(2) + 'M';
                                            }
                                        }
                                    })
                                },
                                scales: {
                                    x: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: t.text,
                                            font: {
                                                family: 'Figtree, sans-serif',
                                                size: 11
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        grid: {
                                            color: t.grid
                                        },
                                        ticks: {
                                            color: t.text,
                                            font: {
                                                family: 'Figtree, sans-serif',
                                                size: 10
                                            },
                                            callback: function(v) {
                                                return 'L$' + v + 'M';
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }

                    // ── Fees: status donut (real data) ──
                    var donutCtx = document.getElementById('sg-fee-donut-chart');
                    if (donutCtx) {
                        charts.feeDonut = new Chart(donutCtx, {
                            type: 'doughnut',
                            data: {
                                labels: feeStatus.map(function(s) {
                                    return s.name;
                                }),
                                datasets: [{
                                    data: feeStatus.map(function(s) {
                                        return s.value;
                                    }),
                                    backgroundColor: feeStatus.map(function(s) {
                                        return s.color;
                                    }),
                                    hoverOffset: 4,
                                    borderWidth: 2,
                                    borderColor: t.donutBorder,
                                    spacing: 3
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutout: '66%',
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: Object.assign(baseTooltip(t), {
                                        callbacks: {
                                            label: function(ctx) {
                                                return ' ' + ctx.label + ': ' + ctx.parsed;
                                            }
                                        }
                                    })
                                }
                            }
                        });
                    }

                    // ── Students by level — horizontal bars (real data) ──
                    var enrCtx = document.getElementById('sg-enrollment-chart');
                    if (enrCtx) {
                        charts.enrollment = new Chart(enrCtx, {
                            type: 'bar',
                            data: {
                                labels: studentsByLevel.map(function(l) {
                                    return l.label;
                                }),
                                datasets: [{
                                    label: 'Students',
                                    data: studentsByLevel.map(function(l) {
                                        return l.count;
                                    }),
                                    backgroundColor: studentsByLevel.map(function(l) {
                                        return l.color;
                                    }),
                                    borderRadius: 4,
                                    barPercentage: 0.7
                                }]
                            },
                            options: {
                                indexAxis: 'y',
                                responsive: true,
                                maintainAspectRatio: false,
                                plugins: {
                                    legend: {
                                        display: false
                                    },
                                    tooltip: Object.assign(baseTooltip(t), {
                                        callbacks: {
                                            label: function(ctx) {
                                                return ' ' + ctx.parsed.x + ' students';
                                            }
                                        }
                                    })
                                },
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        grid: {
                                            color: t.grid
                                        },
                                        ticks: {
                                            color: t.text,
                                            font: {
                                                family: 'Figtree, sans-serif',
                                                size: 11
                                            },
                                            precision: 0
                                        },
                                        border: {
                                            display: false
                                        }
                                    },
                                    y: {
                                        grid: {
                                            display: false
                                        },
                                        ticks: {
                                            color: t.text,
                                            font: {
                                                family: 'Figtree, sans-serif',
                                                size: 11
                                            }
                                        },
                                        border: {
                                            display: false
                                        }
                                    }
                                }
                            }
                        });
                    }
                }

                renderCharts();
                document.addEventListener('sg-theme-changed', renderCharts);

                // Gender tabs (Total Students card — real counts)
                var genderCounts = {
                    all: {{ $totalStudents }},
                    male: {{ $maleCount }},
                    female: {{ $femaleCount }}
                };
                var countEl = document.getElementById('sg-student-count');
                document.querySelectorAll('#sg-gender-tabs button').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('#sg-gender-tabs button').forEach(function(b) {
                            b.classList.remove('sg-active');
                        });
                        btn.classList.add('sg-active');
                        if (countEl) countEl.textContent = Number(genderCounts[btn.dataset.tab] || 0)
                            .toLocaleString();
                    });
                });

                // Attendance tabs (SAMPLE data — cosmetic only, per design)
                document.querySelectorAll('#sg-attendance-tabs button').forEach(function(btn) {
                    btn.addEventListener('click', function() {
                        document.querySelectorAll('#sg-attendance-tabs button').forEach(function(b) {
                            b.classList.remove('sg-active');
                        });
                        btn.classList.add('sg-active');
                    });
                });
            })();
        </script>
    @endpush

@endsection
