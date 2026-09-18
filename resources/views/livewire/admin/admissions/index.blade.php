<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Admissions</h1>
            <p class="text-slate-500 text-sm mt-1">Review and process student applications.</p>
        </div>
        @if ($canManage)
            <button wire:click="openCreateModal" wire:loading.attr="disabled" wire:target="openCreateModal"
                class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors disabled:opacity-60">
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
                class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $status === $key ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
            </button>
        @endforeach
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text" wire:model.live.debounce.400ms="search"
            placeholder="Search by name or admission number..."
            class="flex-1 px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">

        <select wire:model.live="academicYearId"
            class="w-full sm:w-56 px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
            <option value="">All Academic Years</option>
            @foreach ($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->name }}</option>
            @endforeach
        </select>

        {{-- ADD THIS SELECT --}}
        <select wire:model.live="gradeFilter"
            class="w-full sm:w-56 px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
            <option value="">All Grades</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[800px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Admission #</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Applicant</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Grade Applying</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Type</th>
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
                            <td class="px-4 sm:px-6 py-3 text-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium bg-sky-100 text-[#155E8A]">{{ $admission->student_type }}</span>
                            </td>
                            <td class="px-4 sm:px-6 py-3">
                                <div class="flex justify-center flex-wrap gap-2">
                                    @if ($canView)
                                        <button wire:click="viewAdmission({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="viewAdmission({{ $admission->id }})"
                                            class="h-8 w-8 rounded-md bg-sky-100 hover:bg-sky-700 hover:text-white text-sky-700 flex items-center justify-center disabled:opacity-60">
                                            <i class="fas fa-eye text-xs" wire:loading.remove
                                                wire:target="viewAdmission({{ $admission->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="viewAdmission({{ $admission->id }})"></i>
                                        </button>
                                    @endif

                                    @if ($canView && in_array($admission->status, ['rejected']))
                                        <button wire:click="viewAudit({{ $admission->id }})"
                                            wire:loading.attr="disabled" wire:target="viewAudit({{ $admission->id }})"
                                            title="View audit trail"
                                            class="h-8 w-8 rounded-md bg-slate-100 hover:bg-slate-600 hover:text-white text-slate-600 flex items-center justify-center disabled:opacity-60">
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
                                            class="px-3 py-1.5 rounded-md bg-green-100 hover:bg-green-600 hover:text-white text-green-700 text-xs font-semibold disabled:opacity-60">
                                            <span wire:loading.remove
                                                wire:target="confirmAdmit({{ $admission->id }})">Admit</span>
                                            <span wire:loading
                                                wire:target="confirmAdmit({{ $admission->id }})">...</span>
                                        </button>

                                        <button wire:click="confirmReject({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmReject({{ $admission->id }})"
                                            class="px-3 py-1.5 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] text-xs font-semibold disabled:opacity-60">
                                            Reject
                                        </button>

                                        <button wire:click="withdrawAdmission({{ $admission->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="withdrawAdmission({{ $admission->id }})"
                                            class="px-3 py-1.5 rounded-md bg-slate-100 hover:bg-slate-500 hover:text-white text-slate-600 text-xs font-semibold disabled:opacity-60">
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
                            <td colspan="5" class="text-center py-14">
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
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'New Admission'])
                        <button type="button" wire:click="closeCreateModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="storeAdmission" class="flex flex-col flex-1 min-h-0">
                    <div
                        class="p-4 sm:p-6 grid grid-cols-1 md:grid-cols-2 gap-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Applicant Name *</label>
                            <input type="text" wire:model="applicant_name"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('applicant_name')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Age *</label>
                            <input type="number" wire:model="age"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('age')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Gender *</label>
                            <select wire:model="gender"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
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
                            <input type="text" wire:model="parent_phone"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('parent_phone')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Grade Applying For
                                *</label>
                            <select wire:model="grade_id"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
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
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="">Use Active Year</option>
                                @foreach ($academicYears as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Student Type *</label>
                            <select wire:model="student_type"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="New">New</option>
                                <option value="Old">Old</option>
                                <option value="Transfer">Transfer</option>
                            </select>
                        </div>
                        <div class="md:col-span-2">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Last School
                                Attended</label>
                            <input type="text" wire:model="last_school_attended"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Photo</label>
                            <input type="file" wire:model="image" class="w-full text-sm">
                            <div wire:loading wire:target="image" class="text-xs text-sky-600 mt-1">
                                <i class="fas fa-spinner fa-spin"></i> Uploading photo...
                            </div>
                            @error('image')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Transcript</label>
                            <input type="file" wire:model="transcript" class="w-full text-sm">
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
                            <input type="file" wire:model="recommendation_letter" class="w-full text-sm">
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
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Cancel</button>
                        <button type="submit" wire:loading.attr="disabled"
                            wire:target="storeAdmission,image,transcript,recommendation_letter"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm disabled:opacity-60 disabled:cursor-not-allowed">
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
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'Admit Applicant'])
                        <button type="button" wire:click="closeAdmitModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                <form wire:submit.prevent="admitApplicant" class="flex flex-col flex-1 min-h-0">
                    <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <p class="text-xs text-slate-500 bg-sky-50 border border-sky-100 rounded-lg px-3 py-2">
                            <i class="fas fa-circle-info mr-1"></i>
                            Admitting this applicant creates their student login account and enrolls them in the
                            selected academic year.
                        </p>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Academic Year *</label>
                            <select wire:model="admitAcademicYearId"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
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
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('admitEmail')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div x-data="{ pass: '', confirm: '' }">
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Password *</label>
                            <input type="password" wire:model="admitPassword" x-model="pass"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            @error('admitPassword')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror

                            <label class="block text-xs font-semibold text-slate-600 mb-1.5 mt-3">Confirm Password
                                *</label>
                            <input type="password" wire:model="admitPassword_confirmation" x-model="confirm"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                            <p class="mt-1 text-xs" x-show="confirm.length > 0"
                                x-text="pass === confirm ? '✓ Passwords match' : '✕ Passwords do not match'"
                                :class="pass === confirm ? 'text-green-600' : 'text-red-600'"></p>
                        </div>
                    </div>
                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeAdmitModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Cancel</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-sm">
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
            <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">Reject Admission</h3>
                    <button wire:click="closeRejectModal"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <form wire:submit.prevent="rejectAdmission" class="p-4 space-y-2">
                    <label class="block text-xs font-medium text-gray-700">Reason *</label>
                    <textarea wire:model="rejectReason" rows="3"
                        class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md"></textarea>
                    @error('rejectReason')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeRejectModal"
                            class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                        <button type="submit"
                            class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">
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
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-2xl max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => $view_admission->applicant_name,
                        ])
                        <button wire:click="closeViewModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-6 bg-[#F8FAFC] space-y-5 text-sm overflow-y-auto flex-1 min-h-0">

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
                            <p class="font-semibold">{{ $view_admission->grade->level }}
                                {{ $view_admission->grade->section }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Age / Gender</label>
                            <p class="font-semibold">{{ $view_admission->age }} / {{ $view_admission->gender }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Parent Phone</label>
                            <p class="font-semibold">{{ $view_admission->parent_phone }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Student Type</label>
                            <p class="font-semibold">{{ $view_admission->student_type }}</p>
                        </div>
                        <div><label class="text-xs text-slate-500">Last School</label>
                            <p class="font-semibold">{{ $view_admission->last_school_attended ?? '—' }}</p>
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
                                <p class="font-semibold">{{ $view_admission->rejection_reason }}</p>
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
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Close</button>
                </div>
            </div>
        </div>
    @endif

    @if ($showAuditModal && $audit_record)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'Audit Trail'])
                        <button wire:click="closeAuditModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                <div class="p-4 sm:p-6 bg-[#F8FAFC] space-y-3 text-sm overflow-y-auto flex-1 min-h-0">
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
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Close</button>
                </div>
            </div>
        </div>
    @endif
</div>
