<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\StudentGrade;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class StudentPortalGradeController extends Controller
{
    /**
     * Display authenticated student's grades.
     */
    public function index(Request $request)
    {
        $user = Auth::user()->loadMissing(['school', 'student']);
        $student = $user->school_id
            && $user->student
            && (int) $user->student->school_id === (int) $user->school_id
            ? $user->student
            : null;

        abort_unless($student, 404, 'Student profile not found.');

        $period = $request->query('period', 'yearly');
        $validPeriods = [
            'p1', 'p2', 'p3', 'p4', 'p5', 'p6',
            'semester1', 'semester2', 'yearly',
        ];

        if (! in_array($period, $validPeriods, true)) {
            $period = 'yearly';
        }

        $enrollment = Enrollment::query()
            ->with(['grade', 'academicYear'])
            ->where('school_id', $user->school_id)
            ->where('student_id', $student->id)
            ->where('status', 'active')
            ->latest('updated_at')
            ->first();

        $grades = collect();
        if ($enrollment) {
            $grades = StudentGrade::query()
                ->where('school_id', $user->school_id)
                ->where('enrollment_id', $enrollment->id)
                ->whereHas('subject', fn ($query) => $query->where('school_id', $user->school_id))
                ->with(['subject' => fn ($query) => $query
                    ->where('school_id', $user->school_id)
                    ->select('id', 'name')])
                ->orderBy('academic_subject_id')
                ->get();

            $grades->transform(function ($grade) {
                $periodAvg1 = (
                    ($grade->period1 ?? 0) +
                    ($grade->period2 ?? 0) +
                    ($grade->period3 ?? 0)
                ) / 3;

                $grade->firstSemAvg = round(($periodAvg1 + ($grade->exam1 ?? 0)) / 2);

                $periodAvg2 = (
                    ($grade->period4 ?? 0) +
                    ($grade->period5 ?? 0) +
                    ($grade->period6 ?? 0)
                ) / 3;

                $grade->secondSemAvg = round(($periodAvg2 + ($grade->exam2 ?? 0)) / 2);
                $grade->yearlyAvg = round(($grade->firstSemAvg + $grade->secondSemAvg) / 2, 2);

                return $grade;
            });
        }

        return view('student.grades', [
            'grades' => $grades,
            'period' => $period,
            'user' => $user,
            'student' => $student,
            'school' => $user->school,
            'enrollment' => $enrollment,
            'academicYear' => $enrollment?->academicYear,
        ]);
    }
}
