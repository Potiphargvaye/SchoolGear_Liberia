<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')
    {{-- ADD THIS BLOCK --}}
    <div class="relative overflow-hidden rounded-xl px-5 py-4 border border-[#155E8A]/15 bg-gradient-to-r from-[#155E8A]/10 via-sky-50 to-[#155E8A]/5"
        x-data="{
            greeting: 'Hello',
            init() {
                const h = new Date().getHours();
                this.greeting = h < 12 ? 'Good morning' : (h < 17 ? 'Good afternoon' : 'Good evening');
            }
        }">
        <div class="flex items-center gap-3">
            <div class="h-9 w-9 shrink-0 rounded-lg bg-[#155E8A]/15 flex items-center justify-center">
                <i class="fas fa-hand-sparkles text-[#155E8A] text-sm"></i>
            </div>
            <p class="text-sm sm:text-base text-slate-700">
                @if ($isPlatformAdmin)
                    <span x-text="greeting"></span>, {{ auth()->user()->name }} 👋 here's a platform-wide look at fee
                    activity across
                    <span class="font-bold text-[#155E8A]">all schools</span>.
                @else
                    <span x-text="greeting"></span>, {{ auth()->user()->name }} 👋 here's the fee activity for
                    <span
                        class="font-bold text-[#155E8A]">{{ auth()->user()->school->school_name ?? 'your school' }}</span>
                    today.
                @endif
            </p>
        </div>
    </div>
    {{-- END ADDED BLOCK --}}
    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-slate-800">Fees Management</h1>
            <p class="text-slate-500 text-sm mt-1">
                @if ($isPlatformAdmin)
                    Platform-wide view read only. Assign fees and record payments from within each school account.
                @else
                    One record per student — assign fees, record payments, and view history from their row.
                @endif
            </p>
        </div>

        <a href="{{ route('admin.fee-categories.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-lg border border-[#155E8A] text-[#155E8A] font-semibold text-sm hover:bg-sky-50 transition-colors">
            <i class="fas fa-tags text-xs"></i>
            Manage Categories
        </a>
    </div>
    {{-- Fee Statistics (auto-updates with School / Academic Year filters) --}}
    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-3">

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-sky-100 text-[#155E8A] flex items-center justify-center shrink-0">
                <i class="fas fa-users text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Total Students</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">{{ number_format($totalStudents) }}
                </p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-sky-100 text-[#155E8A] flex items-center justify-center shrink-0">
                <i class="fas fa-file-invoice-dollar text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Fees Assigned</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">
                    ${{ number_format($totalFeesAssigned, 2) }}</p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-green-100 text-green-700 flex items-center justify-center shrink-0">
                <i class="fas fa-circle-check text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Fees Collected</p>
                <p class="text-base sm:text-lg font-bold text-green-700 truncate">
                    ${{ number_format($totalFeesCollected, 2) }}</p>
            </div>
        </div>

        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0">
            <div class="h-10 w-10 rounded-lg bg-red-100 text-[#B91C1C] flex items-center justify-center shrink-0">
                <i class="fas fa-scale-unbalanced text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Outstanding Balance</p>
                <p class="text-base sm:text-lg font-bold text-[#B91C1C] truncate">${{ number_format($totalBalance, 2) }}
                </p>
            </div>
        </div>

        <div
            class="bg-white border border-[#E2E8F0] rounded-xl p-3.5 sm:p-4 flex items-center gap-3 min-w-0 col-span-2 sm:col-span-1">
            <div class="h-10 w-10 rounded-lg bg-amber-100 text-amber-700 flex items-center justify-center shrink-0">
                <i class="fas fa-money-bill-wave text-sm"></i>
            </div>
            <div class="min-w-0">
                <p class="text-xs text-slate-400 font-medium truncate">Total Paid</p>
                <p class="text-base sm:text-lg font-bold text-slate-800 truncate">${{ number_format($totalPaid, 2) }}
                </p>
            </div>
        </div>

    </div>
    {{-- Category Tabs (only meaningful once a single school is in scope) --}}
    @if ($categories->isNotEmpty())
        <div class="flex flex-wrap gap-2 border-b border-slate-200 pb-3">
            <button type="button" wire:click="$set('categoryFilter', 'all')"
                class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors
                    {{ $categoryFilter === 'all' ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                All Fees
            </button>
            @foreach ($categories as $category)
                <button type="button" wire:click="$set('categoryFilter', '{{ $category->id }}')"
                    class="px-4 py-2 rounded-lg text-sm font-semibold transition-colors
                        {{ (string) $categoryFilter === (string) $category->id ? 'bg-[#155E8A] text-white' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                    {{ $category->name }}
                </button>
            @endforeach
        </div>
    @endif

    {{-- Search + Filters --}}
    <div
        class="bg-[#F8FAFC] border border-[#E2E8F0] rounded-lg p-3 sm:p-4 flex flex-col sm:flex-row flex-wrap gap-2 sm:gap-3">
        <div class="relative flex-1 min-w-[200px]">
            <i class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" wire:model.live.debounce.350ms="search"
                placeholder="Search by student name or registration ID..."
                class="w-full pl-10 pr-3 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
        </div>

        <select wire:model.live="gradeFilter"
            class="py-2.5 px-3 border border-slate-300 rounded-lg text-sm bg-white min-w-[140px] focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
            <option value="">All Grades</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade->id }}">{{ $grade->level }} {{ $grade->section }}</option>
            @endforeach
        </select>

        {{-- MOVED IN --}}
        @if ($academicYears->isNotEmpty())
            <select wire:model.live="academicYearFilter"
                class="py-2.5 px-3 border border-slate-300 rounded-lg text-sm bg-white min-w-[160px] focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                <option value="">All Academic Years</option>
                @foreach ($academicYears as $year)
                    <option value="{{ $year->id }}">{{ $year->name }}</option>
                @endforeach
            </select>
        @endif

        {{-- MOVED IN — Super Admin: School filter --}}
        @if ($isPlatformAdmin)
            <select wire:model.live="schoolFilter"
                class="py-2.5 px-3 border border-slate-300 rounded-lg text-sm bg-white min-w-[180px] focus:outline-none focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A]">
                <option value="">All Schools</option>
                @foreach ($schools as $school)
                    <option value="{{ $school->id }}">{{ $school->school_name }}</option>
                @endforeach
            </select>
        @endif
    </div>

    {{-- Students Table (one row per Enrollment) --}}
    <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead class="bg-[#155E8A] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Grade</th>
                        @if ($isPlatformAdmin)
                            <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">School</th>
                        @endif
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Assigned</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Paid</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Balance</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($enrollments as $enrollment)
                        @php
                            $totalAssigned = $enrollment->feeAssignments->sum('amount');
                            $totalPaidRow = $enrollment->feeAssignments->sum(
                                fn($a) => $a->payments->sum('amount_paid'),
                            );
                            $balance = $totalAssigned - $totalPaidRow;

                            if ($enrollment->feeAssignments->isEmpty()) {
                                $rowStatus = 'no_fees';
                            } elseif ($balance <= 0) {
                                $rowStatus = 'paid';
                            } elseif ($enrollment->feeAssignments->contains('status', 'overdue')) {
                                $rowStatus = 'overdue';
                            } elseif ($totalPaidRow > 0) {
                                $rowStatus = 'partial';
                            } else {
                                $rowStatus = 'pending';
                            }

                            $statusClasses = [
                                'no_fees' => 'bg-slate-100 text-slate-500',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'partial' => 'bg-blue-100 text-blue-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'overdue' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <tr wire:key="enrollment-{{ $enrollment->id }}" class="hover:bg-sky-50/60 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-slate-800">{{ $enrollment->student->name }}</div>
                                <div class="text-xs text-slate-400 font-mono">
                                    {{ $enrollment->student->user->registration_id }}</div>
                            </td>
                            <td class="px-4 py-3 text-slate-600">{{ $enrollment->grade->level ?? '—' }}
                                {{ $enrollment->grade->section ?? '' }}</td>
                            @if ($isPlatformAdmin)
                                <td class="px-4 py-3 text-slate-600">{{ $enrollment->school->school_name ?? '—' }}</td>
                            @endif
                            <td class="px-4 py-3 text-right text-slate-700">${{ number_format($totalAssigned, 2) }}
                            </td>
                            <td class="px-4 py-3 text-right text-green-600 font-semibold">
                                ${{ number_format($totalPaidRow, 2) }}</td>
                            <td class="px-4 py-3 text-right text-[#B91C1C] font-semibold">
                                ${{ number_format($balance, 2) }}</td>
                            <td class="px-4 py-3 text-center">
                                <span
                                    class="px-2.5 py-1 rounded-full text-xs font-medium {{ $statusClasses[$rowStatus] }}">
                                    {{ $rowStatus === 'no_fees' ? 'No Fees' : ucfirst($rowStatus) }}
                                </span>
                            </td>
                            <td class="px-4 py-3">
                                <div class="flex flex-wrap justify-center gap-1.5">
                                    @if ($canManage)
                                        <button wire:click="openAssignModal({{ $enrollment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="openAssignModal({{ $enrollment->id }})"
                                            class="h-8 w-8 rounded-md bg-sky-100 hover:bg-[#155E8A] hover:text-white text-[#155E8A] flex items-center justify-center transition-colors disabled:opacity-60"
                                            title="Assign Fee">
                                            <i class="fas fa-plus text-xs" wire:loading.remove
                                                wire:target="openAssignModal({{ $enrollment->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="openAssignModal({{ $enrollment->id }})"></i>
                                        </button>
                                        <button wire:click="openPaymentModal({{ $enrollment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="openPaymentModal({{ $enrollment->id }})"
                                            class="h-8 w-8 rounded-md bg-green-100 hover:bg-green-700 hover:text-white text-green-700 flex items-center justify-center transition-colors disabled:opacity-60"
                                            title="Record Payment">
                                            <i class="fas fa-money-bill-wave text-xs" wire:loading.remove
                                                wire:target="openPaymentModal({{ $enrollment->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="openPaymentModal({{ $enrollment->id }})"></i>
                                        </button>
                                    @endif

                                    @if ($canView)
                                        <button wire:click="openHistoryModal({{ $enrollment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="openHistoryModal({{ $enrollment->id }})"
                                            class="h-8 w-8 rounded-md bg-slate-100 hover:bg-slate-600 hover:text-white text-slate-600 flex items-center justify-center transition-colors disabled:opacity-60"
                                            title="Payment History">
                                            <i class="fas fa-clock-rotate-left text-xs" wire:loading.remove
                                                wire:target="openHistoryModal({{ $enrollment->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="openHistoryModal({{ $enrollment->id }})"></i>
                                        </button>
                                        @unless ($isPlatformAdmin)
                                            <a href="{{ route('admin.fees.statement', $enrollment->student->id) }}"
                                                target="_blank"
                                                class="h-8 w-8 rounded-md bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 flex items-center justify-center transition-colors"
                                                title="Fee Statement">
                                                <i class="fas fa-file-invoice text-xs"></i>
                                            </a>
                                        @endunless
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ $isPlatformAdmin ? 8 : 7 }}" class="text-center py-16">
                                <i class="fas fa-users text-5xl text-slate-300 mb-3"></i>
                                <p class="text-slate-500 text-sm">No students found.</p>
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

    {{-- Assign Fee Modal --}}
    @if ($showAssignModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => 'Assign Fee: ' . $assignStudentName,
                        ])
                        <button type="button" wire:click="closeAssignModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="saveAssignment" class="flex flex-col flex-1 min-h-0">
                    <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Fee Category</label>
                                <select wire:model="assignFeeCategoryId"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                    <option value="">Select Category</option>
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                                @error('assignFeeCategoryId')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">
                                    Academic Year
                                </label>

                                <select wire:model="assignAcademicYear"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                    <option value="">Select Academic Year</option>

                                    @foreach (\App\Models\AcademicYear::where('school_id', auth()->user()->school_id)->where('is_active', true)->ordered()->get() as $year)
                                        <option value="{{ $year->name }}">
                                            {{ $year->name }}
                                        </option>
                                    @endforeach

                                </select>

                                @error('assignAcademicYear')
                                    <p class="text-xs text-red-600 mt-1">
                                        {{ $message }}
                                    </p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Installment <span
                                        class="text-slate-400 font-normal">(optional)</span></label>
                                <input type="text" wire:model="assignInstallmentNumber"
                                    placeholder="e.g. 1st installment"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Amount</label>
                                <input type="number" step="0.01" wire:model="assignAmount"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                @error('assignAmount')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Due Date</label>
                            <input type="date" wire:model="assignDueDate"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                            @error('assignDueDate')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Remarks / Reason <span
                                    class="text-slate-400 font-normal">(optional)</span></label>
                            <textarea wire:model="assignRemarks" rows="2"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]"></textarea>
                        </div>
                    </div>

                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeAssignModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Close</button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="saveAssignment"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm disabled:opacity-60">
                            <span wire:loading.remove wire:target="saveAssignment"><i
                                    class="fas fa-save text-xs mr-1"></i> Assign</span>
                            <span wire:loading wire:target="saveAssignment">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Record Payment Modal --}}
    @if ($showPaymentModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => 'Record Payment: ' . $paymentStudentName,
                        ])
                        <button type="button" wire:click="closePaymentModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                @if ($lastReceiptId)
                    {{-- Receipt-ready state --}}
                    <div class="p-6 sm:p-8 text-center space-y-4 bg-[#F8FAFC]">
                        <i class="fas fa-circle-check text-5xl text-green-500"></i>
                        <p class="text-slate-700 font-semibold">Payment recorded successfully.</p>
                        <div class="flex flex-col sm:flex-row justify-center gap-2">
                            <a href="{{ route('admin.fees.receipts.show', $lastReceiptId) }}" target="_blank"
                                class="px-4 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm">
                                <i class="fas fa-receipt text-xs mr-1"></i> View / Print Receipt
                            </a>
                            <a href="{{ route('admin.fees.receipts.download', $lastReceiptId) }}"
                                class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">
                                <i class="fas fa-download text-xs mr-1"></i> PDF
                            </a>
                        </div>
                        <button wire:click="closePaymentModal"
                            class="text-sm text-slate-500 hover:underline">Done</button>
                    </div>
                @else
                    <form wire:submit.prevent="savePayment" class="flex flex-col flex-1 min-h-0">
                        <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Fee Assignment</label>
                                <select wire:model.live="paymentAssignmentId"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                    <option value="">Select outstanding fee...</option>
                                    @foreach ($paymentOutstandingAssignments as $assignment)
                                        <option value="{{ $assignment->id }}">
                                            {{ $assignment->feeCategory->name }} — {{ $assignment->academic_year }}
                                            (Balance: ${{ number_format($assignment->balance(), 2) }})
                                        </option>
                                    @endforeach
                                </select>
                                @error('paymentAssignmentId')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            @if ($this->selectedAssignment)
                                <div
                                    class="bg-sky-50 border border-sky-100 rounded-lg p-3 text-xs text-[#155E8A] grid grid-cols-2 gap-2">
                                    <div><span class="font-semibold">Academic Year:</span>
                                        {{ $this->selectedAssignment->academic_year }}</div>
                                    <div><span class="font-semibold">Outstanding Balance:</span>
                                        ${{ number_format($this->selectedAssignment->balance(), 2) }}</div>
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Amount
                                        Paid</label>
                                    <input type="number" step="0.01" wire:model="paymentAmountPaid"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                    @error('paymentAmountPaid')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Payment
                                        Date</label>
                                    <input type="date" wire:model="paymentDate"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                    @error('paymentDate')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Payment
                                        Method</label>
                                    <select wire:model="paymentMethod"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                        <option value="">Select Method</option>
                                        <option value="Cash">Cash</option>
                                        <option value="Check">Check</option>
                                        <option value="Bank Transfer">Bank Transfer</option>
                                        <option value="Credit Card">Credit Card</option>
                                        <option value="Mobile Money">Mobile Money</option>
                                    </select>
                                    @error('paymentMethod')
                                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                                <div>
                                    <label class="block text-xs font-semibold text-slate-600 mb-1.5">Reference Number
                                        <span class="text-slate-400 font-normal">(optional)</span></label>
                                    <input type="text" wire:model="paymentReferenceNumber"
                                        class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Remarks / Reason
                                    <span class="text-red-500">(required)</span></label>
                                <textarea wire:model="paymentRemarks" rows="2"
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]"></textarea>
                                @error('paymentRemarks')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div
                            class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                            <button type="button" wire:click="closePaymentModal"
                                class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Close</button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="savePayment"
                                class="px-5 py-2.5 rounded-lg bg-green-600 hover:bg-green-700 text-white font-semibold text-sm disabled:opacity-60">
                                <span wire:loading.remove wire:target="savePayment"><i
                                        class="fas fa-money-bill-wave text-xs mr-1"></i> Record Payment</span>
                                <span wire:loading wire:target="savePayment">Saving...</span>
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif

    {{-- Payment History Modal (includes Edit/Delete per assignment — hidden for Super Admin) --}}
    @if ($showHistoryModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-3xl max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', [
                            'title' => 'Fee History: ' . $historyStudentName,
                        ])
                        <button type="button" wire:click="closeHistoryModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                    @forelse ($this->historyAssignments as $assignment)
                        <div class="border border-[#E2E8F0] rounded-lg overflow-hidden bg-white">
                            <div class="bg-slate-50 px-3 py-2.5 flex flex-wrap items-center justify-between gap-2">
                                <div class="text-sm">
                                    <span
                                        class="font-semibold text-slate-800">{{ $assignment->feeCategory->name }}</span>
                                    <span class="text-slate-400">— {{ $assignment->academic_year }}</span>
                                    @if ($assignment->installment_number)
                                        <span class="text-slate-400">({{ $assignment->installment_number }})</span>
                                    @endif
                                </div>
                                <div class="flex items-center gap-2">
                                    <span
                                        class="text-xs px-2 py-1 rounded-full
                                        @if ($assignment->status === 'paid') bg-green-100 text-green-800
                                        @elseif($assignment->status === 'overdue') bg-red-100 text-red-800
                                        @elseif($assignment->status === 'partial') bg-blue-100 text-blue-800
                                        @else bg-yellow-100 text-yellow-800 @endif">
                                        {{ ucfirst($assignment->status) }}
                                    </span>
                                    <span class="text-xs text-slate-500">
                                        ${{ number_format($assignment->amount, 2) }} due
                                        {{ $assignment->due_date->format('M d, Y') }}
                                    </span>
                                    @if ($canEdit)
                                        <button wire:click="openEditAssignmentModal({{ $assignment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="openEditAssignmentModal({{ $assignment->id }})"
                                            class="h-7 w-7 rounded-md bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 flex items-center justify-center disabled:opacity-60"
                                            title="Edit">
                                            <i class="fas fa-pen text-xs" wire:loading.remove
                                                wire:target="openEditAssignmentModal({{ $assignment->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="openEditAssignmentModal({{ $assignment->id }})"></i>
                                        </button>
                                    @endif
                                    @if ($canDelete)
                                        <button wire:click="confirmDeleteAssignment({{ $assignment->id }})"
                                            wire:loading.attr="disabled"
                                            wire:target="confirmDeleteAssignment({{ $assignment->id }})"
                                            class="h-7 w-7 rounded-md bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] flex items-center justify-center disabled:opacity-60"
                                            title="Delete">
                                            <i class="fas fa-trash text-xs" wire:loading.remove
                                                wire:target="confirmDeleteAssignment({{ $assignment->id }})"></i>
                                            <i class="fas fa-spinner fa-spin text-xs" wire:loading
                                                wire:target="confirmDeleteAssignment({{ $assignment->id }})"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            @if ($assignment->payments->isNotEmpty())
                                <div class="overflow-x-auto">
                                    <table class="w-full min-w-[560px] text-xs">
                                        <thead class="bg-white text-slate-400 uppercase">
                                            <tr>
                                                <th class="px-3 py-2 text-left">Date</th>
                                                <th class="px-3 py-2 text-right">Amount</th>
                                                <th class="px-3 py-2 text-left">Method</th>
                                                <th class="px-3 py-2 text-left">Receipt #</th>
                                                <th class="px-3 py-2 text-left">Recorded By</th>
                                                <th class="px-3 py-2 text-center">Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody class="divide-y divide-slate-100">
                                            @foreach ($assignment->payments as $payment)
                                                <tr>
                                                    <td class="px-3 py-2">
                                                        {{ $payment->payment_date->format('M d, Y') }}
                                                    </td>
                                                    <td class="px-3 py-2 text-right font-semibold text-green-700">
                                                        ${{ number_format($payment->amount_paid, 2) }}</td>
                                                    <td class="px-3 py-2">{{ $payment->payment_method }}</td>
                                                    <td class="px-3 py-2 font-mono">{{ $payment->receipt_number }}
                                                    </td>
                                                    <td class="px-3 py-2">{{ $payment->recordedBy?->name ?? '—' }}
                                                    </td>
                                                    <td class="px-3 py-2">
                                                        <div class="flex justify-center gap-1">
                                                            <a href="{{ route('admin.fees.receipts.show', $payment) }}"
                                                                target="_blank"
                                                                class="h-6 w-6 rounded bg-sky-100 text-[#155E8A] hover:bg-[#155E8A] hover:text-white flex items-center justify-center"
                                                                title="View / Print">
                                                                <i class="fas fa-print text-[10px]"></i>
                                                            </a>
                                                            <a href="{{ route('admin.fees.receipts.download', $payment) }}"
                                                                class="h-6 w-6 rounded bg-slate-100 text-slate-600 hover:bg-slate-700 hover:text-white flex items-center justify-center"
                                                                title="Download PDF">
                                                                <i class="fas fa-file-pdf text-[10px]"></i>
                                                            </a>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @else
                                <div class="px-3 py-4 text-center text-xs text-slate-400">No payments recorded yet.
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10 text-slate-400 text-sm">No fee assignments for this student yet.
                        </div>
                    @endforelse
                </div>

                <div class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end shrink-0">
                    <button wire:click="closeHistoryModal"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Close</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Assignment Modal --}}
    @if ($showEditAssignmentModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div
                class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-lg max-h-[92vh] flex flex-col overflow-hidden">
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5 shrink-0">
                    <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                    <div class="flex items-start justify-between gap-3">
                        @include('partials.modal-school-header', ['title' => 'Edit Fee Assignment'])
                        <button type="button" wire:click="closeEditAssignmentModal"
                            class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>
                    </div>
                </div>

                <form wire:submit.prevent="updateAssignment" class="flex flex-col flex-1 min-h-0">
                    <div class="p-4 sm:p-6 space-y-4 overflow-y-auto flex-1 min-h-0 bg-[#F8FAFC]">
                        @if ($editAssignmentLocked)
                            <div class="bg-amber-50 border border-amber-100 rounded-lg p-3 text-xs text-amber-800">
                                <i class="fas fa-lock text-[10px] mr-1"></i>
                                Payments already exist against this fee — only the due date and remarks can be
                                changed, to protect the payment audit trail.
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Fee Category</label>
                                <select wire:model="editFeeCategoryId" @disabled($editAssignmentLocked)
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A] disabled:bg-slate-100">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Academic Year</label>
                                <input type="text" wire:model="editAcademicYear" @disabled($editAssignmentLocked)
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A] disabled:bg-slate-100">
                                @error('editAcademicYear')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Installment</label>
                                <input type="text" wire:model="editInstallmentNumber" @disabled($editAssignmentLocked)
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A] disabled:bg-slate-100">
                            </div>
                            <div>
                                <label class="block text-xs font-semibold text-slate-600 mb-1.5">Amount</label>
                                <input type="number" step="0.01" wire:model="editAmount"
                                    @disabled($editAssignmentLocked)
                                    class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A] disabled:bg-slate-100">
                                @error('editAmount')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Due Date</label>
                            <input type="date" wire:model="editDueDate"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]">
                            @error('editDueDate')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="block text-xs font-semibold text-slate-600 mb-1.5">Remarks</label>
                            <textarea wire:model="editRemarks" rows="2"
                                class="w-full px-3 py-2 rounded-lg border border-slate-300 text-sm focus:ring-1 focus:ring-[#155E8A]"></textarea>
                        </div>
                    </div>

                    <div
                        class="px-4 sm:px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col-reverse sm:flex-row justify-end gap-2 shrink-0">
                        <button type="button" wire:click="closeEditAssignmentModal"
                            class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100">Close</button>
                        <button type="submit" wire:loading.attr="disabled" wire:target="updateAssignment"
                            class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm disabled:opacity-60">
                            <span wire:loading.remove wire:target="updateAssignment"><i
                                    class="fas fa-save text-xs mr-1"></i> Update</span>
                            <span wire:loading wire:target="updateAssignment">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteAssignmentModal)
        <div class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center p-3 z-50">
            <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">
                <div
                    class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                    <h3 class="text-sm font-semibold text-white">Delete Fee Assignment</h3>
                    <button wire:click="closeDeleteAssignmentModal"
                        class="h-7 w-7 rounded-lg bg-white/10 hover:bg-white/20 text-white flex items-center justify-center">
                        <i class="fas fa-times text-xs"></i>
                    </button>
                </div>
                <div class="p-4 text-sm text-slate-700">
                    Are you sure? This cannot be undone.
                </div>
                <div class="px-4 py-3 flex justify-end gap-2 border-t border-slate-200">
                    <button wire:click="closeDeleteAssignmentModal"
                        class="px-3 py-2 text-sm rounded-md border border-slate-300 hover:bg-slate-100">Cancel</button>
                    <button wire:click="deleteAssignment" wire:loading.attr="disabled" wire:target="deleteAssignment"
                        class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700 disabled:opacity-60">
                        <span wire:loading.remove wire:target="deleteAssignment">Delete</span>
                        <span wire:loading wire:target="deleteAssignment">Deleting...</span>
                    </button>
                </div>
            </div>
        </div>
    @endif

</div>
