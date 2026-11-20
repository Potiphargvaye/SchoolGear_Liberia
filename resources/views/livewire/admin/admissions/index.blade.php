<div class="min-w-0 p-3 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Admissions</h1>
            <p class="text-slate-500 text-sm mt-1">Review and process student applications.</p>
        </div>
        @if ($canManage)
            <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal"
                class="inline-flex min-h-11 w-full sm:w-auto items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                <i class="fas fa-plus text-xs" wire:loading.remove wire:target="openCreateModal"></i>
                <i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="openCreateModal"></i>
                New Admission
            </button>
        @endif
    </div>

    {{-- Status Tabs --}}
    <div class="flex flex-wrap gap-2">
        @foreach (['pending' => 'Pending', 'admitted' => 'Admitted', 'rejected' => 'Rejected', 'withdrawn' => 'Withdrawn'] as $key => $label)
            <button wire:click="$set('status', '{{ $key }}')"
                class="min-h-11 px-4 py-2 rounded-lg text-sm font-semibold transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731] {{ $status === $key ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
            </button>
        @endforeach
    </div>

    <div class="grid min-w-0 grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3">
        <input type="text" wire:model.live.debounce.400ms="search"
            placeholder="Search by name or admission number..."
            class="w-full min-w-0 px-3.5 py-3 rounded-lg border border-slate-300 text-base focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">

        <select wire:model.live="academicYearId"
            class="w-full min-w-0 px-3.5 py-3 rounded-lg border border-slate-300 text-base focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
            <option value="">All Academic Years</option>
            @foreach ($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->name }}</option>
            @endforeach
        </select>

        {{-- ADD THIS SELECT --}}
        <select wire:model.live="gradeFilter"
            class="w-full min-w-0 px-3.5 py-3 rounded-lg border border-slate-300 text-base focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
            <option value="">All Grades</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}</option>
            @endforeach
        </select>
    </div>

    <div class="grid grid-cols-1 gap-3 md:hidden">
        @forelse ($admissions as $admission)
            <article class="min-w-0 rounded-xl border border-[#E2E8F0] bg-white p-3 shadow-sm">
                <div class="flex min-w-0 items-start gap-3">
                    @if ($admission->image)
                        <img src="{{ asset('storage/' . $admission->image) }}" alt="{{ $admission->applicant_name }} photo"
                            class="h-12 w-12 shrink-0 rounded-full border border-slate-200 object-cover">
                    @else
                        <div aria-hidden="true" class="flex h-12 w-12 shrink-0 items-center justify-center rounded-full bg-sky-100 font-semibold text-[#155E8A]">
                            {{ strtoupper(substr($admission->applicant_name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="min-w-0 flex-1">
                        <div class="flex min-w-0 flex-wrap items-start justify-between gap-2">
                            <h2 class="min-w-0 flex-1 truncate font-semibold text-slate-800" title="{{ $admission->applicant_name }}">{{ $admission->applicant_name }}</h2>
                            <span class="shrink-0 rounded-full px-2.5 py-1 text-xs font-medium capitalize
                                {{ $admission->status === 'admitted' ? 'bg-green-100 text-green-700' : ($admission->status === 'rejected' ? 'bg-red-100 text-red-700' : ($admission->status === 'withdrawn' ? 'bg-slate-100 text-slate-700' : 'bg-amber-100 text-amber-800')) }}">
                                {{ $admission->status }}
                            </span>
                        </div>
                        <p class="mt-1 break-all font-mono text-xs text-slate-600">{{ $admission->admission_number }}</p>
                        <dl class="mt-3 grid grid-cols-1 gap-2 text-sm sm:grid-cols-2">
                            <div class="min-w-0"><dt class="text-xs text-slate-500">Grade Applying</dt><dd class="break-words text-slate-700">{{ $admission->grade->level }} {{ $admission->grade->section }}</dd></div>
                            <div><dt class="text-xs text-slate-500">Admission Date</dt><dd class="text-slate-700">{{ $admission->date_of_admission?->format('d M Y') ?? '—' }}</dd></div>
                            <div><dt class="text-xs text-slate-500">Type</dt><dd class="text-slate-700">{{ $admission->student_type }}</dd></div>
                        </dl>
                    </div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2 border-t border-slate-100 pt-3">
                    @if ($canView)
                        <button wire:click="viewAdmission({{ $admission->id }})" wire:loading.attr="disabled"
                            wire:target="viewAdmission({{ $admission->id }})" title="View" aria-label="View {{ $admission->applicant_name }}"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-md bg-sky-100 px-3 text-sky-700 disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-eye text-xs" wire:loading.remove wire:target="viewAdmission({{ $admission->id }})"></i><i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="viewAdmission({{ $admission->id }})"></i>
                        </button>
                    @endif
                    @if ($canView && in_array($admission->status, ['rejected']))
                        <button wire:click="viewAudit({{ $admission->id }})" wire:loading.attr="disabled"
                            wire:target="viewAudit({{ $admission->id }})" title="View audit trail" aria-label="View audit trail for {{ $admission->applicant_name }}"
                            class="inline-flex min-h-11 min-w-11 items-center justify-center rounded-md bg-slate-100 px-3 text-slate-600 disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-clock-rotate-left text-xs" wire:loading.remove wire:target="viewAudit({{ $admission->id }})"></i><i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="viewAudit({{ $admission->id }})"></i>
                        </button>
                    @endif
                    @if ($canManage && $admission->status === 'pending')
                        <button wire:click="confirmAdmit({{ $admission->id }})" wire:loading.attr="disabled"
                            wire:target="confirmAdmit({{ $admission->id }})"
                            class="min-h-11 px-3 rounded-md bg-green-100 text-green-700 text-sm font-semibold disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <span wire:loading.remove wire:target="confirmAdmit({{ $admission->id }})">Admit</span><span wire:loading wire:target="confirmAdmit({{ $admission->id }})">...</span>
                        </button>
                        <button wire:click="confirmReject({{ $admission->id }})" wire:loading.attr="disabled"
                            wire:target="confirmReject({{ $admission->id }})"
                            class="min-h-11 px-3 rounded-md bg-red-100 text-[#B91C1C] text-sm font-semibold disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Reject</button>
                        <button wire:click="withdrawAdmission({{ $admission->id }})" wire:loading.attr="disabled"
                            wire:target="withdrawAdmission({{ $admission->id }})"
                            class="min-h-11 px-3 rounded-md bg-slate-100 text-slate-700 text-sm font-semibold disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <span wire:loading.remove wire:target="withdrawAdmission({{ $admission->id }})">Withdraw</span><span wire:loading wire:target="withdrawAdmission({{ $admission->id }})">...</span>
                        </button>
                    @endif
                </div>
            </article>
        @empty
            <div class="rounded-xl border border-[#E2E8F0] bg-white px-4 py-10 text-center">
                <i class="fas fa-file-alt text-4xl text-slate-300 mb-3"></i>
                <p class="text-slate-500 text-sm">No admissions found.</p>
            </div>
        @endforelse
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="hidden overflow-x-auto md:block">
            <table class="w-full min-w-[640px] text-sm lg:min-w-[900px]">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Admission #</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Applicant</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Grade Applying</th>
                        <th class="hidden px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase lg:table-cell">Admission Date</th>
                        <th class="hidden px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase lg:table-cell">Type</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($admissions as $admission)
                        <tr class="hover:bg-sky-50/60 transition-colors">
                            <td class="px-4 sm:px-6 py-3 font-mono text-xs text-slate-600">
                                {{ $admission->admission_number }}</td>
                            <td class="px-4 sm:px-6 py-3 font-semibold text-slate-800">{{ $admission->applicant_name }}
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-slate-600">{{ $admission->grade->level }}
                                {{ $admission->grade->section }}</td>
                            <td class="hidden px-4 sm:px-6 py-3 text-slate-600 lg:table-cell">
                                {{ $admission->date_of_admission?->format('d M Y') ?? '—' }}
                            </td>
                            <td class="hidden px-4 sm:px-6 py-3 text-center lg:table-cell">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-sky-100 text-[#155E8A]">{{ $admission->student_type }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-3">
                                <div class="flex justify-center flex-wrap gap-2">
                                    @if ($canView)
                                        <button wire:click="viewAdmission({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="viewAdmission({{ $admission->id }})"
                                            title="View admission" aria-label="View admission for {{ $admission->applicant_name }}"
                                            class="h-11 w-11 rounded-md bg-sky-100 hover:bg-sky-700 hover:text-white text-sky-700 flex items-center justify-center disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <i class="fas fa-eye text-xs" wire:loading.remove
                                                wire:target="viewAdmission({{ $admission->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="viewAdmission({{ $admission->id }})"></i>
                                        </button>
                                    @endif

                                    @if ($canView && in_array($admission->status, ['rejected']))
                                        <button wire:click="viewAudit({{ $admission->id }})"
                                            wire:loading.attr="disabled" wire:target="viewAudit({{ $admission->id }})"
                                            title="View audit trail" aria-label="View audit trail for {{ $admission->applicant_name }}"
                                            class="h-11 w-11 rounded-md bg-slate-100 hover:bg-slate-600 hover:text-white text-slate-600 flex items-center justify-center disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <i class="fas fa-clock-rotate-left text-xs" wire:loading.remove
                                                wire:target="viewAudit({{ $admission->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="viewAudit({{ $admission->id }})"></i>
                                        </button>
                                    @endif

                                    @if ($canManage && $admission->status === 'pending')
                                        <button wire:click="confirmAdmit({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmAdmit({{ $admission->id }})"
                                            class="min-h-11 px-3 py-1.5 rounded-md bg-green-100 hover:bg-green-600 hover:text-white text-green-700 text-sm font-semibold disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <span wire:loading.remove
                                                wire:target="confirmAdmit({{ $admission->id }})">Admit</span>
                                            <span wire:loading
                                                wire:target="confirmAdmit({{ $admission->id }})">...</span>
                                        </button>

                                        <button wire:click="confirmReject({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmReject({{ $admission->id }})"
                                            class="min-h-11 px-3 py-1.5 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] text-sm font-semibold disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            Reject
                                        </button>

                                        <button wire:click="withdrawAdmission({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="withdrawAdmission({{ $admission->id }})"
                                            class="min-h-11 px-3 py-1.5 rounded-md bg-slate-100 hover:bg-slate-500 hover:text-white text-slate-600 text-sm font-semibold disabled:opacity-60 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                            <span wire:loading.remove
                                                wire:target="withdrawAdmission({{ $admission->id }})">Withdraw</span>
                                            <span wire:loading
                                                wire:target="withdrawAdmission({{ $admission->id }})">...</span>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-14">
                                <i class="fas fa-file-alt text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No admissions found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
            {{ $admissions->links() }}
        </div>
    </div>

    {{-- CREATE MODAL --}}
    @if ($showAddModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92dvh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'New Admission'])
                        <button type="button" wire:click="closeCreateModal"
                            aria-label="Close new admission form"
                            class="shrink-0 h-11 w-11 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="storeAdmission" class="flex flex-col flex-1 min-h-0">
                    <div
                        class="break-words p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC] [&_.relative>input]:!text-base">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Applicant Name *</label>
                            <input type="text" wire:model="applicant_name"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                            @error('applicant_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Age *</label>
                            <input type="number" wire:model="age"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                            @error('age')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Gender *</label>
                            <select wire:model="gender"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                <option value="">Select</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                            @error('gender')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Parent Phone *</label>
                            @if ($phoneCountryPickerAvailable)
                                <div class="flex gap-2">
                                    <div class="relative w-32 sm:w-40 shrink-0" x-data="{ open: false, search: '' }"
                                        @click.outside="open = false">
                                        <button type="button" @click="open = !open"
                                            aria-haspopup="listbox" :aria-expanded="open.toString()"
                                            class="w-full h-full min-h-11 flex items-center justify-between gap-2 px-2.5 rounded-lg border border-slate-300 bg-white text-base text-slate-700">
                                            <span class="flex items-center gap-2 min-w-0">
                                                <img src="{{ $selectedPhoneCountry['flag'] }}"
                                                    alt="{{ $selectedPhoneCountry['name'] }} flag"
                                                    class="h-4 w-6 object-cover shrink-0">
                                                <span class="truncate">{{ $selectedPhoneCountry['dial_code'] }}</span>
                                            </span>
                                            <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                                        </button>
                                        <div x-cloak x-show="open" x-transition
                                            class="absolute left-0 top-full z-30 mt-1 w-72 max-w-[85vw] rounded-lg border border-slate-200 bg-white shadow-lg">
                                            <label class="sr-only" for="parent-phone-country-search">Search African countries</label>
                                            <input id="parent-phone-country-search" type="search" x-model="search"
                                                @keydown.escape="open = false" placeholder="Search countries or codes"
                                                class="w-full rounded-t-lg border-0 border-b border-slate-200 px-3 py-3 text-base focus:ring-2 focus:ring-[#155E8A]/30">
                                            <div role="listbox" aria-label="African countries"
                                                class="max-h-56 overflow-y-auto p-1">
                                                @foreach ($africanPhoneCountries as $country)
                                                    <button type="button" role="option"
                                                        aria-selected="{{ $parentPhoneCountry === $country['code'] ? 'true' : 'false' }}"
                                                        data-search="{{ mb_strtolower($country['name'] . ' ' . $country['dial_code']) }}"
                                                        x-show="!search || $el.dataset.search.includes(search.toLowerCase())"
                                                        x-on:click="open = false; search = ''"
                                                        wire:click="selectParentPhoneCountry('{{ $country['code'] }}')"
                                                        class="flex min-h-11 w-full items-center gap-2 rounded-md px-2 py-2 text-left text-sm text-slate-700 hover:bg-sky-50 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                                                        <img src="{{ $country['flag'] }}" alt="{{ $country['name'] }} flag"
                                                            loading="lazy" class="h-4 w-6 object-cover shrink-0">
                                                        <span class="min-w-0 flex-1 truncate">{{ $country['name'] }}</span>
                                                        <span class="font-mono text-xs text-slate-500">{{ $country['dial_code'] }}</span>
                                                    </button>
                                                @endforeach
                                            </div>
                                        </div>
                                    </div>
                                    <input type="tel" inputmode="numeric" wire:model="parentPhoneNational"
                                        aria-label="Parent phone national number"
                                        placeholder="National number"
                                        class="min-w-0 flex-1 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                </div>
                                @error('parentPhoneCountry')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                @error('parentPhoneNational')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                @error('parent_phone')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            @else
                                <input type="text" wire:model="parent_phone"
                                    class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                @error('parent_phone')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            @endif
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Grade Applying For
                                *</label>
                            <select wire:model="grade_id"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                <option value="">Select Grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}
                                    </option>
                                @endforeach
                            </select>
                            @error('grade_id')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>


                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Academic Year</label>
                            <select wire:model="academicYearId"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                <option value="">Use Active Year</option>
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Student Type *</label>
                            <select wire:model="student_type"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                <option value="New">New</option>
                                <option value="Old">Old</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Last School
                                Attended</label>
                            <input type="text" wire:model="last_school_attended"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Photo</label>
                            <input type="file" wire:model="image" class="w-full min-w-0 text-base">
                            <div wire:loading wire:target="image" class="text-xs text-sky-600 mt-1">
                                <i class="fas fa-spinner fa-spin"></i> Uploading photo...
                            </div>
                            @error('image')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Transcript</label>
                            <input type="file" wire:model="transcript" class="w-full min-w-0 text-base">
                            <div wire:loading wire:target="transcript" class="text-xs text-sky-600 mt-1">
                                <i class="fas fa-spinner fa-spin"></i> Uploading transcript...
                            </div>
                            @error('transcript')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Recommendation
                                Letter</label>
                            <input type="file" wire:model="recommendation_letter" class="w-full min-w-0 text-base">
                            <div wire:loading wire:target="recommendation_letter" class="text-xs text-sky-600 mt-1">
                                <i class="fas fa-spinner fa-spin"></i> Uploading recommendation letter...
                            </div>
                            @error('recommendation_letter')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeCreateModal"
                            class="min-h-11 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled"
                            wire:target="storeAdmission,image,transcript,recommendation_letter"
                            class="min-h-11 px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm disabled:opacity-60 disabled:cursor-not-allowed focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <span wire:loading.remove
                                wire:target="storeAdmission,image,transcript,recommendation_letter">Submit
                                Application</span>
                            <span wire:loading wire:target="storeAdmission,image,transcript,recommendation_letter">
                                <i class="fas fa-spinner fa-spin text-xs mr-1"></i> Uploading...
                            </span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ADMIT MODAL --}}
    @if ($showAdmitModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92dvh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'Admit Applicant'])
                        <button type="button" wire:click="closeAdmitModal"
                            aria-label="Close admit applicant form"
                            class="shrink-0 h-11 w-11 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                <form wire:submit.prevent="admitApplicant" class="flex flex-col flex-1 min-h-0">
                    <div class="break-words p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC] [&_.relative>input]:!text-base">
                        <p class="text-xs text-slate-500 bg-sky-50 border border-sky-100 rounded-lg px-3 py-2">
                            <i class="fas fa-circle-info mr-1"></i>
                            Admitting this applicant creates their student login account and enrolls them in the
                            selected academic year.
                        </p>
                        @if ($admitAdmission)
                            <div class="flex items-center gap-3 rounded-lg border border-slate-200 bg-white p-3">
                                @if ($admitAdmission->image)
                                    <img src="{{ asset('storage/' . $admitAdmission->image) }}"
                                        alt="{{ $admitAdmission->applicant_name }} photo"
                                        class="h-14 w-14 rounded-full object-cover border border-slate-200 shrink-0">
                                @else
                                    <div aria-hidden="true"
                                        class="h-14 w-14 rounded-full bg-sky-100 text-[#155E8A] flex items-center justify-center font-semibold text-lg shrink-0">
                                        {{ strtoupper(substr($admitAdmission->applicant_name, 0, 1)) }}
                                    </div>
                                @endif
                                <div class="min-w-0">
                                    <p class="text-sm font-semibold text-slate-800 truncate">
                                        {{ $admitAdmission->applicant_name }}</p>
                                    <p class="text-xs text-slate-500 font-mono truncate">
                                        {{ $admitAdmission->admission_number }}</p>
                                </div>
                            </div>
                        @endif
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Admission Date *</label>
                            <input type="date" wire:model="admitDate"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                            @error('admitDate')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Academic Year *</label>
                            <select wire:model="admitAcademicYearId"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                                <option value="">Select Academic Year</option>
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                            @error('admitAcademicYearId')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Student Login Email
                                *</label>
                            <input type="email" wire:model="admitEmail"
                                class="w-full min-w-0 px-3 py-3 rounded-lg border border-slate-300 text-base">
                            @error('admitEmail')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{ pass: '', confirm: '' }"
                            x-on:admit-default-password-set.window="pass = $event.detail.password; confirm = $event.detail.password">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                                <label class="block text-xs font-semibold text-slate-600">Password *</label>
                                <button type="button" wire:click="useSystemDefaultPassword"
                                    class="text-xs font-semibold text-[#155E8A] hover:text-[#0F4A6E] underline underline-offset-2">
                                    Use system default password
                                </button>
                            </div>
                            @include('livewire.admin.partials.password-input', [
                                'inputId' => 'admit-password',
                                'field' => 'admitPassword',
                                'alpineModel' => 'pass',
                                'label' => 'Password',
                            ])
                            @error('admitPassword')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 mt-3">Confirm Password
                                *</label>
                            @include('livewire.admin.partials.password-input', [
                                'inputId' => 'admit-password-confirmation',
                                'field' => 'admitPassword_confirmation',
                                'alpineModel' => 'confirm',
                                'label' => 'Confirm password',
                            ])
                            <p class="mt-1 text-xs" x-show="confirm.length > 0"
                                x-text="pass === confirm ? '✓ Passwords match' : '✕ Passwords do not match'"
                                :class="pass === confirm ? 'text-green-600' : 'text-red-600'"></p>
                        </div>
                    </div>
                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeAdmitModal"
                            class="min-h-11 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Cancel</button>
                        <button type="submit"
                            class="min-h-11 px-5 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-sm focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <span wire:loading.remove wire:target="admitApplicant">Confirm Admit</span>
                            <span wire:loading wire:target="admitApplicant">Admitting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- REJECT MODAL --}}
    @if ($showRejectModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm max-h-[92dvh] overflow-y-auto rounded-xl shadow-xl border border-red-100">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">Reject Admission</h3>
                    <button wire:click="closeRejectModal"
                        aria-label="Close reject admission form"
                        class="h-11 w-11 shrink-0 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <form wire:submit.prevent="rejectAdmission" class="break-words p-4 space-y-2">
                    <label class="block text-xs font-medium text-gray-700">Reason *</label>
                    <textarea wire:model="rejectReason" rows="3"
                        class="w-full min-w-0 text-base py-3 px-3 border border-gray-300 rounded-md"></textarea>
                    @error('rejectReason')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex flex-col-reverse gap-2 pt-2 sm:flex-row sm:justify-end">
                        <button type="button" wire:click="closeRejectModal"
                            class="min-h-11 px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Cancel</button>
                        <button type="submit"
                            class="min-h-11 px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <span wire:loading.remove wire:target="rejectAdmission">Reject</span>
                            <span wire:loading wire:target="rejectAdmission">Rejecting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- VIEW MODAL --}}
    @if ($showViewModal && $view_admission)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92dvh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => $view_admission->applicant_name,
                        ])
                        <button wire:click="closeViewModal"
                            aria-label="Close admission details"
                            class="shrink-0 h-11 w-11 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="break-words p-4 sm:p-6 bg-[#F8FAFC] space-y-5 text-sm overflow-y-auto flex-1 min-h-0">

                    {{-- Profile photo + core identity --}}
                    <div class="flex items-center gap-4">
                        @if ($view_admission->image)
                            <img src="{{ asset('storage/' . $view_admission->image) }}"
                                class="h-16 w-16 rounded-full object-cover border-2 border-sky-100 shrink-0">
                        @else
                            <div
                                class="h-16 w-16 rounded-full bg-sky-100 text-[#155E8A] flex items-center justify-center font-bold text-xl shrink-0">
                                {{ strtoupper(substr($view_admission->applicant_name, 0, 1)) }}
                            </div>
                        @endif
                        <div class="min-w-0">
                            <p class="font-semibold text-slate-800 truncate">{{ $view_admission->applicant_name }}</p>
                            <p class="text-xs text-slate-500 font-mono">{{ $view_admission->admission_number }}</p>
                        </div>
                    </div>

                    {{-- Core details --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="text-xs text-slate-500">Grade Applying</label>
                            <p class="break-words font-semibold">{{ $view_admission->grade->level }}
                                {{ $view_admission->grade->section }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Age / Gender</label>
                            <p class="break-words font-semibold">{{ $view_admission->age }} / {{ $view_admission->gender }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Parent Phone</label>
                            <p class="break-all font-semibold">{{ $view_admission->parent_phone }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Student Type</label>
                            <p class="font-semibold">{{ $view_admission->student_type }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Last School</label>
                            <p class="break-words font-semibold">{{ $view_admission->last_school_attended ?? '—' }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Status</label>
                            <p class="font-semibold capitalize">{{ $view_admission->status }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Date of Admission</label>
                            <p class="font-semibold">{{ $view_admission->date_of_admission?->format('d M Y') ?? '—' }}
                            </p>
                        </div>
                        @if ($view_admission->rejection_reason)
                            <div class="sm:col-span-2"><label class="text-xs text-slate-500">Rejection Reason</label>
                                <p class="break-words">{{ $view_admission->rejection_reason }}</p>
                            </div>
                        @endif
                    </div>

                    {{-- Audit --}}
                    <div class="border-t border-slate-200 pt-4">
                        <label class="text-xs text-slate-500">Reviewed By</label>
                        @if ($view_admission->reviewer)
                            <p class="font-semibold">
                                {{ $view_admission->reviewer->name }}
                                <span class="text-xs text-slate-400 font-normal">
                                    ({{ $view_admission->reviewer->getRoleNames()->first() ?? 'Staff' }})
                                </span>
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $view_admission->reviewed_at?->format('d M Y, h:i A') }}</p>
                        @else
                            <p class="text-sm text-slate-400 italic">
                                Not yet reviewed by
                                staff{{ $view_admission->status === 'pending' ? ' — submitted and awaiting review.' : '.' }}
                            </p>
                        @endif
                    </div>
                    {{-- Uploaded documents --}}
                    <div class="border-t border-slate-200 pt-4">
                        <label class="text-xs text-slate-500 block mb-2">Documents</label>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            @if ($view_admission->transcript)
                                <a href="{{ asset('storage/' . $view_admission->transcript) }}" target="_blank"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-red-50 hover:border-red-200 transition-colors">
                                    <span
                                        class="h-9 w-9 rounded-lg bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                                        <i class="fas fa-file-pdf text-base"></i>
                                    </span>
                                    <span class="min-w-0">
                                        <span
                                            class="block text-xs font-semibold text-slate-700 truncate">Transcript</span>
                                        <span class="block text-[11px] text-slate-400">Click to view</span>
                                    </span>
                                </a>
                            @endif

                            @if ($view_admission->recommendation_letter)
                                <a href="{{ asset('storage/' . $view_admission->recommendation_letter) }}"
                                    target="_blank"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-blue-50 hover:border-blue-200 transition-colors">
                                    <span
                                        class="h-9 w-9 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center shrink-0">
                                        <i class="fas fa-file-lines text-base"></i>
                                    </span>
                                    <span class="min-w-0">
                                        <span
                                            class="block text-xs font-semibold text-slate-700 truncate">Recommendation
                                            Letter</span>
                                        <span class="block text-[11px] text-slate-400">Click to view</span>
                                    </span>
                                </a>
                            @endif

                            @if ($view_admission->image)
                                <a href="{{ asset('storage/' . $view_admission->image) }}" target="_blank"
                                    class="flex items-center gap-3 px-3 py-2.5 rounded-lg border border-slate-200 bg-white hover:bg-sky-50 hover:border-sky-200 transition-colors">
                                    <span
                                        class="h-9 w-9 rounded-lg bg-sky-100 text-sky-600 flex items-center justify-center shrink-0">
                                        <i class="fas fa-image text-base"></i>
                                    </span>
                                    <span class="min-w-0">
                                        <span class="block text-xs font-semibold text-slate-700 truncate">Applicant
                                            Photo</span>
                                        <span class="block text-[11px] text-slate-400">Click to view</span>
                                    </span>
                                </a>
                            @endif
                        </div>
                        @if (!$view_admission->transcript && !$view_admission->recommendation_letter && !$view_admission->image)
                            <p class="text-xs text-slate-400">No documents were uploaded for this application.</p>
                        @endif
                    </div>

                </div>
                <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end shrink-0">
                    <button wire:click="closeViewModal"
                        class="min-h-11 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Close</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showAuditModal && $audit_record)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92dvh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'Audit Trail'])
                        <button wire:click="closeAuditModal"
                            aria-label="Close admission audit trail"
                            class="shrink-0 h-11 w-11 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="break-words p-4 sm:p-6 bg-[#F8FAFC] space-y-3 text-sm overflow-y-auto flex-1 min-h-0">
                    <div>
                        <label class="text-xs text-slate-500">Applicant</label>
                        <p class="font-semibold">{{ $audit_record->applicant_name }}
                            ({{ $audit_record->admission_number }})</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Academic Year</label>
                        <p class="font-semibold">{{ $audit_record->academicYear?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Status</label>
                        <p class="font-semibold capitalize">{{ $audit_record->status }}</p>
                    </div>
                    @if ($audit_record->rejection_reason)
                        <div>
                            <label class="text-xs text-slate-500">Reason</label>
                            <p class="font-semibold">{{ $audit_record->rejection_reason }}</p>
                        </div>
                    @endif
                    <div>
                        <label class="text-xs text-slate-500">Performed By</label>
                        <p class="font-semibold">
                            {{ $audit_record->reviewer?->name ?? '—' }}
                            @if ($audit_record->reviewer)
                                <span class="text-xs text-slate-400 font-normal">
                                    ({{ $audit_record->reviewer->getRoleNames()->first() ?? 'Staff' }})
                                </span>
                            @endif
                        </p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Date & Time</label>
                        <p class="font-semibold">{{ $audit_record->reviewed_at?->format('d M Y, h:i A') ?? '—' }}</p>
                    </div>
                </div>
                <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end shrink-0">
                    <button wire:click="closeAuditModal"
                        class="min-h-11 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#F7B731]">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
