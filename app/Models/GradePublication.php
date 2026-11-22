<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Collection;

class GradePublication extends Model
{
    public const SLOTS = [
        'p1', 'p2', 'p3', 'exam1', 'p4', 'p5', 'p6', 'exam2',
    ];

    public const SLOT_LABELS = [
        'p1' => 'P1',
        'p2' => 'P2',
        'p3' => 'P3',
        'exam1' => '1st Exam',
        'p4' => 'P4',
        'p5' => 'P5',
        'p6' => 'P6',
        'exam2' => '2nd Exam',
    ];

    public const SLOT_COLUMNS = [
        'p1' => 'period1',
        'p2' => 'period2',
        'p3' => 'period3',
        'exam1' => 'exam1',
        'p4' => 'period4',
        'p5' => 'period5',
        'p6' => 'period6',
        'exam2' => 'exam2',
    ];

    public static function publishedForEnrollment(Enrollment $enrollment): Collection
    {
        return static::query()
            ->where('school_id', $enrollment->school_id)
            ->where('grade_id', $enrollment->grade_id)
            ->where('academic_year_id', $enrollment->academic_year_id)
            ->whereNotNull('published_at')
            ->whereNull('unpublished_at')
            ->get(['slot', 'published_at']);
    }

    protected $fillable = [
        'school_id',
        'grade_id',
        'academic_year_id',
        'slot',
        'published_at',
        'published_by',
        'unpublished_at',
        'unpublished_by',
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'unpublished_at' => 'datetime',
    ];

    public function publisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'published_by');
    }

    public function unpublisher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'unpublished_by');
    }

    public function isPublished(): bool
    {
        return $this->published_at !== null && $this->unpublished_at === null;
    }
}
