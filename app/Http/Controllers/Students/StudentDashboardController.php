<?php


namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Announcement;
use App\Models\TeacherMaterial;

class StudentDashboardController extends Controller
{
    /**
     * Show the student dashboard
     */
    public function index()
    {
        $user = Auth::user()->load('grade');
        
        $announcements = Announcement::where(function($query) {
                $query->where('end_date', '>=', now())
                      ->orWhereNull('end_date');
            })
            ->orderBy('created_at', 'desc')
            ->get();
        
        return view('student.dashboard', compact('user', 'announcements'));
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