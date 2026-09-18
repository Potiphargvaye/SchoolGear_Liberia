<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Admission;
use App\Models\Announcement;
use App\Models\Enrollment;
use App\Models\FeeAssignment;
use App\Models\FeePayment;
use App\Models\Grade;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     *
     * Everything shown here is scoped to the authenticated admin's school
     * (users.school_id) and, where a school year is selected, to that
     * academic year. Attendance is not implemented in the system yet, so
     * that card intentionally shows the design's sample data.
     */
    public function index()
    {
        $admin = auth()->user();
        $schoolId = $admin->school_id;
        $school = $admin->school;

        /*
        |----------------------------------------------------------------------
        | Academic Year filter (session-driven, set from the navbar)
        |----------------------------------------------------------------------
        */
        $academicYears = AcademicYear::where('school_id', $schoolId)->ordered()->get();

        $selectedYearId = session('dashboard_academic_year_id');
        if (! $selectedYearId || ! $academicYears->contains('id', $selectedYearId)) {
            $selectedYearId = $academicYears->firstWhere('is_active', true)?->id
                ?? $academicYears->first()?->id;
        }

        $selectedYear = $academicYears->firstWhere('id', $selectedYearId);

        /*
        |----------------------------------------------------------------------
        | Enrollments — the single source of truth for who is a student of
        | this school in the selected academic year (same pattern as the
        | Fees module).
        |----------------------------------------------------------------------
        */
        $activeEnrollments = Enrollment::query()
            ->where('school_id', $schoolId)
            ->when($selectedYearId, fn ($q) => $q->where('academic_year_id', $selectedYearId))
            ->where('status', 'active')
            ->get();

        $totalStudents = $activeEnrollments->count();

        // Gender split (real data) — feeds the "Total Students" KPI card.
        $studentsOfEnrollments = Student::query()
            ->whereIn('id', $activeEnrollments->pluck('student_id')->filter())
            ->get(['id', 'gender']);
        $maleCount = $studentsOfEnrollments->where('gender', 'male')->count();
        $femaleCount = $studentsOfEnrollments->where('gender', 'female')->count();

        /*
        |----------------------------------------------------------------------
        | Students by level (Kindergarten / Elementary / Junior / Senior)
        | using Grade::resolveLevel() — the single mapping used elsewhere.
        |----------------------------------------------------------------------
        */
        $gradeLevels = Grade::whereIn(
            'id',
            $activeEnrollments->pluck('grade_id')->filter()->unique()
        )->pluck('level', 'id');

        // Plain PHP array — mutated directly in the loop below (indirect
        // modification of a Collection element is not allowed and throws
        // "Indirect modification of overloaded element ... has no effect").
        // Wrapped in collect() again for the view.
        $studentsByLevel = [
            'kindergarten' => ['label' => 'Kindergarten', 'color' => '#5B3DE0', 'count' => 0],
            'elementary' => ['label' => 'Elementary', 'color' => '#38BDF8', 'count' => 0],
            'junior' => ['label' => 'Junior', 'color' => '#A78BFF', 'count' => 0],
            'senior' => ['label' => 'Senior', 'color' => '#2E7D5B', 'count' => 0],
        ];

        foreach ($activeEnrollments as $enrollment) {
            $level = $gradeLevels[$enrollment->grade_id] ?? null;
            if ($level) {
                $bucket = Grade::resolveLevel($level);
                if (isset($studentsByLevel[$bucket])) {
                    $studentsByLevel[$bucket]['count']++;
                }
            }
        }

        $studentsByLevel = collect($studentsByLevel);

        /*
        |----------------------------------------------------------------------
        | Fees — assigned vs collected, status split, monthly chart and
        | recent payments. Fees always travel through the student's
        | Enrollment, exactly like App\Livewire\Admin\Fees\Index::feeStats().
        |----------------------------------------------------------------------
        */
        $assignmentIds = FeeAssignment::query()
            ->where('school_id', $schoolId)
            ->whereIntegerInRaw('enrollment_id', $activeEnrollments->pluck('id'))
            ->pluck('id');

        $feesAssigned = (float) FeeAssignment::whereIn('id', $assignmentIds)->sum('amount');
        $feesCollected = (float) FeePayment::whereIn('fee_assignment_id', $assignmentIds)->sum('amount_paid');
        $feesOutstanding = max($feesAssigned - $feesCollected, 0);
        $collectPct = $feesAssigned > 0 ? (int) round(($feesCollected / $feesAssigned) * 100) : 0;

        $feeStatusCounts = FeeAssignment::query()
            ->whereIn('id', $assignmentIds)
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $feeStatusDonut = [
            ['name' => 'Paid', 'value' => (int) ($feeStatusCounts['paid'] ?? 0), 'color' => '#2E7D5B'],
            ['name' => 'Partial', 'value' => (int) ($feeStatusCounts['partial'] ?? 0), 'color' => '#38BDF8'],
            ['name' => 'Pending', 'value' => (int) ($feeStatusCounts['pending'] ?? 0), 'color' => '#A78BFF'],
            ['name' => 'Overdue', 'value' => (int) ($feeStatusCounts['overdue'] ?? 0), 'color' => '#F84525'],
        ];
        $feeStatusTotal = max(array_sum(array_column($feeStatusDonut, 'value')), 1);

        // Last 6 months — assigned (per FeeAssignment created month) vs
        // collected (per FeePayment payment_date month), in millions for
        // the chart axis.
        $months = collect(range(5, 0))->map(fn ($i) => now()->subMonths($i));

        $assignedByMonth = FeeAssignment::query()
            ->whereIn('id', $assignmentIds)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as ym, SUM(amount) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $collectedByMonth = FeePayment::query()
            ->whereIn('fee_assignment_id', $assignmentIds)
            ->selectRaw("DATE_FORMAT(payment_date, '%Y-%m') as ym, SUM(amount_paid) as total")
            ->groupBy('ym')
            ->pluck('total', 'ym');

        $feeChart = $months->map(fn ($m) => [
            'month' => $m->format('M'),
            'assigned' => round(((float) ($assignedByMonth[$m->format('Y-m')] ?? 0)) / 1_000_000, 2),
            'collected' => round(((float) ($collectedByMonth[$m->format('Y-m')] ?? 0)) / 1_000_000, 2),
        ])->values();

        $recentPayments = FeePayment::query()
            ->whereIn('fee_assignment_id', $assignmentIds)
            ->with(['feeAssignment.enrollment.student'])
            ->orderByDesc('payment_date')
            ->orderByDesc('id')
            ->limit(5)
            ->get()
            ->map(function (FeePayment $payment) {
                $student = $payment->feeAssignment?->enrollment?->student;
                $initials = collect(explode(' ', trim((string) ($student->name ?? '?'))))
                    ->filter()
                    ->map(fn ($w) => mb_strtoupper(mb_substr($w, 0, 1)))
                    ->take(2)
                    ->implode('');

                return [
                    'initials' => $initials ?: '?',
                    'name' => $student->name ?? 'Unknown student',
                    'receipt' => $payment->receipt_number,
                    'amount' => $payment->amount_paid,
                    'date' => $payment->payment_date?->format('M d') ?? '—',
                    'status' => ucfirst($payment->feeAssignment?->status ?? 'pending'),
                ];
            });

        /*
        |----------------------------------------------------------------------
        | Admissions pipeline (real) — per selected academic year.
        |----------------------------------------------------------------------
        */
        $admissionCounts = Admission::query()
            ->where('school_id', $schoolId)
            ->when($selectedYearId, fn ($q) => $q->where('academic_year_id', $selectedYearId))
            ->select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $admissionPipeline = [
            ['label' => 'Pending', 'count' => (int) ($admissionCounts['pending'] ?? 0), 'color' => '#FFE29A'],
            ['label' => 'Interview', 'count' => (int) ($admissionCounts['interview'] ?? 0), 'color' => '#38BDF8'],
            ['label' => 'Admitted', 'count' => (int) ($admissionCounts['admitted'] ?? 0), 'color' => '#2E7D5B'],
            ['label' => 'Rejected', 'count' => (int) ($admissionCounts['rejected'] ?? 0), 'color' => '#F84525'],
            ['label' => 'Withdrawn', 'count' => (int) ($admissionCounts['withdrawn'] ?? 0), 'color' => '#64748B'],
        ];
        $pipelineMax = max(max(array_column($admissionPipeline, 'count')), 1);

        $pendingAdmissions = (int) ($admissionCounts['pending'] ?? 0);
        $reviewedThisWeek = Admission::query()
            ->where('school_id', $schoolId)
            ->when($selectedYearId, fn ($q) => $q->where('academic_year_id', $selectedYearId))
            ->whereNotNull('reviewed_at')
            ->where('reviewed_at', '>=', now()->startOfWeek())
            ->count();

        /*
        |----------------------------------------------------------------------
        | Announcements (real) — created by staff of the admin's school.
        | Pinned items float to the top like the design.
        |----------------------------------------------------------------------
        */
        $announcements = Announcement::query()
            ->whereHas('user', fn ($q) => $q->where('school_id', $schoolId))
            ->orderByDesc('is_pinned')
            ->orderByDesc('start_date')
            ->limit(3)
            ->get();

        return view('admin.dashboard', compact(
            'school',
            'academicYears',
            'selectedYear',
            'selectedYearId',
            'totalStudents',
            'maleCount',
            'femaleCount',
            'activeEnrollments',
            'studentsByLevel',
            'feesAssigned',
            'feesCollected',
            'feesOutstanding',
            'collectPct',
            'feeStatusDonut',
            'feeStatusTotal',
            'feeChart',
            'recentPayments',
            'admissionPipeline',
            'pipelineMax',
            'pendingAdmissions',
            'reviewedThisWeek',
            'announcements',
        ));
    }

    /**
     * Store the Academic Year filter selection in the session and bounce
     * back so the entire dashboard re-renders against the chosen year.
     */
    public function setAcademicYear(Request $request)
    {
        $validated = $request->validate([
            'academic_year_id' => ['nullable', 'integer'],
        ]);

        $schoolId = auth()->user()->school_id;

        // A year id belonging to another school is never accepted — the
        // session value is dropped instead of stored.
        if (! empty($validated['academic_year_id'])) {
            $exists = AcademicYear::where('school_id', $schoolId)
                ->where('id', $validated['academic_year_id'])
                ->exists();

            session(['dashboard_academic_year_id' => $exists ? (int) $validated['academic_year_id'] : null]);
        } else {
            session(['dashboard_academic_year_id' => null]);
        }

        return back();
    }
}
