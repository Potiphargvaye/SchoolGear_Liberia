<?php

namespace App\Livewire\Admin\Fees;

use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\FeeAssignment;
use App\Models\FeeCategory;
use App\Models\FeePayment;
use App\Models\Grade;
use App\Models\School;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

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

    public $gradeFilter = '';

    // Academic year filter — now the AcademicYear id, since Enrollments
    // carry academic_year_id directly (was a free-text "intake" string
    // match before the Students/Enrollments rebuild).
    public $academicYearFilter = '';

    // Super Admin only — narrows the whole page to one school. Empty
    // string means "all schools".
    public $schoolFilter = '';

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

    public function updatedAcademicYearFilter()
    {
        $this->resetPage();
    }

    public function updatedSchoolFilter()
    {
        // Switching schools invalidates the previously selected category/
        // academic year (they belong to the old school's scope).
        $this->categoryFilter = 'all';
        $this->academicYearFilter = '';
        $this->resetPage();
    }

    /*
    |--------------------------------------------------------------------------
    | Tenant helpers ------------------
    */

    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    protected function isPlatformAdmin(): bool
    {
        return $this->currentSchoolId() === null;
    }

    public function mount()
    {
        if (! $this->isPlatformAdmin()) {
            $this->academicYearFilter = AcademicYear::where('school_id', $this->currentSchoolId())
                ->where('is_active', true)
                ->value('id') ?? '';
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Assign Fee — student is always pre-selected from the row, never a
    | dropdown of every student. Selected via their Enrollment (never the
    | Students table directly), so school/grade/year context always
    | travels with it.
    |--------------------------------------------------------------------------
    */

    public bool $showAssignModal = false;
    public $assignEnrollmentId;
    public $assignStudentName;
    public $assignFeeCategoryId = '';
    public $assignAcademicYear = '';
    public $assignInstallmentNumber = '';
    public $assignAmount = '';
    public $assignDueDate = '';
    public $assignRemarks = '';

    // Bulk (assign)
    public bool $assignToAllInGrade = false;
    public $assignGradeLabel = '';
    public int $assignGradeStudentCount = 0;
    // Bulk (edit)
    public bool $editApplyToGrade = false;
    public $editGradeLabel = '';
    public int $editGradeMatchCount = 0;

    /** Active enrollments in the SAME school + grade + academic year as $source. */
    protected function gradeEnrollmentsQuery(Enrollment $source)
    {
        return Enrollment::where('school_id', $source->school_id)
            ->where('grade_id', $source->grade_id)
            ->where('academic_year_id', $source->academic_year_id)
            ->where('status', 'active');
    }

    protected function gradeLabel(Enrollment $enrollment): string
    {
        return trim(($enrollment->grade->level ?? '') . ' ' . ($enrollment->grade->section ?? '')) ?: 'this grade';
    }

    /** Null-safe match on installment_number. */
    protected function whereInstallment($query, ?string $installment)
    {
        return $installment === null
            ? $query->whereNull('installment_number')
            : $query->where('installment_number', $installment);
    }

    public function openAssignModal(int $enrollmentId)
    {
        if (! auth()->user()->can('manage fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())
            ->with(['student', 'grade'])
            ->findOrFail($enrollmentId);
        $this->assignToAllInGrade = false;
        $this->assignGradeLabel = $this->gradeLabel($enrollment);
        $this->assignGradeStudentCount = $this->gradeEnrollmentsQuery($enrollment)->count();

        $this->assignEnrollmentId = $enrollment->id;
        $this->assignStudentName = $enrollment->student->name;
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
        if (! auth()->user()->can('manage fees') || $this->isPlatformAdmin()) {
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

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())
            ->findOrFail($this->assignEnrollmentId);

        if ($this->assignToAllInGrade) {
            $this->saveBulkAssignment($enrollment);
            return;
        }

        FeeAssignment::create([
            'school_id' => $enrollment->school_id,
            'enrollment_id' => $enrollment->id,
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

    // New Menthod for bulk Assignmenet
    protected function saveBulkAssignment(Enrollment $source): void
    {
        $schoolId = $source->school_id;

        $category = FeeCategory::where('school_id', $schoolId)->find($this->assignFeeCategoryId);
        if (! $category) {
            $this->addError('assignFeeCategoryId', 'Selected fee category does not belong to this school.');
            return;
        }

        if (! AcademicYear::where('school_id', $schoolId)->where('name', $this->assignAcademicYear)->exists()) {
            $this->addError('assignAcademicYear', 'Selected academic year does not belong to this school.');
            return;
        }

        $installment = $this->assignInstallmentNumber ?: null;
        $gradeLabel = $this->gradeLabel($source->loadMissing('grade'));

        try {
            [$created, $skipped] = DB::transaction(function () use ($source, $schoolId, $category, $installment) {
                $targetIds = $this->gradeEnrollmentsQuery($source)->pluck('id');

                $existing = $this->whereInstallment(
                    FeeAssignment::where('school_id', $schoolId)
                        ->whereIn('enrollment_id', $targetIds)
                        ->where('fee_category_id', $category->id)
                        ->where('academic_year', $this->assignAcademicYear),
                    $installment
                )->lockForUpdate()->pluck('enrollment_id');

                $toCreate = $targetIds->diff($existing);

                foreach ($toCreate as $enrollmentId) {
                    FeeAssignment::create([
                        'school_id' => $schoolId,
                        'enrollment_id' => $enrollmentId,
                        'fee_category_id' => $category->id,
                        'academic_year' => $this->assignAcademicYear,
                        'installment_number' => $installment,
                        'amount' => $this->assignAmount,
                        'due_date' => $this->assignDueDate,
                        'remarks' => $this->assignRemarks,
                        'status' => 'pending',
                        'assigned_by' => auth()->id(),
                    ]);
                }

                return [$toCreate->count(), $existing->count()];
            });
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch('notify', message: 'Bulk assignment failed. No changes were saved.', type: 'error');
            return;
        }

        $this->showAssignModal = false;
        $this->assignToAllInGrade = false;

        if ($created === 0) {
            $this->dispatch('notify', message: "No new assignments created. All {$skipped} students in {$gradeLabel} already have this fee.", type: 'error');
            return;
        }

        $msg = "{$category->name} assigned to {$created} students in {$gradeLabel} successfully.";
        if ($skipped > 0) {
            $msg .= " {$skipped} already had it and were skipped.";
        }
        $this->dispatch('notify', message: $msg, type: 'success');
    }
    /*
    |--------------------------------------------------------------------------
    | Record Payment — student pre-selected, then a short dropdown of only
    | THAT student's own outstanding assignments (not a global fee list).
    |--------------------------------------------------------------------------
    */

    public bool $showPaymentModal = false;
    public $paymentEnrollmentId;
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

    public function openPaymentModal(int $enrollmentId)
    {
        if (! auth()->user()->can('manage fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())
            ->with('student')
            ->findOrFail($enrollmentId);

        $this->paymentEnrollmentId = $enrollment->id;
        $this->paymentStudentName = $enrollment->student->name;
        $this->paymentOutstandingAssignments = FeeAssignment::where('enrollment_id', $enrollment->id)
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
        if (! auth()->user()->can('manage fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $assignment = FeeAssignment::where('school_id', $this->currentSchoolId())
            ->findOrFail($this->paymentAssignmentId);
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
    |
    | Available to Super Admin too, but strictly read-only — the Edit/
    | Delete buttons inside this modal are gated by $canEdit/$canDelete,
    | which are always false for a platform-level view.
    |--------------------------------------------------------------------------
    */

    public bool $showHistoryModal = false;
    public $historyEnrollmentId;
    public $historyStudentName;

    public function openHistoryModal(int $enrollmentId)
    {
        if (! auth()->user()->can('view fee details')) {
            abort(403);
        }

        $enrollment = $this->isPlatformAdmin()
            ? Enrollment::with('student')->findOrFail($enrollmentId)
            : Enrollment::where('school_id', $this->currentSchoolId())->with('student')->findOrFail($enrollmentId);

        $this->historyEnrollmentId = $enrollment->id;
        $this->historyStudentName = $enrollment->student->name;
        $this->showHistoryModal = true;
    }

    public function closeHistoryModal()
    {
        $this->showHistoryModal = false;
    }

    public function getHistoryAssignmentsProperty()
    {
        if (! $this->showHistoryModal || ! $this->historyEnrollmentId) {
            return collect();
        }

        return FeeAssignment::where('enrollment_id', $this->historyEnrollmentId)
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
        if (! auth()->user()->can('edit fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $assignment = FeeAssignment::where('school_id', $this->currentSchoolId())->findOrFail($assignmentId);

        $this->editAssignmentId = $assignment->id;
        $this->editAssignmentLocked = $assignment->isLockedForEditing();
        $this->editFeeCategoryId = $assignment->fee_category_id;
        $this->editAcademicYear = $assignment->academic_year;
        $this->editInstallmentNumber = $assignment->installment_number;
        $this->editAmount = $assignment->amount;
        $this->editDueDate = $assignment->due_date->format('Y-m-d');
        $this->editRemarks = $assignment->remarks;
        $this->showEditAssignmentModal = true;

        $enrollment = Enrollment::where('school_id', $this->currentSchoolId())
            ->with('grade')->findOrFail($assignment->enrollment_id);

        $this->editApplyToGrade = false;
        $this->editGradeLabel = $this->gradeLabel($enrollment);
        $this->editGradeMatchCount = $this->whereInstallment(
            FeeAssignment::where('school_id', $assignment->school_id)
                ->whereIn('enrollment_id', $this->gradeEnrollmentsQuery($enrollment)->pluck('id'))
                ->where('fee_category_id', $assignment->fee_category_id)
                ->where('academic_year', $assignment->academic_year),
            $assignment->installment_number
        )->count();
    }

    public function closeEditAssignmentModal()
    {
        $this->showEditAssignmentModal = false;
        $this->resetErrorBag();
    }

    public function updateAssignment()
    {
        if (! auth()->user()->can('edit fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $assignment = FeeAssignment::where('school_id', $this->currentSchoolId())->findOrFail($this->editAssignmentId);

        // Bulk path: must run BEFORE the single update below touches the record
        if ($this->editApplyToGrade) {
            $this->updateAssignmentForGrade($assignment);
            return;
        }

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

        $this->dispatch('notify', message: 'Success fee assignment updated.', type: 'success');
    }


    protected function updateAssignmentForGrade(FeeAssignment $source): void
    {
        $schoolId = $this->currentSchoolId();
        $sourceEnrollment = Enrollment::where('school_id', $schoolId)->with('grade')->findOrFail($source->enrollment_id);
        $sourceLocked = $source->isLockedForEditing();

        // ORIGINAL identity of the assignment being edited. Targets are matched on this.
        $origCategory = $source->fee_category_id;
        $origYear = $source->academic_year;
        $origInstallment = $source->installment_number;

        if ($sourceLocked) {
            $this->validate([
                'editDueDate' => 'required|date',
                'editRemarks' => 'nullable|string',
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

            if (! FeeCategory::where('school_id', $schoolId)->whereKey($this->editFeeCategoryId)->exists()) {
                $this->addError('editFeeCategoryId', 'Selected fee category does not belong to this school.');
                return;
            }
            if (! AcademicYear::where('school_id', $schoolId)->where('name', $this->editAcademicYear)->exists()) {
                $this->addError('editAcademicYear', 'Selected academic year does not belong to this school.');
                return;
            }
        }

        $newInstallment = $this->editInstallmentNumber ?: null;
        $keyChanged = ! $sourceLocked && (
            (int) $this->editFeeCategoryId !== (int) $origCategory
            || $this->editAcademicYear !== $origYear
            || $newInstallment !== $origInstallment
        );

        try {
            [$updated, $skipped] = DB::transaction(function () use (
                $sourceEnrollment,
                $schoolId,
                $origCategory,
                $origYear,
                $origInstallment,
                $sourceLocked,
                $keyChanged,
                $newInstallment
            ) {
                $enrollmentIds = $this->gradeEnrollmentsQuery($sourceEnrollment)->pluck('id')
                    ->push($sourceEnrollment->id)->unique();

                $targets = $this->whereInstallment(
                    FeeAssignment::where('school_id', $schoolId)
                        ->whereIn('enrollment_id', $enrollmentIds)
                        ->where('fee_category_id', $origCategory)
                        ->where('academic_year', $origYear),
                    $origInstallment
                )->withCount('payments')->lockForUpdate()->get();

                $updated = 0;
                $skipped = 0;

                foreach ($targets as $target) {
                    if ($sourceLocked || $target->payments_count > 0) {
                        // Same audit-trail rule as the single edit: only due date + remarks.
                        $data = ['due_date' => $this->editDueDate, 'remarks' => $this->editRemarks];
                    } else {
                        if ($keyChanged) {
                            $clash = $this->whereInstallment(
                                FeeAssignment::where('school_id', $schoolId)
                                    ->where('enrollment_id', $target->enrollment_id)
                                    ->where('fee_category_id', $this->editFeeCategoryId)
                                    ->where('academic_year', $this->editAcademicYear)
                                    ->where('id', '!=', $target->id),
                                $newInstallment
                            )->exists();

                            if ($clash) {
                                $skipped++;
                                continue;
                            }
                        }

                        $data = [
                            'fee_category_id' => $this->editFeeCategoryId,
                            'academic_year' => $this->editAcademicYear,
                            'installment_number' => $newInstallment,
                            'amount' => $this->editAmount,
                            'due_date' => $this->editDueDate,
                            'remarks' => $this->editRemarks,
                        ];
                    }

                    $target->update($data);
                    $target->recalculateStatus();
                    $updated++;
                }

                return [$updated, $skipped];
            });
        } catch (\Throwable $e) {
            report($e);
            $this->dispatch('notify', message: 'Bulk update failed. No changes were saved.', type: 'error');
            return;
        }

        $this->showEditAssignmentModal = false;
        $this->editApplyToGrade = false;

        $msg = "Fee assignment updated for {$updated} students in {$this->editGradeLabel} successfully.";
        if ($skipped > 0) {
            $msg .= " {$skipped} skipped (already had an assignment with the new details).";
        }
        $this->dispatch('notify', message: $msg, type: 'success');
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
        if (! auth()->user()->can('delete fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $assignment = FeeAssignment::where('school_id', $this->currentSchoolId())->findOrFail($assignmentId);

        if (! $assignment->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete this assignment already has payments recorded against it.', type: 'error');
            return;
        }

        $this->deleteAssignmentId = $assignmentId;
        $this->showDeleteAssignmentModal = true;
    }

    public function deleteAssignment()
    {
        if (! auth()->user()->can('delete fees') || $this->isPlatformAdmin()) {
            abort(403);
        }

        $assignment = FeeAssignment::where('school_id', $this->currentSchoolId())->findOrFail($this->deleteAssignmentId);

        if (! $assignment->canBeDeleted()) {
            $this->dispatch('notify', message: 'Cannot delete payments exist against this assignment.', type: 'error');
            $this->showDeleteAssignmentModal = false;
            return;
        }

        $assignment->delete();

        $this->showDeleteAssignmentModal = false;

        $this->dispatch('notify', message: 'Success Fee assignment deleted.', type: 'success');
    }

    public function closeDeleteAssignmentModal()
    {
        $this->showDeleteAssignmentModal = false;
        $this->deleteAssignmentId = null;
    }



    /*
|--------------------------------------------------------------------------
| Stat Cards — purely additive, reads existing filter state, no new
| properties, no change to the Enrollment/FeeAssignment queries below.
|--------------------------------------------------------------------------
*/
    protected function feeStats(?int $scopeSchoolId): array
    {
        $enrollmentIds = Enrollment::query()
            ->where('status', 'active')
            ->when($scopeSchoolId, fn($q) => $q->where('school_id', $scopeSchoolId))
            ->when($this->academicYearFilter, fn($q) => $q->where('academic_year_id', $this->academicYearFilter))
            ->pluck('id');

        $totalStudents = $enrollmentIds->count();

        $assignmentIds = FeeAssignment::whereIn('enrollment_id', $enrollmentIds)->pluck('id');

        $totalFeesAssigned = FeeAssignment::whereIn('id', $assignmentIds)->sum('amount');
        $totalFeesCollected = FeePayment::whereIn('fee_assignment_id', $assignmentIds)->sum('amount_paid');
        $totalBalance = $totalFeesAssigned - $totalFeesCollected;

        return [
            'totalStudents' => $totalStudents,
            'totalFeesAssigned' => $totalFeesAssigned,
            'totalFeesCollected' => $totalFeesCollected,
            'totalBalance' => $totalBalance,
            'totalPaid' => $totalFeesCollected,
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | Render — one row per Enrollment (never fetched from the Students
    | table directly), scoped to the active category tab. For Super
    | Admin, "no school selected" means every school at once, with the
    | School column shown; picking a school narrows the same way it does
    | for a normal school user.
    |--------------------------------------------------------------------------
    */

    public function render()
    {
        $scopeSchoolId = $this->isPlatformAdmin() ? ($this->schoolFilter ?: null) : $this->currentSchoolId();

        $stats = $this->feeStats($scopeSchoolId);   // NEW — one line, reuses existing $scopeSchoolId

        // Category/Academic Year lists only make sense once a single
        // school is in scope — cross-school category IDs don't line up
        // meaningfully in one dropdown.
        $categories = $scopeSchoolId
            ? FeeCategory::where('school_id', $scopeSchoolId)->active()->orderBy('sort_order')->get()
            : collect();

        $academicYears = $scopeSchoolId
            ? AcademicYear::where('school_id', $scopeSchoolId)->ordered()->get()
            : collect();

        $grades = Grade::orderBy('level')->get();

        $schools = $this->isPlatformAdmin() ? School::orderBy('school_name')->get() : collect();

        $enrollmentsQuery = Enrollment::query()
            ->where('status', 'active')
            ->when($scopeSchoolId, function ($query) use ($scopeSchoolId) {
                $query->where('school_id', $scopeSchoolId);
            })
            ->when($this->search, function ($query) {
                $query->whereHas('student', function ($query) {
                    $query->where('name', 'like', "%{$this->search}%")
                        ->orWhereHas('user', function ($query) {
                            $query->where('registration_id', 'like', "%{$this->search}%");
                        });
                });
            })
            ->when($this->gradeFilter, function ($query) {
                $query->where('grade_id', $this->gradeFilter);
            })
            ->when($this->academicYearFilter, function ($query) {
                $query->where('academic_year_id', $this->academicYearFilter);
            });

        if ($this->categoryFilter !== 'all') {
            $enrollmentsQuery->whereHas('feeAssignments', function ($query) {
                $query->where('fee_category_id', $this->categoryFilter);
            });
        }

        $enrollments = $enrollmentsQuery
            ->with([
                'student.user',
                'grade',
                'academicYear',
                'school',
                'feeAssignments' => function ($query) {
                    if ($this->categoryFilter !== 'all') {
                        $query->where('fee_category_id', $this->categoryFilter);
                    }
                    $query->with('payments');
                },
            ])
            ->orderBy('id')
            ->paginate(10);

        return view('livewire.admin.fees.index', array_merge($stats, [   // wrap existing array with array_merge
            'enrollments' => $enrollments,
            'categories' => $categories,
            'grades' => $grades,
            'academicYears' => $academicYears,
            'schools' => $schools,
            'isPlatformAdmin' => $this->isPlatformAdmin(),
            'canManage' => auth()->user()->can('manage fees') && ! $this->isPlatformAdmin(),
            'canEdit' => auth()->user()->can('edit fees') && ! $this->isPlatformAdmin(),
            'canDelete' => auth()->user()->can('delete fees') && ! $this->isPlatformAdmin(),
            'canView' => auth()->user()->can('view fee details'),
        ]));
    }
}
