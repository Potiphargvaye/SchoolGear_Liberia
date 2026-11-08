
    {{-- ========================= THE PASSWORD EYE BALL ICON ACROSS THE SYSTEM ========================= --}}


<div class="relative" x-data="{ visible: false }">
    <input id="{{ $inputId }}" type="password" :type="visible ? 'text' : 'password'" wire:model="{{ $field }}"
        @if (!empty($alpineModel)) x-model="{{ $alpineModel }}" @endif
        @if (!empty($placeholder)) placeholder="{{ $placeholder }}" @endif
        autocomplete="new-password"
        class="w-full px-3 py-2 pr-11 rounded-lg border border-slate-300 text-sm">
    <button type="button" @click="visible = !visible"
        :aria-label="visible ? 'Hide {{ strtolower($label) }}' : 'Show {{ strtolower($label) }}'"
        :title="visible ? 'Hide {{ strtolower($label) }}' : 'Show {{ strtolower($label) }}'"
        class="absolute inset-y-0 right-0 flex w-10 items-center justify-center text-slate-500 hover:text-[#155E8A] focus:outline-none focus-visible:ring-2 focus-visible:ring-[#155E8A] rounded-r-lg">
        <svg x-show="!visible" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M2.25 12s3.5-6.25 9.75-6.25 9.75 6.25 9.75 6.25-3.5 6.25-9.75 6.25S2.25 12 2.25 12Z" />
            <circle cx="12" cy="12" r="2.75" stroke-width="1.8" />
        </svg>
        <svg x-cloak x-show="visible" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
            viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                d="M3 3l18 18M10.6 10.6a2 2 0 0 0 2.8 2.8M9.9 5.9A10.7 10.7 0 0 1 12 5.75c6.25 0 9.75 6.25 9.75 6.25a17.2 17.2 0 0 1-3.1 3.65M6.2 6.2C3.65 7.9 2.25 12 2.25 12s3.5 6.25 9.75 6.25c1.2 0 2.3-.22 3.3-.6" />
        </svg>
    </button>
</div>
