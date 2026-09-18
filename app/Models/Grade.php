<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $fillable = [
        'level',
        'section',
    ];

    /**
     * Teachers assigned to this grade.
     *
     * Teacher ↔ Grade is a separate many-to-many relationship.
     */
    public function teachers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'grade_teacher', 'grade_id', 'user_id')
            ->withTimestamps();
    }

    /**
     * Students belonging to this grade.
     */
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'grade_id')
            ->where('status', 'registered');
    }


    /**
     * Full grade name.
     *
     * Example: Grade 10A
     */
    public function getFullNameAttribute(): string
    {
        return 'Grade ' . $this->level . ($this->section ?: '');
    }

    /**
     * Resolves a raw grade level string (e.g. "Grade 6", "K-4") to its
     * broader subject-scoping bucket (kindergarten/elementary/junior/senior).
     * This is the single source of truth for that mapping — both
     * StudentGradeController::load() and Enrollment::promote() call this
     * rather than each keeping their own copy of the same if/elseif chain.
     */
    public static function resolveLevel(string $gradeLevel): string
    {
        if (in_array($gradeLevel, ['K-3', 'K-4', 'K-5', 'Nursery'])) {
            return 'kindergarten';
        }

        if (in_array($gradeLevel, ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'])) {
            return 'elementary';
        }

        if (in_array($gradeLevel, ['Grade 7', 'Grade 8', 'Grade 9'])) {
            return 'junior';
        }

        return 'senior';
    }
}
