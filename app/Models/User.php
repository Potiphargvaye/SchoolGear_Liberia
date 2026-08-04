<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\SchoolResetPasswordNotification;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    protected $fillable = [
        'name',
        'email',
        'password',
        'registration_id',
        'role',
        'grade_id',
        'subjects', // Added for subject assignment
        'image',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'subjects' => 'array', // Cast subjects to array
    ];

    public function hasRole($role)
    {
        return $this->role === $role; // Your existing role logic remains
    }

    // Student grade relationship (unchanged)
    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    // Updated: Teacher grades relationship (now using id as foreign key)
    public function teacherGrades()
    {
        return $this->hasMany(Grade::class, 'teacher_id'); // Changed to use id
    }

    // Helper method to assign subjects
    public function assignSubjects(array $subjects) 
    {
        $this->update(['subjects' => $subjects]);
    }

    // Helper method to check if user teaches/takes a subject
    public function hasSubject(string $subject): bool
    {
        return in_array($subject, $this->subjects ?? []);
    }
 
    // Updated: for teacher_grade_subject pivot table (now using id)
    public function taughtGrades()
{
    return $this->belongsToMany(Grade::class, 'teacher_grade_subject', 'teacher_id', 'grade_id')
                ->withPivot(['id', 'subjects']) // Include pivot ID
                ->withTimestamps();
}
    
    // Optional: If you need to access the pivot relationships with subjects
    public function taughtSubjects()
    {
        return $this->hasMany(TeacherGradeSubject::class, 'teacher_id');
    }


    // Reset password notification 
    public function sendPasswordResetNotification($token)
{
    $this->notify(new SchoolResetPasswordNotification($token));
}
}