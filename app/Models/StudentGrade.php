<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentGrade extends Model
{
    //

    protected $fillable = [
    'student_id',
    'academic_subject_id',
    'academic_year',
    'grade_level',
    'period1',
    'period2',  
    'period3',
    'exam1',
    'period4',
    'period5',
    'period6',
    'exam2'
];

public function student()
{
    return $this->belongsTo(Student::class);
}

public function subject()
{
    return $this->belongsTo(AcademicSubject::class, 'academic_subject_id');
}

}
