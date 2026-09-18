<div class="p-4 sm:p-6 space-y-6 max-w-5xl mx-auto">

    @include('partials.notifications')

    {{-- Page Header --}}
    <div class="bg-white rounded-xl shadow p-4 sm:p-6 flex flex-col sm:flex-row sm:items-center gap-4">
        <div class="h-12 w-12 rounded-xl bg-sky-100 text-[#155E8A] flex items-center justify-center shrink-0">
            <i class="fas fa-file-signature text-xl"></i>
        </div>
        <div class="min-w-0">
            <h1 class="text-2xl font-bold text-slate-800">Document Branding</h1>
            <p class="text-slate-500 text-sm mt-1">
                Configure how your school's name, logo, and contact details appear on printed documents
                — receipts, statements, report cards, admission letters, and certificates.
            </p>
        </div>
    </div>

    {{-- Fallback note --}}
    <div class="flex items-start gap-3 bg-sky-50 border border-sky-100 rounded-xl px-4 py-3">
        <i class="fas fa-circle-info text-[#155E8A] text-sm mt-0.5 shrink-0"></i>
        <p class="text-xs sm:text-sm text-[#155E8A]">
            Any field you leave blank will automatically fall back to your school's existing profile
            information (name, logo, address, phone, and email) — nothing will be printed empty.
        </p>
    </div>

    <form wire:submit.prevent="save" class="space-y-6">

        {{-- Identity --}}
        <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-4 sm:px-6 py-4 border-b border-[#E2E8F0] bg-[#F8FAFC]">
                <div class="h-9 w-9 rounded-lg bg-sky-100 text-[#155E8A] flex items-center justify-center shrink-0">
                    <i class="fas fa-school text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">School Identity</h2>
                    <p class="text-xs text-slate-500">Name, logo, and contact details shown at the top of every
                        document.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 space-y-5">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            Document Name
                            <span class="text-slate-400 font-normal">(overrides your school's registered name on
                                documents)</span>
                        </label>
                        <input type="text" wire:model="document_name"
                            placeholder="e.g. Willie K Greene High School Lakpazee"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        @error('document_name')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Address</label>
                        <div class="relative">
                            <i
                                class="fas fa-location-dot text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" wire:model="address" placeholder="e.g. Rwanda, Kigali"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        </div>
                        @error('address')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                            P.O. Box
                            <span class="text-slate-400 font-normal">(shown as a second address line, e.g. "P.O. Box:
                                4330 - Monrovia, Liberia")</span>
                        </label>
                        <div class="relative">
                            <i
                                class="fas fa-mail-bulk text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" wire:model="po_box"
                                placeholder="e.g. P.O. Box: 4330 - Monrovia, Liberia"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        </div>
                        @error('po_box')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Phone</label>
                        <div class="relative">
                            <i
                                class="fas fa-phone text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" wire:model="phone"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        </div>
                        @error('phone')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                        <div class="relative">
                            <i
                                class="fas fa-envelope text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="email" wire:model="email"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        </div>
                        @error('email')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Website</label>
                        <div class="relative">
                            <i
                                class="fas fa-globe text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" wire:model="website" placeholder="e.g. www.emmmbhs.edu.lr"
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        </div>
                        @error('website')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">School Number</label>
                        <div class="relative">
                            <i
                                class="fas fa-hashtag text-slate-400 text-xs absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                            <input type="text" wire:model="school_number" placeholder="e.g. School ID / Reg No."
                                class="w-full pl-9 pr-3.5 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                        </div>
                        @error('school_number')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                {{-- Logo upload --}}
                <div>
                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                        Document Logo
                        <span class="text-slate-400 font-normal">(optional — falls back to your school profile
                            logo)</span>
                    </label>

                    <div
                        class="flex flex-col sm:flex-row sm:items-center gap-4 bg-[#F8FAFC] border border-dashed border-slate-300 rounded-xl p-4">
                        <div
                            class="h-16 w-16 rounded-xl bg-white border border-slate-200 flex items-center justify-center overflow-hidden shrink-0">
                            @if ($currentLogoPath)
                                <img src="{{ asset('storage/' . $currentLogoPath) }}"
                                    class="h-full w-full object-cover">
                            @else
                                <i class="fas fa-image text-slate-300 text-xl"></i>
                            @endif
                        </div>

                        <div class="flex-1 min-w-0">
                            <label
                                class="inline-flex items-center gap-2 px-3.5 py-2 rounded-lg border border-slate-300 bg-white text-slate-600 text-xs font-semibold cursor-pointer hover:bg-slate-50 transition-colors">
                                <i class="fas fa-cloud-arrow-up text-xs"></i>
                                Choose Logo
                                <input type="file" wire:model="logo" class="hidden">
                            </label>
                            <p class="text-[11px] text-slate-400 mt-1.5">PNG or JPG recommended, up to 2MB.</p>

                            <div wire:loading wire:target="logo"
                                class="flex items-center gap-1.5 text-xs text-sky-600 mt-1.5">
                                <i class="fas fa-spinner fa-spin"></i> Uploading logo...
                            </div>
                        </div>
                    </div>
                    @error('logo')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
        </div>

        {{-- Footer --}}
        <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-4 sm:px-6 py-4 border-b border-[#E2E8F0] bg-[#F8FAFC]">
                <div class="h-9 w-9 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-shoe-prints text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Document Footer</h2>
                    <p class="text-xs text-slate-500">Contact strip and closing note shown at the bottom of every
                        document.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Location Label</label>
                        <input type="text" wire:model="footer_location_label"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Location</label>
                        <input type="text" wire:model="footer_location"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Call Label</label>
                        <input type="text" wire:model="footer_call_label"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Call / Phone</label>
                        <input type="text" wire:model="footer_call"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div>
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email Label</label>
                        <input type="text" wire:model="footer_email_label"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Footer Email</label>
                        <input type="text" wire:model="footer_email"
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    <div class="sm:col-span-3">
                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">Footer Note</label>
                        <textarea wire:model="footer_note" rows="2"
                            placeholder="e.g. This document is system-generated and valid without a stamp."
                            class="w-full px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"></textarea>
                    </div>
                </div>
            </div>
        </div>

        {{-- Per-document titles & captions --}}
        <div class="bg-white rounded-xl border border-[#E2E8F0] shadow-sm overflow-hidden">
            <div class="flex items-center gap-3 px-4 sm:px-6 py-4 border-b border-[#E2E8F0] bg-[#F8FAFC]">
                <div
                    class="h-9 w-9 rounded-lg bg-purple-100 text-purple-700 flex items-center justify-center shrink-0">
                    <i class="fas fa-heading text-sm"></i>
                </div>
                <div>
                    <h2 class="text-sm font-bold text-slate-800">Document Titles &amp; Captions</h2>
                    <p class="text-xs text-slate-500">Leave blank to use the system default title for that document
                        type.</p>
                </div>
            </div>

            <div class="p-4 sm:p-6 space-y-3">
                @php
                    $docIcons = [
                        'receipt' => ['fa-receipt', 'bg-green-100 text-green-700'],
                        'statement' => ['fa-file-invoice-dollar', 'bg-sky-100 text-[#155E8A]'],
                        'report_card' => ['fa-clipboard-list', 'bg-indigo-100 text-indigo-700'],
                        'admission_letter' => ['fa-envelope-open-text', 'bg-amber-100 text-amber-700'],
                        'certificate' => ['fa-certificate', 'bg-rose-100 text-rose-700'],
                    ];
                @endphp

                @foreach ($documentTypes as $type => $label)
                    @php [$icon, $iconClasses] = $docIcons[$type] ?? ['fa-file', 'bg-slate-100 text-slate-600']; @endphp
                    <div class="border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 bg-[#F8FAFC]">
                        <div class="flex items-center gap-2.5 mb-3">
                            <div
                                class="h-8 w-8 rounded-lg {{ $iconClasses }} flex items-center justify-center shrink-0">
                                <i class="fas {{ $icon }} text-xs"></i>
                            </div>
                            <span class="text-sm font-semibold text-slate-700">{{ $label }}</span>
                        </div>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 sm:pl-[42px]">
                            <div>
                                <label class="block text-[11px] font-medium text-slate-500 mb-1">Title</label>
                                <input type="text" wire:model="titles.{{ $type }}"
                                    placeholder="e.g. OFFICIAL STUDENT FEE RECEIPT"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>
                            <div>
                                <label class="block text-[11px] font-medium text-slate-500 mb-1">Caption <span
                                        class="text-slate-400">(optional)</span></label>
                                <input type="text" wire:model="captions.{{ $type }}"
                                    placeholder="Short subtitle shown under the title"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 bg-white text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Save bar --}}
        <div class="sticky bottom-3 sm:static">
            <div
                class="bg-white sm:bg-transparent border border-[#E2E8F0] sm:border-0 rounded-xl shadow-lg sm:shadow-none p-3 sm:p-0 flex flex-col-reverse sm:flex-row sm:justify-end items-stretch sm:items-center gap-2">
                <p class="hidden sm:block text-xs text-slate-400 mr-auto">
                    <i class="fas fa-shield-halved mr-1"></i> Changes apply to this school only.
                </p>
                <button type="submit" wire:loading.attr="disabled" wire:target="save,logo"
                    class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm disabled:opacity-60 transition-colors flex items-center justify-center gap-2">
                    <span wire:loading.remove wire:target="save,logo" class="flex items-center gap-2">
                        <i class="fas fa-save text-xs"></i> Save Settings
                    </span>
                    <span wire:loading wire:target="save,logo" class="flex items-center gap-2">
                        <i class="fas fa-spinner fa-spin text-xs"></i> Saving...
                    </span>
                </button>
            </div>
        </div>
    </form>
</div>
