@php
    $school = auth()->user()->school;
@endphp

<div class="flex items-center gap-3 min-w-0">
    <div
        class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
        @if ($school && $school->logo)
            <img src="{{ asset('storage/' . $school->logo) }}" alt="{{ $school->school_name }}"
                class="h-full w-full object-cover rounded-full">
        @else
            <span class="text-white font-bold text-sm">
                {{ strtoupper(substr($school->school_name ?? 'S', 0, 1)) }}
            </span>
        @endif
    </div>

    <div class="min-w-0">
        <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold truncate">
            {{ $school->school_name ?? 'SchoolGear' }}
        </p>
        <h2 class="text-white text-base sm:text-lg font-bold leading-tight mt-0.5">
            {{ $title }}
        </h2>
    </div>
</div>


