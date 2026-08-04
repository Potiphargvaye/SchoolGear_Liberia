<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\Grade;
use App\Models\TeacherMaterial; //change
use App\Models\TeacherGradeSubject;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests; // Add this import
use Illuminate\Support\Facades\Storage; // Add this line



class TeacherMaterialController extends Controller
{
    use AuthorizesRequests; 
    public function index(Request $request)
{
    $teacher = Auth::user();
    
    // Get search and filter parameters
    $search = $request->input('search');
    $type = $request->input('type');
    $grade = $request->input('grade');
    $status = $request->input('status');
    
    // Start with base query
    $materialsQuery = TeacherMaterial::where('teacher_id', $teacher->id)
        ->with('grade');

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

    // Apply grade filter
    if ($grade) {
        $materialsQuery->where('grade_id', $grade);
    }

    // Apply status filter
    if ($status) {
        if ($status === 'published') {
            $materialsQuery->where('is_published', true);
        } elseif ($status === 'draft') {
            $materialsQuery->where('is_published', false);
        }
    }

    // Get paginated results
    $materials = $materialsQuery->latest()->paginate(9);

    // Get grades for filter dropdown (keep your existing logic)
    $grades = TeacherGradeSubject::where('teacher_id', $teacher->id)
        ->with('grade')
        ->get()
        ->pluck('grade')
        ->unique();

    // Handle AJAX requests
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
                'is_published' => $material->is_published,
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

    return view('teacher.materials.index', compact('materials', 'grades'));
}

    public function create()
    {
        $teacher = Auth::user();
        $grades = TeacherGradeSubject::where('teacher_id', $teacher->id)
            ->with('grade')
            ->get()
            ->pluck('grade')
            ->unique();

        return view('teacher.materials.create', compact('grades'));
    }

    public function store(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:assignment,note,resource',
        'grade_id' => 'required|exists:grades,id',
        'file' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,png|max:2048',
        'due_date' => 'nullable|date',
        'max_score' => 'nullable|integer|min:0'
    ]);

    $filePath = null;
    if ($request->hasFile('file')) {
        $filePath = $request->file('file')->store('teacher-materials', 'public');
    }

    TeacherMaterial::create([
        'teacher_id' => Auth::id(),
        'title' => $request->title,
        'description' => $request->description,
        'type' => $request->type,
        'grade_id' => $request->grade_id,
        'file_path' => $filePath,
        'due_date' => $request->due_date,
        'max_score' => $request->max_score,
        'is_published' => $request->has('is_published')
    ]);

    // Handle AJAX requests
    if ($request->ajax()) {
        return response()->json([
            'success' => true,
            'message' => 'Material created successfully!'
        ]);
    }

    return redirect()->route('teacher.materials.index')
        ->with('success', 'Material created successfully!');
}

public function edit(TeacherMaterial $material)
{
    // Check if the material belongs to the current teacher
    if (auth()->id() !== $material->teacher_id) {
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized access'
            ], 403);
        }
        abort(403);
    }

    // Debug: Log the request type
    \Log::info('Edit request received', [
        'material_id' => $material->id,
        'is_ajax' => request()->ajax(),
        'wants_json' => request()->wantsJson(),
        'x_requested_with' => request()->header('X-Requested-With'),
        'accept_header' => request()->header('Accept')
    ]);

    // Handle AJAX requests - more comprehensive detection
    $isAjax = request()->ajax() || 
              request()->wantsJson() || 
              request()->header('X-Requested-With') === 'XMLHttpRequest' ||
              str_contains(request()->header('Accept') ?? '', 'application/json');

    if ($isAjax) {
        try {
            return response()->json([
                'success' => true,
                'material' => [
                    'id' => $material->id,
                    'title' => $material->title,
                    'type' => $material->type,
                    'grade_id' => $material->grade_id,
                    'description' => $material->description,
                    'file_path' => $material->file_path,
                    'file_name' => $material->file_path ? basename($material->file_path) : null,
                    'due_date' => $material->due_date ? $material->due_date->format('Y-m-d\TH:i') : null,
                    'max_score' => $material->max_score,
                    'is_published' => (bool)$material->is_published,
                ]
            ]);
        } catch (\Exception $e) {
            \Log::error('Error loading material: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Error loading material data'
            ], 500);
        }
    }

    $grades = Grade::all();
    return view('teacher.materials.edit', compact('material', 'grades'));
}

public function update(Request $request, TeacherMaterial $material)
{
    $this->authorize('update', $material);

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'type' => 'required|in:assignment,note,resource',
        'grade_id' => 'required|exists:grades,id',
        'file' => 'nullable|file|mimes:pdf,doc,docx,txt,jpg,png|max:2048',
        'due_date' => 'nullable|date',
        'max_score' => 'nullable|integer|min:0'
    ]);

    if ($request->hasFile('file')) {
        // Delete old file if exists
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }
        $filePath = $request->file('file')->store('teacher-materials', 'public');
        $material->file_path = $filePath;
    }

    $material->update([
        'title' => $request->title,
        'description' => $request->description,
        'type' => $request->type,
        'grade_id' => $request->grade_id,
        'due_date' => $request->due_date,
        'max_score' => $request->max_score,
        'is_published' => $request->has('is_published')
    ]);

    // Handle AJAX requests
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Material updated successfully!'
        ]);
    }

    return redirect()->route('teacher.materials.index')
        ->with('success', 'Material updated successfully!');
}

public function destroy(TeacherMaterial $material)
{
    $this->authorize('delete', $material);

    try {
        // Delete file if exists
        if ($material->file_path) {
            Storage::disk('public')->delete($material->file_path);
        }

        $material->delete();

        // Handle AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Material deleted successfully!'
            ]);
        }

        return redirect()->route('teacher.materials.index')
            ->with('success', 'Material deleted successfully!');

    } catch (\Exception $e) {
        // Handle AJAX error response
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Error deleting material: ' . $e->getMessage()
            ], 500);
        }

        return back()->with('error', 'Error deleting material: ' . $e->getMessage());
    }
}


public function togglePublish(TeacherMaterial $material)
{
    $this->authorize('update', $material);

    try {
        $material->update([
            'is_published' => !$material->is_published
        ]);

        $action = $material->is_published ? 'published' : 'unpublished';

        // Handle AJAX requests
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => "Material {$action} successfully!"
            ]);
        }

        return redirect()->route('teacher.materials.index')
            ->with('success', "Material {$action} successfully!");

    } catch (\Exception $e) {
        // Handle AJAX error response
        if (request()->ajax() || request()->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => "Error {$action} material: " . $e->getMessage()
            ], 500);
        }

        return back()->with('error', "Error {$action} material: " . $e->getMessage());
    }
}
}