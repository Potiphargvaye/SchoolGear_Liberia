<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class TeacherGradeSubject extends Pivot
{
    protected $table = 'teacher_grade_subject';
    
    protected $casts = [
        'subjects' => 'array',
        'teacher_id' => 'string' // Critical for registration_id
    ];
    
    public $incrementing = true; // If you're using auto-increment IDs
    
    /**
     * Define the relationship with the Grade model
     */
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }
    
    /**
     * Define the relationship with the Teacher (User) model
     */
    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}