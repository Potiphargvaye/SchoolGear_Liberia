<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use App\Models\FeeAssignment;

class FeePayment extends Model
{
    protected $fillable = [
        'fee_assignment_id',
        'receipt_number',
        'amount_paid',
        'payment_date',
        'payment_method',
        'reference_number',
        'remarks',
        'recorded_by',
        'updated_by',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */
    public function feeAssignment(): BelongsTo
    {
        return $this->belongsTo(FeeAssignment::class);
    }

    public function recordedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'recorded_by');
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(FeeAssignment::class, 'fee_assignment_id');
    }
    /*
    |--------------------------------------------------------------------------
    | Business logic
    |--------------------------------------------------------------------------
    */

    /**
     * Generate the next unique Receipt Number.
     *
     * Format: RCT/{year}/{5-digit sequence} — e.g. RCT/2026/00001
     *
     * Same single-source-of-truth principle as RegistrationIdService and
     * Application::generateApplicationNumber().
     */
    public static function generateReceiptNumber(): string
    {
        $year = now()->year;

        $lastPayment = static::where('receipt_number', 'like', "RCT/{$year}/%")
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if (
            $lastPayment &&
            preg_match('/(\d+)$/', $lastPayment->receipt_number, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }

        do {
            $receiptNumber = 'RCT/' . $year . '/' . str_pad($nextNumber, 5, '0', STR_PAD_LEFT);
            $nextNumber++;
        } while (
            static::where('receipt_number', $receiptNumber)->exists()
        );

        return $receiptNumber;
    }

    /*
    |--------------------------------------------------------------------------
    | Model events — every payment change keeps its parent Assignment's
    | status in sync automatically, so nothing calling this model has to
    | remember to do it manually.
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (FeePayment $payment) {
            if (! $payment->receipt_number) {
                $payment->receipt_number = static::generateReceiptNumber();
            }
        });

        static::created(function (FeePayment $payment) {
            $payment->feeAssignment?->recalculateStatus();
        });

        static::updated(function (FeePayment $payment) {
            $payment->feeAssignment?->recalculateStatus();
        });

        static::deleted(function (FeePayment $payment) {
            $payment->feeAssignment?->recalculateStatus();
        });
    }
}
