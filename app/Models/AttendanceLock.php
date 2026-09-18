<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttendanceLock extends Model
{
    protected $fillable = [
        'school_id',
        'academic_year_id',
        'grade_id',
        'lock_type',
        'date',
        'week_start_date',
        'week_end_date',
        'semester',
        'is_locked',
        'locked_by',
    ];

    protected $casts = [
        'date' => 'date',
        'week_start_date' => 'date',
        'week_end_date' => 'date',
        'is_locked' => 'boolean',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function lockedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'locked_by');
    }

    /**
     * The single source of truth for "is this date locked". Every
     * screen (Entry, and eventually bulk edits) calls this rather than
     * re-implementing the date/week/semester logic itself — keeps the
     * rule in one place, not hardcoded into a Livewire component.
     */
    public static function isDateLocked(int $schoolId, int $academicYearId, int $gradeId, \Carbon\Carbon $date, ?string $semester = null): bool
    {
        return static::where('school_id', $schoolId)
            ->where('academic_year_id', $academicYearId)
            ->where('is_locked', true)
            ->where(function ($q) use ($gradeId) {
                $q->whereNull('grade_id')->orWhere('grade_id', $gradeId);
            })
            ->where(function ($q) use ($date, $semester) {
                $q->where(function ($q) use ($date) {
                    $q->where('lock_type', 'date')->where('date', $date->toDateString());
                })->orWhere(function ($q) use ($date) {
                    $q->where('lock_type', 'week')
                        ->where('week_start_date', '<=', $date->toDateString())
                        ->where('week_end_date', '>=', $date->toDateString());
                });

                if ($semester) {
                    $q->orWhere(function ($q) use ($semester) {
                        $q->where('lock_type', 'semester')->where('semester', $semester);
                    });
                }
            })
            ->exists();
    }
}
