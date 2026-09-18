<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\AcademicSubject;
use App\Models\StudentGrade;
use Illuminate\Support\Facades\DB;


class Enrollment extends Model
{
    protected $fillable = [
        'school_id',
        'admission_id',
        'student_id',
        'grade_id',
        'academic_year_id',
        'status_changed_by',
        'status',
        'graduated_at',
        'transferred_at',
        'transferred_reason',
        'dropped_out_at',
        'dropped_out_reason',
        'suspended_at',
        'suspended_reason',
        'expelled_at',
        'expelled_reason',
    ];

    protected $casts = [
        'graduated_at' => 'datetime',
        'transferred_at' => 'datetime',
        'dropped_out_at' => 'datetime',
        'suspended_at' => 'datetime',
        'expelled_at' => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function admission(): BelongsTo
    {
        return $this->belongsTo(Admission::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function statusChangedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'status_changed_by');
    }
    public function promotions(): HasMany
    {
        return $this->hasMany(Promotion::class);
    }

    public function feeAssignments(): HasMany
    {
        return $this->hasMany(FeeAssignment::class);
    }

    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }


    public function promote(int $toGradeId, int $toAcademicYearId, User $promotedBy, ?string $remarks = null): Promotion
    {
        $fromGrade = $this->grade;
        $toGrade = Grade::findOrFail($toGradeId);

        $fromLevel = Grade::resolveLevel($fromGrade->level);
        $toLevel = Grade::resolveLevel($toGrade->level);
        return DB::transaction(function () use ($toGradeId, $toAcademicYearId, $promotedBy, $remarks, $fromLevel, $toLevel) {

            $promotion = $this->promotions()->create([
                'school_id' => $this->school_id,
                'student_id' => $this->student_id,
                'from_grade_id' => $this->grade_id,
                'to_grade_id' => $toGradeId,
                'from_academic_year_id' => $this->academic_year_id,
                'to_academic_year_id' => $toAcademicYearId,
                'promoted_by' => $promotedBy->id,
                'promoted_at' => now(),
                'remarks' => $remarks,
            ]);

            // enrollment_id never changes on promotion, so existing
            // StudentGrade rows stay attached automatically when the level
            // bucket doesn't change (both grades share the same subject
            // rows). Crossing a level bucket means the subject rows
            // themselves are different IDs (academic_subjects is level-
            // scoped), so grades must be explicitly remapped to the
            // equivalent-named subject at the new level, or they'll sit
            // orphaned under the old subject_id and never display again.
            if ($fromLevel !== $toLevel) {
                $studentGrades = StudentGrade::where('enrollment_id', $this->id)->get();

                foreach ($studentGrades as $studentGrade) {
                    $oldSubject = AcademicSubject::find($studentGrade->academic_subject_id);
                    if (! $oldSubject) {
                        continue;
                    }

                    $newSubject = AcademicSubject::where('school_id', $this->school_id)
                        ->where('name', $oldSubject->name)
                        ->where('level', $toLevel)
                        ->first();

                    // No equivalent subject at the new level (e.g. "Phonics"
                    // has no Junior counterpart) — leave this grade behind
                    // intentionally rather than guessing at a mapping.
                    if (! $newSubject) {
                        continue;
                    }

                    // Guard the unique(enrollment_id, academic_subject_id)
                    // constraint — skip if the new subject somehow already
                    // has a grade row for this enrollment.
                    $alreadyExists = StudentGrade::where('enrollment_id', $this->id)
                        ->where('academic_subject_id', $newSubject->id)
                        ->exists();

                    if (! $alreadyExists) {
                        $studentGrade->update(['academic_subject_id' => $newSubject->id]);
                    }
                }
            }

            $this->update([
                'grade_id' => $toGradeId,
                'academic_year_id' => $toAcademicYearId,
            ]);

            return $promotion;
        });
    }


    public function graduate(): void
    {
        $this->update(['status' => 'graduated', 'graduated_at' => now()]);
    }

    public function transfer(string $reason, User $performedBy): void
    {
        $this->update([
            'status' => 'transferred',
            'transferred_at' => now(),
            'transferred_reason' => $reason,
            'status_changed_by' => $performedBy->id,
        ]);
    }

    public function dropOut(string $reason, User $performedBy): void
    {
        $this->update([
            'status' => 'dropped_out',
            'dropped_out_at' => now(),
            'dropped_out_reason' => $reason,
            'status_changed_by' => $performedBy->id,
        ]);
    }

    public function suspend(string $reason, User $performedBy): void
    {
        $this->update([
            'status' => 'suspended',
            'suspended_at' => now(),
            'suspended_reason' => $reason,
            'status_changed_by' => $performedBy->id,
        ]);
    }

    public function expel(string $reason, User $performedBy): void
    {
        $this->update([
            'status' => 'expelled',
            'expelled_at' => now(),
            'expelled_reason' => $reason,
            'status_changed_by' => $performedBy->id,
        ]);
    }

    /**
     * Bring a suspended enrollment back to active.
     */
    public function reactivate(): void
    {
        $this->update([
            'status' => 'active',
            'suspended_at' => null,
            'suspended_reason' => null,
        ]);
    }

    public function getEffectiveReasonAttribute(): ?string
    {
        return match ($this->status) {
            'transferred' => $this->transferred_reason,
            'dropped_out' => $this->dropped_out_reason,
            'suspended' => $this->suspended_reason,
            'expelled' => $this->expelled_reason,
            default => null,
        };
    }

    public function getEffectiveChangedAtAttribute(): ?\Illuminate\Support\Carbon
    {
        return match ($this->status) {
            'transferred' => $this->transferred_at,
            'dropped_out' => $this->dropped_out_at,
            'suspended' => $this->suspended_at,
            'expelled' => $this->expelled_at,
            default => null,
        };
    }
}
