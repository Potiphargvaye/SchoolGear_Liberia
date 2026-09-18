<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admission extends Model
{
    protected $fillable = [
        'school_id',
        'admission_number',
        'applicant_name',
        'age',
        'gender',
        'parent_phone',
        'grade_id',
        'academic_year_id',   // NEW
        'student_type',
        'last_school_attended',
        'image',
        'transcript',
        'recommendation_letter',
        'date_of_admission',
        'status',
        'reviewed_by',
        'reviewed_at',
        'rejection_reason',
    ];

    protected $casts = [
        'date_of_admission' => 'date',
        'reviewed_at' => 'datetime',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    public function academicYear(): BelongsTo
    {
        return $this->belongsTo(AcademicYear::class);
    }
    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }

    public function student(): HasOne
    {
        return $this->hasOne(Student::class);
    }

    /*
    |--------------------------------------------------------------------------
    | Business logic — mirrors LIPA's Application::approve()/reject()
    |--------------------------------------------------------------------------
    */


    /**
     * Admit this applicant — creates the login User (with the Student
     * role), the Student profile, and the initial Enrollment. Only
     * applicants who reach this step ever get a login account; rejected/
     * withdrawn applicants never do. Wrapped in a transaction so a
     * failure never leaves an orphaned User without its Student profile.
     */
    public function admit(User $reviewer, int $academicYearId, string $email, string $password): Student
    {
        return \Illuminate\Support\Facades\DB::transaction(function () use ($reviewer, $academicYearId, $email, $password) {

            $this->update([
                'status' => 'admitted',
                'reviewed_by' => $reviewer->id,
                'reviewed_at' => now(),
                'date_of_admission' => now()->toDateString(),
            ]);

            $registrationId = (new \App\Services\RegistrationIdService())->generate();

            $studentUser = User::create([
                'school_id' => $this->school_id,
                'registration_id' => $registrationId,
                'name' => $this->applicant_name,
                'email' => $email,
                'password' => \Illuminate\Support\Facades\Hash::make($password),
                'image' => $this->image,
                'status' => 'active',
                'created_by' => $reviewer->id,
            ]);

            $studentUser->assignRole('Student');

            $student = Student::create([
                'school_id' => $this->school_id,
                'admission_id' => $this->id,
                'user_id' => $studentUser->id,
                'image' => $this->image,
                'name' => $this->applicant_name,
                'age' => $this->age,
                'gender' => $this->gender,
                'parent_phone' => $this->parent_phone,
            ]);

            $student->enrollment()->create([
                'school_id' => $this->school_id,
                'admission_id' => $this->id,
                'grade_id' => $this->grade_id,
                'academic_year_id' => $academicYearId,
                'status' => 'active',
            ]);

            return $student;
        });
    }

    public function reject(User $reviewer, string $reason): void
    {
        $this->update([
            'status' => 'rejected',
            'reviewed_by' => $reviewer->id,
            'reviewed_at' => now(),
            'rejection_reason' => $reason,
        ]);
    }

    public function withdraw(): void
    {
        $this->update(['status' => 'withdrawn']);
    }
}
