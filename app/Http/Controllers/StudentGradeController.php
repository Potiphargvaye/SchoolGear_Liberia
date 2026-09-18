<?php

namespace App\Http\Controllers;

use App\Models\AcademicSubject;
use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\GradeAudit;
use App\Models\GradeLock;
use App\Models\StudentGrade;
use Illuminate\Http\Request;

class StudentGradeController extends Controller
{
    protected function currentSchoolId(): ?int
    {
        return auth()->user()->school_id;
    }

    public function create()
    {
        $this->authorize('enter student grades');

        $user = auth()->user();
        $schoolId = $this->currentSchoolId();

        if ($user->hasRole('Teacher')) {
            $grades = $user->teacherGrades()->orderBy('grades.level')->get();
        } else {
            $grades = Grade::orderBy('level')->get();
        }

        // Only the active academic year is offered on the selection screen,
        // for every role — Platform Admin's null school_id naturally
        // yields an empty collection here too, which is the desired
        // "no context" behavior we're leaving as-is.
        $academicYears = AcademicYear::where('school_id', $schoolId)
            ->where('is_active', true)
            ->ordered()
            ->get();

        return view('admin.grades.select-grade', compact('grades', 'academicYears'));
    }


    public function load(Request $request)
    {
        $this->authorize('enter student grades');

        $user = auth()->user();
        $schoolId = $this->currentSchoolId();
        $isTeacher = $user->hasRole('Teacher');

        $gradeId = $request->grade_id;
        $academicYearId = $request->academic_year_id;

        // Hard backend guard: a Teacher cannot load a grade they weren't
        // assigned, even by editing the URL directly.
        if ($isTeacher) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            if (! in_array((int) $gradeId, $allowedGradeIds)) {
                abort(403, 'You are not assigned to this grade.');
            }
        }

        $grade = Grade::findOrFail($gradeId);
        $academicYear = AcademicYear::where('school_id', $schoolId)->findOrFail($academicYearId);

        $sem1Locked = GradeLock::where([
            'school_id' => $schoolId,
            'grade_id' => $gradeId,
            'academic_year_id' => $academicYearId,
            'semester' => 'sem1',
        ])->where('is_locked', true)->exists();

        $sem2Locked = GradeLock::where([
            'school_id' => $schoolId,
            'grade_id' => $gradeId,
            'academic_year_id' => $academicYearId,
            'semester' => 'sem2',
        ])->where('is_locked', true)->exists();

        // Single source of truth — same mapping Enrollment::promote() uses,
        // so cross-level promotion and this view can never drift apart.
        $level = Grade::resolveLevel($grade->level);

        $subjectsQuery = AcademicSubject::where('school_id', $schoolId)
            ->where('level', $level);

        // Scope subjects to the Teacher's own assignments, on top of the
        // school+level filter that already applies to everyone.
        if ($isTeacher) {
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            $subjectsQuery->whereIn('id', $allowedSubjectIds);
        }

        $subjects = $subjectsQuery->get();

        $enrollments = Enrollment::where('school_id', $schoolId)
            ->where('grade_id', $gradeId)
            ->where('academic_year_id', $academicYearId)
            ->with('student')
            ->get();

        $grades = StudentGrade::where('school_id', $schoolId)
            ->whereIn('enrollment_id', $enrollments->pluck('id'))
            ->get()
            ->keyBy(function ($grade) {
                return $grade->enrollment_id . '-' . $grade->academic_subject_id;
            });

        // Full academic-year list (not just active) so the in-page filter
        // can switch between any year without returning to the selection screen.
        $allAcademicYears = AcademicYear::where('school_id', $schoolId)
            ->ordered()
            ->get();

        // Grade filter dropdown options, scoped the same way create() is.
        $allGrades = $isTeacher
            ? $user->teacherGrades()->orderBy('grades.level')->get()
            : Grade::orderBy('level')->get();

        return view('admin.grades.grade-entry', compact(
            'enrollments',
            'subjects',
            'grades',
            'grade',
            'academicYear',
            'allAcademicYears',
            'allGrades',
            'sem1Locked',
            'sem2Locked'
        ));
    }
    public function store(Request $request)
    {
        $this->authorize('enter student grades');

        $user = auth()->user();
        $schoolId = $this->currentSchoolId();
        $isTeacher = $user->hasRole('Teacher');

        $gradeId = $request->grade_id;
        $academicYearId = $request->academic_year_id;

        $allowedGradeIds = [];
        $allowedSubjectIds = [];

        if ($isTeacher) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();

            if (! in_array((int) $gradeId, $allowedGradeIds)) {
                abort(403, 'You are not assigned to this grade.');
            }
        }

        $clean = function ($value) {
            if ($value === '' || $value === null || $value === 'null') return null;
            return is_numeric($value) ? (int) $value : null;
        };

        $grades = null;
        if ($request->filled('grades_json')) {
            $grades = json_decode($request->grades_json, true);
        }

        if (empty($grades)) {
            $rawGrades = $request->input('grades', []);
            foreach ($rawGrades as $enrollmentId => $subjects) {
                foreach ($subjects as $subjectId => $fields) {
                    foreach ($fields as $field => $value) {
                        $grades[$enrollmentId][$subjectId][$field] = $clean($value);
                    }
                }
            }
        }

        if (empty($grades)) {
            return back()->with('error', 'No grades data received. Please try again.');
        }

        $sem1Locked = GradeLock::where([
            'school_id' => $schoolId,
            'grade_id' => $gradeId,
            'academic_year_id' => $academicYearId,
            'semester' => 'sem1',
        ])->where('is_locked', true)->exists();

        $sem2Locked = GradeLock::where([
            'school_id' => $schoolId,
            'grade_id' => $gradeId,
            'academic_year_id' => $academicYearId,
            'semester' => 'sem2',
        ])->where('is_locked', true)->exists();

        $performedBy = auth()->id();

        foreach ($grades as $enrollmentId => $subjects) {

            $enrollment = Enrollment::where('school_id', $schoolId)->find($enrollmentId);
            if (! $enrollment) {
                continue;
            }

            foreach ($subjects as $subjectId => $data) {

                // Silently skip any subject a Teacher wasn't assigned to,
                // rather than trusting the payload — this is what actually
                // stops a spoofed request from writing grades outside scope.
                if ($isTeacher && ! in_array((int) $subjectId, $allowedSubjectIds)) {
                    continue;
                }

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

                $existingGrade = StudentGrade::where([
                    'enrollment_id'       => $enrollmentId,
                    'academic_subject_id' => $subjectId,
                ])->first();

                if (
                    is_null($data['period1']) && is_null($data['period2']) && is_null($data['period3']) &&
                    is_null($data['exam1']) && is_null($data['period4']) && is_null($data['period5']) &&
                    is_null($data['period6']) && is_null($data['exam2'])
                ) {
                    if ($existingGrade) {
                        GradeAudit::record(
                            $schoolId,
                            $existingGrade->id,
                            (int) $enrollmentId,
                            (int) $subjectId,
                            'deleted',
                            $existingGrade->only(['period1', 'period2', 'period3', 'exam1', 'period4', 'period5', 'period6', 'exam2']),
                            $performedBy
                        );
                        $existingGrade->delete();
                    }
                    continue;
                }

                if ($existingGrade && ! auth()->user()->can('edit student grades')) {
                    $data['period1'] = $existingGrade->period1 ?? $data['period1'];
                    $data['period2'] = $existingGrade->period2 ?? $data['period2'];
                    $data['period3'] = $existingGrade->period3 ?? $data['period3'];
                    $data['exam1']   = $existingGrade->exam1   ?? $data['exam1'];
                    $data['period4'] = $existingGrade->period4 ?? $data['period4'];
                    $data['period5'] = $existingGrade->period5 ?? $data['period5'];
                    $data['period6'] = $existingGrade->period6 ?? $data['period6'];
                    $data['exam2']   = $existingGrade->exam2   ?? $data['exam2'];
                }

                if ($sem1Locked) {
                    $data['period1'] = $existingGrade->period1 ?? null;
                    $data['period2'] = $existingGrade->period2 ?? null;
                    $data['period3'] = $existingGrade->period3 ?? null;
                    $data['exam1']   = $existingGrade->exam1   ?? null;
                }

                if ($sem2Locked) {
                    $data['period4'] = $existingGrade->period4 ?? null;
                    $data['period5'] = $existingGrade->period5 ?? null;
                    $data['period6'] = $existingGrade->period6 ?? null;
                    $data['exam2']   = $existingGrade->exam2   ?? null;
                }

                $before = $existingGrade
                    ? $existingGrade->only(['period1', 'period2', 'period3', 'exam1', 'period4', 'period5', 'period6', 'exam2'])
                    : null;

                $studentGrade = StudentGrade::updateOrCreate(
                    [
                        'enrollment_id'       => $enrollmentId,
                        'academic_subject_id' => $subjectId,
                    ],
                    [
                        'school_id' => $schoolId,
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

                $changes = [];
                foreach ($data as $field => $newValue) {
                    $oldValue = $before[$field] ?? null;
                    if ($oldValue !== $newValue) {
                        $changes[$field] = [$oldValue, $newValue];
                    }
                }

                if (! empty($changes)) {
                    GradeAudit::record(
                        $schoolId,
                        $studentGrade->id,
                        (int) $enrollmentId,
                        (int) $subjectId,
                        $before === null ? 'created' : 'updated',
                        $changes,
                        $performedBy
                    );
                }
            }
        }

        return redirect()->route('grades.load', [
            'grade_id'         => $gradeId,
            'academic_year_id' => $academicYearId,
        ])->with('success', 'Grades saved successfully 🎉');
    }

    public function lockSemester(Request $request)
    {
        // controller methods also check for permissions to :
        $this->authorize('lock & unlock grade submission');

        $schoolId = $this->currentSchoolId();

        $lock = GradeLock::firstOrCreate(
            [
                'school_id'        => $schoolId,
                'grade_id'         => $request->grade_id,
                'academic_year_id' => $request->academic_year_id,
                'semester'         => $request->semester,
            ]
        );

        $lock->is_locked = $request->action === 'lock';
        $lock->save();

        return back()->with('success', 'Semester lock status updated.');
    }
}
