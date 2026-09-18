<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentGrade extends Model
{
    protected $fillable = [
        'school_id',
        'enrollment_id',
        'academic_subject_id',
        'period1',
        'period2',
        'period3',
        'exam1',
        'period4',
        'period5',
        'period6',
        'exam2',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    /**
     * Replaces the old direct student() relation — the student is now
     * always reached through the enrollment: $grade->enrollment->student.
     */
    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(AcademicSubject::class, 'academic_subject_id');
    }
}
