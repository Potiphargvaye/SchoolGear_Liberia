<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\GradePublication;
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
        $publishedSlots = collect();
        if ($enrollment) {
            $publishedSlots = GradePublication::publishedForEnrollment($enrollment);
            $publishedSlotKeys = $publishedSlots->pluck('slot')->all();

            if ($publishedSlotKeys !== []) {
                $grades = StudentGrade::query()
                    ->where('school_id', $enrollment->school_id)
                    ->where('enrollment_id', $enrollment->id)
                    ->whereHas('subject', fn ($query) => $query->where('school_id', $enrollment->school_id))
                    ->where(function ($query) use ($publishedSlotKeys) {
                        foreach ($publishedSlotKeys as $slot) {
                            $query->orWhereNotNull(GradePublication::SLOT_COLUMNS[$slot]);
                        }
                    })
                    ->with(['subject' => fn ($query) => $query
                        ->where('school_id', $enrollment->school_id)
                        ->select('id', 'name')])
                    ->orderBy('academic_subject_id')
                    ->get();

                $isIncomplete = function ($v) {
                    return $v !== null && $v !== '' && is_numeric($v) && (float) $v == 0;
                };

                $grades->transform(function ($grade) use ($publishedSlotKeys, $isIncomplete) {
                    foreach (GradePublication::SLOT_COLUMNS as $slot => $column) {
                        if (! in_array($slot, $publishedSlotKeys, true)) {
                            $grade->{$column} = null;
                        }
                    }

                    $semester1Published = collect(['p1', 'p2', 'p3', 'exam1'])
                        ->every(fn ($slot) => in_array($slot, $publishedSlotKeys, true));
                    $semester2Published = collect(['p4', 'p5', 'p6', 'exam2'])
                        ->every(fn ($slot) => in_array($slot, $publishedSlotKeys, true));

                    $sem1Incomplete = $semester1Published && (
                        $isIncomplete($grade->period1) ||
                        $isIncomplete($grade->period2) ||
                        $isIncomplete($grade->period3) ||
                        $isIncomplete($grade->exam1)
                    );
                    $sem2Incomplete = $semester2Published && (
                        $isIncomplete($grade->period4) ||
                        $isIncomplete($grade->period5) ||
                        $isIncomplete($grade->period6) ||
                        $isIncomplete($grade->exam2)
                    );

                    if ($semester1Published) {
                        if ($sem1Incomplete) {
                            $grade->firstSemAvg = 'I';
                        } else {
                            $periodAvg1 = (
                                ($grade->period1 ?? 0) +
                                ($grade->period2 ?? 0) +
                                ($grade->period3 ?? 0)
                            ) / 3;

                            $grade->firstSemAvg = round(($periodAvg1 + ($grade->exam1 ?? 0)) / 2);
                        }
                    } else {
                        $grade->firstSemAvg = null;
                    }

                    if ($semester2Published) {
                        if ($sem2Incomplete) {
                            $grade->secondSemAvg = 'I';
                        } else {
                            $periodAvg2 = (
                                ($grade->period4 ?? 0) +
                                ($grade->period5 ?? 0) +
                                ($grade->period6 ?? 0)
                            ) / 3;

                            $grade->secondSemAvg = round(($periodAvg2 + ($grade->exam2 ?? 0)) / 2);
                        }
                    } else {
                        $grade->secondSemAvg = null;
                    }

                    $grade->yearlyAvg = $semester1Published && $semester2Published
                        ? ($sem1Incomplete || $sem2Incomplete ? 'I' : round(($grade->firstSemAvg + $grade->secondSemAvg) / 2, 2))
                        : null;

                    return $grade;
                });
            }
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
