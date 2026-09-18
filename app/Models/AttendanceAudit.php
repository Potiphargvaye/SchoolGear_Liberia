<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceAudit extends Model
{
    protected $fillable = [
        'school_id',
        'attendance_id',
        'enrollment_id',
        'period_id',
        'academic_subject_id',
        'date',
        'action',
        'changes',
        'performed_by',
        'performed_at',
    ];

    protected $casts = [
        'date' => 'date',
        'changes' => 'array',
        'performed_at' => 'datetime',
    ];

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function period(): BelongsTo
    {
        return $this->belongsTo(Period::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(AcademicSubject::class, 'academic_subject_id');
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    public static function record(
        int $schoolId,
        ?int $attendanceId,
        int $enrollmentId,
        int $periodId,
        int $academicSubjectId,
        string $date,
        string $action,
        ?array $changes,
        ?int $performedBy
    ): self {
        return static::create([
            'school_id' => $schoolId,
            'attendance_id' => $attendanceId,
            'enrollment_id' => $enrollmentId,
            'period_id' => $periodId,
            'academic_subject_id' => $academicSubjectId,
            'date' => $date,
            'action' => $action,
            'changes' => $changes,
            'performed_by' => $performedBy,
            'performed_at' => now(),
        ]);
    }
}
