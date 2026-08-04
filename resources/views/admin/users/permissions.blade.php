@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <!-- Page Header -->
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">Manage User Access</h1>
        <p class="text-gray-600 mt-1">Assign roles and permissions for <span class="font-semibold">{{ $user->name }}</span>.</p>
    </div>

    <!-- Success Message -->
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-800 px-4 py-2 rounded mb-6">
            {{ session('success') }}
        </div>
    @endif  

    <form action="{{ route('admin.users.permissions.update', $user->id) }}" method="POST" class="space-y-6">
        @csrf

        <!-- Role Selection -->
        <div>
            <label for="role" class="block mb-2 font-medium text-gray-700">Role</label>
            <select id="role" name="role" class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                @foreach(\Spatie\Permission\Models\Role::all() as $role)
                    <option value="{{ $role->name }}" @if($user->hasRole($role->name)) selected @endif>
                        {{ ucfirst($role->name) }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Permissions Grid -->
        <div>
            <h2 class="text-lg font-semibold mb-3">Permissions</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                @foreach($permissions as $permission)
                    <label class="flex items-center space-x-2 p-3 border border-gray-200 rounded cursor-pointer hover:bg-gray-50 transition">
                        <input type="checkbox" name="permissions[]" value="{{ $permission->name }}" 
                            @if(in_array($permission->name, $userPermissions)) checked @endif
                            class="h-5 w-5 text-blue-600 focus:ring-blue-500 border-gray-300 rounded">
                        <span class="text-gray-700">{{ ucfirst(str_replace('-', ' ', $permission->name)) }}</span>
                    </label>
                @endforeach
            </div>
        </div>

        <!-- Submit Button -->
        <div>
            <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded font-medium transition">
                Save Changes
            </button>
        </div>
    </form>
</div>
@endsection