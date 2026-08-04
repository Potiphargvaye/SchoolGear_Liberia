<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    public function edit(User $user)
    {
        // Get all available permissions
        $permissions = Permission::all();

        // Get current user's permissions
        $userPermissions = $user->getAllPermissions()
            ->pluck('name')
            ->toArray();

        return view('admin.users.permissions', compact('user', 'permissions', 'userPermissions'));
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'permissions' => 'nullable|array',
            'permissions.*' => 'string|exists:permissions,name',
        ]);

        // Sync user permissions (overwrite previous)
        $user->syncPermissions($request->permissions ?? []);

        return redirect()
            ->route('admin.users.permissions.edit', $user->id)
            ->with('success', 'Permissions updated successfully.');
    }
}