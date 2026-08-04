<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Student extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'image',
        'name',
        'age',
        'gender',
        'parent_phone',
        'transcript',
        'recommendation_letter',
        'class_applying_for',
        'date_of_admission',
        'status', // ✅ added
        'status',
        'shift',
        'intake',
        'grade_id',
        'subjects',
        'last_school_attended',
        'student_type'

    ];

    protected $casts = [
        'date_of_admission' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'subjects' => 'array',
        'grade_id' => 'integer',
    ];

    public function grade()
    {
        return $this->belongsTo(Grade::class, 'grade_id');
    }

    public function assignSubjects(array $subjects)
    {
        $this->update(['subjects' => $subjects]);
    }


    protected static function boot()
    {
        parent::boot();

        static::creating(function ($student) {
            $latestStudent = static::latest('id')->first();
            $nextId = $latestStudent ? $latestStudent->id + 1 : 1;
            $student->student_id = 'EDMOL' . str_pad($nextId, 4, '0', STR_PAD_LEFT) . '/' . date('Y');

            // ✅ ensure default status
            $student->status = $student->status ?? 'candidate';
        });
    }


    /**
     * Every Fee Assignment (and, through it, every Payment) belonging to
     * this student. Linked via the business-facing `student_id` string
     * (e.g. EDMOL0001/2026), matching how fee_assignments' foreign key
     * already references students.student_id rather than the numeric id.
     */
    public function feeAssignments()
    {
        return $this->hasMany(FeeAssignment::class, 'student_id', 'student_id');
    }
}
