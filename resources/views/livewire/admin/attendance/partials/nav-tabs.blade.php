@php
    $tabs = [
        ['route' => 'attendance.entry', 'icon' => 'fa-pencil', 'label' => 'Take Attendance'],
        ['route' => 'attendance.summary', 'icon' => 'fa-chart-bar', 'label' => 'Summary'],
        ['route' => 'attendance.history', 'icon' => 'fa-clock-rotate-left', 'label' => 'History'],
        ['route' => 'attendance.reports', 'icon' => 'fa-print', 'label' => 'Reports'],
    ];
@endphp

<div class="flex items-center gap-1 bg-white border border-slate-200 rounded-xl p-1 shadow-sm text-sm w-fit">
    @foreach ($tabs as $tab)
        <a href="{{ route($tab['route']) }}"
            class="px-4 py-2 rounded-lg font-medium transition-colors
                {{ request()->routeIs($tab['route']) ? 'bg-[#155E8A] text-white' : 'text-slate-600 hover:bg-slate-50' }}">
            <i class="fa-solid {{ $tab['icon'] }} mr-1.5"></i>{{ $tab['label'] }}
        </a>
    @endforeach
</div>
