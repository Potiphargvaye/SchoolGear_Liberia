@php
    $tabs = [
        ['route' => 'attendance.entry', 'icon' => 'fa-pencil', 'label' => 'Take Attendance'],
        ['route' => 'attendance.summary', 'icon' => 'fa-chart-bar', 'label' => 'Summary'],
        ['route' => 'attendance.history', 'icon' => 'fa-clock-rotate-left', 'label' => 'History'],
        ['route' => 'attendance.reports', 'icon' => 'fa-print', 'label' => 'Reports'],
        ['route' => 'attendance.audit-trail', 'icon' => 'fa-shield-halved', 'label' => 'Audit Trail'],
    ];
@endphp

<nav aria-label="Attendance sections" class="attendance-tabs-scroll flex min-w-0 max-w-full items-center gap-1 overflow-x-auto rounded-xl border border-slate-200 bg-white p-1 text-sm shadow-sm dark:border-slate-700 dark:bg-slate-900 md:w-full md:flex-wrap md:overflow-visible">
    @foreach ($tabs as $tab)
        @php $isDanger = $tab['route'] === 'attendance.audit-trail'; @endphp
        <a href="{{ route($tab['route']) }}"
            @if (request()->routeIs($tab['route'])) aria-current="page" data-attendance-active-tab @endif
            class="inline-flex min-h-11 shrink-0 items-center justify-center rounded-lg px-3 py-2 font-medium transition-colors focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-sky-600 md:flex-1 md:px-4
                {{ request()->routeIs($tab['route'])
                    ? ($isDanger
                        ? 'bg-[#B91C1C] text-white'
                        : 'bg-[#155E8A] text-white')
                    : ($isDanger
                        ? 'text-red-700 hover:bg-red-50 dark:text-red-300 dark:hover:bg-red-950'
                        : 'text-slate-700 hover:bg-slate-50 dark:text-slate-200 dark:hover:bg-slate-800') }}">
            <i class="fa-solid {{ $tab['icon'] }} mr-1.5"></i>{{ $tab['label'] }}
        </a>
    @endforeach
</nav>

<style>
    .attendance-tabs-scroll {
        scrollbar-width: none;
        overscroll-behavior-x: contain;
        scroll-behavior: smooth;
    }

    .attendance-tabs-scroll::-webkit-scrollbar {
        display: none;
    }

    @media (min-width: 768px) {
        .attendance-tabs-scroll {
            scroll-behavior: auto;
        }
    }
</style>

<script>
    (function () {
        function revealActiveAttendanceTab() {
            var activeTab = document.querySelector('[data-attendance-active-tab]');
            if (activeTab) {
                activeTab.scrollIntoView({ block: 'nearest', inline: 'nearest' });
            }
        }

        requestAnimationFrame(revealActiveAttendanceTab);
        document.addEventListener('livewire:navigated', revealActiveAttendanceTab);
    })();
</script>
