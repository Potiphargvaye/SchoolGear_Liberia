<?php

namespace App\Livewire\Admin\Attendance;

use App\Models\AcademicSubject;
use App\Models\Attendance;
use App\Models\Enrollment;
use App\Models\Period;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Grade;


class StudentAttendanceHistory extends Component
{
    use WithPagination;

    public $enrollmentId;
    public $search = '';
    public $statusFilter = '';
    public $periodFilter = '';
    public $subjectFilter = '';
    public $month;

    public $allPeriods = [];
    public $allSubjects = [];

    public function mount()
    {
        $this->enrollmentId = request()->query('enrollment_id');
        $this->month = now()->format('Y-m');
        $this->allPeriods = Period::where('school_id', auth()->user()->school_id)->orderBy('sort_order')->get();
    }

    protected function loadFilterOptions()
    {
        $user = auth()->user();
        $schoolId = $user->school_id;

        $this->allPeriods = Period::where('school_id', $schoolId)->orderBy('sort_order')->get();

        $this->allSubjects = $user->hasRole('Teacher')
            ? $user->teacherSubjects()->orderBy('name')->get()
            : AcademicSubject::where('school_id', $schoolId)->orderBy('name')->get();
    }

    public function selectStudent($enrollmentId)
    {
        $this->enrollmentId = $enrollmentId;
        $this->subjectFilter = '';
        $this->resetPage();
    }

    public function changeMonth($direction)
    {
        $current = Carbon::createFromFormat('Y-m', $this->month);
        $this->month = $direction === 'next' ? $current->addMonth()->format('Y-m') : $current->subMonth()->format('Y-m');
    }

    // These four all drive the same underlying query, so any one of
    // them changing must re-sync Summary + Heatmap + All Records
    // together — resetPage() keeps pagination from landing on a now-
    // invalid page after the filtered result set shrinks.
    public function updatingStatusFilter()
    {
        $this->resetPage();
    }
    public function updatingPeriodFilter()
    {
        $this->resetPage();
    }
    public function updatingSubjectFilter()
    {
        $this->resetPage();
    }

    public function resetFilters()
    {
        $this->reset(['statusFilter', 'periodFilter', 'subjectFilter']);
        $this->resetPage();
    }

    protected function scopedEnrollments()
    {
        $user = auth()->user();
        $query = Enrollment::where('school_id', $user->school_id)->with('student', 'grade');

        if ($user->hasRole('Teacher')) {
            $allowedGradeIds = $user->teacherGrades()->pluck('grades.id')->toArray();
            $query->whereIn('grade_id', $allowedGradeIds);
        }

        return $query;
    }

    /**
     * The one place Period + Subject scoping is applied. Every section
     * of the page (summary stats, heatmap, records table) builds off
     * this same base query, so the three can never drift out of sync
     * with each other.
     */
    protected function baseAttendanceQuery(int $enrollmentId)
    {
        $query = Attendance::where('enrollment_id', $enrollmentId);

        if ($this->periodFilter) {
            $query->where('period_id', $this->periodFilter);
        }

        if ($this->subjectFilter) {
            $query->where('academic_subject_id', $this->subjectFilter);
        }

        return $query;
    }

    public function render()
    {
        if (! $this->enrollmentId) {
            $students = $this->scopedEnrollments()
                ->when($this->search, fn($q) => $q->whereHas('student', fn($s) => $s->where('name', 'like', '%' . $this->search . '%')))
                ->limit(20)
                ->get();

            return view('livewire.admin.attendance.student-attendance-history', [
                'pickerMode' => true,
                'students' => $students,
            ]);
        }

        $enrollment = $this->scopedEnrollments()->find($this->enrollmentId);
        if (! $enrollment) {
            abort(403, 'You do not have access to this student.');
        }


        $user = auth()->user();

        $level = Grade::resolveLevel($enrollment->grade->level);
        $subjectQuery = AcademicSubject::where('school_id', $user->school_id)->where('level', $level);

        if ($user->hasRole('Teacher')) {
            $allowedSubjectIds = $user->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            $subjectQuery->whereIn('id', $allowedSubjectIds);
        }

        $this->allSubjects = $subjectQuery->orderBy('name')->get();

        // Teacher can only ever filter down to a subject they're
        // actually assigned to — same guard used everywhere else.
        if (auth()->user()->hasRole('Teacher') && $this->subjectFilter) {
            $allowedSubjectIds = auth()->user()->teacherSubjects()->pluck('academic_subjects.id')->toArray();
            if (! in_array((int) $this->subjectFilter, $allowedSubjectIds)) {
                abort(403, 'You are not assigned to this subject.');
            }
        }

        $monthStart = Carbon::createFromFormat('Y-m', $this->month)->startOfMonth();
        $monthEnd = $monthStart->copy()->endOfMonth();

        // ── Monthly Attendance Pattern (heatmap) — filtered ──
        $monthRecords = $this->baseAttendanceQuery($enrollment->id)
            ->whereBetween('date', [$monthStart->toDateString(), $monthEnd->toDateString()])
            ->get()
            ->groupBy(fn($r) => $r->date->toDateString());

        $cells = [];
        $cursor = $monthStart->copy();
        while ($cursor <= $monthEnd) {
            $dayRecords = $monthRecords->get($cursor->toDateString());
            $status = null;
            if ($dayRecords && $dayRecords->count()) {
                if ($dayRecords->contains('status', 'absent')) $status = 'absent';
                elseif ($dayRecords->contains('status', 'late')) $status = 'late';
                else $status = 'present';
            }

            $cells[] = [
                'date' => $cursor->day,
                'weekOfMonth' => $cursor->weekOfMonth,
                'isWeekend' => $cursor->isWeekend(),
                'status' => $status,
                'remark' => $dayRecords ? $dayRecords->first(fn($r) => $r->remarks)?->remarks : null,
            ];
            $cursor->addDay();
        }

        $weeks = collect($cells)->groupBy('weekOfMonth');

        // ── Summary stats — same filtered base, full history not just this month ──
        $allRecords = $this->baseAttendanceQuery($enrollment->id)->get();
        $totalDaysRecorded = $allRecords->pluck('date')->unique()->count();
        $daysPresent = $allRecords->where('status', 'present')->pluck('date')->unique()->count();
        $daysAbsent = $allRecords->where('status', 'absent')->pluck('date')->unique()->count();
        $timesLate = $allRecords->where('status', 'late')->count();
        $attendanceRate = $totalDaysRecorded ? round($daysPresent / $totalDaysRecorded * 100) : 0;

        // ── All Records table — same filtered base + status filter ──
        $recordsQuery = $this->baseAttendanceQuery($enrollment->id)
            ->with('subject', 'period', 'markedBy')
            ->orderByDesc('date');

        if ($this->statusFilter) {
            $recordsQuery->where('status', $this->statusFilter);
        }

        return view('livewire.admin.attendance.student-attendance-history', [
            'pickerMode' => false,
            'enrollment' => $enrollment,
            'weeks' => $weeks,
            'monthLabel' => $monthStart->format('F Y'),
            'totalDaysRecorded' => $totalDaysRecorded,
            'daysPresent' => $daysPresent,
            'daysAbsent' => $daysAbsent,
            'timesLate' => $timesLate,
            'attendanceRate' => $attendanceRate,
            'records' => $recordsQuery->paginate(15),
        ]);
    }
}
