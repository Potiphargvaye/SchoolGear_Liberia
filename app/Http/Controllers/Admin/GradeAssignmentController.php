<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Grade;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Subject;
use App\Models\Student;

class GradeAssignmentController extends Controller
{
public function index()
{
    $grades = Grade::with(['teachers' => function($query) {
        $query->select('users.id', 'name', 'registration_id')
              ->withPivot('id', 'subjects');
    }, 'students'])->get();
    
    $allTeachers = User::where('role', 'teacher')->get();
   $unassignedStudents = Student::where('status', 'registered')
                             ->whereNull('grade_id')
                             ->get();

    
    $allSubjects = \App\Models\Subject::orderBy('name')->get();
    
    // Preload subjects for display
    $subjectsMap = \App\Models\Subject::pluck('name', 'id')->toArray();
    
    // Process teachers to convert subject IDs to names
    foreach ($grades as $grade) {
        foreach ($grade->teachers as $teacher) {
            $subjectIds = json_decode($teacher->pivot->subjects, true) ?? [];
            $teacher->subjectNames = array_map(function($id) use ($subjectsMap) {
                return $subjectsMap[$id] ?? null;
            }, $subjectIds);
            $teacher->subjectNames = array_filter($teacher->subjectNames); 
        }
    }
    
    return view('admin.grade-assignments.index', compact(
        'grades',
        'allTeachers',
        'unassignedStudents',
        'allSubjects'
    ));
}

    public function assignTeacher(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'grade_id' => 'required|exists:grades,id',
            'subjects' => 'required|array|min:1'
        ]);
        
        $teacher = User::findOrFail($validated['teacher_id']);
        $grade = Grade::findOrFail($validated['grade_id']);
        
        $grade->teachers()->attach($teacher->id, [
            'subjects' => json_encode($validated['subjects'])
        ]);
        
        return back()->with('success', 'Teacher assigned successfully');
    }

    public function unassignTeacher(Request $request, $assignmentId)
{
    DB::table('teacher_grade_subject')
        ->where('id', $assignmentId)
        ->delete();

    // Check if it's an AJAX request
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Teacher assignment removed'
        ]);
    }
    
    return back()->with('success', 'Teacher assignment removed');
}

    public function assignHomeroomTeacher(Request $request)
    {
        $validated = $request->validate([
            'teacher_id' => 'required|exists:users,id',
            'grade_id' => 'required|exists:grades,id',
            'subjects' => 'required|array|min:1'
        ]);

        $teacher = User::findOrFail($validated['teacher_id']);
        
        Grade::findOrFail($validated['grade_id'])->update([
            'teacher_id' => $teacher->registration_id,
            'subjects' => json_encode($validated['subjects'])
        ]);

        return back()->with('success', 'Teacher assigned successfully');
    }

    public function assignStudent(Request $request)
    {
        $validated = $request->validate([
    'student_id' => 'required|exists:students,id',
    'grade_id' => 'required|exists:grades,id',
    'subjects' => 'required|array|min:1'
]);


$student = Student::findOrFail($validated['student_id']);

        $student->update([
            'grade_id' => $validated['grade_id'],
            'subjects' => json_encode($validated['subjects'])
        ]);

        return back()->with('success', 'Student assigned successfully');
    }

public function unassignStudent(Request $request, Student $student)
{
    $student->update([
        'grade_id' => null,
        'subjects' => null
    ]);

    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'message' => 'Student unassigned successfully'
        ]);
    }

    return back()->with('success', 'Student unassigned successfully');
}


    public function updateSubjects(Request $request, Grade $grade)
    {
        $validated = $request->validate([
            'subjects' => 'required|array',
            'subjects.*' => 'string|max:255'
        ]);
        
        $subjects = array_values(array_filter($validated['subjects'], function($subject) {
            return !empty(trim($subject));
        }));
        
        $grade->update(['subjects' => $subjects]);
        
        return back()->with('success', 'Subjects updated successfully');
    }





    // app/Http/Controllers/GradeAssignmentController.php

public function create()
{
    // Replace hardcoded array with database fetch
    $allSubjects = Subject::orderBy('name')->pluck('name', 'id');
    
    return view('grade-assignments.create', compact('allSubjects'));
}

// Add methods for managing subjects
public function getSubjects()
{
    $subjects = Subject::orderBy('name')->get();
    return response()->json($subjects);
}
// for the edit subget model 
public function getSubject($id)
{
    try {
        $subject = Subject::findOrFail($id);
        return response()->json($subject);
    } catch (\Exception $e) {
        return response()->json([
            'error' => 'Subject not found'
        ], 404);
    }
}

public function storeSubject(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255|unique:subjects,name',
        'code' => 'nullable|string|max:50|unique:subjects,code',
        'description' => 'nullable|string'
    ]);

    $subject = Subject::create($request->all());

    return response()->json([
        'success' => true,
        'subject' => $subject,
        'message' => 'Subject added successfully!'
    ]);
}

public function updateSubject(Request $request, $id)
{
    try {
        $subject = Subject::findOrFail($id);
        
        $request->validate([
            'name' => 'required|string|max:255|unique:subjects,name,' . $subject->id,
            'code' => 'nullable|string|max:50|unique:subjects,code,' . $subject->id,
            'description' => 'nullable|string'
        ]);

        $subject->update($request->all());

        return response()->json([
            'success' => true,
            'subject' => $subject,
            'message' => 'Subject updated successfully!'
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error updating subject: ' . $e->getMessage()
        ], 500);
    }
}
    
}








