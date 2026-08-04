<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GradeLock extends Model
{
    //
    protected $fillable = [
    'grade_level',
    'academic_year',
    'semester',
    'is_locked'
];
}
