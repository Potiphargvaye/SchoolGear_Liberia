<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\AcademicSubject;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\Period;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class StudentAttendanceController extends Controller
{
    public function index(Request $request): View
    {
        $user = Auth::user()->loadMissing(['school', 'student']);
        $student = $user->school_id
            && $user->student
            && (int) $user->student->school_id === (int) $user->school_id
            ? $user->student
            : null;

        abort_unless($student, 404, 'Student profile not found.');

        $enrollment = Enrollment::query()
            ->with(['grade', 'academicYear'])
            ->where('school_id', $user->school_id)
            ->where('student_id', $student->id)
            ->where('status', 'active')
            ->latest('updated_at')
            ->first();

        $monthValue = $request->query('month');
        $month = is_string($monthValue)
            && preg_match('/^\d{4}-(0[1-9]|1[0-2])$/', $monthValue)
            && (int) substr($monthValue, 0, 4) > 0
            ? Carbon::createFromFormat('!Y-m', $monthValue)
            : now()->startOfMonth();
        $monthStart = $month->copy()->startOfMonth();
        $monthEnd = $month->copy()->endOfMonth();
        $statusValue = $request->query('status');
        $statusFilter = in_array($statusValue, ['present', 'absent', 'late'], true) ? $statusValue : '';

        $periods = collect();
        $subjects = collect();
        if ($enrollment) {
            $periods = Period::query()
                ->where('school_id', $user->school_id)
                ->orderBy('sort_order')
                ->orderBy('name')
                ->get(['id', 'name']);

            $subjects = $enrollment->grade
                ? AcademicSubject::query()
                    ->where('school_id', $user->school_id)
                    ->where('level', Grade::resolveLevel($enrollment->grade->level))
                    ->orderBy('name')
                    ->get(['id', 'name'])
                : collect();
        }

        $requestedPeriod = $request->query('period');
        $periodFilter = is_scalar($requestedPeriod) && ctype_digit((string) $requestedPeriod)
            && $periods->contains(fn ($period) => (int) $period->id === (int) $requestedPeriod)
            ? (int) $requestedPeriod
            : null;
        $requestedSubject = $request->query('subject');
        $subjectFilter = is_scalar($requestedSubject) && ctype_digit((string) $requestedSubject)
            && $subjects->contains(fn ($subject) => (int) $subject->id === (int) $requestedSubject)
            ? (int) $requestedSubject
            : null;

        $summary = collect();
        $records = Attendance::query()->where('id', -1)->paginate(20)->withQueryString();
        $monthRecordCount = 0;

        if ($enrollment) {
            $baseAttendanceQuery = Attendance::query()
                ->where('school_id', $user->school_id)
                ->where('enrollment_id', $enrollment->id)
                ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
                ->whereHas('period', fn ($query) => $query->where('school_id', $user->school_id))
                ->whereHas('subject', fn ($query) => $query->where('school_id', $user->school_id));

            $monthRecordCount = (clone $baseAttendanceQuery)->count();
            $attendanceQuery = (clone $baseAttendanceQuery)
                ->when($periodFilter, fn ($query) => $query->where('period_id', $periodFilter))
                ->when($subjectFilter, fn ($query) => $query->where('academic_subject_id', $subjectFilter));

            $summary = (clone $attendanceQuery)
                ->selectRaw('date, status, COUNT(*) as total')
                ->groupBy('date', 'status')
                ->orderBy('date')
                ->get()
                ->groupBy(fn ($row) => Carbon::parse($row->date)->toDateString());

            $records = (clone $attendanceQuery)
                ->when($statusFilter, fn ($query) => $query->where('status', $statusFilter))
                ->select(['id', 'date', 'status', 'remarks', 'period_id', 'academic_subject_id'])
                ->with([
                    'period' => fn ($query) => $query->where('school_id', $user->school_id)->select(['id', 'name']),
                    'subject' => fn ($query) => $query->where('school_id', $user->school_id)->select(['id', 'name']),
                ])
                ->orderByDesc('date')
                ->orderBy('period_id')
                ->paginate(20)
                ->appends([
                    'month' => $monthStart->format('Y-m'),
                    'period' => $periodFilter,
                    'subject' => $subjectFilter,
                    'status' => $statusFilter ?: null,
                ]);
        }

        $days = [];
        $daysPresent = 0;
        $daysAbsent = 0;
        $daysLate = 0;

        for ($date = $monthStart->copy(); $date->lte($monthEnd); $date->addDay()) {
            $dayRecords = $summary->get($date->toDateString(), collect());
            $dayStatus = null;

            if ($dayRecords->isNotEmpty()) {
                if ($dayRecords->contains('status', 'absent')) {
                    $dayStatus = 'absent';
                    $daysAbsent++;
                } elseif ($dayRecords->contains('status', 'late')) {
                    $dayStatus = 'late';
                    $daysLate++;
                } else {
                    $dayStatus = 'present';
                    $daysPresent++;
                }
            }

            $days[] = [
                'date' => $date->copy(),
                'status' => $dayStatus,
                'records' => (int) $dayRecords->sum('total'),
            ];
        }

        $daysRecorded = $daysPresent + $daysAbsent + $daysLate;
        $daysExcused = 0;
        $attendanceRate = $daysRecorded > 0 ? round($daysPresent / $daysRecorded * 100) : 0;
        $rateClass = $attendanceRate < 75 ? 'low' : ($attendanceRate < 90 ? 'medium' : 'high');
        $calendarDays = collect($days);
        $calendarWeeks = collect(array_fill(0, $monthStart->dayOfWeekIso - 1, null))
            ->concat($calendarDays)
            ->chunk(7);
        $previousMonth = $monthStart->copy()->subMonth()->format('Y-m');
        $nextMonth = $monthStart->copy()->addMonth()->format('Y-m');
        $academicYear = $enrollment?->academicYear;
        $activeFilters = [];
        if ($subjectFilter) {
            $activeFilters[] = $subjects->firstWhere('id', $subjectFilter)->name;
        }
        if ($periodFilter) {
            $activeFilters[] = $periods->firstWhere('id', $periodFilter)->name;
        }
        $monthQuery = [
            'period' => $periodFilter,
            'subject' => $subjectFilter,
            'status' => $statusFilter ?: null,
        ];

        return view('student.attendance', compact(
            'user',
            'student',
            'enrollment',
            'academicYear',
            'monthStart',
            'monthEnd',
            'statusFilter',
            'periods',
            'subjects',
            'periodFilter',
            'subjectFilter',
            'activeFilters',
            'records',
            'days',
            'calendarWeeks',
            'daysPresent',
            'daysAbsent',
            'daysLate',
            'daysExcused',
            'daysRecorded',
            'monthRecordCount',
            'attendanceRate',
            'rateClass',
            'previousMonth',
            'nextMonth',
            'monthQuery'
        ));
    }
}
