<?php

namespace App\Http\Controllers;

use App\Models\AcademicSubject;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\StudentGrade;
use App\Services\SchoolDocumentBranding;
use Illuminate\Http\Request;
use App\Models\AcademicYear;

class ReportCardController extends Controller
{
    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    /**
     * List enrollments (never Students directly) that have at least one
     * grade recorded, scoped to this school and an optional level filter.
     */
    public function index(Request $request, $level = 'senior')
    {
        $user = auth()->user();
        $schoolId = $this->currentSchoolId();
        $isTeacher = $user->hasRole('Teacher');

        $levelGroups = [
            'kindergarten' => fn($g) => in_array($g, ['K-3', 'K-4', 'K-5', 'Nursery']),
            'elementary'   => fn($g) => in_array($g, ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6']),
            'junior'       => fn($g) => in_array($g, ['Grade 7', 'Grade 8', 'Grade 9']),
            'senior'       => fn($g) => in_array($g, ['Grade 10', 'Grade 11', 'Grade 12']),
        ];

        if (! array_key_exists($level, $levelGroups)) {
            $level = 'senior';
        }

        $gradesQuery = Grade::query();

        // Teachers only ever see grades they've been assigned — same rule
        // already enforced in Grade Entry. Every other role is untouched.
        if ($isTeacher) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $gradesQuery->whereIn('id', $allowedGradeIds);
        }

        $matchingGradeIds = $gradesQuery->get()
            ->filter(fn($g) => $levelGroups[$level]($g->level))
            ->pluck('id');

        $academicYearId = $request->query('academic_year_id');

        $enrollmentIds = StudentGrade::where('school_id', $schoolId)
            ->whereHas('enrollment', function ($q) use ($matchingGradeIds, $academicYearId) {
                $q->whereIn('grade_id', $matchingGradeIds);
                if ($academicYearId) {
                    $q->where('academic_year_id', $academicYearId);
                }
            })
            ->select('enrollment_id')
            ->distinct()
            ->pluck('enrollment_id');

        $enrollments = Enrollment::where('school_id', $schoolId)
            ->whereIn('id', $enrollmentIds)
            ->with(['student.user', 'grade', 'academicYear'])
            ->get();

        // Full academic-year list for the filter dropdown — every role sees
        // every year, same pattern as the Grade Entry academic-year filter.
        $academicYears = AcademicYear::where('school_id', $schoolId)->ordered()->get();

        return view('admin.report-cards.index', compact('enrollments', 'level', 'academicYears', 'academicYearId'));
    }

    /// verify it later on may be remove or keep it

    public function getTableColumnsForPeriod($period)
    {
        $columns = ['subject'];

        if (in_array($period, ['p1', 'semester1', 'yearly'])) $columns[] = 'period1';
        if (in_array($period, ['p2', 'semester1', 'yearly'])) $columns[] = 'period2';
        if (in_array($period, ['p3', 'semester1', 'yearly'])) $columns[] = 'period3';

        if (in_array($period, ['semester1', 'yearly'])) {
            $columns[] = 'exam1';
            $columns[] = 'firstSemAvg';
        }

        if (in_array($period, ['p4', 'semester2', 'yearly'])) $columns[] = 'period4';
        if (in_array($period, ['p5', 'semester2', 'yearly'])) $columns[] = 'period5';
        if (in_array($period, ['p6', 'semester2', 'yearly'])) $columns[] = 'period6';

        if (in_array($period, ['semester2', 'yearly'])) {
            $columns[] = 'exam2';
            $columns[] = 'secondSemAvg';
        }

        if ($period === 'yearly') $columns[] = 'yearAvg';

        return $columns;
    }

    // for printing multiples reports card
    // for printing multiples reports card
    /**
     * Print multiple report cards in one document, one per enrollment.
     */
    public function printMultiple(Request $request)
    {
        $schoolId = $this->currentSchoolId();

        $enrollmentIds = array_filter(explode(',', $request->enrollments ?? ''));
        if (empty($enrollmentIds)) {
            return redirect()->back()->with('error', 'No students selected.');
        }

        $enrollments = Enrollment::where('school_id', $schoolId)
            ->whereIn('id', $enrollmentIds)
            ->with(['student.user', 'grade', 'academicYear'])
            ->get();

        $gradesData = [];
        $overallAverages = [];

        // ✅ NEW: store per-column totals
        $periodAverages = [];

        foreach ($enrollments as $enrollment) {

            $grades = StudentGrade::where('school_id', $schoolId)
                ->where('enrollment_id', $enrollment->id)
                ->with('subject')
                ->get();

            $gradesData[$enrollment->id] = $grades;

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
                $periodAverages['p1'][$enrollment->id] = ($periodAverages['p1'][$enrollment->id] ?? 0) + $g->period1;
                $periodAverages['p2'][$enrollment->id] = ($periodAverages['p2'][$enrollment->id] ?? 0) + $g->period2;
                $periodAverages['p3'][$enrollment->id] = ($periodAverages['p3'][$enrollment->id] ?? 0) + $g->period3;

                $periodAverages['p4'][$enrollment->id] = ($periodAverages['p4'][$enrollment->id] ?? 0) + $g->period4;
                $periodAverages['p5'][$enrollment->id] = ($periodAverages['p5'][$enrollment->id] ?? 0) + $g->period5;
                $periodAverages['p6'][$enrollment->id] = ($periodAverages['p6'][$enrollment->id] ?? 0) + $g->period6;

                $periodAverages['exam1'][$enrollment->id] = ($periodAverages['exam1'][$enrollment->id] ?? 0) + $g->exam1;
                $periodAverages['exam2'][$enrollment->id] = ($periodAverages['exam2'][$enrollment->id] ?? 0) + $g->exam2;

                $periodAverages['semester1'][$enrollment->id] = ($periodAverages['semester1'][$enrollment->id] ?? 0) + $firstSemAvg;
                $periodAverages['semester2'][$enrollment->id] = ($periodAverages['semester2'][$enrollment->id] ?? 0) + $secondSemAvg;
                $periodAverages['yearly'][$enrollment->id] = ($periodAverages['yearly'][$enrollment->id] ?? 0) + $yearAvg;
            }

            // overall yearly average
            if ($subjectCount > 0) {
                $overallAverages[$enrollment->id] = $totalYearAverage / $subjectCount;
            }
        }

        /*
    |-----------------------------------------
    | Convert totals → averages per subject
    |-----------------------------------------
    */
        foreach ($periodAverages as $key => $enrollmentsArr) {
            foreach ($enrollmentsArr as $eid => $total) {
                $count = count($gradesData[$eid]);
                if ($count > 0) {
                    $periodAverages[$key][$eid] = $total / $count;
                }
            }
        }

        /*
    |-----------------------------------------
    | Ranking per column
    |-----------------------------------------
    */
        $rankableColumns = ['p1', 'p2', 'p3', 'exam1', 'semester1', 'p4', 'p5', 'p6', 'exam2', 'semester2', 'yearly'];
        $periodRanks = [];

        foreach ($rankableColumns as $col) {
            if (! isset($periodAverages[$col])) continue;
            $enrollmentsArr = $periodAverages[$col];
            arsort($enrollmentsArr);
            foreach (array_keys($enrollmentsArr) as $index => $eid) {
                $periodRanks[$col][$eid] = $index + 1;
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
        foreach ($sorted as $enrollmentId => $avg) {
            $ranks[$enrollmentId] = $position;
            $position++;
        }

        // Query params
        $periods = explode(',', $request->query('periods', 'yearly'));
        $headers = explode(',', $request->query('headers', '1'));
        $footers = explode(',', $request->query('footers', '1'));

        $branding = SchoolDocumentBranding::for($schoolId);

        return view('admin.report-cards.multi', [
            'enrollments' => $enrollments,
            'gradesData' => $gradesData,
            'overallAverages' => $overallAverages,
            'ranks' => $ranks,
            'totalStudents' => count($enrollments),
            'periods' => $periods,
            'headers' => $headers,
            'footers' => $footers,

            // ✅ NEW (IMPORTANT)
            'periodAverages' => $periodAverages,
            'periodRanks' => $periodRanks,
            'branding' => $branding,
        ]);
    }

    /**
     * Print a single report card for one enrollment.
     */
    public function print($level, $enrollmentId)
    {
        $schoolId = $this->currentSchoolId();
        $period = request('period', 'yearly');

        $enrollment = Enrollment::where('school_id', $schoolId)
            ->with(['student.user', 'grade', 'academicYear'])
            ->findOrFail($enrollmentId);

        $grades = StudentGrade::where('school_id', $schoolId)
            ->where('enrollment_id', $enrollmentId)
            ->with('subject')
            ->orderBy('academic_subject_id')
            ->get();

        ///Handle Checkbox in Controller for the reportcard header and fotter
        $showHeader = request()->has('showHeader');
        $showFooter = request()->has('showFooter');
        $tableOnly = request()->has('tableOnly');

        if ($tableOnly) {
            $showHeader = false;
            $showFooter = false;
        }

        // Every other enrollment in the same school, grade, and academic
        // year — used for ranking, exactly like the previous behavior.
        $classEnrollmentIds = Enrollment::where('school_id', $schoolId)
            ->where('grade_id', $enrollment->grade_id)
            ->where('academic_year_id', $enrollment->academic_year_id)
            ->pluck('id');

        /*
    |--------------------------------------------------------------------------
    | Calculate yearly averages for every student in the class
    |--------------------------------------------------------------------------
    */
        $averages = [];

        // ✅ NEW: Multi-period tracking
        $periodAverages = [
            'p1' => [],
            'p2' => [],
            'p3' => [],
            'p4' => [],
            'p5' => [],
            'p6' => [],
            'exam1' => [],
            'exam2' => [],
            'semester1' => [],
            'semester2' => [],
            'yearly' => [],
        ];

        foreach ($classEnrollmentIds as $classEnrollmentId) {

            $sGrades = StudentGrade::where('school_id', $schoolId)
                ->where('enrollment_id', $classEnrollmentId)
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
                $periodAverages['p1'][$classEnrollmentId] = ($periodAverages['p1'][$classEnrollmentId] ?? 0) + $g->period1;
                $periodAverages['p2'][$classEnrollmentId] = ($periodAverages['p2'][$classEnrollmentId] ?? 0) + $g->period2;
                $periodAverages['p3'][$classEnrollmentId] = ($periodAverages['p3'][$classEnrollmentId] ?? 0) + $g->period3;

                $periodAverages['p4'][$classEnrollmentId] = ($periodAverages['p4'][$classEnrollmentId] ?? 0) + $g->period4;
                $periodAverages['p5'][$classEnrollmentId] = ($periodAverages['p5'][$classEnrollmentId] ?? 0) + $g->period5;
                $periodAverages['p6'][$classEnrollmentId] = ($periodAverages['p6'][$classEnrollmentId] ?? 0) + $g->period6;

                // ✅ NEW: include exam averages
                $periodAverages['exam1'][$classEnrollmentId] = ($periodAverages['exam1'][$classEnrollmentId] ?? 0) + $g->exam1;
                $periodAverages['exam2'][$classEnrollmentId] = ($periodAverages['exam2'][$classEnrollmentId] ?? 0) + $g->exam2;

                $periodAverages['semester1'][$classEnrollmentId] = ($periodAverages['semester1'][$classEnrollmentId] ?? 0) + $firstSemAvg;
                $periodAverages['semester2'][$classEnrollmentId] = ($periodAverages['semester2'][$classEnrollmentId] ?? 0) + $secondSemAvg;
                $periodAverages['yearly'][$classEnrollmentId] = ($periodAverages['yearly'][$classEnrollmentId] ?? 0) + $yearAvg;

                // Keep your switch (unchanged)
                switch ($period) {
                    case 'p1':
                        $score = $g->period1;
                        break;
                    case 'p2':
                        $score = $g->period2;
                        break;
                    case 'p3':
                        $score = $g->period3;
                        break;
                    case 'p4':
                        $score = $g->period4;
                        break;
                    case 'p5':
                        $score = $g->period5;
                        break;
                    case 'p6':
                        $score = $g->period6;
                        break;
                    case 'semester1':
                        $score = $firstSemAvg;
                        break;
                    case 'semester2':
                        $score = $secondSemAvg;
                        break;
                    default:
                        $score = $yearAvg;
                }
            }

            if ($subjectCount > 0) {
                $averages[$classEnrollmentId] = $totalYearAverage / $subjectCount;
            }
        }

        // ✅ FINALIZE averages AFTER loop (FIXED).
        foreach ($periodAverages as $key => $enrollmentsArr) {
            foreach ($enrollmentsArr as $eid => $total) {
                $count = StudentGrade::where('school_id', $schoolId)
                    ->where('enrollment_id', $eid)
                    ->count();
                if ($count > 0) {
                    $periodAverages[$key][$eid] = $total / $count;
                }
            }
        }

        arsort($averages);
        // Cast to int — $enrollmentId is a route-parameter string, while the
        // averages array is keyed by integer enrollment IDs from Eloquent.
        $rank = array_search((int) $enrollmentId, array_keys($averages)) + 1;
        $totalStudents = count($averages);

        // ✅ Rank per column
        $rankableColumns = ['p1', 'p2', 'p3', 'exam1', 'semester1', 'p4', 'p5', 'p6', 'exam2', 'semester2', 'yearly'];
        $periodRanks = [];

        foreach ($rankableColumns as $col) {
            if (! isset($periodAverages[$col])) continue;
            $enrollmentsArr = $periodAverages[$col];
            arsort($enrollmentsArr);
            foreach (array_keys($enrollmentsArr) as $index => $eid) {
                $periodRanks[$col][$eid] = $index + 1;
            }
        }

        // Determine the report level from the enrollment's actual grade
        // ⚠️ FIXED: same kindergarten bug as index() — exact match against
        // the real grade-level strings, not str_contains($gradeLevel, 'K').
        $gradeLevel = $enrollment->grade->level;

        if (in_array($gradeLevel, ['K-3', 'K-4', 'K-5', 'Nursery'])) {
            $resolvedLevel = 'kindergarten';
        } elseif (in_array($gradeLevel, ['Grade 1', 'Grade 2', 'Grade 3', 'Grade 4', 'Grade 5', 'Grade 6'])) {
            $resolvedLevel = 'elementary';
        } elseif (in_array($gradeLevel, ['Grade 7', 'Grade 8', 'Grade 9'])) {
            $resolvedLevel = 'junior';
        } else {
            $resolvedLevel = 'senior';
        }

        $branding = SchoolDocumentBranding::for($schoolId);

        return view("admin.report-cards.$resolvedLevel", [
            'enrollment' => $enrollment,
            'grades' => $grades,
            'rank' => $rank,
            'totalStudents' => $totalStudents,
            'period' => $period,
            'periodAverages' => $periodAverages,
            'periodRanks' => $periodRanks,
            'showHeader' => $showHeader,
            'showFooter' => $showFooter,
            'branding' => $branding,
        ]);
    }

    public function deleteStudentGrades(int $enrollmentId)
    {
        $schoolId = $this->currentSchoolId();

        $enrollment = Enrollment::where('school_id', $schoolId)->findOrFail($enrollmentId);

        StudentGrade::where('school_id', $schoolId)
            ->where('enrollment_id', $enrollment->id)
            ->delete();

        return redirect()->back()->with('success', 'Student grades deleted successfully.');
    }
}
