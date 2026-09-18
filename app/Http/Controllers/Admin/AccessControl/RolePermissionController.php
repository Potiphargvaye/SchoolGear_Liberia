<?php

namespace App\Http\Controllers\Admin\AccessControl;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;

class RolePermissionController extends Controller
{
    /**
     * The Role↔Permission matrix redefines what a role (e.g. "Teacher")
     * can do platform-wide. Only SchoolGear's Super Admin may touch this —
     * a School Owner changing "Teacher" here would silently change every
     * other school's Teachers too, since roles/permissions stay global
     * under Option A.
     */
    protected function ensurePlatformAdmin(): void
    {
        if (auth()->user()->school_id !== null) {
            abort(403, 'Only the SchoolGear platform administrator can manage role permissions.');
        }
    }

    /**
     * Display roles and permissions.
     */
    public function index(Request $request)
    {
        $this->ensurePlatformAdmin();

        // All roles with their assigned permissions
        $roles = Role::with('permissions')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%");
            })
            ->orderBy('name')
            ->paginate(10)
            ->appends($request->query());

        // All permissions grouped by module
        $permissions = Permission::orderBy('name')
            ->get()
            ->groupBy(function ($permission) {

                $name = strtolower($permission->name);

                if (str_contains($name, 'dashboard')) {
                    return 'Dashboard';
                }

                if (str_contains($name, 'user')) {
                    return 'Users';
                }

                if (str_contains($name, 'student')) {
                    return 'Students';
                }

                if (str_contains($name, 'course')) {
                    return 'Courses';
                }

                if (str_contains($name, 'lesson')) {
                    return 'Lessons';
                }

                if (str_contains($name, 'assignment')) {
                    return 'Assignments';
                }

                if (str_contains($name, 'quiz')) {
                    return 'Quizzes';
                }

                if (str_contains($name, 'certificate')) {
                    return 'Certificates';
                }

                if (str_contains($name, 'announcement')) {
                    return 'Announcements';
                }

                if (str_contains($name, 'report')) {
                    return 'Reports';
                }

                if (str_contains($name, 'setting')) {
                    return 'Settings';
                }

                if (str_contains($name, 'category')) {
                    return 'Categories';
                }

                if (str_contains($name, 'enrollment')) {
                    return 'Enrollments';
                }

                if (str_contains($name, 'role')) {
                    return 'Roles';
                }

                if (str_contains($name, 'permission')) {
                    return 'Permissions';
                }

                return 'Other';
            });

        return view(
            'admin.access-control.role-permissions.index',
            compact(
                'roles',
                'permissions'
            )
        );
    }

    /**
     * Optional.
     * We are using a modal instead of a separate page.
     */
    public function edit(Role $role)
    {
        $this->ensurePlatformAdmin();

        return redirect()
            ->route('admin.access-control.role-permissions.index');
    }

    /**
     * Update role permissions.
     */
    public function update(Request $request, Role $role)
    {
        $this->ensurePlatformAdmin();

        $request->validate([
            'permissions' => 'nullable|array',
        ]);

        $role->syncPermissions(
            $request->permissions ?? []
        );

        return redirect()
            ->route('admin.access-control.role-permissions.index')
            ->with(
                'success',
                'Role permissions updated successfully.'
            );
    }
}
