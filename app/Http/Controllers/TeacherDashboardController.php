<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\TeacherGradeSubject;
use App\Models\User;

class TeacherDashboardController extends Controller
{
    public function index()
    {
        $teacher = Auth::user();
        
        // Get classes assigned (distinct grades)
        $classesAssigned = TeacherGradeSubject::where('teacher_id', $teacher->id)
            ->distinct('grade_id')
            ->count('grade_id');
            
        // Get total students using a subquery for better performance
        $totalStudents = User::where('role', 'student')
            ->whereIn('grade_id', function($query) use ($teacher) {
                $query->select('grade_id')
                    ->from('teacher_grade_subject')
                    ->where('teacher_id', $teacher->id);
            })
            ->count();
        
        return view('teacher.dashboard', compact(
            'teacher',
            'classesAssigned',
            'totalStudents'
        ));
    }
}