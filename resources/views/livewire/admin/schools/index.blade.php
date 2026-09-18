<div>
    @include('partials.notifications')

    <div class="container mx-auto px-4 sm:px-6 py-6">

        {{-- Stats --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
            <div class="bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-xs sm:text-sm font-medium">Total Schools</p>
                <h3 class="text-xl font-bold">{{ $totalSchools }}</h3>
            </div>
            <div class="bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-xs sm:text-sm font-medium">Active</p>
                <h3 class="text-xl font-bold">{{ $activeSchools }}</h3>
            </div>
            <div class="bg-gradient-to-r from-amber-500 to-amber-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-xs sm:text-sm font-medium">On Trial</p>
                <h3 class="text-xl font-bold">{{ $trialSchools }}</h3>
            </div>
            <div class="bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-4 shadow-md">
                <p class="text-xs sm:text-sm font-medium">Disabled</p>
                <h3 class="text-xl font-bold">{{ $disabledSchools }}</h3>
            </div>
        </div>

        {{-- Toolbar --}}
        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3 sm:p-4 mb-5">
            <div class="flex flex-col sm:flex-row gap-3">
                <div class="relative flex-1">
                    <i
                        class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" wire:model.live.debounce.400ms="search"
                        placeholder="Search by school name, registration ID, or email..."
                        class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                </div>

                <select wire:model.live="statusFilter"
                    class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700">
                    <option value="">All Statuses</option>
                    <option value="active">Active</option>
                    <option value="disabled">Disabled</option>
                </select>

                <select wire:model.live="subscriptionFilter"
                    class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm text-slate-700">
                    <option value="">All Subscriptions</option>
                    <option value="trial">Trial</option>
                    <option value="active">Active</option>
                    <option value="past_due">Past Due</option>
                    <option value="cancelled">Cancelled</option>
                </select>

                @if ($canCreate)
                    <button wire:click="$set('showAddModal', true)"
                        class="inline-flex items-center justify-center gap-2 bg-[#155E8A] hover:bg-[#0F4A6E] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shrink-0">
                        <i class="fas fa-plus text-xs"></i> New School
                    </button>
                @endif
            </div>
        </div>

        {{-- Table --}}
        <div class="bg-white rounded-xl shadow-sm border border-[#E2E8F0] overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full min-w-[900px]">
                    <thead class="bg-[#155E8A] text-white">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">Registration ID</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">School</th>
                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase">Owner</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase">Status</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase">Subscription</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase">Trial Ends</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold uppercase">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse ($schools as $school)
                            <tr class="hover:bg-sky-50/60 transition-colors">
                                <td class="px-6 py-4 font-mono text-sm text-slate-600">{{ $school->registration_id }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        @if ($school->logo)
                                            <img src="{{ asset('storage/' . $school->logo) }}"
                                                alt="{{ $school->school_name }}"
                                                class="h-8 w-8 rounded-full object-cover border border-slate-200 shrink-0">
                                        @else
                                            <div
                                                class="h-8 w-8 rounded-full bg-sky-100 text-[#155E8A] flex items-center justify-center text-xs font-bold shrink-0">
                                                {{ strtoupper(substr($school->school_name, 0, 1)) }}
                                            </div>
                                        @endif
                                        <span class="font-semibold text-slate-800">{{ $school->school_name }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-slate-600">{{ optional($school->owner)->name ?? '—' }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    @if ($school->status === 'active')
                                        <span
                                            class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Active</span>
                                    @else
                                        <span
                                            class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Disabled</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <span
                                        class="px-3 py-1 rounded-full bg-sky-100 text-[#155E8A] text-xs font-semibold capitalize">
                                        {{ str_replace('_', ' ', $school->subscription_status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 text-center text-sm text-slate-500">
                                    {{ optional($school->trial_end_date)->format('d M Y') ?? '—' }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex justify-center gap-2">
                                        <button wire:click="viewSchool({{ $school->id }})"
                                            wire:loading.attr="disabled" wire:target="viewSchool({{ $school->id }})"
                                            title="View"
                                            class="h-9 w-9 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-700 hover:text-white transition-colors flex items-center justify-center disabled:opacity-60">
                                            <i class="fas fa-eye text-sm" wire:loading.remove
                                                wire:target="viewSchool({{ $school->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-sm" wire:loading
                                                wire:target="viewSchool({{ $school->id }})"></i>
                                        </button>

                                        @if ($canEdit)
                                            <button wire:click="editSchool({{ $school->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="editSchool({{ $school->id }})" title="Edit"
                                                class="h-9 w-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-500 hover:text-white transition-colors flex items-center justify-center disabled:opacity-60">
                                                <i class="fas fa-edit text-sm" wire:loading.remove
                                                    wire:target="editSchool({{ $school->id }})"></i>
                                                <i class="fas fa-spinner fa-spin text-sm" wire:loading
                                                    wire:target="editSchool({{ $school->id }})"></i>
                                            </button>

                                            <button wire:click="confirmToggleStatus({{ $school->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="confirmToggleStatus({{ $school->id }})"
                                                title="Toggle Status"
                                                class="h-9 w-9 rounded-lg bg-slate-100 text-slate-700 hover:bg-slate-500 hover:text-white transition-colors flex items-center justify-center disabled:opacity-60">
                                                <i class="fas fa-power-off text-sm" wire:loading.remove
                                                    wire:target="confirmToggleStatus({{ $school->id }})"></i>
                                                <i class="fas fa-spinner fa-spin text-sm" wire:loading
                                                    wire:target="confirmToggleStatus({{ $school->id }})"></i>
                                            </button>
                                        @endif

                                        @if ($canDelete)
                                            <button wire:click="confirmDelete({{ $school->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="confirmDelete({{ $school->id }})" title="Delete"
                                                class="h-9 w-9 rounded-lg bg-red-100 text-[#B91C1C] hover:bg-[#B91C1C] hover:text-white transition-colors flex items-center justify-center disabled:opacity-60">
                                                <i class="fas fa-trash text-sm" wire:loading.remove
                                                    wire:target="confirmDelete({{ $school->id }})"></i>
                                                <i class="fas fa-spinner fa-spin text-sm" wire:loading
                                                    wire:target="confirmDelete({{ $school->id }})"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center py-16">
                                    <i class="fas fa-school text-5xl text-slate-300 mb-3"></i>
                                    <p class="text-slate-500 text-sm">No schools found.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
                {{ $schools->links() }}
            </div>
        </div>
    </div>

    {{-- ========================= CREATE MODAL (SchoolGear platform branding) ========================= --}}
    @if ($showAddModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                {{-- Header (fixed — does not scroll) --}}
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div
                                class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                                <img src="{{ asset('logo/logo1.jpg') }}" alt="SchoolGear Logo"
                                    class="h-full w-full object-contain rounded-full">
                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold truncate">
                                    SchoolGear Liberia SaaS
                                </p>
                                <h2 class="text-white text-base sm:text-lg font-bold leading-tight mt-0.5">
                                    Register New School
                                </h2>
                            </div>
                        </div>

                        <button type="button" wire:click="$set('showAddModal', false)"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>

                    <p class="text-sky-100 text-xs mt-3">
                        Creates the school account and its initial Owner login in one step.
                    </p>
                </div>

                {{-- Form wraps scrollable body + fixed footer --}}
                <form wire:submit.prevent="storeSchool" class="flex flex-col flex-1 min-h-0">

                    {{-- Scrollable body only --}}
                    <div class="p-4 sm:p-6 space-y-5 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">

                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-4">
                            <p class="text-xs font-bold uppercase tracking-wide text-[#0F4C81] mb-3">School Information
                            </p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">School Name
                                        *</label>
                                    <input type="text" wire:model="school_name"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    @error('school_name')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                                        Short Name / Acronym <span class="text-slate-400 font-normal">(optional)</span>
                                    </label>
                                    <input type="text" wire:model="short_name" maxlength="20"
                                        placeholder="e.g. MZBSPS"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    <p class="mt-1 text-[11px] text-slate-500">
                                        Shown in the sidebar for long school names. Auto-generated if left blank.
                                    </p>
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">School Email
                                        *</label>
                                    <input type="email" wire:model="school_email"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    @error('school_email')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Phone</label>
                                    <input type="text" wire:model="phone"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Country</label>
                                    <input type="text" wire:model="country"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">City</label>
                                    <input type="text" wire:model="city"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Address</label>
                                    <input type="text" wire:model="address"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Logo</label>
                                    <input type="file" wire:model="logo" class="w-full text-sm">
                                    @error('logo')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                    @if ($logo)
                                        <img src="{{ $logo->temporaryUrl() }}"
                                            class="h-14 w-14 rounded-lg object-cover border border-slate-200 mt-2">
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-4" x-data="{ pass: '', confirm: '' }">
                            <p class="text-xs font-bold uppercase tracking-wide text-[#B91C1C] mb-3">Initial Owner
                                Account</p>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Owner Full Name
                                        *</label>
                                    <input type="text" wire:model="owner_name"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    @error('owner_name')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Owner Email
                                        *</label>
                                    <input type="email" wire:model="owner_email"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    @error('owner_email')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password *</label>
                                    <input type="password" wire:model="owner_password" x-model="pass"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    @error('owner_password')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Confirm Password
                                        *</label>
                                    <input type="password" wire:model="owner_password_confirmation" x-model="confirm"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                    <p class="mt-1 text-xs" x-show="confirm.length > 0"
                                        x-text="pass === confirm ? '✓ Passwords match' : '✕ Passwords do not match'"
                                        :class="pass === confirm ? 'text-green-600' : 'text-red-600'">
                                    </p>
                                </div>
                            </div>
                            <p class="text-[11px] text-slate-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Registration IDs are generated automatically for both the school and the owner account.
                                The owner receives the "Owner" role.
                            </p>
                        </div>
                    </div>

                    {{-- Footer (fixed — outside scrollable region) --}}
                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="$set('showAddModal', false)"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm">
                            <span wire:loading.remove wire:target="storeSchool">Create School</span>
                            <span wire:loading wire:target="storeSchool">Creating...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ========================= EDIT MODAL ========================= --}}
    @if ($showEditModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                {{-- Header --}}
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div
                                class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                                @if ($edit_logo)
                                    <img src="{{ $edit_logo->temporaryUrl() }}" alt="{{ $edit_school_name }}"
                                        class="h-full w-full object-cover rounded-full">
                                @elseif ($edit_current_logo)
                                    <img src="{{ asset('storage/' . $edit_current_logo) }}"
                                        alt="{{ $edit_school_name }}"
                                        class="h-full w-full object-cover rounded-full">
                                @else
                                    <span class="text-white font-bold text-sm">
                                        {{ strtoupper(substr($edit_school_name ?? '?', 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold truncate">
                                    Edit School
                                </p>
                                <h2 class="text-white text-base sm:text-lg font-bold leading-tight mt-0.5 truncate">
                                    {{ $edit_school_name }}
                                </h2>
                            </div>
                        </div>

                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="updateSchool" class="flex flex-col flex-1 min-h-0">

                    <div
                        class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">School Name</label>
                            <input type="text" wire:model="edit_school_name"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('edit_school_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                                Short Name / Acronym <span class="text-slate-400 font-normal">(optional)</span>
                            </label>
                            <input type="text" wire:model="edit_short_name" maxlength="20"
                                placeholder="e.g. MZBSPS"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('edit_short_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Email</label>
                            <input type="email" wire:model="edit_email"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('edit_email')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Phone</label>
                            <input type="text" wire:model="edit_phone"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Country</label>
                            <input type="text" wire:model="edit_country"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">City</label>
                            <input type="text" wire:model="edit_city"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Address</label>
                            <input type="text" wire:model="edit_address"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Status</label>
                            <select wire:model="edit_status"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="active">Active</option>
                                <option value="disabled">Disabled</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Subscription
                                Status</label>
                            <select wire:model="edit_subscription_status"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="trial">Trial</option>
                                <option value="active">Active</option>
                                <option value="past_due">Past Due</option>
                                <option value="cancelled">Cancelled</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Replace Logo</label>
                            <input type="file" wire:model="edit_logo" class="w-full text-sm">
                            @error('edit_logo')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="$set('showEditModal', false)"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">
                            Cancel
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm">
                            <span wire:loading.remove wire:target="updateSchool">Save Changes</span>
                            <span wire:loading wire:target="updateSchool">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- ========================= VIEW MODAL ========================= --}}
    @if ($showViewModal && $view_school)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">

                {{-- Header --}}
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                    <div class="flex items-start justify-between gap-3">
                        <div class="flex items-center gap-3 min-w-0">
                            <div
                                class="h-12 w-12 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                                @if ($view_school->logo)
                                    <img src="{{ asset('storage/' . $view_school->logo) }}"
                                        alt="{{ $view_school->school_name }}"
                                        class="h-full w-full object-cover rounded-full">
                                @else
                                    <span class="text-white font-bold">
                                        {{ strtoupper(substr($view_school->school_name, 0, 1)) }}
                                    </span>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <p
                                    class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold font-mono truncate">
                                    {{ $view_school->registration_id }}
                                </p>
                                <h2 class="text-white text-base sm:text-lg font-bold leading-tight mt-0.5 truncate">
                                    {{ $view_school->school_name }}
                                </h2>
                            </div>
                        </div>

                        <button type="button" wire:click="$set('showViewModal', false)"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-6 bg-[#F8FAFC] space-y-3 text-sm overflow-y-auto flex-1 min-h-0">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div><label class="text-xs text-slate-500">Email</label>
                            <p class="font-semibold text-slate-800">{{ $view_school->email }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Phone</label>
                            <p class="font-semibold text-slate-800">{{ $view_school->phone ?? '—' }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">City / Country</label>
                            <p class="font-semibold text-slate-800">{{ $view_school->city }},
                                {{ $view_school->country }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Address</label>
                            <p class="font-semibold text-slate-800">{{ $view_school->address ?? '—' }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Owner</label>
                            <p class="font-semibold text-slate-800">{{ optional($view_school->owner)->name ?? '—' }}
                            </p>
                        </div>
                        <div><label class="text-xs text-slate-500">Owner Registration ID</label>
                            <p class="font-semibold text-slate-800 font-mono">
                                {{ optional($view_school->owner)->registration_id ?? '—' }}</p>

                            @if ($view_school->short_name)
                                <p class="text-[11px] text-blue-900 font-bold truncate">
                                    {{ $view_school->short_name }}
                                </p>
                            @endif
                        </div>
                        <div><label class="text-xs text-slate-500">Subscription</label>
                            <p class="font-semibold text-slate-800 capitalize">
                                {{ str_replace('_', ' ', $view_school->subscription_status) }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Trial Ends</label>
                            <p class="font-semibold text-slate-800">
                                {{ optional($view_school->trial_end_date)->format('d M Y') ?? '—' }}</p>
                        </div>
                    </div>
                </div>

                <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end shrink-0">
                    <button wire:click="$set('showViewModal', false)"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">
                        Close
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ========================= DELETE CONFIRMATION MODAL ========================= --}}
    @if ($showDeleteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">Confirm Delete</h3>
                    <button wire:click="$set('showDeleteModal', false)"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="px-4 py-3 space-y-2">
                    <p class="text-sm text-gray-700">Delete <strong>{{ $deleteSchoolName }}</strong>?</p>
                    <p class="flex items-center gap-1 text-xs text-red-600">
                        <i class="fas fa-exclamation-triangle text-xs"></i> This will soft-delete the school record.
                    </p>
                </div>
                <div class="px-4 py-3 border-t border-gray-200 flex justify-end gap-2">
                    <button wire:click="$set('showDeleteModal', false)"
                        class="px-3 py-1.5 text-xs border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button wire:click="deleteSchool" wire:loading.attr="disabled" wire:target="deleteSchool"
                        class="px-3 py-1.5 text-xs bg-red-600 text-white rounded-md hover:bg-red-700 disabled:opacity-60">
                        <span wire:loading.remove wire:target="deleteSchool">Delete</span>
                        <span wire:loading wire:target="deleteSchool">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ========================= TOGGLE STATUS CONFIRMATION MODAL ========================= --}}
    @if ($showToggleModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-slate-200">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-[#155E8A] to-[#0F4A6E] rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">
                        Confirm {{ $toggleTargetStatus === 'disabled' ? 'Disable' : 'Enable' }}
                    </h3>
                    <button wire:click="$set('showToggleModal', false)"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="px-4 py-3 space-y-2">
                    <p class="text-sm text-gray-700">
                        Are you sure you want to
                        <strong>{{ $toggleTargetStatus === 'disabled' ? 'disable' : 'enable' }}</strong>
                        <strong>{{ $toggleSchoolName }}</strong>?
                    </p>
                    @if ($toggleTargetStatus === 'disabled')
                        <p class="flex items-center gap-1 text-xs text-amber-600">
                            <i class="fas fa-exclamation-triangle text-xs"></i>
                            Disabling a school prevents its Owner/staff from logging in until re-enabled.
                        </p>
                    @endif
                </div>
                <div class="px-4 py-3 border-t border-gray-200 flex justify-end gap-2">
                    <button wire:click="$set('showToggleModal', false)"
                        class="px-3 py-1.5 text-xs border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100">Cancel</button>
                    <button wire:click="toggleStatus" wire:loading.attr="disabled" wire:target="toggleStatus"
                        class="px-3 py-1.5 text-xs {{ $toggleTargetStatus === 'disabled' ? 'bg-red-600 hover:bg-red-700' : 'bg-green-600 hover:bg-green-700' }} text-white rounded-md disabled:opacity-60">
                        <span wire:loading.remove
                            wire:target="toggleStatus">{{ $toggleTargetStatus === 'disabled' ? 'Disable' : 'Enable' }}</span>
                        <span wire:loading
                            wire:target="toggleStatus">{{ $toggleTargetStatus === 'disabled' ? 'Disabling...' : 'Enabling...' }}</span>
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
