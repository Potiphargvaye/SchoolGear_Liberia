<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPortalGradeController extends Controller
{
    /**
     * Display authenticated student's grades
     */
   public function index(Request $request)
{
    $user = Auth::user();

    /*
    |----------------------------------------------------------
    | Match student using registration_id (NO user_id needed)
    |----------------------------------------------------------
    */
    $student = Student::where('student_id', $user->registration_id)->first();

    if (!$student) {
        abort(404, 'Student profile not found for this registration ID.');
    }

    /*
    |----------------------------------------------------------
    | Period validation
    |----------------------------------------------------------
    */
    $period = $request->get('period', 'yearly');

    $validPeriods = [
        'p1','p2','p3',
        'p4','p5','p6',
        'semester1','semester2',
        'yearly'
    ];

    if (!in_array($period, $validPeriods)) {
        $period = 'yearly';
    }

    /*
    |----------------------------------------------------------
    | Fetch grades
    |----------------------------------------------------------
    */
    $grades = StudentGrade::where('student_id', $student->id)
        ->with('subject')
        ->orderBy('academic_subject_id')
        ->get();

    /*
    /*
|--------------------------------------------------------------------------
| Calculate averages
|--------------------------------------------------------------------------
*/
$grades->transform(function ($grade) {

    // FIRST SEMESTER
    $periodAvg1 = (
        ($grade->period1 ?? 0) +
        ($grade->period2 ?? 0) +
        ($grade->period3 ?? 0)
    ) / 3;

    $grade->firstSemAvg = round(
        ($periodAvg1 + ($grade->exam1 ?? 0)) / 2,
        2
    );

    // SECOND SEMESTER
    $periodAvg2 = (
        ($grade->period4 ?? 0) +
        ($grade->period5 ?? 0) +
        ($grade->period6 ?? 0)
    ) / 3;

    $grade->secondSemAvg = round(
        ($periodAvg2 + ($grade->exam2 ?? 0)) / 2,
        2
    );

    // YEARLY AVERAGE
    $grade->yearlyAvg = round(
        ($grade->firstSemAvg + $grade->secondSemAvg) / 2,
        2
    );

    return $grade;
});
    $firstGrade = $grades->first();

    return view('student.grades', [
        'grades' => $grades,
        'period' => $period,
        'gradeLevel' => $firstGrade->grade_level ?? null,
        'academicYear' => $firstGrade->academic_year ?? null,
        'user' => $user,
        'student' => $student,
    ]);
}
}