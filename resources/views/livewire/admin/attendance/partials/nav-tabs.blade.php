@php
    $tabs = [
        ['route' => 'attendance.entry', 'icon' => 'fa-pencil', 'label' => 'Take Attendance'],
        ['route' => 'attendance.summary', 'icon' => 'fa-chart-bar', 'label' => 'Summary'],
        ['route' => 'attendance.history', 'icon' => 'fa-clock-rotate-left', 'label' => 'History'],
        ['route' => 'attendance.reports', 'icon' => 'fa-print', 'label' => 'Reports'],
        ['route' => 'attendance.audit-trail', 'icon' => 'fa-shield-halved', 'label' => 'Audit Trail'],
    ];
@endphp

<div class="flex items-center gap-1 bg-white border border-slate-200 rounded-xl p-1 shadow-sm text-sm w-fit">
    @foreach ($tabs as $tab)
        @php $isDanger = $tab['route'] === 'attendance.audit-trail'; @endphp
        <a href="{{ route($tab['route']) }}"
            class="px-4 py-2 rounded-lg font-medium transition-colors
                {{ request()->routeIs($tab['route'])
                    ? ($isDanger
                        ? 'bg-[#B91C1C] text-white'
                        : 'bg-[#155E8A] text-white')
                    : ($isDanger
                        ? 'text-[#B91C1C] hover:bg-red-50'
                        : 'text-slate-600 hover:bg-slate-50') }}">
            <i class="fa-solid {{ $tab['icon'] }} mr-1.5"></i>{{ $tab['label'] }}
        </a>
    @endforeach
</div>
