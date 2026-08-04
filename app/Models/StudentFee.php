<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StudentFee extends Model
{
    use HasFactory;

    protected $primaryKey = 'fee_id';
    public $incrementing = true;

    protected $fillable = [
        'student_id',
        'fee_type',
        'installment_number',
        'academic_year',
        'amount',
        'paid_amount',
        'due_date',
        'payment_date',
        'payment_method',
        'reference_number',
        'status'
    ];

    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'date',
        'amount' => 'decimal:2',
        'paid_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }
}


