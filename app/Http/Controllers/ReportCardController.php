<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\AcademicSubject;
use App\Models\StudentGrade;
use Illuminate\Http\Request;

class ReportCardController extends Controller
{

 public function index($level = 'senior')
    {
        
        // Map level to actual grade levels
        if ($level === 'kindergarten') {
    $gradeLevels = ['K-3','K-4','K-5','Nursery'];
  } elseif ($level === 'elementary') {
    $gradeLevels = ['Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6'];
  } elseif ($level === 'junior') {
    $gradeLevels = ['Grade 7','Grade 8','Grade 9'];
  } else { // default senior
    $gradeLevels = ['Grade 10','Grade 11','Grade 12'];
    $level = 'senior';
  }

        // Get students that have grades in this level
        $students = Student::whereIn( 
            'id',
            StudentGrade::whereIn('grade_level', $gradeLevels)
                ->select('student_id')
                ->distinct()
        )->get();

        return view('admin.report-cards.index', compact('students', 'level'));
    }

    /// verify it later on may be remove or keep it 

  public function getTableColumnsForPeriod($period)
{
    $columns = ['subject'];

    if(in_array($period, ['p1','semester1','yearly'])) $columns[] = 'period1';
    if(in_array($period, ['p2','semester1','yearly'])) $columns[] = 'period2';
    if(in_array($period, ['p3','semester1','yearly'])) $columns[] = 'period3';

    if(in_array($period, ['semester1','yearly'])) {
        $columns[] = 'exam1';
        $columns[] = 'firstSemAvg';
    }

    if(in_array($period, ['p4','semester2','yearly'])) $columns[] = 'period4';
    if(in_array($period, ['p5','semester2','yearly'])) $columns[] = 'period5';
    if(in_array($period, ['p6','semester2','yearly'])) $columns[] = 'period6';

    if(in_array($period, ['semester2','yearly'])) {
        $columns[] = 'exam2';
        $columns[] = 'secondSemAvg';
    }

    if($period === 'yearly') $columns[] = 'yearAvg';

    return $columns;
}




// for printing multiples reports card 
// for printing multiples reports card 
public function printMultiple(Request $request)
{
    $studentIds = explode(',', $request->students ?? '');
    if(empty($studentIds)) {
        return redirect()->back()->with('error', 'No students selected.');
    }

    $students = Student::whereIn('id', $studentIds)->get();

    $gradesData = []; 
    $overallAverages = []; 

    // ✅ NEW: store per-column totals
    $periodAverages = [];

    foreach($students as $student) {

        $grades = \App\Models\StudentGrade::where('student_id', $student->id)->get();
        $gradesData[$student->id] = $grades;

        $totalYearAverage = 0;
        $subjectCount = 0;

        foreach ($grades as $g) {

            // First semester
            $periodAvg1 = ($g->period1 + $g->period2 + $g->period3) / 3;
            $firstSemAvg = round(($periodAvg1 + $g->exam1) / 2);

            // Second semester
            $periodAvg2 = ($g->period4 + $g->period5 + $g->period6) / 3;
            $secondSemAvg = round(($periodAvg2 + $g->exam2) / 2);

            // Year average
            $yearAvg = ($firstSemAvg + $secondSemAvg) / 2;

            $totalYearAverage += $yearAvg;
            $subjectCount++;

            // ✅ SAME AS SINGLE REPORT (IMPORTANT)
            $periodAverages['p1'][$student->id] = ($periodAverages['p1'][$student->id] ?? 0) + $g->period1;
            $periodAverages['p2'][$student->id] = ($periodAverages['p2'][$student->id] ?? 0) + $g->period2;
            $periodAverages['p3'][$student->id] = ($periodAverages['p3'][$student->id] ?? 0) + $g->period3;

            $periodAverages['p4'][$student->id] = ($periodAverages['p4'][$student->id] ?? 0) + $g->period4;
            $periodAverages['p5'][$student->id] = ($periodAverages['p5'][$student->id] ?? 0) + $g->period5;
            $periodAverages['p6'][$student->id] = ($periodAverages['p6'][$student->id] ?? 0) + $g->period6;

            $periodAverages['exam1'][$student->id] = ($periodAverages['exam1'][$student->id] ?? 0) + $g->exam1;
            $periodAverages['exam2'][$student->id] = ($periodAverages['exam2'][$student->id] ?? 0) + $g->exam2;

            $periodAverages['semester1'][$student->id] = ($periodAverages['semester1'][$student->id] ?? 0) + $firstSemAvg;
            $periodAverages['semester2'][$student->id] = ($periodAverages['semester2'][$student->id] ?? 0) + $secondSemAvg;
            $periodAverages['yearly'][$student->id] = ($periodAverages['yearly'][$student->id] ?? 0) + $yearAvg;
        }

        // overall yearly average
        if ($subjectCount > 0) {
            $overallAverages[$student->id] = $totalYearAverage / $subjectCount;
        }
    }

    /*
    |-----------------------------------------
    | Convert totals → averages per subject
    |-----------------------------------------
    */
    foreach ($periodAverages as $key => $studentsArr) {
        foreach ($studentsArr as $sid => $total) {

            $count = count($gradesData[$sid]);

            if ($count > 0) {
                $periodAverages[$key][$sid] = $total / $count;
            }
        }
    }

    /*
    |-----------------------------------------
    | Ranking per column
    |-----------------------------------------
    */
    $rankableColumns = ['p1','p2','p3','exam1','semester1','p4','p5','p6','exam2','semester2','yearly'];

    $periodRanks = [];

    foreach ($rankableColumns as $col) {

        if(!isset($periodAverages[$col])) continue;

        $studentsArr = $periodAverages[$col];

        arsort($studentsArr);

        foreach (array_keys($studentsArr) as $index => $sid) {
            $periodRanks[$col][$sid] = $index + 1;
        }
    }

    /*
    |-----------------------------------------
    | Overall Ranking (your existing logic)
    |-----------------------------------------
    */
    $sorted = $overallAverages;
    arsort($sorted);

    $ranks = [];
    $position = 1;

    foreach($sorted as $studentId => $avg) {
        $ranks[$studentId] = $position;
        $position++;
    }

    // Query params
    $periods = explode(',', $request->query('periods', 'yearly'));
    $headers = explode(',', $request->query('headers', '1'));
    $footers = explode(',', $request->query('footers', '1'));

    return view('admin.report-cards.multi', [
        'students' => $students,
        'gradesData' => $gradesData,
        'overallAverages' => $overallAverages,
        'ranks' => $ranks,
        'totalStudents' => count($students),
        'periods' => $periods,
        'headers' => $headers,
        'footers' => $footers, 

        // ✅ NEW (IMPORTANT)
        'periodAverages' => $periodAverages,
        'periodRanks' => $periodRanks,
    ]);
}

public function printSenior($level, $studentId)
{
    $period = request('period', 'yearly');
    // Find the student from the students table
    $student = Student::findOrFail($studentId);

    // Get all grades for the selected student
    $grades = StudentGrade::where('student_id', $studentId)
        ->with('subject') // load subject relationship
        ->orderBy('academic_subject_id') // keep subjects ordered
        ->get();

    ///Handle Checkbox in Controller for the reportcard header and fotter
    $showHeader = request()->has('showHeader');
    $showFooter = request()->has('showFooter');
    $tableOnly  = request()->has('tableOnly');

    if($tableOnly){
        $showHeader = false;
        $showFooter = false;
    }

    /*
    |--------------------------------------------------------------------------
    | Determine the student's grade level and academic year
    |--------------------------------------------------------------------------
    */
    $gradeLevel = $grades->first()->grade_level ?? null;
    $academicYear = $grades->first()->academic_year ?? null;

    /*
    |--------------------------------------------------------------------------
    | Get all students who have grades in the SAME grade level and academic year
    |--------------------------------------------------------------------------
    */
    $classStudents = StudentGrade::where('grade_level', $gradeLevel)
        ->where('academic_year', $academicYear)
        ->select('student_id')
        ->distinct()
        ->get();

    /*
    |--------------------------------------------------------------------------
    | Calculate yearly averages for every student in the class
    |--------------------------------------------------------------------------
    */ 
    $averages = [];

    // ✅ NEW: Multi-period tracking
    $periodAverages = [
        'p1' => [], 'p2' => [], 'p3' => [],
        'p4' => [], 'p5' => [], 'p6' => [],
        'semester1' => [], 'semester2' => [],
        'yearly' => [],
    ];

    foreach ($classStudents as $cs) {

        $sGrades = StudentGrade::where('student_id', $cs->student_id)
            ->where('grade_level', $gradeLevel)
            ->where('academic_year', $academicYear)
            ->get();

        $totalYearAverage = 0;
        $subjectCount = 0;

        foreach ($sGrades as $g) {

            /*
            |--------------------------------------------------------------------------
            | School's Official Formula
            |--------------------------------------------------------------------------
            */

            // First semester
            $periodAvg1 = ($g->period1 + $g->period2 + $g->period3) / 3;
            $firstSemAvg = round(($periodAvg1 + $g->exam1) / 2);

            // Second semester
            $periodAvg2 = ($g->period4 + $g->period5 + $g->period6) / 3;
            $secondSemAvg = round(($periodAvg2 + $g->exam2) / 2);

            // Year average
            $yearAvg = ($firstSemAvg + $secondSemAvg) / 2;

            $totalYearAverage += $yearAvg;
            $subjectCount++;

            // ✅ accumulate per column
            $periodAverages['p1'][$cs->student_id] = ($periodAverages['p1'][$cs->student_id] ?? 0) + $g->period1;
            $periodAverages['p2'][$cs->student_id] = ($periodAverages['p2'][$cs->student_id] ?? 0) + $g->period2;
            $periodAverages['p3'][$cs->student_id] = ($periodAverages['p3'][$cs->student_id] ?? 0) + $g->period3;

            $periodAverages['p4'][$cs->student_id] = ($periodAverages['p4'][$cs->student_id] ?? 0) + $g->period4;
            $periodAverages['p5'][$cs->student_id] = ($periodAverages['p5'][$cs->student_id] ?? 0) + $g->period5;
            $periodAverages['p6'][$cs->student_id] = ($periodAverages['p6'][$cs->student_id] ?? 0) + $g->period6;

            // ✅ NEW: include exam averages
$periodAverages['exam1'][$cs->student_id] = ($periodAverages['exam1'][$cs->student_id] ?? 0) + $g->exam1;
$periodAverages['exam2'][$cs->student_id] = ($periodAverages['exam2'][$cs->student_id] ?? 0) + $g->exam2;

            $periodAverages['semester1'][$cs->student_id] = ($periodAverages['semester1'][$cs->student_id] ?? 0) + $firstSemAvg;
            $periodAverages['semester2'][$cs->student_id] = ($periodAverages['semester2'][$cs->student_id] ?? 0) + $secondSemAvg;
            $periodAverages['yearly'][$cs->student_id] = ($periodAverages['yearly'][$cs->student_id] ?? 0) + $yearAvg;

            // Keep your switch (unchanged)
            switch ($period) {
                case 'p1': $score = $g->period1; break;
                case 'p2': $score = $g->period2; break;
                case 'p3': $score = $g->period3; break;
                case 'p4': $score = $g->period4; break;
                case 'p5': $score = $g->period5; break;
                case 'p6': $score = $g->period6; break;
                case 'semester1': $score = $firstSemAvg; break;
                case 'semester2': $score = $secondSemAvg; break;
                default: $score = $yearAvg;
            }
        } 

        if ($subjectCount > 0) {
            $averages[$cs->student_id] = $totalYearAverage / $subjectCount;
        }
    }

    // ✅ FINALIZE averages AFTER loop (FIXED).
    foreach ($periodAverages as $key => $students) {
        foreach ($students as $sid => $total) {
            $count = StudentGrade::where('student_id', $sid)
                ->where('grade_level', $gradeLevel)
                ->where('academic_year', $academicYear)
                ->count();

            if ($count > 0) {
                $periodAverages[$key][$sid] = $total / $count;
            }
        }
    }

    

    arsort($averages);
    $rank = array_search($studentId, array_keys($averages)) + 1;
    $totalStudents = count($averages);

    // ✅ Rank per column

    $rankableColumns = ['p1','p2','p3','exam1','semester1','p4','p5','p6','exam2','semester2','yearly'];

$periodRanks = [];
foreach ($rankableColumns as $col) {
    if(!isset($periodAverages[$col])) continue;

    $students = $periodAverages[$col];
    arsort($students);
    foreach (array_keys($students) as $index => $sid) {
        $periodRanks[$col][$sid] = $index + 1;
    }
}

    $gradeLevel = $student->class_applying_for;

    if (in_array($gradeLevel, ['K-3','K-4','K-5','Nursery'])) {
        $level = 'kindergarten';
    } elseif (in_array($gradeLevel, ['Grade 1','Grade 2','Grade 3','Grade 4','Grade 5','Grade 6'])) {
        $level = 'elementary';
    } elseif (in_array($gradeLevel, ['Grade 7','Grade 8','Grade 9'])) {
        $level = 'junior';
    } else {
        $level = 'senior';
    }

    return view("admin.report-cards.$level", [
        'student' => $student,
        'grades' => $grades,
        'rank' => $rank,
        'totalStudents' => $totalStudents,
        'period' => $period,
        'periodAverages' => $periodAverages,
        'periodRanks' => $periodRanks,
        'showHeader' => request()->has('showHeader'),
        'showFooter' => request()->has('showFooter'),
    ]);
}



public function deleteStudentGrades($studentId)
{
    // Delete all grades for the student
    StudentGrade::where('student_id', $studentId)->delete();

    return redirect()->back()->with('success', 'Student grades deleted successfully.');
}
}   