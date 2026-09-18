<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Enrollments</h1>
            <p class="text-slate-500 text-sm mt-1">Manage academic status: promotions, transfers, suspensions, and
                graduations.</p>
        </div>
        <a href="{{ route('admin.students.index') }}"
            class="inline-flex items-center gap-2 px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-semibold text-sm hover:bg-slate-100">
            <i class="fas fa-users text-xs"></i> View Students
        </a>
    </div>

    {{-- Status Tabs with counts --}}
    <div class="flex flex-wrap gap-2">
        @foreach (['active' => 'Active', 'graduated' => 'Graduated', 'transferred' => 'Transferred', 'dropped_out' => 'Dropped Out', 'suspended' => 'Suspended', 'expelled' => 'Expelled'] as $key => $label)
            <button wire:click="$set('status', '{{ $key }}')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors {{ $status === $key ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                {{ $label }} ({{ $statusCounts[$key] ?? 0 }})
            </button>
        @endforeach
    </div>

    <div class="flex flex-col sm:flex-row gap-3">
        <input type="text" wire:model.live.debounce.400ms="search"
            placeholder="Search by student name or registration ID..."
            class="flex-1 px-3.5 py-2.5 rounded-lg border border-slate-300 text-sm focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
        <select wire:model.live="gradeFilter" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
            <option value="">All Grades</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}</option>
            @endforeach
        </select>

        <select wire:model.live="academicYearId" class="rounded-lg border border-slate-300 px-3 py-2.5 text-sm">
            <option value="">All Academic Years</option>
            @foreach ($academicYears as $year)
                <option value="{{ $year->id }}">{{ $year->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Student ID</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Name</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Grade</th>
                        <th class="px-4 sm:px-6 py-3 text-left text-xs font-semibold uppercase">Academic Year</th>
                        <th class="px-4 sm:px-6 py-3 text-center text-xs font-semibold uppercase">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($enrollments as $enrollment)
                        <tr class="hover:bg-sky-50/60 transition-colors">
                            <td class="px-4 sm:px-6 py-3 font-mono text-xs text-slate-600">
                                {{ $enrollment->student->user->registration_id }}</td>
                            <td class="px-4 sm:px-6 py-3">
                                <a href="{{ route('admin.students.show', $enrollment->student->id) }}" wire:navigate
                                    class="font-semibold text-slate-800 hover:text-[#155E8A] hover:underline">
                                    {{ $enrollment->student->name }}
                                </a>
                            </td>
                            <td class="px-4 sm:px-6 py-3 text-slate-600">{{ $enrollment->grade->level }}
                                {{ $enrollment->grade->section }}</td>
                            <td class="px-4 sm:px-6 py-3 text-slate-600">{{ $enrollment->academicYear->name }}</td>
                            <td class="px-4 sm:px-6 py-3">
                                <div class="flex justify-center flex-wrap gap-2">
                                    @if ($canManage && $enrollment->status === 'active')
                                        <button wire:click="confirmPromote({{ $enrollment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmPromote({{ $enrollment->id }})"
                                            class="px-3 py-1.5 rounded-md bg-green-100 hover:bg-green-600 hover:text-white text-green-700 text-xs font-semibold disabled:opacity-60">
                                            Promote
                                        </button>

                                        <button wire:click="graduateStudent({{ $enrollment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="graduateStudent({{ $enrollment->id }})"
                                            class="px-3 py-1.5 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] text-xs font-semibold disabled:opacity-60">
                                            <span wire:loading.remove
                                                wire:target="graduateStudent({{ $enrollment->id }})">Graduate</span>
                                            <span wire:loading
                                                wire:target="graduateStudent({{ $enrollment->id }})">...</span>
                                        </button>

                                        <button wire:click="confirmStatusAction({{ $enrollment->id }}, 'transfer')"
                                            wire:loading.attr="disabled"
                                            class="px-3 py-1.5 rounded-md bg-slate-100 hover:bg-slate-500 hover:text-white text-slate-600 text-xs font-semibold disabled:opacity-60">
                                            Transfer
                                        </button>

                                        <button wire:click="confirmStatusAction({{ $enrollment->id }}, 'suspend')"
                                            wire:loading.attr="disabled"
                                            class="px-3 py-1.5 rounded-md bg-orange-100 hover:bg-orange-600 hover:text-white text-orange-700 text-xs font-semibold disabled:opacity-60">
                                            Suspend
                                        </button>

                                        <button wire:click="confirmStatusAction({{ $enrollment->id }}, 'expel')"
                                            wire:loading.attr="disabled"
                                            class="px-3 py-1.5 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] text-xs font-semibold disabled:opacity-60">
                                            Expel
                                        </button>
                                    @endif

                                    @if ($canManage && $enrollment->status === 'suspended')
                                        <button wire:click="reactivateStudent({{ $enrollment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="reactivateStudent({{ $enrollment->id }})"
                                            class="px-3 py-1.5 rounded-md bg-green-100 hover:bg-green-600 hover:text-white text-green-700 text-xs font-semibold disabled:opacity-60">
                                            <span wire:loading.remove
                                                wire:target="reactivateStudent({{ $enrollment->id }})">Reactivate</span>
                                            <span wire:loading
                                                wire:target="reactivateStudent({{ $enrollment->id }})">...</span>
                                        </button>

                                        <button wire:click="confirmStatusAction({{ $enrollment->id }}, 'expel')"
                                            wire:loading.attr="disabled"
                                            class="px-3 py-1.5 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] text-xs font-semibold disabled:opacity-60">
                                            Expel
                                        </button>
                                    @endif

                                    @if (in_array($enrollment->status, ['transferred', 'dropped_out', 'suspended', 'expelled']))
                                        <button wire:click="viewAudit({{ $enrollment->id }})"
                                            wire:loading.attr="disabled" wire:target="viewAudit({{ $enrollment->id }})"
                                            title="View audit trail"
                                            class="h-8 w-8 rounded-md bg-slate-100 hover:bg-slate-600 hover:text-white text-slate-600 flex items-center justify-center disabled:opacity-60">
                                            <i class="fas fa-clock-rotate-left text-xs" wire:loading.remove
                                                wire:target="viewAudit({{ $enrollment->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="viewAudit({{ $enrollment->id }})"></i>
                                        </button>
                                    @endif

                                    @if (!in_array($enrollment->status, ['active', 'suspended']))
                                        <span class="text-xs text-slate-400 italic">No further actions</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center py-14">
                                <i class="fas fa-graduation-cap text-4xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No enrollments found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
            {{ $enrollments->links() }}
        </div>
    </div>

    {{-- PROMOTE MODAL --}}
    @if ($showPromoteModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => 'Promote ' . $promoteStudentName,
                        ])
                        <button type="button" wire:click="closePromoteModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>
                <form wire:submit.prevent="promoteStudent" class="bg-[#F8FAFC]">
                    <div class="p-4 sm:p-6 space-y-4">
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Promote To Grade *</label>
                            <select wire:model="promoteToGradeId"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="">Select Grade</option>
                                @foreach ($grades as $grade)
                                    <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}
                                    </option>
                                @endforeach
                            </select>
                            @error('promoteToGradeId')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Academic Year *</label>
                            <select wire:model="promoteToAcademicYearId"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm">
                                <option value="">Select Academic Year</option>
                                @foreach (\App\Models\AcademicYear::where('school_id', auth()->user()->school_id)->ordered()->get() as $year)
                                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                                @endforeach
                            </select>
                            @error('promoteToAcademicYearId')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Remarks</label>
                            <textarea wire:model="promoteRemarks" rows="2"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm"></textarea>
                        </div>
                    </div>
                    <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                        <button type="button" wire:click="closePromoteModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Cancel</button>
                        <button type="submit"
                            class="px-5 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-sm">
                            <span wire:loading.remove wire:target="promoteStudent">Promote</span>
                            <span wire:loading wire:target="promoteStudent">Promoting...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- STATUS ACTION MODAL (transfer/dropout/suspend/expel — reason required) --}}
    @if ($showStatusModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-slate-200">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-[#155E8A] to-[#0F4A6E] rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white capitalize">
                        {{ str_replace('dropOut', 'Drop Out', $statusAction) }} — {{ $statusStudentName }}
                    </h3>
                    <button wire:click="closeStatusModal"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <form wire:submit.prevent="applyStatusAction" class="p-4 space-y-2">
                    <label class="block text-xs font-medium text-gray-700">Reason *</label>
                    <textarea wire:model="statusReason" rows="3"
                        class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md"></textarea>
                    @error('statusReason')
                        <p class="text-xs text-red-600">{{ $message }}</p>
                    @enderror
                    <div class="flex justify-end gap-2 pt-2">
                        <button type="button" wire:click="closeStatusModal"
                            class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                        <button type="submit"
                            class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">
                            <span wire:loading.remove wire:target="applyStatusAction">Confirm</span>
                            <span wire:loading wire:target="applyStatusAction">Applying...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif


    {{-- AUDIT TRAIL MODAL --}}
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
                        <label class="text-xs text-slate-500">Student</label>
                        <p class="font-semibold">{{ $audit_record->student->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Grade / Academic Year</label>
                        <p class="font-semibold">{{ $audit_record->grade->level }}
                            {{ $audit_record->grade->section }} — {{ $audit_record->academicYear->name }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-500">Status</label>
                        <p class="font-semibold capitalize">{{ str_replace('_', ' ', $audit_record->status) }}</p>
                    </div>
                    @if ($audit_record->effective_reason)
                        <div>
                            <label class="text-xs text-slate-500">Reason</label>
                            <p class="font-semibold">{{ $audit_record->effective_reason }}</p>
                        </div>
                    @endif
                    <div class="border-t border-slate-200 pt-3">
                        <label class="text-xs text-slate-500">Performed By</label>
                        @if ($audit_record->statusChangedBy)
                            <p class="font-semibold">
                                {{ $audit_record->statusChangedBy->name }}
                                <span class="text-xs text-slate-400 font-normal">
                                    ({{ $audit_record->statusChangedBy->getRoleNames()->first() ?? 'Staff' }})
                                </span>
                            </p>
                            <p class="text-xs text-slate-400">
                                {{ $audit_record->effective_changed_at?->format('d M Y, h:i A') }}</p>
                        @else
                            <p class="text-sm text-slate-400 italic">Sorry! no record of who performed this action.</p>
                        @endif
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
