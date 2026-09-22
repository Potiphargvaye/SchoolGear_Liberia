<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GradeAudit extends Model
{
    protected $fillable = [
        'school_id',
        'student_grade_id',
        'enrollment_id',
        'academic_subject_id',
        'action',
        'changes',
        'performed_by',
        'performed_at',
    ];

    protected $casts = [
        'changes' => 'array',
        'performed_at' => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function enrollment(): BelongsTo
    {
        return $this->belongsTo(Enrollment::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(AcademicSubject::class, 'academic_subject_id');
    }

    public function performedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'performed_by');
    }

    /**
     * Central place to write an audit row — every grade create/update/
     * delete in StudentGradeController funnels through here, so the
     * trail can never be forgotten in some code path.
     */

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public static function record(
        int $schoolId,
        ?int $studentGradeId,
        int $enrollmentId,
        int $gradeId,
        int $academicSubjectId,
        string $action,
        ?array $changes,
        ?int $performedBy
    ): self {
        return static::create([
            'school_id' => $schoolId,
            'student_grade_id' => $studentGradeId,
            'enrollment_id' => $enrollmentId,
            'grade_id' => $gradeId,
            'academic_subject_id' => $academicSubjectId,
            'action' => $action,
            'changes' => $changes,
            'performed_by' => $performedBy,
            'performed_at' => now(),
        ]);
    }
}
