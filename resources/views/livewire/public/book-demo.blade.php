@php
    $input =
        'w-full rounded-lg border bg-white px-3.5 py-2.5 text-sm text-slate-800 placeholder-slate-400 outline-none transition focus:border-sg-primary focus:ring-2 focus:ring-sg-primary/20';
    $label = 'block text-sm font-medium text-slate-700 mb-1.5';
    $pill =
        'block cursor-pointer rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-center text-sm text-slate-700 transition hover:border-sg-primary peer-checked:border-sg-primary peer-checked:bg-sg-primary/10 peer-checked:font-semibold peer-checked:text-sg-primaryDark peer-focus-visible:ring-2 peer-focus-visible:ring-sg-primary/30';
@endphp

<div>
    @if ($submitted)
        {{-- Success confirmation --}}
        <div class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8" role="status">
            <div class="flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">
                <i class="fas fa-check text-lg"></i>
            </div>

            <h2 class="mt-4 text-2xl font-bold text-sg-primaryDark">Your demo request is in</h2>
            <p class="mt-1.5 text-sm text-slate-500">
                Reference <span class="font-semibold text-slate-700">{{ $summary['reference'] }}</span>. Keep it handy
                if you contact us about this request.
            </p>

            <dl class="mt-5 divide-y divide-slate-100 rounded-lg border border-slate-200 text-sm">
                <div class="flex justify-between gap-4 px-4 py-2.5">
                    <dt class="text-slate-500">School</dt>
                    <dd class="text-right font-medium text-slate-800">{{ $summary['school'] }}</dd>
                </div>
                <div class="flex justify-between gap-4 px-4 py-2.5">
                    <dt class="text-slate-500">Preferred date</dt>
                    <dd class="text-right font-medium text-slate-800">{{ $summary['date'] }}</dd>
                </div>
                <div class="flex justify-between gap-4 px-4 py-2.5">
                    <dt class="text-slate-500">Preferred time</dt>
                    <dd class="text-right font-medium text-slate-800">{{ $summary['time'] }}</dd>
                </div>
            </dl>

            <p class="mt-5 text-sm text-slate-600 leading-relaxed">
                This is a request, not a confirmed session yet. Our team will contact you on WhatsApp or by email to
                confirm the date and time.
            </p>

            @if ($emailSent)
                <p class="mt-3 text-sm text-slate-600">
                    <i class="fas fa-envelope text-sg-primary mr-1.5"></i>
                    We sent a confirmation to <span class="font-medium">{{ $summary['email'] }}</span>.
                </p>
            @else
                <p class="mt-3 rounded-lg border border-amber-200 bg-amber-50 px-3.5 py-2.5 text-sm text-amber-800">
                    Your request is saved, but we could not send the confirmation email to
                    <span class="font-medium">{{ $summary['email'] }}</span>. Our team will still contact you.
                </p>
            @endif

            <div class="mt-6 flex flex-col gap-3 sm:flex-row">
                <a href="{{ url('/') }}"
                    class="inline-flex items-center justify-center rounded-lg bg-sg-primary px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-sg-primaryDark">
                    Back to homepage
                </a>
                <button type="button" wire:click="resetForm"
                    class="inline-flex items-center justify-center rounded-lg border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                    Book another request
                </button>
            </div>
        </div>
    @else
        <form wire:submit="submit" novalidate
            class="bg-white rounded-2xl border border-slate-200 shadow-sm p-6 sm:p-8 space-y-5">

            <div>
                <h2 class="text-xl font-bold text-sg-primaryDark">Tell us about your school</h2>
                <p class="mt-1 text-sm text-slate-500">All fields are required except the message.</p>
            </div>

            @error('form')
                <div class="rounded-lg border border-red-200 bg-red-50 px-3.5 py-2.5 text-sm text-red-700" role="alert">
                    {{ $message }}
                </div>
            @enderror

            {{-- Honeypot --}}
            <div style="position:absolute; left:-9999px;" aria-hidden="true">
                <label>Website <input type="text" wire:model="website" tabindex="-1" autocomplete="off"></label>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <div>
                    <label for="full_name" class="{{ $label }}">Full name</label>
                    <input id="full_name" type="text" wire:model.blur="full_name" autocomplete="name"
                        class="{{ $input }} @error('full_name') border-red-400 @else border-slate-300 @enderror">
                    @error('full_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="{{ $label }}">Email address</label>
                    <input id="email" type="email" wire:model.blur="email" autocomplete="email"
                        class="{{ $input }} @error('email') border-red-400 @else border-slate-300 @enderror">
                    @error('email')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="school_name" class="{{ $label }}">School name</label>
                    <input id="school_name" type="text" wire:model.blur="school_name"
                        class="{{ $input }} @error('school_name') border-red-400 @else border-slate-300 @enderror">
                    @error('school_name')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="whatsapp_number" class="{{ $label }}">WhatsApp number</label>
                    <input id="whatsapp_number" type="tel" wire:model.blur="whatsapp_number" autocomplete="tel"
                        placeholder="+231 77 000 0000"
                        class="{{ $input }} @error('whatsapp_number') border-red-400 @else border-slate-300 @enderror">
                    @error('whatsapp_number')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="city" class="{{ $label }}">School location or city</label>
                    <input id="city" type="text" wire:model.blur="city" placeholder="e.g. Monrovia"
                        class="{{ $input }} @error('city') border-red-400 @else border-slate-300 @enderror">
                    @error('city')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <fieldset>
                    <legend class="{{ $label }}">School category</legend>
                    <div class="grid grid-cols-2 gap-3">
                        @foreach ($categories as $key => $categoryLabel)
                            <label class="relative">
                                <input type="radio" wire:model="school_category" value="{{ $key }}"
                                    class="peer sr-only">
                                <span class="{{ $pill }}">{{ $categoryLabel }}</span>
                            </label>
                        @endforeach
                    </div>
                    @error('school_category')
                        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                    @enderror
                </fieldset>
            </div>

            <div>
                <label for="school_address" class="{{ $label }}">Full school address</label>
                <input id="school_address" type="text" wire:model.blur="school_address" autocomplete="street-address"
                    class="{{ $input }} @error('school_address') border-red-400 @else border-slate-300 @enderror">
                @error('school_address')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <label for="preferred_date" class="{{ $label }}">Preferred date</label>
                <input id="preferred_date" type="date" wire:model.blur="preferred_date"
                    min="{{ now()->addDay()->toDateString() }}" max="{{ now()->addDays(90)->toDateString() }}"
                    class="{{ $input }} sm:max-w-xs @error('preferred_date') border-red-400 @else border-slate-300 @enderror">
                @error('preferred_date')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <fieldset>
                <legend class="{{ $label }}">Preferred time</legend>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-3">
                    @foreach ($timeSlots as $key => $slotLabel)
                        <label class="relative">
                            <input type="radio" wire:model="preferred_time" value="{{ $key }}"
                                class="peer sr-only">
                            <span class="{{ $pill }}">{{ $slotLabel }}</span>
                        </label>
                    @endforeach
                </div>
                <p class="mt-1.5 text-xs text-slate-500">Times are in Liberia time (GMT).</p>
                @error('preferred_time')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </fieldset>

            <div>
                <label for="message" class="{{ $label }}">Message or additional request <span
                        class="font-normal text-slate-400">(optional)</span></label>
                <textarea id="message" rows="4" wire:model.blur="message" maxlength="1000"
                    placeholder="Tell us what you would like to see or discuss."
                    class="{{ $input }} @error('message') border-red-400 @else border-slate-300 @enderror"></textarea>
                @error('message')
                    <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" wire:loading.attr="disabled" wire:target="submit"
                class="w-full inline-flex items-center justify-center gap-2 rounded-lg bg-sg-primary px-5 py-3 text-sm font-semibold text-white transition hover:bg-sg-primaryDark disabled:cursor-not-allowed disabled:opacity-60">
                <span wire:loading.remove wire:target="submit">
                    <i class="fas fa-calendar-check mr-1.5"></i> Book my demo
                </span>
                <span wire:loading wire:target="submit">
                    <i class="fas fa-circle-notch fa-spin mr-1.5"></i> Sending your request
                </span>
            </button>

            <p class="text-center text-xs text-slate-400">
                We only use these details to arrange your demo or consultation.
            </p>
        </form>
    @endif
</div>
