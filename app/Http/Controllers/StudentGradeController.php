<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\AcademicSubject;
use App\Models\StudentGrade;
use App\Models\GradeLock;

class StudentGradeController extends Controller
{
    //


public function create()
{
    //controller methods also check for permissions:
     $this->authorize('enter student grades');

    return view('admin.grades.select-grade');
}


public function load(Request $request) 
{
   
    $gradeLevel = $request->grade_level;
    $academicYear = $request->academic_year;
    
// Locked greade entry by admin 
    $sem1Locked = \App\Models\GradeLock::where([
    'grade_level' => $gradeLevel,
    'academic_year' => $academicYear,
    'semester' => 'sem1'
])->where('is_locked', true)->exists(); 

$sem2Locked = \App\Models\GradeLock::where([
    'grade_level' => $gradeLevel,
    'academic_year' => $academicYear,
    'semester' => 'sem2'
])->where('is_locked', true)->exists();

    // Determine level
   if (in_array($gradeLevel, ['K-3','K-4','K-5','Nursery'])) {
    $level = 'kindergarten';
} elseif (in_array($gradeLevel, ['Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6'])) {
    $level = 'elementary';
} elseif (in_array($gradeLevel, ['Grade 7','Grade 8','Grade 9'])) {
    $level = 'junior';
} else {
    $level = 'senior';
}

    // Get subjects
    $subjects = AcademicSubject::where('level', $level)->get();

    // Get students
    $students = Student::where('class_applying_for', $gradeLevel)->get();

    // NEW: Load existing grades in the UI view
    $grades = StudentGrade::where('grade_level', $gradeLevel)
        ->where('academic_year', $academicYear)
        ->get()
        ->keyBy(function ($grade) {
            return $grade->student_id . '-' . $grade->academic_subject_id;
        });

    return view('admin.grades.grade-entry', compact(
        'students',
        'subjects',
        'grades',
        'gradeLevel',
        'academicYear',
        'sem1Locked',
        'sem2Locked'
    ));
}


public function store(Request $request)
{
    // Helper to clean empty string to null
    $clean = function($value) {
        if ($value === '' || $value === null || $value === 'null') return null;
        return is_numeric($value) ? (int) $value : null;
    };

    // Try JSON first
    $grades = null;
    if ($request->filled('grades_json')) {
        $grades = json_decode($request->grades_json, true);
    }

    // Fallback to raw input
    if (empty($grades)) {
        $rawGrades = $request->input('grades', []);
        // Clean all values from raw input
        foreach ($rawGrades as $studentId => $subjects) {
            foreach ($subjects as $subjectId => $fields) {
                foreach ($fields as $field => $value) {
                    $grades[$studentId][$subjectId][$field] = $clean($value);
                }
            }
        }
    }

    if (empty($grades)) {
        return back()->with('error', 'No grades data received. Please try again.');
    }

    $academicYear = $request->academic_year;
    $gradeLevel   = $request->grade_level;

    $sem1Locked = \App\Models\GradeLock::where([
        'grade_level'  => $gradeLevel,
        'academic_year'=> $academicYear,
        'semester'     => 'sem1',
    ])->where('is_locked', true)->exists();

    $sem2Locked = \App\Models\GradeLock::where([
        'grade_level'  => $gradeLevel,
        'academic_year'=> $academicYear,
        'semester'     => 'sem2',
    ])->where('is_locked', true)->exists();

    foreach ($grades as $studentId => $subjects) {
        foreach ($subjects as $subjectId => $data) {

            // Clean all incoming values
            $data = [
                'period1' => $clean($data['period1'] ?? null),
                'period2' => $clean($data['period2'] ?? null),
                'period3' => $clean($data['period3'] ?? null),
                'exam1'   => $clean($data['exam1']   ?? null),
                'period4' => $clean($data['period4'] ?? null),
                'period5' => $clean($data['period5'] ?? null),
                'period6' => $clean($data['period6'] ?? null),
                'exam2'   => $clean($data['exam2']   ?? null),
            ];

            // Skip if all fields are null
            // If all grade fields are empty, remove the existing grade record
if (
    is_null($data['period1']) &&
    is_null($data['period2']) &&
    is_null($data['period3']) &&
    is_null($data['exam1']) &&
    is_null($data['period4']) &&
    is_null($data['period5']) &&
    is_null($data['period6']) &&
    is_null($data['exam2'])
) {
    StudentGrade::where([
        'student_id'          => $studentId,
        'academic_subject_id' => $subjectId,
        'academic_year'       => $academicYear,
        'grade_level'         => $gradeLevel,
    ])->delete();

    continue;
}

            $existingGrade = \App\Models\StudentGrade::where([
                'student_id'          => $studentId,
                'academic_subject_id' => $subjectId,
                'academic_year'       => $academicYear,
                'grade_level'         => $gradeLevel,
            ])->first();

            // Prevent editing if user lacks permission
            if ($existingGrade && !auth()->user()->can('edit student grades')) {
                $data['period1'] = $existingGrade->period1 ?? $data['period1'];
                $data['period2'] = $existingGrade->period2 ?? $data['period2'];
                $data['period3'] = $existingGrade->period3 ?? $data['period3'];
                $data['exam1']   = $existingGrade->exam1   ?? $data['exam1'];
                $data['period4'] = $existingGrade->period4 ?? $data['period4'];
                $data['period5'] = $existingGrade->period5 ?? $data['period5'];
                $data['period6'] = $existingGrade->period6 ?? $data['period6'];
                $data['exam2']   = $existingGrade->exam2   ?? $data['exam2'];
            }

            // Protect locked semester 1
            if ($sem1Locked) {
                $data['period1'] = $existingGrade->period1 ?? null;
                $data['period2'] = $existingGrade->period2 ?? null;
                $data['period3'] = $existingGrade->period3 ?? null;
                $data['exam1']   = $existingGrade->exam1   ?? null;
            }

            // Protect locked semester 2
            if ($sem2Locked) {
                $data['period4'] = $existingGrade->period4 ?? null;
                $data['period5'] = $existingGrade->period5 ?? null;
                $data['period6'] = $existingGrade->period6 ?? null;
                $data['exam2']   = $existingGrade->exam2   ?? null;
            }

            \App\Models\StudentGrade::updateOrCreate(
                [
                    'student_id'          => $studentId,
                    'academic_subject_id' => $subjectId,
                    'academic_year'       => $academicYear,
                    'grade_level'         => $gradeLevel,
                ],
                [
                    'period1' => $data['period1'],
                    'period2' => $data['period2'],
                    'period3' => $data['period3'],
                    'exam1'   => $data['exam1'],
                    'period4' => $data['period4'],
                    'period5' => $data['period5'],
                    'period6' => $data['period6'],
                    'exam2'   => $data['exam2'],
                ]
            );
        }
    }

    return redirect()->route('grades.load', [
        'grade_level'   => $gradeLevel,
        'academic_year' => $academicYear,
    ])->with('success', 'Grades saved successfully 🎉');
}

public function lockSemester(Request $request)
{
    //controller methods also check for permissions to :
$this->authorize('lock & unlock grade submission');

    $lock = \App\Models\GradeLock::firstOrCreate(
        [
            'grade_level' => $request->grade_level,
            'academic_year' => $request->academic_year,
            'semester' => $request->semester,
        ]
    );

    $lock->is_locked = $request->action === 'lock';
    $lock->save();

    return back()->with('success', 'Semester lock status updated.');
}
}







