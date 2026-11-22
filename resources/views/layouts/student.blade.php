<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="theme-color" content="#3A2A99">
    <title>@yield('title', 'Learning Portal') SchoolGear</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/js/app.js'])
    <style>
        :root {
            color-scheme: light;
            /* SchoolGear brand */
            --purple: #3A2A99;
            --purple-deep: #2D2080;
            --purple-bright: #5B3FE0;
            --blue: #1A97D8;
            --cyan: #3DBCF5;
            --yellow: #F7B731;
            --yellow-soft: #FFF4D6;
            --yellow-line: #F4DFA2;
            --yellow-ink: #7A5200;
            /* Neutrals */
            --surface: #F2F1FA;
            --page: #F6F6FB;
            --ink: #1F1B3A;
            --muted: #6B6985;
            --line: #E6E4F0;
            /* Layout */
            --sidebar-width: 276px;
            --sidebar-collapsed: 80px;
            --topbar-height: 72px;
            --font: 'Poppins', Inter, ui-sans-serif, system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        * {
            box-sizing: border-box;
        }

        [x-cloak] {
            display: none !important;
        }

        html {
            max-width: 100%;
            overflow-x: clip;
            -webkit-text-size-adjust: 100%;
        }

        body {
            margin: 0;
            max-width: 100%;
            overflow-x: clip;
            background: var(--page);
            color: var(--ink);
            font-family: var(--font);
            font-size: 14px;
            line-height: 1.5;
            -webkit-font-smoothing: antialiased;
        }

        button,
        a {
            font: inherit;
        }

        img {
            max-width: 100%;
        }

        button:focus-visible,
        a:focus-visible,
        summary:focus-visible {
            outline: 3px solid var(--cyan);
            outline-offset: 3px;
        }

        .sr-only {
            position: absolute;
            width: 1px;
            height: 1px;
            padding: 0;
            margin: -1px;
            overflow: hidden;
            clip: rect(0, 0, 0, 0);
            white-space: nowrap;
            border: 0;
        }

        .portal-shell {
            width: 100%;
            max-width: 100%;
            min-height: 100vh;
        }

        /* ---------- Sidebar ---------- */
        .portal-sidebar {
            position: fixed;
            z-index: 40;
            inset: 0 auto 0 0;
            display: flex;
            width: var(--sidebar-width);
            flex-direction: column;
            background: var(--purple);
            color: #fff;
            transition: width .2s ease, transform .2s ease;
        }

        .portal-brand {
            display: flex;
            height: var(--topbar-height);
            flex: 0 0 auto;
            align-items: center;
            gap: 10px;
            padding: 0 20px;
            border-bottom: 1px solid rgba(255, 255, 255, .12);
        }

        .portal-brand-link {
            display: flex;
            min-width: 0;
            flex: 1 1 auto;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
        }

        .portal-brand-link img {
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            padding: 4px;
            object-fit: cover;
            border-radius: 11px;
            background: #fff;
        }

        .portal-brand-copy {
            min-width: 0;
        }

        .portal-brand-name {
            display: block;
            max-width: 100%;
            overflow: hidden;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.2;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-brand-caption {
            display: block;
            margin-top: 2px;
            color: #D9D4F5;
            font-size: 11.5px;
        }

        .portal-close {
            display: none;
            width: 36px;
            height: 36px;
            flex: 0 0 36px;
            align-items: center;
            justify-content: center;
            border: 0;
            border-radius: 9px;
            background: rgba(255, 255, 255, .1);
            color: #fff;
            cursor: pointer;
        }

        .portal-nav {
            display: grid;
            flex: 1 1 auto;
            align-content: start;
            gap: 4px;
            padding: 18px 12px;
            overflow-y: auto;
        }

        .portal-nav-link,
        .portal-nav-disabled {
            position: relative;
            display: flex;
            width: 100%;
            min-height: 46px;
            align-items: center;
            gap: 14px;
            padding: 0 14px;
            border: 0;
            border-radius: 11px;
            background: transparent;
            color: #E7E3FA;
            font-size: 14px;
            text-align: left;
            text-decoration: none;
            transition: background .15s ease, color .15s ease;
        }

        .portal-nav-link i,
        .portal-nav-disabled i {
            width: 22px;
            flex: 0 0 22px;
            text-align: center;
            font-size: 16px;
        }

        .portal-nav-link:hover {
            background: rgba(255, 255, 255, .09);
            color: #fff;
        }

        .portal-nav-link.is-active {
            background: rgba(255, 255, 255, .15);
            color: #fff;
            font-weight: 500;
        }

        .portal-nav-link.is-active i {
            color: var(--yellow);
        }

        .portal-nav-link.is-active::before {
            content: "";
            position: absolute;
            left: 0;
            top: 11px;
            bottom: 11px;
            width: 4px;
            border-radius: 0 4px 4px 0;
            background: var(--yellow);
        }

        .portal-nav-disabled {
            color: #B9B2DE;
            cursor: not-allowed;
        }

        .portal-nav-label {
            flex: 1 1 auto;
            white-space: nowrap;
        }

        .portal-soon {
            padding: 2px 8px;
            border-radius: 20px;
            background: rgba(247, 183, 49, .18);
            color: #FFD97A;
            font-size: 10.5px;
            font-weight: 600;
        }

        .portal-sidebar-bottom {
            flex: 0 0 auto;
            padding: 14px 14px 16px;
            border-top: 1px solid rgba(255, 255, 255, .12);
        }

        .portal-profile {
            display: flex;
            align-items: center;
            gap: 11px;
            padding: 11px;
            border-radius: 14px;
            background: rgba(255, 255, 255, .09);
        }

        .portal-profile-link {
            color: inherit;
            text-decoration: none;
        }

        .portal-profile-link:hover,
        .portal-profile-link.is-active {
            background: rgba(255, 255, 255, .16);
        }

        .portal-profile-link.is-active {
            box-shadow: inset 3px 0 var(--yellow);
        }

        .portal-profile-copy {
            min-width: 0;
        }

        .portal-profile-name {
            display: block;
            overflow: hidden;
            font-size: 13px;
            font-weight: 600;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-profile-id {
            display: block;
            overflow: hidden;
            color: #D4CEF3;
            font-size: 11.5px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-powered {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 12px 4px 0;
            color: #CFC9F0;
            font-size: 11.5px;
        }

        .portal-powered i {
            color: var(--yellow);
        }

        /* ---------- Avatar ---------- */
        .portal-avatar {
            display: inline-flex;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            border-radius: 50%;
            background: #E9E5FF;
            color: var(--purple);
            font-size: 13px;
            font-weight: 600;
        }

        .portal-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .portal-avatar--lg {
            width: 46px;
            height: 46px;
            flex-basis: 46px;
            font-size: 15px;
        }

        .portal-avatar--ring {
            box-shadow: 0 0 0 2px var(--purple), 0 0 0 4px var(--yellow);
        }

        /* ---------- Main + topbar ---------- */
        .portal-main {
            display: flex;
            min-width: 0;
            min-height: 100vh;
            flex-direction: column;
            margin-left: var(--sidebar-width);
            transition: margin-left .2s ease;
        }

        .portal-topbar {
            position: sticky;
            z-index: 30;
            top: 0;
            display: flex;
            min-width: 0;
            height: var(--topbar-height);
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            flex-wrap: nowrap;
            padding: 0 30px;
            border-bottom: 1px solid var(--line);
            background: rgba(255, 255, 255, .96);
        }

        @supports (backdrop-filter: blur(8px)) {
            .portal-topbar {
                background: rgba(255, 255, 255, .88);
                backdrop-filter: blur(10px);
            }
        }

        .portal-topbar-start,
        .portal-topbar-end {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 14px;
        }

        .portal-topbar-start {
            flex: 1 1 0;
        }

        .portal-topbar-end {
            flex: 0 0 auto;
        }

        .portal-toggle,
        .portal-menu-button {
            display: inline-flex;
            width: 42px;
            height: 42px;
            flex: 0 0 42px;
            align-items: center;
            justify-content: center;
            border: 1px solid var(--line);
            border-radius: 11px;
            background: #fff;
            color: var(--purple);
            cursor: pointer;
            transition: background .15s ease, border-color .15s ease;
        }

        .portal-toggle:hover,
        .portal-menu-button:hover {
            border-color: #C9C2F2;
            background: var(--surface);
        }

        .portal-toggle i {
            transition: transform .2s ease;
        }

        .sidebar-collapsed .portal-toggle i {
            transform: rotate(180deg);
        }

        .portal-menu-button {
            display: none;
        }

        .portal-school {
            display: flex;
            min-width: 0;
            flex: 1 1 auto;
            align-items: center;
            gap: 12px;
            overflow: hidden;
        }

        .portal-school-icon {
            display: inline-flex;
            width: 40px;
            height: 40px;
            flex: 0 0 40px;
            align-items: center;
            justify-content: center;
            border-radius: 11px;
            background: var(--surface);
            color: var(--purple-bright);
        }

        .portal-school-icon img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: inherit;
        }

        .portal-school-copy {
            min-width: 0;
            flex: 1 1 auto;
            overflow: hidden;
        }

        .portal-school-name {
            display: block;
            overflow: hidden;
            font-size: 15px;
            font-weight: 600;
            line-height: 1.25;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-page-name {
            display: block;
            overflow: hidden;
            color: var(--muted);
            font-size: 12px;
            line-height: 1.3;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-year {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding: 7px 13px;
            border: 1px solid var(--yellow-line);
            border-radius: 999px;
            background: var(--yellow-soft);
            color: var(--yellow-ink);
            font-size: 12.5px;
            font-weight: 500;
            white-space: nowrap;
        }

        /* ---------- User menu ---------- */
        .portal-user-menu {
            position: relative;
        }

        .portal-user-menu summary {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 11px;
            padding: 5px 8px 5px 5px;
            border: 1px solid var(--line);
            border-radius: 999px;
            background: #fff;
            cursor: pointer;
            list-style: none;
        }

        .portal-user-menu summary::-webkit-details-marker {
            display: none;
        }

        .portal-user-menu summary:hover,
        .portal-user-menu[open] summary {
            border-color: #C9C2F2;
            background: var(--surface);
        }

        .portal-user-copy {
            min-width: 0;
            line-height: 1.25;
        }

        .portal-user-name {
            display: block;
            max-width: 170px;
            overflow: hidden;
            font-size: 13px;
            font-weight: 600;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-user-id {
            display: block;
            max-width: 170px;
            overflow: hidden;
            color: var(--muted);
            font-size: 11.5px;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .portal-user-chevron {
            color: var(--muted);
            font-size: 11px;
            transition: transform .15s ease;
        }

        .portal-user-menu[open] .portal-user-chevron {
            transform: rotate(180deg);
        }

        .portal-user-popover {
            position: absolute;
            z-index: 60;
            top: calc(100% + 12px);
            right: 0;
            width: min(290px, calc(100vw - 24px));
            max-width: calc(100vw - 24px);
            padding: 16px;
            border: 1px solid var(--line);
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 16px 40px rgba(34, 28, 83, .14);
        }

        .portal-popover-head {
            display: flex;
            min-width: 0;
            align-items: center;
            gap: 12px;
        }

        .portal-popover-head>div {
            min-width: 0;
        }

        .portal-popover-head strong {
            display: block;
            font-size: 14px;
            line-height: 1.3;
            overflow-wrap: anywhere;
        }

        .portal-popover-head span {
            display: block;
            color: var(--muted);
            font-size: 12px;
            overflow-wrap: anywhere;
        }

        .portal-popover-school {
            display: flex;
            align-items: flex-start;
            gap: 10px;
            margin-top: 14px;
            padding: 11px 12px;
            border-radius: 11px;
            background: var(--surface);
            color: var(--purple);
            font-size: 12.5px;
            line-height: 1.4;
        }

        .portal-popover-school i {
            margin-top: 2px;
            color: var(--purple-bright);
        }

        .portal-logout {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 11px 12px;
            border: 0;
            border-radius: 11px;
            background: transparent;
            color: #B42318;
            cursor: pointer;
            text-align: left;
            font-weight: 500;
        }

        .portal-logout:hover {
            background: #FEF3F2;
        }

        .portal-profile-action {
            display: flex;
            width: 100%;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 11px 12px;
            border-radius: 11px;
            color: var(--purple);
            text-decoration: none;
            font-weight: 500;
        }

        .portal-profile-action:hover {
            background: var(--surface);
        }

        /* ---------- Content + footer ---------- */
        .portal-content {
            width: 100%;
            max-width: 1360px;
            min-width: 0;
            flex: 1 0 auto;
            margin: 0 auto;
            padding: 30px;
        }

        .portal-footer {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 6px 18px;
            min-width: 0;
            padding: 18px 30px;
            border-top: 1px solid var(--line);
            color: var(--muted);
            font-size: 12px;
        }

        .portal-footer i {
            margin-right: 7px;
            color: var(--purple-bright);
        }

        .portal-footer>span {
            min-width: 0;
            overflow-wrap: anywhere;
        }

        .portal-overlay {
            position: fixed;
            z-index: 35;
            inset: 0;
            border: 0;
            background: rgba(22, 18, 54, .52);
        }

        /* ---------- Collapsed sidebar (desktop only) ---------- */
        @media (min-width: 961px) {
            .sidebar-collapsed .portal-sidebar {
                width: var(--sidebar-collapsed);
            }

            .sidebar-collapsed .portal-main {
                margin-left: var(--sidebar-collapsed);
            }

            .sidebar-collapsed .portal-brand {
                justify-content: center;
                padding: 0 8px;
            }

            .sidebar-collapsed .portal-brand-link {
                flex: 0 0 auto;
            }

            .sidebar-collapsed .portal-brand-copy,
            .sidebar-collapsed .portal-nav-label,
            .sidebar-collapsed .portal-soon,
            .sidebar-collapsed .portal-profile-copy,
            .sidebar-collapsed .portal-powered span {
                display: none;
            }

            .sidebar-collapsed .portal-nav {
                padding-inline: 10px;
            }

            .sidebar-collapsed .portal-nav-link,
            .sidebar-collapsed .portal-nav-disabled {
                justify-content: center;
                padding: 0;
            }

            .sidebar-collapsed .portal-nav-link i,
            .sidebar-collapsed .portal-nav-disabled i {
                font-size: 17px;
            }

            .sidebar-collapsed .portal-sidebar-bottom {
                padding-inline: 10px;
            }

            .sidebar-collapsed .portal-profile {
                justify-content: center;
                padding: 8px 0;
                background: transparent;
            }

            .sidebar-collapsed .portal-powered {
                justify-content: center;
                margin-inline: 0;
            }
        }

        /* ---------- Tablet and mobile ---------- */
        @media (max-width: 960px) {
            .portal-sidebar {
                width: min(300px, calc(100vw - 52px));
                transform: translateX(-105%);
                box-shadow: none;
            }

            .portal-shell.sidebar-open .portal-sidebar {
                transform: translateX(0);
                box-shadow: 0 0 50px rgba(20, 14, 60, .4);
            }

            .portal-main {
                margin-left: 0;
            }

            .portal-menu-button {
                display: inline-flex;
            }

            .portal-toggle {
                display: none;
            }

            .portal-close {
                display: inline-flex;
            }

            .portal-topbar {
                padding: 0 18px;
            }

            .portal-content {
                padding: 24px 18px;
            }

            .portal-footer {
                padding: 16px 18px;
            }
        }

        @media (max-width: 700px) {

            .portal-user-copy,
            .portal-user-chevron {
                display: none;
            }

            .portal-user-menu summary {
                padding: 3px;
            }

            .portal-user-popover {
                right: 0;
                width: min(290px, calc(100vw - 24px));
            }
        }

        @media (max-width: 359px) {
            .portal-user-popover {
                width: min(290px, calc(100vw - 48px));
            }
        }

        @media (max-width: 560px) {
            .portal-year {
                display: none;
            }

            .portal-topbar {
                gap: 10px;
            }

            .portal-topbar-start {
                gap: 10px;
            }

            .portal-school-icon {
                display: none;
            }

            .portal-school {
                flex: 1 1 0;
            }

            .portal-school-name {
                max-width: 100%;
            }

            .portal-topbar-end,
            .portal-user-menu,
            .portal-user-menu summary,
            .portal-avatar {
                flex-shrink: 0;
            }

            .portal-content {
                padding: 20px 14px;
            }

            .portal-footer {
                padding: 16px 14px;
            }
        }

        @media (prefers-reduced-motion: reduce) {

            *,
            *::before,
            *::after {
                scroll-behavior: auto !important;
                transition-duration: .01ms !important;
            }
        }
    </style>
    @stack('styles')
</head>

<body>
    @php
        $brandSchool = $school ?? null ?: auth()->user()->school;
        $brandLogoFallback = asset('logo/Schoolgear1.jpeg');
        $brandName = $brandSchool
            ? $brandSchool->display_short_name ??
                ($brandSchool->short_name ?? ($brandSchool->school_name ?? 'SchoolGear Liberia'))
            : 'SchoolGear Liberia';
        $profileImage = $student->image ?? ($user->image ?? null);
        $nameParts = array_slice(array_filter(explode(' ', trim($user->name))), 0, 2);
        $userInitials = collect($nameParts)->map(fn($part) => strtoupper(substr($part, 0, 1)))->implode('');
    @endphp
    <div class="portal-shell" x-data="{
        sidebarCollapsed: false,
        mobileOpen: false,
        initSidebar() {
            try {
                this.sidebarCollapsed = localStorage.getItem('schoolgearPortalSidebarCollapsed') === 'true';
            } catch (error) {}
        },
        toggleSidebar() {
            this.sidebarCollapsed = !this.sidebarCollapsed;
            try {
                localStorage.setItem('schoolgearPortalSidebarCollapsed', this.sidebarCollapsed);
            } catch (error) {}
        }
    }" x-init="initSidebar()"
        x-effect="document.body.style.overflow = mobileOpen ? 'hidden' : ''"
        :class="{ 'sidebar-collapsed': sidebarCollapsed, 'sidebar-open': mobileOpen }"
        @keydown.escape.window="mobileOpen = false">
        <button type="button" class="portal-overlay" x-cloak x-show="mobileOpen" @click="mobileOpen = false"
            aria-label="Close navigation menu"></button>

        {{-- ================= Sidebar ================= --}}
        <aside id="portal-navigation" class="portal-sidebar" aria-label="Main navigation">
            <div class="portal-brand">
                <a class="portal-brand-link" href="{{ route('student.dashboard') }}" @click="mobileOpen = false">
                    <img src="{{ $brandSchool && $brandSchool->logo ? asset('storage/' . $brandSchool->logo) : $brandLogoFallback }}"
                        alt="{{ $brandSchool->school_name ?? 'SchoolGear Liberia' }}"
                        title="{{ $brandSchool->school_name ?? 'SchoolGear Liberia' }}"
                        onerror="this.onerror=null;this.src='{{ $brandLogoFallback }}'">
                    <span class="portal-brand-copy">
                        <span class="portal-brand-name"
                            title="{{ $brandSchool->school_name ?? 'SchoolGear Liberia' }}">{{ $brandName }}</span>
                        <span class="portal-brand-caption">Learning portal</span>
                    </span>
                </a>
                <button type="button" class="portal-close" @click="mobileOpen = false"
                    aria-label="Close navigation menu">
                    <i class="fa-solid fa-xmark" aria-hidden="true"></i>
                </button>
            </div>

            <nav class="portal-nav" aria-label="Portal sections">
                <a href="{{ route('student.dashboard') }}"
                    class="portal-nav-link {{ request()->routeIs('student.dashboard') ? 'is-active' : '' }}"
                    @if (request()->routeIs('student.dashboard')) aria-current="page" @endif title="Dashboard"
                    @click="mobileOpen = false">
                    <i class="fa-solid fa-house" aria-hidden="true"></i>
                    <span class="portal-nav-label">Dashboard</span>
                </a>
                <a href="{{ route('student.grades') }}"
                    class="portal-nav-link {{ request()->routeIs('student.grades') ? 'is-active' : '' }}"
                    @if (request()->routeIs('student.grades')) aria-current="page" @endif title="Grades"
                    @click="mobileOpen = false">
                    <i class="fa-solid fa-chart-column" aria-hidden="true"></i>
                    <span class="portal-nav-label">Grades</span>
                </a>
                <a href="{{ route('student.attendance') }}"
                    class="portal-nav-link {{ request()->routeIs('student.attendance') ? 'is-active' : '' }}"
                    @if (request()->routeIs('student.attendance')) aria-current="page" @endif title="Attendance"
                    @click="mobileOpen = false">
                    <i class="fa-solid fa-calendar-check" aria-hidden="true"></i>
                    <span class="portal-nav-label">Attendance</span>
                </a>
                @foreach ([['label' => 'Fees', 'icon' => 'fa-wallet'], ['label' => 'Announcements', 'icon' => 'fa-bullhorn']] as $item)
                    <button type="button" class="portal-nav-disabled" disabled aria-disabled="true"
                        title="{{ $item['label'] }} coming soon">
                        <i class="fa-solid {{ $item['icon'] }}" aria-hidden="true"></i>
                        <span class="portal-nav-label">{{ $item['label'] }}</span>
                        <span class="portal-soon">Soon</span>
                    </button>
                @endforeach
            </nav>

            <div class="portal-sidebar-bottom">
                <a href="{{ route('student.profile') }}"
                    class="portal-profile portal-profile-link {{ request()->routeIs('student.profile') ? 'is-active' : '' }}"
                    @if (request()->routeIs('student.profile')) aria-current="page" @endif title="My profile"
                    @click="mobileOpen = false">
                    <span class="portal-avatar portal-avatar--ring" title="{{ $user->name }}">
                        @if ($profileImage)
                            <img src="{{ asset('storage/' . $profileImage) }}" alt=""
                                onerror="this.hidden=true; this.nextElementSibling.hidden=false">
                            <span hidden>{{ $userInitials ?: '?' }}</span>
                        @else
                            {{ $userInitials ?: '?' }}
                        @endif
                    </span>
                    <span class="portal-profile-copy">
                        <span class="portal-profile-name">{{ $user->name }}</span>
                        <span class="portal-profile-id">{{ $user->registration_id }}</span>
                    </span>
                </a>
                <div class="portal-powered" title="Powered by SchoolGear Software">
                    <i class="fa-solid fa-gear" aria-hidden="true"></i>
                    <span>Powered by SchoolGear Software</span>
                </div>
            </div>
        </aside>

        {{-- ================= Main ================= --}}
        <div class="portal-main">
            <header class="portal-topbar">
                <div class="portal-topbar-start">
                    <button type="button" class="portal-menu-button" @click="mobileOpen = true"
                        aria-label="Open navigation menu" aria-controls="portal-navigation"
                        :aria-expanded="mobileOpen.toString()">
                        <i class="fa-solid fa-bars" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="portal-toggle" @click="toggleSidebar()"
                        :aria-expanded="(!sidebarCollapsed).toString()"
                        :aria-label="sidebarCollapsed ? 'Expand sidebar' : 'Collapse sidebar'" title="Toggle sidebar">
                        <i class="fa-solid fa-angles-left" aria-hidden="true"></i>
                    </button>
                    <div class="portal-school">
                        <span class="portal-school-icon">
                            <img src="{{ $brandSchool && $brandSchool->logo ? asset('storage/' . $brandSchool->logo) : $brandLogoFallback }}"
                                alt="{{ $brandSchool->school_name ?? 'SchoolGear Liberia' }}"
                                onerror="this.onerror=null;this.src='{{ $brandLogoFallback }}'">
                        </span>
                        <div class="portal-school-copy">
                            <span class="portal-school-name">{{ $school->school_name ?? 'School' }}</span>
                            <span class="portal-page-name">@yield('title', 'Learning Portal')</span>
                        </div>
                    </div>
                </div>

                <div class="portal-topbar-end">
                    @if ($academicYear ?? null)
                        <span class="portal-year" title="Academic year">
                            <i class="fa-regular fa-calendar" aria-hidden="true"></i>
                            {{ $academicYear->name }}
                        </span>
                    @endif

                    <details class="portal-user-menu" x-data @click.outside="$el.removeAttribute('open')"
                        @keydown.escape="$el.removeAttribute('open')">
                        <summary aria-label="Open user menu">
                            <span class="portal-avatar">
                                @if ($profileImage)
                                    <img src="{{ asset('storage/' . $profileImage) }}" alt=""
                                        onerror="this.hidden=true; this.nextElementSibling.hidden=false">
                                    <span hidden>{{ $userInitials ?: '?' }}</span>
                                @else
                                    {{ $userInitials ?: '?' }}
                                @endif
                            </span>
                            <span class="portal-user-copy">
                                <span class="portal-user-name">{{ $user->name }}</span>
                                <span class="portal-user-id">{{ $user->registration_id }}</span>
                            </span>
                            <i class="fa-solid fa-chevron-down portal-user-chevron" aria-hidden="true"></i>
                        </summary>
                        <div class="portal-user-popover">
                            <div class="portal-popover-head">
                                <span class="portal-avatar portal-avatar--lg">
                                    @if ($profileImage)
                                        <img src="{{ asset('storage/' . $profileImage) }}" alt=""
                                            onerror="this.hidden=true; this.nextElementSibling.hidden=false">
                                        <span hidden>{{ $userInitials ?: '?' }}</span>
                                    @else
                                        {{ $userInitials ?: '?' }}
                                    @endif
                                </span>
                                <div>
                                    <strong>{{ $user->name }}</strong>
                                    <span>{{ $user->registration_id }}</span>
                                </div>
                            </div>
                            <div class="portal-popover-school">
                                <i class="fa-solid fa-school" aria-hidden="true"></i>
                                <span>{{ $school->school_name ?? 'School' }}</span>
                            </div>
                            <a href="{{ route('student.profile') }}" class="portal-profile-action"
                                @click="$el.closest('details').removeAttribute('open')">
                                <i class="fa-regular fa-user" aria-hidden="true"></i>
                                My profile
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="portal-logout">
                                    <i class="fa-solid fa-arrow-right-from-bracket" aria-hidden="true"></i>
                                    Log Out
                                </button>
                            </form>
                        </div>
                    </details>
                </div>
            </header>

            <main class="portal-content">
                @yield('content')
            </main>

            <footer class="portal-footer">
                <span><i class="fa-solid fa-gear" aria-hidden="true"></i>Powered by SchoolGear Software</span>
                <span>&copy; {{ date('Y') }} {{ $school->school_name ?? 'SchoolGear' }}</span>
            </footer>
        </div>
    </div>
    @stack('scripts')
</body>

</html>
