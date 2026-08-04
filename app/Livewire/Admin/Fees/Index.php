<?php

namespace App\Livewire\Admin\Fees;

use App\Models\FeeAssignment;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\Student;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    /*
    |--------------------------------------------------------------------------
    | UI State — category tabs, search, grade filter
    |--------------------------------------------------------------------------
    */

    public string $categoryFilter = 'all';

    public string $search = '';

    public string $gradeFilter = '';

    public function updatedCategoryFilter()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedGradeFilter()
    {
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Assign Fee — student is always pre-selected from the row, never a
    | dropdown of every student.
    |--------------------------------------------------------------------------
    */

    public bool $showAssignModal = false;
    public $assignStudentId;
    public $assignStudentName;
    public $assignFeeCategoryId = '';
    public $assignAcademicYear = '';
    public $assignInstallmentNumber = '';
    public $assignAmount = '';
    public $assignDueDate = '';
    public $assignRemarks = '';
    // Academic year flitter property 
    public $academicYearFilter = '';

    public function openAssignModal(string $studentId)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $student = Student::where('student_id', $studentId)->firstOrFail();

        $this->assignStudentId = $student->student_id;
        $this->assignStudentName = $student->name;
        // Defaults to whichever category tab is active, if a real one is selected.
        $this->assignFeeCategoryId = $this->categoryFilter !== 'all' ? $this->categoryFilter : '';
        $this->assignAcademicYear = '';
        $this->assignInstallmentNumber = '';
        $this->assignAmount = '';
        $this->assignDueDate = '';
        $this->assignRemarks = '';
        $this->showAssignModal = true;
    }

    public function closeAssignModal()
    {
        $this->showAssignModal = false;
        $this->resetErrorBag();
    }

    protected function academicYearRules(): array
    {
        return [
            'required',
            'exists:academic_years,name',
        ];
    }

    public function saveAssignment()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $this->validate([
            'assignFeeCategoryId' => 'required|exists:fee_categories,id',
            'assignAcademicYear' => $this->academicYearRules(),
            'assignInstallmentNumber' => 'nullable|string|max:255',
            'assignAmount' => 'required|numeric|min:0.01',
            'assignDueDate' => 'required|date',
            'assignRemarks' => 'nullable|string',
        ]);

        FeeAssignment::create([
            'student_id' => $this->assignStudentId,
            'fee_category_id' => $this->assignFeeCategoryId,
            'academic_year' => $this->assignAcademicYear,
            'installment_number' => $this->assignInstallmentNumber ?: null,
            'amount' => $this->assignAmount,
            'due_date' => $this->assignDueDate,
            'remarks' => $this->assignRemarks,
            'status' => 'pending',
            'assigned_by' => auth()->id(),
        ]);

        $this->showAssignModal = false;

        $this->dispatch('notify', message: "Fee assigned to {$this->assignStudentName}.", type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Record Payment — student pre-selected, then a short dropdown of only
    | THAT student's own outstanding assignments (not a global fee list).
    |--------------------------------------------------------------------------
    */

    public bool $showPaymentModal = false;
    public $paymentStudentId;
    public $paymentStudentName;
    public $paymentOutstandingAssignments = [];
    public $paymentAssignmentId = '';
    public $paymentAmountPaid = '';
    public $paymentDate = '';
    public $paymentMethod = '';
    public $paymentReferenceNumber = '';
    public $paymentRemarks = '';

    // Set after a successful save so the modal can show a "Receipt ready" state.
    public $lastReceiptId = null;

    public function openPaymentModal(string $studentId)
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $student = Student::where('student_id', $studentId)->firstOrFail();

        $this->paymentStudentId = $student->student_id;
        $this->paymentStudentName = $student->name;
        $this->paymentOutstandingAssignments = FeeAssignment::where('student_id', $student->student_id)
            ->where('status', '!=', 'paid')
            ->with('feeCategory')
            ->orderByDesc('due_date')
            ->get();
        $this->paymentAssignmentId = '';
        $this->paymentAmountPaid = '';
        $this->paymentDate = now()->format('Y-m-d');
        $this->paymentMethod = '';
        $this->paymentReferenceNumber = '';
        $this->paymentRemarks = '';
        $this->lastReceiptId = null;
        $this->showPaymentModal = true;
    }

    public function getSelectedAssignmentProperty()
    {
        if (! $this->paymentAssignmentId) {
            return null;
        }

        return FeeAssignment::with('feeCategory')->find($this->paymentAssignmentId);
    }

    public function closePaymentModal()
    {
        $this->showPaymentModal = false;
        $this->lastReceiptId = null;
        $this->resetErrorBag();
    }

    public function savePayment()
    {
        if (! auth()->user()->can('manage fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($this->paymentAssignmentId);
        $balance = (float) $assignment->balance();

        $this->validate([
            'paymentAssignmentId' => 'required|exists:fee_assignments,id',
            'paymentAmountPaid' => "required|numeric|min:0.01|max:{$balance}",
            'paymentDate' => 'required|date',
            'paymentMethod' => 'required|string|max:255',
            'paymentReferenceNumber' => 'nullable|string|max:255',
            'paymentRemarks' => 'required|string|min:3',
        ], [
            'paymentAmountPaid.max' => 'Amount paid cannot exceed the outstanding balance of $' . number_format($balance, 2) . '.',
        ]);

        $payment = FeePayment::create([
            'fee_assignment_id' => $this->paymentAssignmentId,
            'amount_paid' => $this->paymentAmountPaid,
            'payment_date' => $this->paymentDate,
            'payment_method' => $this->paymentMethod,
            'reference_number' => $this->paymentReferenceNumber,
            'remarks' => $this->paymentRemarks,
            'recorded_by' => auth()->id(),
        ]);

        // Status recalculation happens automatically via FeePayment's
        // "created" model event — nothing to do here.

        $this->lastReceiptId = $payment->id;

        $this->dispatch('notify', message: "Payment recorded — Receipt {$payment->receipt_number}.", type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Payment History — read-only, per student. Edit/Delete on individual
    | assignments live here too, since that's where assignment-level rows
    | actually exist (a student can have many assignments, so these
    | actions don't make sense on the main per-student row).
    |--------------------------------------------------------------------------
    */

    public bool $showHistoryModal = false;
    public $historyStudentId;
    public $historyStudentName;

    public function openHistoryModal(string $studentId)
    {
        if (! auth()->user()->can('view fee details')) {
            abort(403);
        }

        $student = Student::where('student_id', $studentId)->firstOrFail();

        $this->historyStudentId = $student->student_id;
        $this->historyStudentName = $student->name;
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
    }

    public function getHistoryAssignmentsProperty()
    {
        if (! $this->showHistoryModal || ! $this->historyStudentId) {
            return collect();
        }

        return FeeAssignment::where('student_id', $this->historyStudentId)
            ->with(['feeCategory', 'payments' => fn($q) => $q->orderByDesc('payment_date')])
            ->orderByDesc('due_date')
            ->get();
    }

    /*
    |--------------------------------------------------------------------------
    | Edit Assignment — only unlocked fields once a payment exists
    | (amount/category/year become read-only to protect the audit trail).
    |--------------------------------------------------------------------------
    */

    public bool $showEditAssignmentModal = false;
    public $editAssignmentId;
    public $editAssignmentLocked = false;
    public $editFeeCategoryId = '';
    public $editAcademicYear = '';
    public $editInstallmentNumber = '';
    public $editAmount = '';
    public $editDueDate = '';
    public $editRemarks = '';

    public function openEditAssignmentModal(int $assignmentId)
    {
        if (! auth()->user()->can('edit fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($assignmentId);

        $this->editAssignmentId = $assignment->id;
        $this->editAssignmentLocked = $assignment->isLockedForEditing();
        $this->editFeeCategoryId = $assignment->fee_category_id;
        $this->editAcademicYear = $assignment->academic_year;
        $this->editInstallmentNumber = $assignment->installment_number;
        $this->editAmount = $assignment->amount;
        $this->editDueDate = $assignment->due_date->format('Y-m-d');
        $this->editRemarks = $assignment->remarks;
        $this->showEditAssignmentModal = true;
    }

    public function closeEditAssignmentModal()
    {
        $this->showEditAssignmentModal = false;
        $this->resetErrorBag();
    }

    public function updateAssignment()
    {
        if (! auth()->user()->can('edit fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($this->editAssignmentId);

        if ($assignment->isLockedForEditing()) {
            // Only due_date/remarks are editable once a payment exists.
            $this->validate([
                'editDueDate' => 'required|date',
                'editRemarks' => 'nullable|string',
            ]);

            $assignment->update([
                'due_date' => $this->editDueDate,
                'remarks' => $this->editRemarks,
            ]);
        } else {
            $this->validate([
                'editFeeCategoryId' => 'required|exists:fee_categories,id',
                'editAcademicYear' => $this->academicYearRules(),
                'editInstallmentNumber' => 'nullable|string|max:255',
                'editAmount' => 'required|numeric|min:0.01',
                'editDueDate' => 'required|date',
                'editRemarks' => 'nullable|string',
            ]);

            $assignment->update([
                'fee_category_id' => $this->editFeeCategoryId,
                'academic_year' => $this->editAcademicYear,
                'installment_number' => $this->editInstallmentNumber ?: null,
                'amount' => $this->editAmount,
                'due_date' => $this->editDueDate,
                'remarks' => $this->editRemarks,
            ]);
        }

        $assignment->recalculateStatus();

        $this->showEditAssignmentModal = false;

        $this->dispatch('notify', message: 'Fee assignment updated.', type: 'success');
    }

    /*
    |--------------------------------------------------------------------------
    | Delete Assignment — only if it has zero payments.
    |--------------------------------------------------------------------------
    */

    public $deleteAssignmentId;
    public bool $showDeleteAssignmentModal = false;

    public function confirmDeleteAssignment(int $assignmentId)
    {
        if (! auth()->user()->can('delete fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($assignmentId);

        if (! $assignment->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete — this assignment already has payments recorded against it.', type: 'error');
            return;
        }

        $this->deleteAssignmentId = $assignmentId;
        $this->showDeleteAssignmentModal = true;
    }

    public function deleteAssignment()
    {
        if (! auth()->user()->can('delete fees')) {
            abort(403);
        }

        $assignment = FeeAssignment::findOrFail($this->deleteAssignmentId);

        if (! $assignment->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete — payments exist against this assignment.', type: 'error');
            $this->showDeleteAssignmentModal = false;
            return;
        }

        $assignment->delete();

        $this->showDeleteAssignmentModal = false;

        $this->dispatch('notify', message: 'Fee assignment deleted.', type: 'success');
    }

    public function closeDeleteAssignmentModal()
    {
        $this->showDeleteAssignmentModal = false;
        $this->deleteAssignmentId = null;
    }

    /*
    |--------------------------------------------------------------------------
    | Render — one row per Student, scoped to the active category tab.
    |--------------------------------------------------------------------------
    */

    public function mount()
    {
        $this->academicYearFilter = \App\Models\AcademicYear::where('is_active', true)
            ->orderBy('sort_order')
            ->value('name');
    }


    public function render()
    {

        $academicYears = \App\Models\AcademicYear::query()
            ->whereIn(
                'name',
                Student::query()
                    ->whereNotNull('intake')
                    ->distinct()
                    ->pluck('intake')
            )
            ->withCount('students')
            ->ordered()
            ->get();

        $categories = FeeCategory::active()->orderBy('sort_order')->get();

        $grades = Student::query()->distinct()->pluck('class_applying_for')->filter()->values();

        $studentsQuery = Student::query()

            ->where('status', 'active')

            ->when($this->academicYearFilter, function ($query) {
                $query->where('intake', $this->academicYearFilter);
            })

            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhere('student_id', 'like', "%{$this->search}%");
                });
            })

            ->when($this->gradeFilter, function ($query) {
                $query->where('class_applying_for', $this->gradeFilter);
            });

        if ($this->categoryFilter !== 'all') {
            $studentsQuery->whereHas('feeAssignments', function ($query) {
                $query->where('fee_category_id', $this->categoryFilter);
            });
        }

        $students = $studentsQuery
            ->with(['feeAssignments' => function ($query) {
                if ($this->categoryFilter !== 'all') {
                    $query->where('fee_category_id', $this->categoryFilter);
                }
                $query->with('payments');
            }])
            ->orderBy('name')
            ->paginate(10);

        return view('livewire.admin.fees.index', [
            'students' => $students,
            'categories' => $categories,
            'grades' => $grades,
            'canManage' => auth()->user()->can('manage fees'),
            'canEdit' => auth()->user()->can('edit fees'),
            'canDelete' => auth()->user()->can('delete fees'),
            'canView' => auth()->user()->can('view fee details'),
            'academicYears' => $academicYears,
        ]);
    }
}
