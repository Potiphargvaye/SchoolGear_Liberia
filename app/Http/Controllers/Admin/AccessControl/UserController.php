<?php

namespace App\Http\Controllers\Admin\AccessControl;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * School-scoping helper.
     *
     * Super Admin (school_id === null) is a platform-level account and can
     * see/manage users across every school. Every other admin (Owner,
     * Principal, etc.) is confined to their own school's users.
     *
     * Applied to every query that lists or looks up users.
     */
    protected function scopeToSchool($query)
    {
        $currentUser = Auth::user();

        if ($currentUser->school_id !== null) {
            $query->where('school_id', $currentUser->school_id);
        }

        return $query;
    }

    /**
     * Guard against cross-school access to a single user via direct ID
     * (route-model binding alone does not prevent this — a School A admin
     * could still guess/type a School B user's URL).
     */
    protected function authorizeSameSchool(User $user): void
    {
        $currentUser = Auth::user();

        // Super Admin (no school_id) can access any user.
        if ($currentUser->school_id === null) {
            return;
        }

        if ($user->school_id !== $currentUser->school_id) {
            abort(403, 'You do not have access to this user.');
        }
    }

    /**
     * Display all staff users.          
     */
    public function index()
    {
        $search = request('search');

        $users = $this->scopeToSchool(
            User::with('roles')

                // Exclude Students
                ->whereDoesntHave('roles', function ($query) {
                    $query->where('name', 'Student');
                })
        )
            ->when($search, function ($query) use ($search) {

                $query->where(function ($q) use ($search) {

                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('registration_id', 'like', "%{$search}%");
                });
            })

            ->latest()
            ->paginate(10)
            ->withQueryString();

        /*
    |--------------------------------------------------------------------------
    | Available Roles
    |--------------------------------------------------------------------------
    */

        $roles = Role::orderBy('name')->get();

        /*
    |--------------------------------------------------------------------------
    | Dashboard Statistics (scoped to the same school boundary as the list)
    |--------------------------------------------------------------------------
    */

        $totalUsers = $this->scopeToSchool(User::query())->count();

        $totalStudents = $this->scopeToSchool(User::role('Student'))->count();

        $totalStaff = $this->scopeToSchool(
            User::whereDoesntHave('roles', function ($query) {
                $query->where('name', 'Student');
            })
        )->count();

        $activeUsers = $this->scopeToSchool(User::where('status', 'active'))->count();

        return view(
            'admin.users.index',
            compact(
                'users',
                'roles',
                'totalUsers',
                'totalStudents',
                'totalStaff',
                'activeUsers'
            )
        );
    }
    /**
     * Create a new staff account.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                'unique:users,email',
            ],

            'role' => [
                'required',
                Rule::exists('roles', 'name'),
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

            'password' => [
                'required',
                'confirmed',
            ],

        ]);

        /*
    |--------------------------------------------------------------------------
    | Upload Profile Image
    |--------------------------------------------------------------------------
    */

        $imagePath = null;

        if ($request->hasFile('image')) {

            $imagePath = $request
                ->file('image')
                ->store('profile-images', 'public');
        }

        /*
|--------------------------------------------------------------------------
| Generate Staff Registration ID
|--------------------------------------------------------------------------
*/

        $year = now()->year;

        $lastStaff = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'Student');
        })
            ->orderByDesc('id')
            ->first();

        $nextNumber = 1;

        if (
            $lastStaff &&
            preg_match('/(\d+)$/', $lastStaff->registration_id, $matches)
        ) {
            $nextNumber = (int) $matches[1] + 1;
        }


        //Ensure Registration ID is Always Unique

        do {

            $registrationId =
                'LIPA/' .
                $year .
                '/' .
                str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

            $nextNumber++;
        } while (
            User::where('registration_id', $registrationId)->exists()
        );


        //Generate Staff Registration ID (scoped to the creator's school)


        $registrationId = (new \App\Services\RegistrationIdService())
            ->generateForStaff();
        /*
    |--------------------------------------------------------------------------
    | Create User (inherits creator's school_id — Phase 3 behavior, unchanged)
    |--------------------------------------------------------------------------
    */

        $user = User::create([

            'school_id' => Auth::user()->school_id,

            'registration_id' => $registrationId,

            'name' => $validated['name'],

            'email' => $validated['email'],

            'password' => Hash::make($validated['password']),

            'image' => $imagePath,

            'status' => 'active',

            'created_by' => Auth::id(),

        ]);

        /*
    |--------------------------------------------------------------------------
    | Assign Selected Spatie Role
    |--------------------------------------------------------------------------
    */

        $user->assignRole($validated['role']);

        /*
    |--------------------------------------------------------------------------
    | Redirect
    |--------------------------------------------------------------------------
    */

        return redirect()
            ->route('admin.access-control.users.index')
            ->with(
                'success',
                'Staff account created successfully. Registration ID: ' . $registrationId
            );
    }

    /**
     * View user.
     */
    public function show(Request $request, User $user)
    {
        $this->authorizeSameSchool($user);

        if ($request->ajax()) {

            $user->load([
                'roles',
                'creator',
            ]);

            return response()->json([

                'success' => true,

                'user' => [

                    'id' => $user->id,

                    'registration_id' => $user->registration_id,

                    'name' => $user->name,

                    'email' => $user->email,

                    'status' => $user->status,

                    'role' => optional($user->roles->first())->name,

                    'image' => $user->image,

                    'image_exists' => $user->image
                        ? Storage::disk('public')->exists($user->image)
                        : false,

                    'email_verified_at' => $user->email_verified_at,

                    'created_at' => optional($user->created_at)->format('M d, Y h:i A'),

                    'updated_at' => optional($user->updated_at)->format('M d, Y h:i A'),

                    'last_login_at' => $user->last_login_at
                        ? $user->last_login_at->format('M d, Y h:i A')
                        : null,

                    'created_by' => optional($user->creator)->name,

                    'created_by_registration_id' => optional($user->creator)->registration_id,

                    'created_by_role' => $user->creator
                        ? optional($user->creator->roles->first())->name
                        : null,

                ],

            ]);
        }

        abort(404);
    }

    /**
     * Update staff account   .
     */
    public function update(Request $request, User $user)
    {
        $this->authorizeSameSchool($user);

        /// Protect Super Administrator

        if ($user->hasRole('Super Admin')) {

            return response()->json([

                'success' => false,

                'message' => 'The Super Administrator account is protected and cannot be modified.'

            ], 403);
        }

        $validated = $request->validate([

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'email' => [
                'required',
                'email',
                Rule::unique('users', 'email')->ignore($user->id),
            ],

            'role' => [
                'required',
                Rule::exists('roles', 'name'),
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                    'suspended',
                ]),
            ],

            'image' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png',
                'max:2048',
            ],

        ]);

        /*
    |--------------------------------------------------------------------------
    | Upload New Profile Image
    |--------------------------------------------------------------------------
    */

        if ($request->hasFile('image')) {

            if ($user->image && Storage::disk('public')->exists($user->image)) {

                Storage::disk('public')->delete($user->image);
            }

            $validated['image'] = $request
                ->file('image')
                ->store('profile-images', 'public');
        }

        /*
    |--------------------------------------------------------------------------
    | Update User Information
    |--------------------------------------------------------------------------
    */

        $user->update([

            'name'   => $validated['name'],

            'email'  => $validated['email'],

            'status' => $validated['status'],

            'image'  => $validated['image'] ?? $user->image,

        ]);

        /*
    |--------------------------------------------------------------------------
    | Update Spatie Role
    |--------------------------------------------------------------------------
    */

        $user->syncRoles([
            $validated['role']
        ]);

        /*
    |--------------------------------------------------------------------------
    | Return Response
    |--------------------------------------------------------------------------
    */

        if ($request->ajax()) {

            return response()->json([

                'success' => true,

                'message' => 'Staff account updated successfully.',

            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Staff account updated successfully.',
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'registration_id' => $user->registration_id,
                'status' => $user->status,
                'role' => optional($user->roles->first())->name,
            ],
        ]);
    }


    /**
     * Delete staff account.
     */
    public function destroy(Request $request, User $user)
    {
        $this->authorizeSameSchool($user);

        if ($user->hasRole('Super Admin')) {

            $message = 'Super Administrator cannot be deleted.';

            if ($request->ajax()) {
                return response()->json([
                    'success' => false,
                    'message' => $message,
                ], 403);
            }

            return back()->with('error', $message);
        }

        if ($user->image) {
            Storage::disk('public')->delete($user->image);
        }

        $user->delete();

        if ($request->ajax()) {
            return response()->json([
                'success' => true,
                'message' => 'User deleted successfully.',
            ]);
        }

        return back()->with(
            'success',
            'User deleted successfully.'
        );
    }
}
