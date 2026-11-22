<?php


namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\GradePublication;
use App\Models\StudentGrade;
use App\Models\TeacherMaterial;

class StudentDashboardController extends Controller
{
    /**
     * Show the student dashboard
     */
    public function index()
    {
        $user = Auth::user()->loadMissing(['school', 'student']);
        $student = $user->school_id
            && $user->student
            && (int) $user->student->school_id === (int) $user->school_id
            ? $user->student
            : null;
        $enrollment = null;
        $grades = collect();
        $latestGradePublishedAt = null;

        if ($student) {
            $enrollment = Enrollment::query()
                ->with(['grade', 'academicYear'])
                ->where('school_id', $user->school_id)
                ->where('student_id', $student->id)
                ->where('status', 'active')
                ->latest('updated_at')
                ->first();

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
                        ->get(['id', 'academic_subject_id', 'updated_at']);

                    $latestGradePublishedAt = $publishedSlots->max('published_at');
                }
            }
        }

        $latestGrade = $grades->sortByDesc('updated_at')->first();
        $school = $user->school;
        $academicYear = $enrollment?->academicYear;

        return view('student.dashboard', compact(
            'user',
            'student',
            'school',
            'enrollment',
            'academicYear',
            'grades',
            'latestGrade',
            'latestGradePublishedAt'
        ));
    }

    /**
     * Show the student materials page
     */
    public function materials(Request $request)
{
    $user = Auth::user()->load('grade');
    
    $search = $request->input('search');
    $type = $request->input('type');
    
    // Get the student's grade
    $studentGrade = $user->grade;
    
    $materialsQuery = TeacherMaterial::with('grade')
        ->where('is_published', true);

    // Apply grade filter if student has a grade
    if ($studentGrade) {
        $materialsQuery->where('grade_id', $studentGrade->id);
    }

    // Apply search filter
    if ($search) {
        $materialsQuery->where(function($query) use ($search) {
            $query->where('title', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
        });
    }

    // Apply type filter
    if ($type) {
        $materialsQuery->where('type', $type);
    }

    $materials = $materialsQuery->orderBy('created_at', 'desc')
        ->paginate(9);

    if ($request->ajax() || $request->wantsJson()) {
        $materialsArray = [];
        foreach ($materials->items() as $material) {
            $materialsArray[] = [
                'id' => $material->id,
                'title' => $material->title,
                'description' => $material->description,
                'type' => $material->type,
                'due_date' => $material->due_date ? $material->due_date->format('M d, Y') : null,
                'max_score' => $material->max_score,
                'file_path' => $material->file_path ? asset('storage/' . $material->file_path) : null,
                'created_at' => $material->created_at->diffForHumans(),
                'grade' => [
                    'level' => $material->grade->level,
                    'section' => $material->grade->section
                ]
            ];
        }

        return response()->json([
            'materials' => $materialsArray,
            'total' => $materials->total(),
            'pagination' => $materials->hasPages() ? $materials->links()->toHtml() : ''
        ]);
    }

    return view('student.materials', compact('user', 'materials'));
}
}
