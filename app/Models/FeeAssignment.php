<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class FeeAssignment extends Model
{
    protected $fillable = [
        'student_id',
        'fee_category_id',
        'academic_year',
        'installment_number',
        'amount',
        'due_date',
        'remarks',
        'status',
        'assigned_by',
        'legacy_student_fee_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function feeCategory(): BelongsTo
    {
        return $this->belongsTo(FeeCategory::class);
    }

    public function assignedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function payments(): HasMany
    {
        return $this->hasMany(FeePayment::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Business logic
    |--------------------------------------------------------------------------
    | Kept here, single source of truth, same principle as
    | Application::approve()/reject() and Enrollment's lifecycle methods.
    */

    public function totalPaid(): string
    {
        return (string) $this->payments()->sum('amount_paid');
    }

    public function balance(): string
    {
        return bcsub((string) $this->amount, $this->totalPaid(), 2);
    }

    /**
     * Recomputed after every payment create/update/delete (see FeePayment's
     * model events) — status is never hand-set by the UI.
     */
    public function recalculateStatus(): void
    {
        $totalPaid = (float) $this->totalPaid();
        $amount = (float) $this->amount;

        if ($totalPaid <= 0) {
            $status = $this->due_date && $this->due_date->isPast() ? 'overdue' : 'pending';
        } elseif ($totalPaid >= $amount) {
            $status = 'paid';
        } else {
            $status = $this->due_date && $this->due_date->isPast() ? 'overdue' : 'partial';
        }

        $this->update(['status' => $status]);
    }

    /**
     * An assignment can only be deleted if no payment has ever been
     * recorded against it — protects the audit trail once money has moved.
     */
    public function canBeDeleted(): bool
    {
        return $this->payments()->doesntExist();
    }

    /**
     * Once a payment exists, the amount/category/academic year become
     * locked to protect the audit trail — only due_date and remarks stay
     * editable after that point (enforced in the Livewire component).
     */
    public function isLockedForEditing(): bool
    {
        return $this->payments()->exists();
    }
}
