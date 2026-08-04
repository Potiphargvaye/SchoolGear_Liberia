<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    protected $fillable = [
        'level',
        'section',
        'teacher_id', // Changed from teacher_id to store registeration id in the grade table
        'subjects'
    ];

    protected $casts = [
        'subjects' => 'array'
    ];

    // One-to-many relationship (if you're using this)
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id') // Changed back to teacher_id
                    ->where('role', 'teacher');
    }

    // Many-to-many relationship through teacher_grade_subject pivot table
    public function teachers()
    {
        return $this->belongsToMany(User::class, 'teacher_grade_subject', 'grade_id', 'teacher_id')
                    ->withPivot(['id', 'subjects']) // Include pivot ID
                    ->withTimestamps();
    }

    // Add this helper method to access subjects easily
    public function getSubjectsForGrade($gradeId)
    {
        return $this->taughtGrades()
                    ->where('grade_id', $gradeId)
                    ->first()
                    ?->pivot
                    ?->subjects ?? [];
    }
    
// Updated: point to Student model instead of User
    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'grade_id')
                    ->where('status', 'registered');
    }

    public function TeacherMaterial()
    {
        return $this->hasMany(Material::class);
    }

    // Helper method: Get full grade name (e.g., "Grade 10A")
    public function getFullNameAttribute(): string
    {
        return 'Grade ' . $this->level . ($this->section ?: '');
    }

    // Helper method to assign subjects to grade
    public function assignSubjects(array $subjects)
    {
        $this->update(['subjects' => $subjects]);
    }
    
    // Helper method to add a subject
    public function addSubject(string $subject)
    {
        $subjects = $this->subjects ?? [];
        if (!in_array($subject, $subjects)) {
            $subjects[] = $subject;
            $this->subjects = $subjects;
            $this->save();
        }
    }
    
    // Helper method to remove a subject
    public function removeSubject(string $subject)
    {
        $subjects = $this->subjects ?? [];
        if (($key = array_search($subject, $subjects)) !== false) {
            unset($subjects[$key]);
            $this->subjects = array_values($subjects); // reindex array
            $this->save();
        }
    }
}