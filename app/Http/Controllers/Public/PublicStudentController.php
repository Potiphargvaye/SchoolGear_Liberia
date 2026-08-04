<?php


namespace App\Http\Controllers\Public;

use App\Http\Controllers\Controller;
use App\Models\Student;
use Illuminate\Http\Request;



class PublicStudentController extends Controller
{
  
public function create()
{
    return view('public.registeration-form');  
}


public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'age' => 'required|integer|min:5|max:45',
        'gender' => 'required|in:Male,Female,Other',
        'parent_phone' => 'required|string|max:15',
        'class_applying_for' => 'required|string|max:100',
        'date_of_admission' => 'required|date',
        'transcript' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        'recommendation_letter' => 'nullable|file|mimes:pdf,doc,docx|max:5120',
        'student_type' => 'required|in:New,Old',
        'last_school_attended' => 'required|string|max:255',
    ]);

    $data = $request->except([
        '_token',
        'image',
        'transcript',
        'recommendation_letter'
    ]);

   
    if ($request->hasFile('transcript')) {
        $data['transcript'] = $request->file('transcript')
            ->store('students/transcripts', 'public');
    }

    if ($request->hasFile('recommendation_letter')) {
        $data['recommendation_letter'] = $request->file('recommendation_letter')
            ->store('students/recommendations', 'public');
    }
Student::create($data);

if ($request->ajax()) {
    return response()->json([
        'status' => 'success',
        'message' => 'Registration completed'
    ]);
}

return redirect()->back()->with(
    'success',
    'Your application has been submitted successfully.'
);
}
/**
     * 🛡️ Secure dynamic report card verification engine
     */
    public function verifyReportCard($id)
    {
        // 🔥 Target the exact varchar student_id column (e.g. EDMOL0012/2026)
        $student = Student::where('student_id', $id)->firstOrFail();

        // Render the ultra-clean validation sheet layout
        return view('public.verify-card', compact('student'));
    }
}











