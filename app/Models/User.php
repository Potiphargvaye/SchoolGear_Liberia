<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Notifications\SchoolResetPasswordNotification;

use App\Models\Student;
use Illuminate\Database\Eloquent\Relations\HasOne;


class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles;

    /**
     * Guard name for Spatie Permission.
     */
    protected $guard_name = 'web';


    /**
     * Mass assignable attributes.
     */
    protected $fillable = [

        // Tenancy
        'school_id',
        // Login Information
        'registration_id',

        'name',

        'email',

        'image',

        // Authentication
        'password',

        // Account Status
        'status',

        // Login Tracking
        'last_login_at',
        'created_by',

    ];


    /**
     * Hidden attributes.
     */
    protected $hidden = [

        'password',

        'remember_token',

    ];


    /**
     * Attribute casting.
     */
    protected $casts = [

        'email_verified_at' => 'datetime',

        'last_login_at' => 'datetime',

        'password' => 'hashed',

    ];


    /**
     * Send password reset notification.
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(
            new SchoolResetPasswordNotification($token)
        );
    }


    /**
     * User who created this account.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Users created by this account.
     */
    public function createdUsers()
    {
        return $this->hasMany(User::class, 'created_by');
    }


    // Add this relationship method inside your existing App\Models\User class.
// Do not replace the file — just add this method alongside your other
// relationships/methods.

    /**
     * The Student profile linked to this account, if this user is a student.
     * Staff/admin users will simply have this return null.
     */
    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /**
     * The School this user belongs to.
     * NULL for platform-level accounts (e.g. Super Admin) that predate
     * multi-tenancy or operate outside any single school.
     */
    public function school(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(School::class);
    }


    public function teacherGrades(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Grade::class, 'grade_teacher')->withTimestamps();;
    }

    public function teacherSubjects(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(AcademicSubject::class, 'subject_teacher')->withTimestamps();;
    }
}
