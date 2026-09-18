<?php

namespace App\Http\Controllers\Admin\AccessControl;

use App\Http\Controllers\Controller;
use App\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    /**
     * Roles are global, platform-wide definitions (Option A — School/Tenant
     * Foundation). Only SchoolGear's own Super Admin (school_id === null)
     * may create, rename, delete, or browse the raw Role catalog.
     *
     * School Owners/staff still assign existing roles to their own users —
     * that flow lives in UserController and is already school-scoped via
     * scopeToSchool(). This controller governs the *definitions* only.
     */
    protected function ensurePlatformAdmin(): void
    {
        if (auth()->user()->school_id !== null) {
            abort(403, 'Only the SchoolGear platform administrator can manage roles.');
        }
    }

    /**
     * Display all roles.
     */
    public function index(Request $request)
    {
        $this->ensurePlatformAdmin();

        $roles = Role::withCount('users')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        return view('admin.access-control.roles.index', compact('roles'));
    }
    /**
     * Show create form.
     */
    public function create()
    {
        $this->ensurePlatformAdmin();

        return view('admin.access-control.roles.create');
    }

    /**
     * Store a new role.
     */
    public function store(Request $request)
    {
        $this->ensurePlatformAdmin();

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name',
        ]);

        Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
        ]);

        return redirect()
            ->route('admin.access-control.roles.index')
            ->with('success', 'Role created successfully.');
    }

    /**
     * Show edit form.
     */
    public function edit(Role $role)
    {
        $this->ensurePlatformAdmin();

        return view('admin.access-control.roles.edit', compact('role'));
    }

    /**
     * Update role.
     */
    public function update(Request $request, Role $role)
    {
        $this->ensurePlatformAdmin();

        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be renamed.');
        }

        $request->validate([
            'name' => 'required|string|max:100|unique:roles,name,' . $role->id,
        ]);

        $role->update([
            'name' => $request->name,
        ]);

        return redirect()
            ->route('admin.access-control.roles.index')
            ->with('success', 'Role updated successfully.');
    }

    /**
     * Delete role. 
     */
    public function destroy(Role $role)
    {
        $this->ensurePlatformAdmin();

        if ($role->name === 'Super Admin') {
            return back()->with('error', 'Super Admin role cannot be deleted.');
        }

        if ($role->users()->count() > 0) {
            return back()->with(
                'error',
                'Cannot delete a role that is assigned to users.'
            );
        }

        $role->delete();

        return redirect()
            ->route('admin.access-control.roles.index')
            ->with('success', 'Role deleted successfully.');
    }
}
