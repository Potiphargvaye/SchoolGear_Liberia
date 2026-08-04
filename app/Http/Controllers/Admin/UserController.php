<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{

    public function index()
{
    $search = request('search');
    
    $users = User::with('grade')
        ->when($search, function($query) use ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                  ->orWhere('email', 'like', '%'.$search.'%')
                  ->orWhere('registration_id', 'like', '%'.$search.'%')
                  ->orWhereHas('grade', function($q) use ($search) {
                      $q->where('name', 'like', '%'.$search.'%');
                  });
            });
        })
        ->latest()
        ->paginate(10)
        ->appends(['search' => $search]); // Preserve search in pagination links

    // Calculate user statistics
    $totalUsers = User::count();
    $totalTeachers = User::where('role', 'teacher')->count();
    $totalStudents = User::where('role', 'student')->count();
    $totalAdmins = User::where('role', 'admin')->count();

    return view('admin.users.index', compact(
        'users',
        'totalUsers', 
        'totalTeachers', 
        'totalStudents', 
        'totalAdmins'
    ));
}
    public function create()
    {
        return view('admin.users.create');
    }

    public function edit(Request $request, User $user)
{
    // Check if it's an AJAX request
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'registration_id' => $user->registration_id,
                'role' => $user->role,
                'image' => $user->image,
                'image_exists' => $user->image && file_exists(public_path('storage/'.$user->image))
            ]
        ]);
    }

    // Regular request - return the full view (for non-JS fallback)
    return view('admin.users.edit', compact('user'));
}

    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            'registration_id' => 'required|string|max:255|unique:users,registration_id,'.$user->id,
            'role' => 'required|in:student,teacher,admin',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($user->image && Storage::exists('public/'.$user->image)) {
                Storage::delete('public/'.$user->image);
            }
            
            // Store new image with timestamp cache busting
            $path = $request->file('image')->store('profile-images', 'public');
            $validated['image'] = $path;
            
            // Clear the cached version
            if (function_exists('clear_file_cache')) {
                clear_file_cache(asset('storage/'.$path));
            }
        }

        $user->update($validated);

        return redirect()->route('admin.users.index')
               ->with('success', 'User updated successfully');
    }

   public function destroy(Request $request, User $user)
{
    try {
        $user->delete();

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully!'
            ]);
        }

        return redirect()->route('admin.users.index')
                         ->with('success', 'User deleted successfully!');

    } catch (\Exception $e) {
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete user: ' . $e->getMessage()
            ], 500);
        }

        return redirect()->back()
                         ->with('error', 'Failed to delete user: ' . $e->getMessage());
    }
}

public function show(Request $request, User $user)
{
    // Check if it's an AJAX request
    if ($request->ajax() || $request->wantsJson()) {
        return response()->json([
            'success' => true,
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'registration_id' => $user->registration_id,
                'role' => $user->role,
                'image' => $user->image,
                'image_exists' => $user->image && file_exists(public_path('storage/'.$user->image)),
                'email_verified_at' => $user->email_verified_at,
                'is_active' => $user->is_active ?? true,
                'created_at_formatted' => $user->created_at->format('M d, Y'),
                'updated_at_formatted' => $user->updated_at->format('M d, Y'),
                'grade' => $user->grade ? [
                    'level' => $user->grade->level,
                    'section' => $user->grade->section
                ] : null
            ]
        ]);
    }

    // Regular request - return the full view (for non-JS fallback)
    return view('admin.users.show', compact('user'));
}
}  