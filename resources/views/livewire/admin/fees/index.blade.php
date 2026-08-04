<div class="p-4 sm:p-6 bg-white rounded-xl shadow space-y-5">

    @include('partials.notifications')

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Fees Management</h1>
            <p class="text-gray-500 text-sm mt-1">
                One record per student — assign fees, record payments, and view history from their row.
            </p>
        </div>

        <a href="{{ route('admin.fee-categories.index') }}"
            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 rounded-md border border-[#0a1f44] text-[#0a1f44] font-semibold text-sm hover:bg-blue-50 transition-colors">
            <i class="fas fa-tags text-xs"></i>
            Manage Categories
        </a>
    </div>

    {{-- Category Tabs --}}
    <div class="flex flex-wrap gap-2 border-b border-gray-200 pb-3">
        <button type="button" wire:click="$set('categoryFilter', 'all')"
            class="px-4 py-2 rounded-md text-sm font-semibold transition-colors
                {{ $categoryFilter === 'all' ? 'bg-[#0a1f44] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
            All Fees
        </button>
        @foreach ($categories as $category)
            <button type="button" wire:click="$set('categoryFilter', '{{ $category->id }}')"
                class="px-4 py-2 rounded-md text-sm font-semibold transition-colors
                    {{ (string) $categoryFilter === (string) $category->id ? 'bg-[#0a1f44] text-white' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">
                {{ $category->name }}
            </button>
        @endforeach
    </div>

    <div class="w-full sm:w-64">
        <select wire:model.live="academicYearFilter"
            class="w-full rounded-lg border-gray-300 text-sm focus:ring-[#0a1f44] focus:border-[#0a1f44]">
            <option value="">All Academic Years</option>

            @foreach ($academicYears as $year)
                <option value="{{ $year->name }}">
                    {{ $year->name }} ({{ $year->students_count }})
                </option>
            @endforeach
        </select>
    </div>

    {{-- Search + Grade Filter --}}
    <div class="bg-gray-50 border border-gray-200 rounded-md p-3 sm:p-4 flex flex-col sm:flex-row gap-2 sm:gap-3">
        <div class="relative flex-1">
            <i class="fas fa-magnifying-glass text-gray-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
            <input type="text" wire:model.live.debounce.350ms="search"
                placeholder="Search by student name or Student ID..."
                class="w-full pl-10 pr-3 py-2.5 rounded-md border border-gray-300 text-sm text-gray-700 placeholder-gray-400 focus:ring-2 focus:ring-[#0a1f44]/30 focus:border-[#0a1f44] transition-shadow">
        </div>

        <select wire:model.live="gradeFilter"
            class="py-2.5 px-3 border border-gray-300 rounded-md text-sm bg-white min-w-[140px] focus:outline-none focus:ring-2 focus:ring-[#0a1f44]/30 focus:border-[#0a1f44]">
            <option value="">All Grades</option>
            @foreach ($grades as $grade)
                <option value="{{ $grade }}">{{ $grade }}</option>
            @endforeach
        </select>
    </div>

    {{-- Students Table --}}
    <div class="bg-white rounded-md border border-gray-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[900px] text-sm">
                <thead class="bg-[#0a1f44] text-white">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Student</th>
                        <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide">Grade</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Assigned</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Paid</th>
                        <th class="px-4 py-3 text-right text-xs font-semibold uppercase tracking-wide">Balance</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">Status</th>
                        <th class="px-4 py-3 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @forelse ($students as $student)
                        @php
                            $totalAssigned = $student->feeAssignments->sum('amount');
                            $totalPaid = $student->feeAssignments->sum(fn($a) => $a->payments->sum('amount_paid'));
                            $balance = $totalAssigned - $totalPaid;

                            if ($student->feeAssignments->isEmpty()) {
                                $rowStatus = 'no_fees';
                            } elseif ($balance <= 0) {
                                $rowStatus = 'paid';
                            } elseif ($student->feeAssignments->contains('status', 'overdue')) {
                                $rowStatus = 'overdue';
                            } elseif ($totalPaid > 0) {
                                $rowStatus = 'partial';
                            } else {
                                $rowStatus = 'pending';
                            }

                            $statusClasses = [
                                'no_fees' => 'bg-gray-100 text-gray-500',
                                'pending' => 'bg-yellow-100 text-yellow-800',
                                'partial' => 'bg-blue-100 text-blue-800',
                                'paid' => 'bg-green-100 text-green-800',
                                'overdue' => 'bg-red-100 text-red-800',
                            ];
                        @endphp
                        <tr wire:key="student-{{ $student->student_id }}"
                            class="hover:bg-blue-50/50 transition-colors">
                            <td class="px-4 py-3">
                                <div class="font-semibold text-gray-800">{{ $student->name }}</div>
                                <div class="text-xs text-gray-400 font-mono">{{ $student->student_id }}</div>
                            </td>
                            <td class="px-4 py-3 text-gray-600">{{ $student->class_applying_for ?? '—' }}</td>
                            <td class="px-4 py-3 text-right text-gray-700">${{ number_format($totalAssigned, 2) }}</td>
                            <td class="px-4 py-3 text-right text-green-600 font-semibold">
                                ${{ number_format($totalPaid, 2) }}</td>
                            <td class="px-4 py-3 text-right text-red-600 font-semibold">
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
                                        <button wire:click="openAssignModal('{{ $student->student_id }}')"
                                            class="px-2.5 py-1.5 rounded-md bg-blue-100 hover:bg-[#0a1f44] hover:text-white text-[#0a1f44] text-xs font-semibold transition-colors"
                                            title="Assign Fee">
                                            <i class="fas fa-plus text-xs"></i>
                                        </button>
                                        <button wire:click="openPaymentModal('{{ $student->student_id }}')"
                                            class="px-2.5 py-1.5 rounded-md bg-green-100 hover:bg-green-700 hover:text-white text-green-700 text-xs font-semibold transition-colors"
                                            title="Record Payment">
                                            <i class="fas fa-money-bill-wave text-xs"></i>
                                        </button>
                                    @endif

                                    @if ($canView)
                                        <button wire:click="openHistoryModal('{{ $student->student_id }}')"
                                            class="px-2.5 py-1.5 rounded-md bg-gray-100 hover:bg-gray-700 hover:text-white text-gray-600 text-xs font-semibold transition-colors"
                                            title="Payment History">
                                            <i class="fas fa-clock-rotate-left text-xs"></i>
                                        </button>
                                        <a href="{{ route('admin.fees.statement', $student->id) }}" target="_blank"
                                            class="px-2.5 py-1.5 rounded-md bg-amber-100 hover:bg-amber-600 hover:text-white text-amber-700 text-xs font-semibold transition-colors"
                                            title="Fee Statement">
                                            <i class="fas fa-file-invoice text-xs"></i>
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center py-16">
                                <i class="fas fa-users text-5xl text-gray-300 mb-3"></i>
                                <p class="text-gray-500 text-sm">No students found.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="bg-gray-50 px-4 sm:px-6 py-4 border-t border-gray-200">
            {{ $students->links() }}
        </div>
    </div>

    {{-- Assign Fee Modal --}}
    @if ($showAssignModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="bg-[#0a1f44] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold">Assign Fee — {{ $assignStudentName }}</h3>
                    <button wire:click="closeAssignModal" class="text-white/80 hover:text-white">&times;</button>
                </div>

                <form wire:submit.prevent="saveAssignment" class="p-4 space-y-3">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Fee Category</label>
                            <select wire:model="assignFeeCategoryId"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
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
                            <label class="block text-xs font-medium text-gray-700 mb-1">
                                Academic Year
                            </label>

                            <select wire:model="assignAcademicYear"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                                <option value="">Select Academic Year</option>

                                @foreach (\App\Models\AcademicYear::active()->ordered()->get() as $year)
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

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Installment <span
                                    class="text-gray-400 font-normal">(optional)</span></label>
                            <input type="text" wire:model="assignInstallmentNumber"
                                placeholder="e.g. 1st installment"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" wire:model="assignAmount"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                            @error('assignAmount')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Due Date</label>
                        <input type="date" wire:model="assignDueDate"
                            class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                        @error('assignDueDate')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Remarks / Reason <span
                                class="text-gray-400 font-normal">(optional)</span></label>
                        <textarea wire:model="assignRemarks" rows="2"
                            class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]"></textarea>
                    </div>

                    <div class="bg-gray-50 -mx-4 -mb-4 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                        <button type="button" wire:click="closeAssignModal"
                            class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Close</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-md bg-[#0a1f44] text-white font-semibold hover:opacity-90">
                            <i class="fas fa-save text-xs mr-1"></i> Assign
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Record Payment Modal --}}
    @if ($showPaymentModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="bg-[#0a1f44] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold">Record Payment — {{ $paymentStudentName }}</h3>
                    <button wire:click="closePaymentModal" class="text-white/80 hover:text-white">&times;</button>
                </div>

                @if ($lastReceiptId)
                    {{-- Receipt-ready state --}}
                    <div class="p-6 text-center space-y-4">
                        <i class="fas fa-circle-check text-5xl text-green-500"></i>
                        <p class="text-gray-700 font-semibold">Payment recorded successfully.</p>
                        <div class="flex justify-center gap-2">
                            <a href="{{ route('admin.fees.receipts.show', $lastReceiptId) }}" target="_blank"
                                class="px-4 py-2 text-sm rounded-md bg-[#0a1f44] text-white font-semibold hover:opacity-90">
                                <i class="fas fa-receipt text-xs mr-1"></i> View / Print Receipt
                            </a>
                            <a href="{{ route('admin.fees.receipts.download', $lastReceiptId) }}"
                                class="px-4 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">
                                <i class="fas fa-download text-xs mr-1"></i> PDF
                            </a>
                        </div>
                        <button wire:click="closePaymentModal"
                            class="text-sm text-gray-500 hover:underline">Done</button>
                    </div>
                @else
                    <form wire:submit.prevent="savePayment" class="p-4 space-y-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Fee Assignment</label>
                            <select wire:model.live="paymentAssignmentId"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
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
                                class="bg-blue-50 border border-blue-100 rounded-md p-3 text-xs text-[#0a1f44] grid grid-cols-2 gap-2">
                                <div><span class="font-semibold">Academic Year:</span>
                                    {{ $this->selectedAssignment->academic_year }}</div>
                                <div><span class="font-semibold">Outstanding Balance:</span>
                                    ${{ number_format($this->selectedAssignment->balance(), 2) }}</div>
                            </div>
                        @endif

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Amount Paid</label>
                                <input type="number" step="0.01" wire:model="paymentAmountPaid"
                                    class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                                @error('paymentAmountPaid')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Payment Date</label>
                                <input type="date" wire:model="paymentDate"
                                    class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                                @error('paymentDate')
                                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-700 mb-1">Payment Method</label>
                                <select wire:model="paymentMethod"
                                    class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
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
                                <label class="block text-xs font-medium text-gray-700 mb-1">Reference Number <span
                                        class="text-gray-400 font-normal">(optional)</span></label>
                                <input type="text" wire:model="paymentReferenceNumber"
                                    class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Remarks / Reason <span
                                    class="text-red-500">(required)</span></label>
                            <textarea wire:model="paymentRemarks" rows="2"
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]"></textarea>
                            @error('paymentRemarks')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="bg-gray-50 -mx-4 -mb-4 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                            <button type="button" wire:click="closePaymentModal"
                                class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Close</button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="savePayment"
                                class="px-4 py-2 text-sm rounded-md bg-green-700 text-white font-semibold hover:opacity-90 disabled:opacity-60">
                                <i class="fas fa-money-bill-wave text-xs mr-1"></i> Record Payment
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    @endif

    {{-- Payment History Modal (includes Edit/Delete per assignment) --}}
    @if ($showHistoryModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto">
                <div class="bg-[#0a1f44] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold">Fee History — {{ $historyStudentName }}</h3>
                    <button wire:click="closeHistoryModal" class="text-white/80 hover:text-white">&times;</button>
                </div>

                <div class="p-4 space-y-4">
                    @forelse ($this->historyAssignments as $assignment)
                        <div class="border border-gray-200 rounded-md overflow-hidden">
                            <div class="bg-gray-50 px-3 py-2 flex flex-wrap items-center justify-between gap-2">
                                <div class="text-sm">
                                    <span
                                        class="font-semibold text-gray-800">{{ $assignment->feeCategory->name }}</span>
                                    <span class="text-gray-400">— {{ $assignment->academic_year }}</span>
                                    @if ($assignment->installment_number)
                                        <span class="text-gray-400">({{ $assignment->installment_number }})</span>
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
                                    <span class="text-xs text-gray-500">
                                        ${{ number_format($assignment->amount, 2) }} due
                                        {{ $assignment->due_date->format('M d, Y') }}
                                    </span>
                                    @if ($canEdit)
                                        <button wire:click="openEditAssignmentModal({{ $assignment->id }})"
                                            class="h-7 w-7 rounded-md bg-yellow-100 hover:bg-yellow-600 hover:text-white text-yellow-700 flex items-center justify-center"
                                            title="Edit">
                                            <i class="fas fa-pen text-xs"></i>
                                        </button>
                                    @endif
                                    @if ($canDelete)
                                        <button wire:click="confirmDeleteAssignment({{ $assignment->id }})"
                                            class="h-7 w-7 rounded-md bg-red-100 hover:bg-red-700 hover:text-white text-red-700 flex items-center justify-center"
                                            title="Delete">
                                            <i class="fas fa-trash text-xs"></i>
                                        </button>
                                    @endif
                                </div>
                            </div>

                            @if ($assignment->payments->isNotEmpty())
                                <table class="w-full text-xs">
                                    <thead class="bg-white text-gray-400 uppercase">
                                        <tr>
                                            <th class="px-3 py-2 text-left">Date</th>
                                            <th class="px-3 py-2 text-right">Amount</th>
                                            <th class="px-3 py-2 text-left">Method</th>
                                            <th class="px-3 py-2 text-left">Receipt #</th>
                                            <th class="px-3 py-2 text-left">Recorded By</th>
                                            <th class="px-3 py-2 text-center">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-100">
                                        @foreach ($assignment->payments as $payment)
                                            <tr>
                                                <td class="px-3 py-2">{{ $payment->payment_date->format('M d, Y') }}
                                                </td>
                                                <td class="px-3 py-2 text-right font-semibold text-green-700">
                                                    ${{ number_format($payment->amount_paid, 2) }}</td>
                                                <td class="px-3 py-2">{{ $payment->payment_method }}</td>
                                                <td class="px-3 py-2 font-mono">{{ $payment->receipt_number }}</td>
                                                <td class="px-3 py-2">{{ $payment->recordedBy?->name ?? '—' }}</td>
                                                <td class="px-3 py-2">
                                                    <div class="flex justify-center gap-1">
                                                        <a href="{{ route('admin.fees.receipts.show', $payment) }}"
                                                            target="_blank"
                                                            class="px-2 py-1 rounded bg-blue-100 text-[#0a1f44] hover:bg-[#0a1f44] hover:text-white"
                                                            title="View / Print">
                                                            <i class="fas fa-print text-[10px]"></i>
                                                        </a>
                                                        <a href="{{ route('admin.fees.receipts.download', $payment) }}"
                                                            class="px-2 py-1 rounded bg-gray-100 text-gray-600 hover:bg-gray-700 hover:text-white"
                                                            title="Download PDF">
                                                            <i class="fas fa-file-pdf text-[10px]"></i>
                                                        </a>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="px-3 py-4 text-center text-xs text-gray-400">No payments recorded yet.
                                </div>
                            @endif
                        </div>
                    @empty
                        <div class="text-center py-10 text-gray-400 text-sm">No fee assignments for this student yet.
                        </div>
                    @endforelse
                </div>

                <div class="bg-gray-50 px-4 py-3 flex justify-end border-t border-gray-200">
                    <button wire:click="closeHistoryModal"
                        class="px-4 py-2 text-sm rounded-md bg-[#0a1f44] text-white font-semibold hover:opacity-90">Close</button>
                </div>
            </div>
        </div>
    @endif

    {{-- Edit Assignment Modal --}}
    @if ($showEditAssignmentModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-lg max-h-[90vh] overflow-y-auto">
                <div class="bg-[#0a1f44] text-white px-5 py-4 flex justify-between items-center">
                    <h3 class="font-semibold">Edit Fee Assignment</h3>
                    <button wire:click="closeEditAssignmentModal"
                        class="text-white/80 hover:text-white">&times;</button>
                </div>

                <form wire:submit.prevent="updateAssignment" class="p-4 space-y-3">
                    @if ($editAssignmentLocked)
                        <div class="bg-amber-50 border border-amber-100 rounded-md p-3 text-xs text-amber-800">
                            <i class="fas fa-lock text-[10px] mr-1"></i>
                            Payments already exist against this fee — only the due date and remarks can be changed,
                            to protect the payment audit trail.
                        </div>
                    @endif

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Fee Category</label>
                            <select wire:model="editFeeCategoryId" @disabled($editAssignmentLocked)
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44] disabled:bg-gray-100">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Academic Year</label>
                            <input type="text" wire:model="editAcademicYear" @disabled($editAssignmentLocked)
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44] disabled:bg-gray-100">
                            @error('editAcademicYear')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Installment</label>
                            <input type="text" wire:model="editInstallmentNumber" @disabled($editAssignmentLocked)
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44] disabled:bg-gray-100">
                        </div>
                        <div>
                            <label class="block text-xs font-medium text-gray-700 mb-1">Amount</label>
                            <input type="number" step="0.01" wire:model="editAmount" @disabled($editAssignmentLocked)
                                class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44] disabled:bg-gray-100">
                            @error('editAmount')
                                <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Due Date</label>
                        <input type="date" wire:model="editDueDate"
                            class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]">
                        @error('editDueDate')
                            <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-700 mb-1">Remarks</label>
                        <textarea wire:model="editRemarks" rows="2"
                            class="w-full text-sm py-2 px-2.5 border border-gray-300 rounded-md focus:ring-1 focus:ring-[#0a1f44]"></textarea>
                    </div>

                    <div class="bg-gray-50 -mx-4 -mb-4 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                        <button type="button" wire:click="closeEditAssignmentModal"
                            class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Close</button>
                        <button type="submit"
                            class="px-4 py-2 text-sm rounded-md bg-[#0a1f44] text-white font-semibold hover:opacity-90">
                            <i class="fas fa-save text-xs mr-1"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    {{-- Delete Confirmation Modal --}}
    @if ($showDeleteAssignmentModal)
        <div class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center px-3 z-50">
            <div class="bg-white rounded-md shadow-2xl w-full max-w-xs overflow-hidden">
                <div class="bg-red-600 text-white px-4 py-3">
                    <h3 class="font-semibold text-sm">Delete Fee Assignment</h3>
                </div>
                <div class="p-4 text-sm text-gray-700">
                    Are you sure? This cannot be undone.
                </div>
                <div class="bg-gray-50 px-4 py-3 flex justify-end gap-2 border-t border-gray-200">
                    <button wire:click="closeDeleteAssignmentModal"
                        class="px-3 py-2 text-sm rounded-md border border-gray-300 hover:bg-gray-100">Cancel</button>
                    <button wire:click="deleteAssignment"
                        class="px-3 py-2 text-sm rounded-md bg-red-600 text-white font-semibold hover:bg-red-700">Delete</button>
                </div>
            </div>
        </div>
    @endif

</div>
