<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AcademicYear;
use App\Models\Enrollment;
use App\Models\Grade;
use App\Models\GradePublication;
use App\Models\GradePublicationAudit;
use Illuminate\Http\Request;
use Illuminate\View\View;

class GradeController extends Controller
{
    /**
     * Grade → Teacher assignment (and, for Platform Admins, Grade CRUD).
     * All logic lives in App\Livewire\Admin\Grades\GradeManager.
     *
     * Lives in its own view namespace (grade-management) rather than
     * admin/grades, since that folder already holds the Grade Entry
     * module's views (select-grade, grade-entry). 
     */
    public function manage(): View
    {
        return view('admin.grade-management.manage');
    }

    public function auditTrail(): View
    {
        return view('admin.grade-management.audit-trail');
    }

    public function publicationHistory(Request $request): View
    {
        $user = auth()->user();

        abort_unless(
            $user->can('publish student grades') || $user->can('unpublish student grades'),
            403
        );

        $slotLabels = GradePublication::SLOT_LABELS;
        $schoolId = $user->school_id;

        if (! $schoolId) {
            return view('admin.grades.publication-history', [
                'audits' => collect(),
                'academicYears' => collect(),
                'grades' => collect(),
                'slotLabels' => $slotLabels,
                'selectedAcademicYearId' => null,
                'selectedGradeId' => null,
                'selectedSlot' => null,
                'selectedAction' => null,
                'schoolRequired' => true,
            ]);
        }

        $academicYears = AcademicYear::where('school_id', $schoolId)
            ->orderBy('sort_order')
            ->orderByDesc('id')
            ->get();

        $schoolGradeIds = Enrollment::where('school_id', $schoolId)
            ->distinct()
            ->pluck('grade_id');

        $grades = Grade::whereIn('id', $schoolGradeIds)
            ->orderBy('level')
            ->orderBy('section')
            ->get();

        $selectedAcademicYearId = $this->validatedSchoolFilterId(
            $request->query('academic_year_id'),
            fn (int $id) => AcademicYear::where('school_id', $schoolId)->whereKey($id)->exists()
        );

        $selectedGradeId = $this->validatedSchoolFilterId(
            $request->query('grade_id'),
            fn (int $id) => $schoolGradeIds->contains($id)
        );

        $selectedSlot = $request->query('slot');
        if ($selectedSlot !== null && (! is_string($selectedSlot) || ! array_key_exists($selectedSlot, $slotLabels))) {
            abort(404);
        }

        $selectedAction = $request->query('action');
        if ($selectedAction !== null && (! is_string($selectedAction) || ! in_array($selectedAction, ['published', 'unpublished'], true))) {
            abort(404);
        }

        $audits = GradePublicationAudit::query()
            ->where('school_id', $schoolId)
            ->with(['grade', 'academicYear', 'performedBy'])
            ->when($selectedAcademicYearId, fn ($query, $id) => $query->where('academic_year_id', $id))
            ->when($selectedGradeId, fn ($query, $id) => $query->where('grade_id', $id))
            ->when($selectedSlot, fn ($query, $slot) => $query->where('slot', $slot))
            ->when($selectedAction, fn ($query, $action) => $query->where('action', $action))
            ->orderByDesc('performed_at')
            ->orderByDesc('id')
            ->paginate(20)
            ->withQueryString();

        return view('admin.grades.publication-history', compact(
            'audits',
            'academicYears',
            'grades',
            'slotLabels',
            'selectedAcademicYearId',
            'selectedGradeId',
            'selectedSlot',
            'selectedAction',
        ) + ['schoolRequired' => false]);
    }

    private function validatedSchoolFilterId(mixed $value, callable $belongsToSchool): ?int
    {
        if ($value === null || $value === '') {
            return null;
        }

        if (! is_scalar($value) || ! ctype_digit((string) $value)) {
            abort(404);
        }

        $id = (int) $value;
        abort_unless($belongsToSchool($id), 404);

        return $id;
    }
}
