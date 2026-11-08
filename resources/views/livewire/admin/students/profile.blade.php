<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    {{-- ========================= HEADER — flat, matches Fee Categories / Academic Years pattern ========================= --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div class="flex items-center gap-3">
            @if ($student->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($student->image))
                <img src="{{ asset('storage/' . $student->image) }}"
                    alt="{{ $student->name }} photo"
                    class="h-12 w-12 rounded-lg object-cover border border-slate-200">
            @else
                <div
                    class="h-12 w-12 rounded-lg bg-sky-100 text-[#155E8A] flex items-center justify-center font-bold text-lg">
                    {{ strtoupper(substr($student->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h1 class="text-2xl font-bold text-gray-800">{{ $student->name }}</h1>
                <p class="text-gray-500 text-sm mt-0.5 font-mono">{{ $student->user->registration_id }}</p>
            </div>
        </div>
        <div class="flex gap-2">
            <a href="{{ route('admin.students.index') }}"
                class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md border border-gray-300 text-gray-600 font-semibold text-sm hover:bg-gray-100">
                <i class="fas fa-arrow-left text-xs"></i> Back to Students
            </a>
            @if ($canEdit)
                <button wire:click="openEditModal" wire:loading.attr="disabled" wire:target="openEditModal"
                    class="inline-flex items-center gap-2 px-4 py-2.5 rounded-md bg-[#155E8A] text-white font-semibold text-sm hover:opacity-90 disabled:opacity-60">
                    <i class="fas fa-pen text-xs" wire:loading.remove wire:target="openEditModal"></i>
                    <i class="fas fa-spinner fa-spin text-xs" wire:loading wire:target="openEditModal"></i>
                    Edit
                </button>
            @endif
        </div>
    </div>

    {{-- ========================= STATUS STRIP ========================= --}}
    <div
        class="flex flex-wrap items-center gap-x-6 gap-y-2 text-sm bg-gray-50 border border-gray-200 rounded-md px-4 py-3">
        <div class="flex items-center gap-1.5">
            <span class="text-gray-500">Status:</span>
            @php $st = $student->enrollment?->status; @endphp
            @if ($st === 'active')
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Active</span>
            @elseif ($st === 'graduated')
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-sky-100 text-[#155E8A]">Graduated</span>
            @elseif ($st === 'suspended')
                <span
                    class="px-2 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-700">Suspended</span>
            @elseif (in_array($st, ['transferred', 'dropped_out', 'expelled']))
                <span
                    class="px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700 capitalize">{{ str_replace('_', ' ', $st) }}</span>
            @else
                <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-500">No
                    Enrollment</span>
            @endif
        </div>

        <div class="flex items-center gap-1.5">
            <span class="text-gray-500">Grade:</span>
            <span class="font-medium text-gray-700">{{ optional($student->enrollment?->grade)->level ?? '—' }}
                {{ optional($student->enrollment?->grade)->section }}</span>
        </div>

        <div class="flex items-center gap-1.5">
            <span class="text-gray-500">Academic Year:</span>
            <span
                class="font-medium text-gray-700">{{ optional($student->enrollment?->academicYear)->name ?? '—' }}</span>
        </div>

        @if ($student->admission)
            <div class="flex items-center gap-1.5">
                <span class="text-gray-500">Student Type:</span>
                <span class="font-medium text-gray-700">{{ $student->admission->student_type }}</span>
            </div>
        @endif
    </div>

    {{-- ========================= TABS ========================= --}}
    <div class="flex flex-wrap gap-1 border-b border-gray-200">
        @foreach (['overview' => 'Overview', 'admission' => 'Admission & Documents', 'academic' => 'Academic History', 'account' => 'Account'] as $key => $label)
            <button wire:click="setTab('{{ $key }}')"
                class="px-4 py-2.5 text-sm font-semibold border-b-2 transition-colors {{ $activeTab === $key ? 'border-[#155E8A] text-[#155E8A]' : 'border-transparent text-gray-500 hover:text-gray-700' }}">
                {{ $label }}
            </button>
        @endforeach
    </div>

    {{-- ========================= OVERVIEW ========================= --}}
    @if ($activeTab === 'overview')
        <div class="bg-white rounded-md border border-gray-200">
            <div class="px-5 py-3 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700">Personal Information</h3>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Age</p>
                    <p class="font-medium text-gray-800 mt-0.5">{{ $student->age }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Gender</p>
                    <p class="font-medium text-gray-800 mt-0.5">{{ $student->gender }}</p>
                </div>
                <div>
                    <p class="text-gray-500">Parent / Guardian Phone</p>
                    @if ($student->parent_phone)
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $student->parent_phone) }}"
                            class="font-medium text-[#155E8A] hover:underline underline-offset-2 mt-0.5 inline-block">
                            {{ $student->parent_phone }}
                        </a>
                    @else
                        <p class="font-medium text-gray-800 mt-0.5">—</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-500">Registration ID</p>
                    <p class="font-medium text-gray-800 font-mono mt-0.5">{{ $student->user->registration_id }}</p>
                </div>
                @if ($student->admission?->admission_number)
                    <div>
                        <p class="text-gray-500">Admission Number</p>
                        <p class="font-medium text-gray-800 font-mono mt-0.5">
                            {{ $student->admission->admission_number }}</p>
                    </div>
                @endif
                @if ($student->admission?->date_of_admission)
                    <div>
                        <p class="text-gray-500">Date of Admission</p>
                        <p class="font-medium text-gray-800 mt-0.5">
                            {{ $student->admission->date_of_admission->format('d M Y') }}</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ========================= ADMISSION & DOCUMENTS ========================= --}}
    @if ($activeTab === 'admission')
        <div class="space-y-5">

            <div class="bg-white rounded-md border border-gray-200">
                <div class="px-5 py-3 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700">Admission Application</h3>
                </div>

                @if ($student->admission)
                    <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                        <div>
                            <p class="text-gray-500">Applicant Name</p>
                            <p class="font-medium text-gray-800 mt-0.5">{{ $student->admission->applicant_name }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Grade Applied For</p>
                            <p class="font-medium text-gray-800 mt-0.5">
                                {{ optional($student->admission->grade)->level }}
                                {{ optional($student->admission->grade)->section }}</p>
                        </div>
                        <div>
                            <p class="text-gray-500">Application Status</p>
                            <p class="mt-0.5">
                                <span
                                    class="px-2 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700 capitalize">{{ $student->admission->status }}</span>
                            </p>
                        </div>
                        @if ($student->admission->last_school_attended)
                            <div>
                                <p class="text-gray-500">Last School Attended</p>
                                <p class="font-medium text-gray-800 mt-0.5">
                                    {{ $student->admission->last_school_attended }}</p>
                            </div>
                        @endif
                        @if ($student->admission->reviewed_at)
                            <div>
                                <p class="text-gray-500">Reviewed On</p>
                                <p class="font-medium text-gray-800 mt-0.5">
                                    {{ $student->admission->reviewed_at->format('d M Y, h:i A') }}</p>
                            </div>
                        @endif
                    </div>
                @else
                    <div class="px-5 py-8 text-center text-sm text-gray-400">
                        No admission record is linked to this student.
                    </div>
                @endif
            </div>

            <div class="bg-white rounded-md border border-gray-200">
                <div class="px-5 py-3 border-b border-gray-200">
                    <h3 class="text-sm font-semibold text-gray-700">Submitted Documents</h3>
                </div>

                @php
                    $documents = collect();
                    if ($student->admission) {
                        $documents = collect([
                            [
                                'label' => 'Transcript',
                                'icon' => 'fa-file-lines',
                                'path' => $student->admission->transcript,
                            ],
                            [
                                'label' => 'Recommendation Letter',
                                'icon' => 'fa-file-signature',
                                'path' => $student->admission->recommendation_letter,
                            ],
                        ]);
                        if ($student->admission->image) {
                            $documents->push([
                                'label' => 'Submitted Photo',
                                'icon' => 'fa-image',
                                'path' => $student->admission->image,
                            ]);
                        }
                    }
                @endphp

                @if ($documents->isNotEmpty())
                    <div class="divide-y divide-gray-100">
                        @foreach ($documents as $doc)
                            @if (!empty($doc['path']) && \Illuminate\Support\Facades\Storage::disk('public')->exists($doc['path']))
                                <a href="{{ asset('storage/' . $doc['path']) }}" target="_blank" rel="noopener"
                                    class="flex items-center gap-3 px-5 py-3 hover:bg-gray-50 transition-colors group">
                                    <i class="fas {{ $doc['icon'] }} text-gray-400 text-sm w-4"></i>
                                    <span class="text-sm font-medium text-gray-700 flex-1">{{ $doc['label'] }}</span>
                                    <span
                                        class="text-xs text-[#155E8A] font-medium opacity-0 group-hover:opacity-100 transition-opacity">View
                                        →</span>
                                </a>
                            @else
                                <div class="flex items-center gap-3 px-5 py-3">
                                    <i class="fas {{ $doc['icon'] }} text-gray-300 text-sm w-4"></i>
                                    <span class="text-sm text-gray-500 flex-1">{{ $doc['label'] }}</span>
                                    <span class="text-xs text-gray-400">File not available</span>
                                </div>
                            @endif
                        @endforeach
                    </div>
                @else
                    <div class="px-5 py-8 text-center">
                        <p class="text-sm text-gray-500">No documents submitted.</p>
                        <p class="text-xs text-gray-400 mt-1">Transcripts or recommendation letters uploaded during
                            admission will appear here.</p>
                    </div>
                @endif
            </div>
        </div>
    @endif

    {{-- ========================= ACADEMIC HISTORY ========================= --}}
    @if ($activeTab === 'academic')
        <div class="bg-white rounded-md border border-gray-200 overflow-hidden">
            <div class="px-5 py-3 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700">Promotion History</h3>
            </div>

            @if ($student->promotions->isNotEmpty())
                <table class="w-full text-sm">
                    <thead class="bg-gray-50 text-gray-500 text-xs uppercase">
                        <tr>
                            <th class="px-5 py-2.5 text-left">From</th>
                            <th class="px-5 py-2.5 text-left">To</th>
                            <th class="px-5 py-2.5 text-left">Date</th>
                            <th class="px-5 py-2.5 text-left">Remarks</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($student->promotions as $promo)
                            <tr>
                                <td class="px-5 py-3 text-gray-700">{{ $promo->fromGrade->level }}
                                    {{ $promo->fromGrade->section }}</td>
                                <td class="px-5 py-3 text-gray-700 font-medium">{{ $promo->toGrade->level }}
                                    {{ $promo->toGrade->section }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ $promo->promoted_at->format('d M Y') }}</td>
                                <td class="px-5 py-3 text-gray-500">{{ $promo->remarks ?? '—' }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <div class="px-5 py-8 text-center">
                    <p class="text-sm text-gray-500">No promotion history yet.</p>
                    <p class="text-xs text-gray-400 mt-1">Once this student is promoted to a new grade, it will appear
                        here.</p>
                </div>
            @endif
        </div>
    @endif

    {{-- ========================= ACCOUNT ========================= --}}
    @if ($activeTab === 'account')
        <div class="bg-white rounded-md border border-gray-200">
            <div class="px-5 py-3 border-b border-gray-200">
                <h3 class="text-sm font-semibold text-gray-700">Login Account</h3>
            </div>
            <div class="p-5 grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-4 text-sm">
                <div>
                    <p class="text-gray-500">Login Email</p>
                    @if ($student->user->email)
                        <a href="mailto:{{ $student->user->email }}"
                            class="font-medium text-[#155E8A] hover:underline underline-offset-2 mt-0.5 inline-block">
                            {{ $student->user->email }}
                        </a>
                    @else
                        <p class="font-medium text-gray-800 mt-0.5">—</p>
                    @endif
                </div>
                <div>
                    <p class="text-gray-500">Account Status</p>
                    <p class="mt-0.5">
                        @php $accStatus = $student->user->status; @endphp
                        <span
                            class="px-2 py-0.5 rounded-full text-xs font-medium capitalize
                            {{ $accStatus === 'active' ? 'bg-green-100 text-green-700' : ($accStatus === 'suspended' ? 'bg-red-100 text-red-700' : 'bg-gray-100 text-gray-500') }}">
                            {{ $accStatus }}
                        </span>
                    </p>
                </div>
                <div>
                    <p class="text-gray-500">Account Created</p>
                    <p class="font-medium text-gray-800 mt-0.5">{{ $student->user->created_at->format('d M Y') }}</p>
                </div>
            </div>
        </div>
    @endif

    {{-- ========================= EDIT MODAL — unchanged from before ========================= --}}
    @if ($showEditModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'Edit Student'])
                        <button type="button" wire:click="closeEditModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                <form wire:submit.prevent="updateStudent" class="flex flex-col flex-1 min-h-0">
                    <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Name</label>
                            <input type="text" wire:model="name"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Age</label>
                                <input type="number" wire:model="age"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                @error('age')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Gender</label>
                                <select wire:model="gender"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    <option value="Male">Male</option>
                                    <option value="Female">Female</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Parent Phone</label>
                            @if ($parentPhoneUsesPicker && $phoneCountryPickerAvailable)
                                <div class="flex gap-2">
                                    <div class="relative w-40 shrink-0" x-data="{ open: false, search: '' }"
                                        @click.outside="open = false">
                                        @php
                                            $selectedStudentPhoneCountry = collect($africanPhoneCountries)->firstWhere('code', $parentPhoneCountry);
                                        @endphp
                                        <button type="button" @click="open = !open"
                                            aria-haspopup="listbox" :aria-expanded="open.toString()"
                                            class="w-full h-full min-h-[38px] flex items-center justify-between gap-2 px-2.5 rounded-lg border border-slate-300 bg-white text-sm text-slate-700">
                                            <span class="flex items-center gap-2 min-w-0">
                                                <img src="{{ $selectedStudentPhoneCountry['flag'] ?? '' }}"
                                                    alt="{{ $selectedStudentPhoneCountry['name'] ?? 'Selected country' }} flag"
                                                    class="h-4 w-6 object-cover shrink-0">
                                                <span class="truncate">{{ $selectedStudentPhoneCountry['dial_code'] ?? '' }}</span>
                                            </span>
                                            <i class="fas fa-chevron-down text-[10px] text-slate-400"></i>
                                        </button>
                                        <div x-cloak x-show="open" x-transition
                                            class="absolute left-0 top-full z-30 mt-1 w-72 max-w-[85vw] rounded-lg border border-slate-200 bg-white shadow-lg">
                                            <label class="sr-only" for="student-parent-phone-country-search">Search African countries</label>
                                            <input id="student-parent-phone-country-search" type="search" x-model="search"
                                                @keydown.escape="open = false" placeholder="Search countries or codes"
                                                class="w-full rounded-t-lg border-0 border-b border-slate-200 px-3 py-2 text-sm focus:ring-2 focus:ring-[#155E8A]/30">
                                            <div role="listbox" aria-label="African countries"
                                                class="max-h-56 overflow-y-auto p-1">
                                                @foreach ($africanPhoneCountries as $country)
                                                    <button type="button" role="option"
                                                        aria-selected="{{ $parentPhoneCountry === $country['code'] ? 'true' : 'false' }}"
                                                        data-search="{{ mb_strtolower($country['name'] . ' ' . $country['dial_code']) }}"
                                                        x-show="!search || $el.dataset.search.includes(search.toLowerCase())"
                                                        x-on:click="open = false; search = ''"
                                                        wire:click="selectParentPhoneCountry('{{ $country['code'] }}')"
                                                        class="flex w-full items-center gap-2 rounded-md px-2 py-2 text-left text-sm text-slate-700 hover:bg-sky-50">
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
                                        aria-label="Parent phone national number" placeholder="National number"
                                        class="min-w-0 flex-1 px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                </div>
                                <button type="button" wire:click="useParentPhonePlainInput"
                                    class="mt-1 text-xs text-[#155E8A] underline underline-offset-2">Use number as stored</button>
                                @error('parentPhoneCountry')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                                @error('parentPhoneNational')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            @else
                                <input type="text" wire:model="parent_phone"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                @if ($phoneCountryPickerAvailable)
                                    <button type="button" wire:click="useParentPhoneCountryPicker"
                                        class="mt-1 text-xs text-[#155E8A] underline underline-offset-2">Use African country picker</button>
                                @endif
                            @endif
                            @error('parent_phone')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Replace Photo</label>
                            <input type="file" wire:model="image" class="w-full text-sm">
                            @if ($student->image)
                                <p class="mt-1 text-xs text-slate-500">
                                    @if (\Illuminate\Support\Facades\Storage::disk('public')->exists($student->image))
                                        Current photo is available.
                                    @else
                                        Current photo file not available.
                                    @endif
                                </p>
                            @endif
                        </div>
                        @if ($student->admission)
                            <hr class="border-slate-200">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Admission Date</label>
                                <input type="date" wire:model="dateOfAdmission"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                @error('dateOfAdmission')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        @endif
                        <hr class="border-slate-200">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Login Email</label>
                            <input type="email" wire:model="email"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('email')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Account Status</label>
                            <select wire:model="status"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="active">Active</option>
                                <option value="inactive">Inactive</option>
                                <option value="suspended">Suspended</option>
                            </select>
                        </div>
                        <div x-data="{ pass: '', confirm: '' }"
                            x-on:student-default-password-set.window="pass = $event.detail.password; confirm = $event.detail.password">
                            <div class="flex flex-wrap items-center justify-between gap-2 mb-1.5">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">New Password
                                (optional)</label>
                                <button type="button" wire:click="useSystemDefaultPassword"
                                    class="text-xs font-semibold text-[#155E8A] hover:text-[#0F4A6E] underline underline-offset-2">
                                    Use system default password
                                </button>
                            </div>
                            @include('livewire.admin.partials.password-input', [
                                'inputId' => 'student-new-password',
                                'field' => 'new_password',
                                'alpineModel' => 'pass',
                                'label' => 'New password',
                            ])
                            @include('livewire.admin.partials.password-input', [
                                'inputId' => 'student-new-password-confirmation',
                                'field' => 'new_password_confirmation',
                                'alpineModel' => 'confirm',
                                'label' => 'Confirm new password',
                                'placeholder' => 'Confirm new password',
                            ])
                            <p class="mt-1 text-xs" x-show="confirm.length > 0"
                                x-text="pass === confirm ? '✓ Passwords match' : '✕ Passwords do not match'"
                                :class="pass === confirm ? 'text-green-600' : 'text-red-600'"></p>
                            @error('new_password')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeEditModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Cancel</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm">
                            <span wire:loading.remove wire:target="updateStudent">Save Changes</span>
                            <span wire:loading wire:target="updateStudent">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>
