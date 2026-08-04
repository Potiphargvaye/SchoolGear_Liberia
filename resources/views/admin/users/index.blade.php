@extends('layouts.admin')

@section('content')
@php
use Illuminate\Support\Facades\Storage;
@endphp

<style>
    /* Statistics Cards Styles */
    .stats-cards {
        animation: fadeInUp 0.6s ease-out;
    }

    .stat-card {
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: -50%;
        right: -50%;
        width: 100%;
        height: 100%;
        background: linear-gradient(transparent, rgba(255, 255, 255, 0.1), transparent);
        transform: rotate(30deg);
        transition: all 0.6s ease;
    }

    .stat-card:hover::before {
        animation: shimmer 1.5s ease-in-out;
    }

    .stat-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    .stat-icon {
        transition: all 0.3s ease;
    }

    .stat-card:hover .stat-icon {
        transform: scale(1.1);
        background: rgba(255, 255, 255, 0.3) !important;
    }

    /* Modal Styles */
    .modal-enter {
        animation: modalEnter 0.3s ease-out;
    }

    /* Loading Spinner Styles */
    .loading-spinner {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        z-index: 1000;
        background: white;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        border: 1px solid #e5e7eb;
    }

    .shimmer {
        position: relative;
        overflow: hidden;
    }

    .shimmer::before {
        content: '';
        position: absolute;
        top: 0;
        left: -100%;
        width: 100%;
        height: 100%;
        background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.4), transparent);
        animation: shimmer 1.5s infinite;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes shimmer {
        0% {
            transform: translateX(-100%);
        }
        100% {
            transform: translateX(200%);
        }
    }

    @keyframes modalEnter {
        from {
            opacity: 0;
            transform: scale(0.9) translateY(-10px);
        }
        to {
            opacity: 1;
            transform: scale(1) translateY(0);
        }
    }

    /* Responsive Design */
    @media (max-width: 768px) {
        .stats-cards {
            grid-template-columns: 1fr;
            gap: 1rem;
        }
        
        .stat-card {
            padding: 1.5rem;
        }
        
        .stat-card .text-3xl {
            font-size: 1.875rem;
        }
    }

    .search-input:focus {
        outline: none;
        box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.3);
    }
    .user-row {
        transition: all 0.2s ease;
    }
    .user-row:hover {
        background-color: #f9fafb;
        transform: translateY(-1px);
        box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
    }
    
</style>

<body class="bg-gray-50 min-h-screen">
    <div class="container mx-auto px-4 py-8">
        <!-- Stats Grid -->
       <div class="stats-cards grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <!-- Total Users Card -->
    <div class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-4 shadow-md flex items-center">
        <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
            <i class="fas fa-users text-sm sm:text-base"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs sm:text-sm font-medium text-white">Total Users</p>
            <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalUsers }}</h3>
        </div>
    </div>

    <!-- Teachers Card -->
    <div class="stat-card bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4 shadow-md flex items-center">
        <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
            <i class="fas fa-chalkboard-teacher text-sm sm:text-base"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs sm:text-sm font-medium text-white">Teachers</p>
            <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalTeachers }}</h3>
        </div>
    </div>

    <!-- Students Card -->
    <div class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-4 shadow-md flex items-center">
        <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
            <i class="fas fa-user-graduate text-sm sm:text-base"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs sm:text-sm font-medium text-white">Students</p>
            <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalStudents }}</h3>
        </div>
    </div>

    <!-- Administrators Card -->
    <div class="stat-card bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-4 shadow-md flex items-center">
        <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
            <i class="fas fa-user-shield text-sm sm:text-base"></i>
        </div>
        <div class="flex-1">
            <p class="text-xs sm:text-sm font-medium text-white">Administrators</p>
            <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalAdmins }}</h3>
        </div>
    </div>
</div>


       <!-- Top Bar with Search -->
<div class="top-bar bg-white rounded-lg shadow-sm p-3 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
    <div class="flex justify-between items-center w-full md:w-auto">
        <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Users Management</h1>
    </div>
    
    <div class="flex flex-col md:flex-row items-start md:items-center gap-3 w-full md:w-auto">
        <!-- Search Bar -->
        <div class="search-bar flex items-center bg-gray-100 py-1.5 px-3 rounded-full w-full md:w-80">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <input type="text" id="searchInput" placeholder="Search users..." 
                   class="bg-transparent py-1 px-2 w-full focus:outline-none text-sm search-input">
        </div>
        
        <!-- Add New User Button -->
        <button onclick="openCreateUserModal()" class="flex items-center gap-1.5 bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700 transition-colors whitespace-nowrap text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Add New User
        </button>
        
        <!-- Admin Profile -->
        <div class="user-profile cursor-pointer">
            @if(auth()->user()->image)
            <img src="{{ asset('storage/'.auth()->user()->image) }}" 
                 alt="Admin" 
                 class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border-2 border-indigo-300 shadow-sm">
            @else
            <div class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-700 flex items-center justify-center font-semibold text-lg md:text-xl shadow-sm">
                {{ substr(auth()->user()->name, 0, 1) }}
            </div>
            @endif
        </div>
    </div>
</div>


    <!-- Loading Spinner --> 
<div id="loadingSpinner" class="loading-spinner">
    <div class="flex flex-col items-center">
        <div class="relative">
            <!-- Smaller spinner icon -->
            <i class="fas fa-spinner fa-spin text-2xl text-indigo-500 mb-1"></i>
            <div class="absolute inset-0 bg-indigo-500 rounded-full animate-ping opacity-20"></div>
        </div>
        <!-- Smaller text -->
        <p class="mt-1 text-gray-600 text-sm font-medium">Searching users...</p>
        <p class="text-xs text-gray-400">Please wait while we find the best matches</p>
    </div>
</div>

        
    <!-- Users Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <!-- Table Headers -->
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Reg ID</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Verified</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Role</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Grade</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Joined</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                
                <!-- Table Body -->
                <tbody class="bg-white divide-y divide-gray-200" id="usersTable">
                    @foreach($users as $user)
                    <tr class="user-row hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $initials = implode('', array_map(function($word) {
                                    return strtoupper(substr(trim($word), 0, 1));
                                }, array_slice(explode(' ', $user->name), 0, 2)));
                                
                                $colors = ['bg-indigo-100', 'bg-green-100', 'bg-yellow-100', 'bg-red-100', 'bg-blue-100', 'bg-purple-100'];
                                $colorClass = $colors[array_rand($colors)];
                            @endphp

                            @if($user->image)
                                <img src="{{ asset('storage/'.$user->image) }}" 
                                     class="h-10 w-10 rounded-full object-cover border border-gray-200"
                                     alt="{{ $user->name }} avatar">
                            @else
                                <div class="h-10 w-10 rounded-full {{ $colorClass }} flex items-center justify-center font-semibold text-gray-600">
                                    {{ $initials ?: '?' }}
                                </div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->registration_id }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $user->name }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">{{ $user->email }}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($user->email_verified_at)
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                    Verified
                                </span>
                            @else
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">
                                    Not Verified
                                </span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                {{ $user->role == 'admin' ? 'bg-purple-100 text-purple-800' : 
                                   ($user->role == 'teacher' ? 'bg-blue-100 text-blue-800' : 'bg-green-100 text-green-800') }}">
                                {{ ucfirst($user->role) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            @if($user->grade)
                                Grade {{ $user->grade->level }}-{{ $user->grade->section }}
                            @else
                                N/A
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $user->created_at->format('M d, Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
    <div class="flex space-x-2">
        <!-- View Button -->
        <button onclick="openViewModal({{ $user->id }})" class="text-blue-600 hover:text-blue-900 transition-colors" title="View User">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
            </svg>
        </button>

        <!-- Edit Button -->
        <button onclick="openEditModal({{ $user->id }})" class="text-indigo-600 hover:text-indigo-900 transition-colors" title="Edit User">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
            </svg>
        </button>

        <!-- Delete Button -->
        <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')" class="text-red-600 hover:text-red-900 transition-colors" title="Delete User">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5-4h4m-4 0V3a1 1 0 00-1-1h-2a1 1 0 00-1 1v1m10 0h-4" />
            </svg>
        </button>
        @can('manage users')
<a href="{{ route('admin.users.permissions.edit', $user->id) }}" 
   class="bg-blue-500 text-white px-2 py-1 rounded">
    Access
</a>
@endcan
    </div>
</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-gray-50 border-t border-gray-200">
            {{ $users->links() }}
        </div>
    </div>
</div>

<!-- Add User Modal -->
<div id="createUserModal" class="fixed inset-0 bg-blue-900 bg-opacity-60 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
    <div class="relative top-8 mx-auto p-2 w-full max-w-lg">
        <div class="bg-white rounded-xl shadow-xl border border-blue-100 transform transition-all duration-200">
            <!-- Modal Header -->
            <div class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-800 to-blue-900 rounded-t-xl">
                <div class="text-white">
                    <h3 class="text-lg font-bold">Add New System User</h3>
                    <p class="text-blue-200 text-sm mt-1">Admin panel for registering new users</p>
                </div>
                <button onclick="closeCreateUserModal()" class="text-white hover:bg-red-500 hover:scale-110 transition-all duration-200 p-1.5 rounded-full bg-red-400">
                    <i class="fas fa-times text-base"></i>
                </button>
            </div>

            <!-- Modal Body -->
            <div class="p-4 max-h-[75vh] overflow-y-auto">
                <form method="POST" action="{{ route('register') }}" enctype="multipart/form-data" id="registrationForm" class="space-y-4">
                    @csrf

                    <!-- Profile Image Upload -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Profile Photo</label>
                        <div class="flex items-center space-x-3">
                            <div class="relative">
                                <img id="image-preview" src="{{ asset('images/default-avatar.png') }}" class="h-12 w-12 rounded-full object-cover border-2 border-white shadow">
                                <div class="absolute -bottom-1 -right-1 bg-blue-800 rounded-full p-1">
                                    <i class="fas fa-camera text-white text-xs"></i>
                                </div>
                            </div>
                            <label class="file-upload flex-1">
                                <input type="file" id="image" name="image" accept="image/*" class="hidden">
                                <div class="file-upload-label border-2 border-dashed border-gray-300 rounded-lg p-2 text-center cursor-pointer hover:border-blue-600 transition-colors">
                                    <p class="text-xs text-gray-600">Click to upload photo</p>
                                    <p class="text-[10px] text-gray-500 mt-0.5">PNG, JPG up to 2MB</p>
                                </div>
                            </label>
                        </div>
                        @error('image')
                            <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Grid Layout for Form Fields -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                        <!-- Name -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Full Name *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required
                                   class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   placeholder="John Doe">
                            @error('name')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email *</label>
                            <input type="email" id="email" name="email" value="{{ old('email') }}" required
                                   class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   placeholder="user@example.com">
                            @error('email')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Registration ID -->
                        <div>
                            <label for="registration_id" class="block text-sm font-medium text-gray-700 mb-1">Registration ID *</label>
                            <input type="text" id="registration_id" name="registration_id" value="{{ old('registration_id') }}" required
                                   class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   placeholder="EDMOL0001/2025">
                            @error('registration_id')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Role Selection -->
                        <div>
                            <label for="role" class="block text-sm font-medium text-gray-700 mb-1">User Role *</label>
                            <select id="role" name="role" required
                                    class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm appearance-none bg-white">
                                <option value="">Select a role</option>
                                <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Student</option>
                                <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Teacher</option>
                                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administrator</option>
                            </select>
                            @error('role')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password *</label>
                            <input type="password" id="password" name="password" required
                                   class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   placeholder="••••••">
                            @error('password')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-[10px] text-gray-500"> Enter a password for this account.</p>
                        </div>

                        <!-- Confirm Password -->
                        <div>
                            <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Confirm Password *</label>
                            <input type="password" id="password_confirmation" name="password_confirmation" required
                                   class="w-full px-3 py-1.5 rounded-md border border-gray-300 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 text-sm"
                                   placeholder="••••••">
                            @error('password_confirmation')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p id="passwordMatchMessage" class="mt-1 text-xs hidden"></p>
                        </div>
                    </div>

                    <!-- Form Actions -->
                    <div class="pt-4 flex flex-col sm:flex-row justify-end gap-2">
                        <button type="button" onclick="closeCreateUserModal()" 
                                class="px-4 py-2 border border-blue-300 text-blue-700 rounded-md hover:bg-blue-50 hover:border-blue-400 hover:scale-105 transition-all duration-200 text-sm">
                            Cancel
                        </button>
                        <button type="submit" 
                                class="px-5 py-2 bg-gradient-to-r from-blue-800 to-blue-900 text-white rounded-md hover:from-blue-900 hover:to-blue-950 hover:scale-105 transform transition-all duration-200 text-sm flex items-center justify-center gap-1">
                            <i class="fas fa-user-plus text-xs"></i> Register
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div id="deleteUserModal"
     class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm z-50 hidden">

    <div class="fixed inset-0 flex items-center justify-center p-3">
        <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">

            <!-- Header -->
            <div class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
                <h3 class="text-sm font-semibold text-white">
                    Confirm Delete
                </h3>
                <button onclick="closeDeleteModal()"
                        class="text-white text-lg leading-none hover:scale-110 transition">
                    &times;
                </button>
            </div>

            <!-- Body -->
            <div class="px-4 py-3 space-y-2">
                <p class="text-sm text-gray-700">
                    Are you sure you want to delete this user?
                </p>

                <p id="deleteUserDetails"
                   class="text-xs font-medium text-gray-800 px-3 py-2 bg-gray-50 border border-gray-200 rounded-md">
                </p>

                <p class="flex items-center gap-1 text-xs text-red-600">
                    <i class="fas fa-exclamation-triangle text-xs"></i>
                    This action cannot be undone.
                </p>
            </div>

            <!-- Footer -->
            <div class="px-4 py-3 border-t border-gray-200 flex justify-end gap-2">
                <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-3 py-1.5 text-xs border border-gray-300 rounded-md text-gray-700 hover:bg-gray-100 transition">
                    Cancel
                </button>

                <form id="deleteUserForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="px-3 py-1.5 text-xs bg-red-600 text-white rounded-md hover:bg-red-700 transition flex items-center gap-1">
                        <i class="fas fa-trash text-[10px]"></i>
                        Delete
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div id="editUserModal"
     class="fixed inset-0 bg-blue-900 bg-opacity-60 backdrop-blur-sm z-50 hidden
            flex items-center justify-center px-3 py-6 overflow-y-auto">


    <div class="w-full max-w-lg bg-white rounded-xl shadow-xl border border-indigo-100 overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 bg-indigo-600">
            <div class="text-white">
                <h3 class="text-sm font-semibold leading-tight">Edit User</h3>
                <p class="text-[11px] text-indigo-100">Update details</p>
            </div>
            <button onclick="closeEditModal()"
                    class="text-white bg-indigo-500 hover:bg-red-500 transition rounded-full p-1.5">
                <i class="fas fa-times text-xs"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-3 max-h-[85vh] overflow-y-auto">
            <form id="editUserForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">

                    <!-- Name -->
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-0.5">
                            Full Name *
                        </label>
                        <input type="text" name="name" id="edit_name" required
                               class="w-full px-2 py-1.5 text-xs rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <!-- Email -->
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-0.5">
                            Email *
                        </label>
                        <input type="email" name="email" id="edit_email" required
                               class="w-full px-2 py-1.5 text-xs rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <!-- Registration ID -->
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-0.5">
                            Reg. ID *
                        </label>
                        <input type="text" name="registration_id" id="edit_registration_id" required
                               class="w-full px-2 py-1.5 text-xs rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-500">
                    </div>

                    <!-- Role -->
                    <div>
                        <label class="block text-[11px] font-medium text-gray-600 mb-0.5">
                            Role *
                        </label>
                        <select name="role" id="edit_role" required
                                class="w-full px-2 py-1.5 text-xs rounded-md border border-gray-300 focus:ring-1 focus:ring-indigo-500 bg-white">
                            <option value="">Select</option>
                            <option value="student">Student</option>
                            <option value="teacher">Teacher</option>
                            <option value="admin">Admin</option>
                        </select>
                    </div>

                    <!-- Profile Image -->
                    <div class="sm:col-span-2">
                        <label class="block text-[11px] font-medium text-gray-600 mb-1">
                            Profile Photo
                        </label>

                        <div class="flex items-center gap-3">
                            <div class="relative">
                                <img id="edit_image_preview"
                                     src="{{ asset('images/default-avatar.png') }}"
                                     class="h-14 w-14 rounded-full object-cover border border-indigo-200">
                                <span class="absolute -bottom-1 -right-1 bg-indigo-600 text-white rounded-full p-1">
                                    <i class="fas fa-camera text-[9px]"></i>
                                </span>
                            </div>

                            <label class="flex-1 cursor-pointer">
                                <input type="file" id="edit_image" name="image" accept="image/*"
                                       class="hidden" onchange="displayEditImagePreview(this)">
                                <div class="border border-dashed border-gray-300 rounded-md px-2 py-2 text-center hover:border-indigo-400 transition">
                                    <p class="text-[11px] text-gray-600">Tap to upload</p>
                                    <p class="text-[10px] text-gray-400">PNG / JPG</p>
                                </div>
                            </label>
                        </div>

                        <div id="currentImageContainer"
                             class="hidden mt-2 px-2 py-1.5 bg-indigo-50 border border-indigo-200 rounded-md">
                            <p class="text-[10px] text-indigo-700 flex items-center">
                                <i class="fas fa-info-circle mr-1"></i>
                                <span id="currentImageText">
                                    Current image kept
                                </span>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="mt-3 pt-3 border-t border-indigo-100 flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                            class="px-3 py-1.5 text-xs rounded-md border border-gray-300 text-gray-600 hover:bg-gray-100">
                        Cancel
                    </button>

                    <button type="submit"
                            class="px-4 py-1.5 text-xs rounded-md bg-indigo-600 text-white hover:bg-indigo-700 font-medium flex items-center">
                        <i class="fas fa-save mr-1 text-[10px]"></i>
                        Update
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- View User Modal -->
<div id="viewUserModal"
     class="fixed inset-0 bg-slate-900 bg-opacity-70 backdrop-blur-sm z-50 hidden
            flex items-start sm:items-center justify-center px-2 pt-6 sm:pt-0">

    <div class="w-full max-w-lg bg-white rounded-lg shadow-lg border border-slate-200 overflow-hidden">

        <!-- Header -->
        <div class="flex items-center justify-between px-3 py-2 bg-slate-800">
            <div class="text-white">
                <h3 class="text-sm font-semibold leading-tight">User Details</h3>
                <p class="text-[10px] text-slate-200">Overview</p>
            </div>
            <button onclick="closeViewModal()"
                    class="text-white bg-slate-700 hover:bg-red-600 transition rounded-full p-1">
                <i class="fas fa-times text-[10px]"></i>
            </button>
        </div>

        <!-- Body -->
        <div class="p-2 max-h-[80vh] overflow-y-auto">
            <div class="flex flex-col sm:flex-row gap-2">

                <!-- Left Column -->
                <div class="sm:w-1/3 space-y-2 text-center">

                    <!-- Profile -->
                    <div class="relative inline-block">
                        <img id="view_image"
                             src="{{ asset('images/default-avatar.png') }}"
                             class="h-14 w-14 rounded-full object-cover border border-slate-300 mx-auto">
                        <span class="absolute -bottom-1 -right-1 bg-green-600 text-white rounded-full p-1">
                            <i class="fas fa-check text-[8px]"></i>
                        </span>
                    </div>
                    <h2 id="view_name" class="text-xs font-semibold text-gray-800 mt-1"></h2>
                    <p id="view_role" class="text-[10px] text-gray-500 capitalize"></p>

                    <!-- Actions -->
                    <div class="bg-slate-50 border border-slate-200 rounded-md p-1 space-y-1">
                        <button onclick="switchToEditFromView()"
                                class="w-full text-[10px] bg-slate-800 text-white py-1 rounded-md hover:bg-slate-900 flex items-center justify-center gap-1">
                            <i class="fas fa-edit text-[8px]"></i> Edit
                        </button>
                        <button id="view_delete_btn"
                                class="w-full text-[10px] bg-red-600 text-white py-1 rounded-md hover:bg-red-700 flex items-center justify-center gap-1">
                            <i class="fas fa-trash text-[8px]"></i> Delete
                        </button>
                    </div>
                </div>

                <!-- Right Column -->
                <div class="sm:w-2/3 space-y-1 text-xs">

                    <!-- Basic Info -->
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-2">
                        <h4 class="font-semibold text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-id-card mr-1 text-slate-700"></i> Basic Info
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
                            <div>
                                <span class="text-gray-500 text-[10px]">Reg ID</span>
                                <p id="view_registration_id" class="font-semibold text-gray-800 text-[10px]"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-[10px]">Email</span>
                                <p id="view_email" class="font-semibold text-gray-800 break-all text-[10px]"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-[10px]">Status</span>
                                <p id="view_status" class="font-semibold text-[10px]"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Role & Grade -->
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-2">
                        <h4 class="font-semibold text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-users-cog mr-1 text-slate-700"></i> Role & Grade
                        </h4>
                        <div class="grid grid-cols-2 gap-1">
                            <div>
                                <span class="text-gray-500 text-[10px]">Role</span>
                                <p id="view_role_badge" class="font-semibold text-[10px]"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-[10px]">Grade</span>
                                <p id="view_grade" class="font-semibold text-gray-800 text-[10px]">N/A</p>
                            </div>
                        </div>
                    </div>

                    <!-- Account Info -->
                    <div class="bg-gray-50 border border-gray-200 rounded-md p-2">
                        <h4 class="font-semibold text-gray-700 mb-1 flex items-center">
                            <i class="fas fa-calendar-alt mr-1 text-slate-700"></i> Account
                        </h4>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-1">
                            <div>
                                <span class="text-gray-500 text-[10px]">Created</span>
                                <p id="view_created_at" class="font-semibold text-gray-800 text-[10px]"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-[10px]">Updated</span>
                                <p id="view_updated_at" class="font-semibold text-gray-800 text-[10px]"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-[10px]">Email Verified</span>
                                <p id="view_email_verified" class="font-semibold text-[10px]"></p>
                            </div>
                            <div>
                                <span class="text-gray-500 text-[10px]">User ID</span>
                                <p id="view_user_id" class="font-semibold text-gray-800 font-mono break-all text-[10px]"></p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>

    </div>
</div>
<script>
    // Search functionality variables
    let searchTimeout;
    
    // ========== SEARCH FUNCTIONALITY ==========
    function performSearch() {
        const searchTerm = document.getElementById('searchInput').value.trim();
        const userRows = document.querySelectorAll('#usersTable .user-row');
        
        // Show loading spinner
        showLoadingSpinner();
        
        // Clear previous timeout
        clearTimeout(searchTimeout);
        
        // Set new timeout for search with debouncing
        searchTimeout = setTimeout(() => {
            // Simulate search (you can replace this with actual AJAX call)
            userRows.forEach(row => {
                const textContent = row.textContent.toLowerCase();
                if (searchTerm === '' || textContent.includes(searchTerm)) {
                    row.style.display = '';
                } else {
                    row.style.display = 'none';
                }
            });
            
            // Hide loading spinner after search completes
            setTimeout(() => {
                hideLoadingSpinner();
                
                // Show search results info
                const visibleRows = document.querySelectorAll('#usersTable .user-row[style=""]').length;
                const totalRows = userRows.length;
                showSearchResultsInfo(visibleRows, totalRows, searchTerm);
            }, 300); // Small delay to show loading state
            
        }, 500);
    }

    // Loading spinner functions
    function showLoadingSpinner() {
        const spinner = document.getElementById('loadingSpinner');
        const usersTable = document.getElementById('usersTable');
        
        // Create shimmer effect on existing rows
        if (usersTable) {
            usersTable.querySelectorAll('.user-row').forEach(row => {
                row.style.opacity = '0.6';
                row.classList.add('shimmer');
            });
        }
        
        // Show spinner
        spinner.style.display = 'block';
    }

    function hideLoadingSpinner() {
        const spinner = document.getElementById('loadingSpinner');
        const usersTable = document.getElementById('usersTable');
        
        // Remove shimmer effect
        if (usersTable) {
            usersTable.querySelectorAll('.user-row').forEach(row => {
                row.style.opacity = '1';
                row.classList.remove('shimmer');
            });
        }
        
        spinner.style.display = 'none';
    }

    function showSearchResultsInfo(currentCount, totalCount, searchTerm) {
        let resultsInfo = document.getElementById('searchResultsInfo');
        
        if (!resultsInfo) {
            resultsInfo = document.createElement('div');
            resultsInfo.id = 'searchResultsInfo';
            resultsInfo.className = 'mb-4';
            const usersTable = document.querySelector('.bg-white.rounded-lg.shadow');
            usersTable.parentNode.insertBefore(resultsInfo, usersTable);
        }
        
        if (searchTerm) {
            resultsInfo.innerHTML = `
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-3">
                    <i class="fas fa-info-circle text-blue-500 mr-2"></i>
                    Showing ${currentCount} of ${totalCount} users matching "${searchTerm}"
                    <button onclick="clearSearch()" class="ml-2 text-blue-600 hover:text-blue-800 font-medium">Clear search</button>
                </div>
            `;
        } else {
            resultsInfo.innerHTML = '';
        }
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        performSearch();
    }

    // ========== MODAL FUNCTIONALITY ==========
    function openCreateUserModal() {
        const modal = document.getElementById('createUserModal');
        modal.classList.remove('hidden');
        modal.classList.add('modal-enter');
        document.body.style.overflow = 'hidden';
    }

   function closeCreateUserModal() {
    const modal = document.getElementById('createUserModal');
    modal.classList.add('hidden');
    document.body.style.overflow = 'auto';
    resetForm();
    
    // Auto reload the page after modal closes
    setTimeout(() => {
        window.location.reload();
    }, 100);
}

    function resetForm() {
        document.getElementById('registrationForm').reset();
        const preview = document.getElementById('image-preview');
        if (preview) {
            preview.src = "{{ asset('images/default-avatar.png') }}";
        }
        
        // Clear validation errors
        document.querySelectorAll('.text-red-600').forEach(el => {
            el.textContent = '';
        });
    }

    // ========== FORM FUNCTIONALITY ==========
    document.addEventListener('DOMContentLoaded', function() {
        // File upload interaction
        const fileUploadLabel = document.querySelector('.file-upload-label');
        if (fileUploadLabel) {
            fileUploadLabel.addEventListener('click', function() {
                document.getElementById('image').click();
            });
        }

        // Image preview handler
        const imageInput = document.getElementById('image');
        if (imageInput) {
            imageInput.addEventListener('change', function() {
                const preview = document.getElementById('image-preview');
                if (this.files && this.files[0]) {
                    preview.src = URL.createObjectURL(this.files[0]);
                }
            });
        }

        // Search input event listener
        const searchInput = document.getElementById('searchInput');
        if (searchInput) {
            searchInput.addEventListener('input', performSearch);
            
            // Clear search when escape key is pressed
            searchInput.addEventListener('keydown', function(e) {
                if (e.key === 'Escape') {
                    clearSearch();
                }
            });
        }

        // Handle form submission with AJAX
        const registrationForm = document.getElementById('registrationForm');
        if (registrationForm) {
            registrationForm.addEventListener('submit', function(e) {
                e.preventDefault();
                
                const submitButton = this.querySelector('button[type="submit"]');
                const originalText = submitButton.innerHTML;
                
                // Show loading state
                submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Creating User...';
                submitButton.disabled = true;

                const formData = new FormData(this);
                
                fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                    }
                })
                .then(response => {
                    // If we get a redirect (success), handle it
                    if (response.redirected) {
                        return { success: true };
                    }
                    
                    // Try to parse as JSON, if fails assume success
                    return response.text().then(text => {
                        try {
                            return JSON.parse(text);
                        } catch (e) {
                            // If it's not JSON but we got here, assume success
                            return { success: true };
                        }
                    });
                })
                .then(data => {
                    if (data.success) {
                        closeCreateUserModal();
                        showSuccessMessage('User created successfully!');
                        setTimeout(() => {
                            window.location.reload();
                        }, 1500);
                    } else {
                        throw new Error(data.message || 'Failed to create user');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    closeCreateUserModal();
                    showSuccessMessage('User created successfully!');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                });
            });
        }
    });

// ========== DELETE MODAL FUNCTIONALITY ==========
function openDeleteModal(userId, userName) {
    console.log('Opening delete modal for user ID:', userId);
    
    // Set delete details
    document.getElementById('deleteUserDetails').textContent = `"${userName}"`;
    
    // Set form action
    document.getElementById('deleteUserForm').action = `/admin/users/${userId}`;
    
    // Show modal
    const modal = document.getElementById('deleteUserModal');
    modal.classList.remove('hidden');
}

function closeDeleteModal() {
    const modal = document.getElementById('deleteUserModal');
    if (modal) {
        modal.classList.add('hidden');
    }
}

// Handle delete form submission with AJAX
document.getElementById('deleteUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Delete form submitted via AJAX');
    
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Deleting...';
    submitButton.disabled = true;

    fetch(this.action, {
        method: 'DELETE', 
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value,
            'Accept': 'application/json'
        }
    })
    .then(response => {
        // If we get a redirect (success), handle it
        if (response.redirected) {
            return { success: true };
        }
        
        // Try to parse as JSON, if fails assume success
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                // If it's not JSON but we got here, assume success
                return { success: true };
            }
        });
    })
    .then(data => {
        console.log('Delete success data:', data);
        if (data.success) {
            closeDeleteModal();
            showSuccessMessage('User deleted successfully!');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to delete user');
        }
    })
    .catch(error => {
        console.error('Delete error:', error);
        showErrorMessage('Failed to delete user: ' + error.message);
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});

// ========== EDIT MODAL FUNCTIONALITY ==========
function openEditModal(userId) {
    console.log('Opening edit modal for user ID:', userId);
    
    // Show loading state
    showInfoMessage('Loading user data...');
    
    // Get CSRF token
    const csrfToken = document.querySelector('input[name="_token"]').value;
    
    fetch(`/admin/users/${userId}/edit?ajax=1`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();
    })
    .then(data => {
        console.log('Received user data:', data);
        
        if (data.success) {
            const user = data.user;
            
            // Populate form fields
            document.getElementById('edit_name').value = user.name;
            document.getElementById('edit_email').value = user.email;
            document.getElementById('edit_registration_id').value = user.registration_id;
            document.getElementById('edit_role').value = user.role;
            
            // Set form action
            document.getElementById('editUserForm').action = `/admin/users/${userId}`;
            
            // Handle image display
            const preview = document.getElementById('edit_image_preview');
            const currentImageContainer = document.getElementById('currentImageContainer');
            
            if (user.image && user.image_exists) {
                preview.src = `/storage/${user.image}?v=${new Date().getTime()}`;
                currentImageContainer.classList.remove('hidden');
                document.getElementById('currentImageText').textContent = 'Current profile image is displayed';
            } else {
                // Show initials if no image
                const initials = getInitials(user.name);
                preview.src = "{{ asset('images/default-avatar.png') }}";
                currentImageContainer.classList.remove('hidden');
                document.getElementById('currentImageText').textContent = `Current display: ${initials} (initials)`;
            }
            
            // Show modal
            const modal = document.getElementById('editUserModal');
            modal.classList.remove('hidden');
            
            console.log('Edit modal populated successfully');
        } else {
            throw new Error(data.message || 'Failed to load user data');
        }
    })
    .catch(error => {
        console.error('Error loading user data:', error);
        showErrorMessage('Failed to load user data: ' + error.message);
    });
}

function closeEditModal() {
    const modal = document.getElementById('editUserModal');
    if (modal) {
        modal.classList.add('hidden');
        resetEditForm();
    }
}

function displayEditImagePreview(input) {
    const preview = document.getElementById('edit_image_preview');
    const currentImageContainer = document.getElementById('currentImageContainer');
    
    if (input.files && input.files[0]) {
        preview.src = URL.createObjectURL(input.files[0]);
        currentImageContainer.classList.remove('hidden');
        document.getElementById('currentImageText').textContent = 'New image selected - will replace current image';
    }
}

function resetEditForm() {
    document.getElementById('editUserForm').reset();
    document.getElementById('currentImageContainer').classList.add('hidden');
}

// Helper function to get initials
function getInitials(name) {
    return name.split(' ').map(word => word.charAt(0).toUpperCase()).join('').substring(0, 2);
}

// Handle edit form submission with AJAX
document.getElementById('editUserForm').addEventListener('submit', function(e) {
    e.preventDefault();
    console.log('Edit form submitted via AJAX');
    
    const submitButton = this.querySelector('button[type="submit"]');
    const originalText = submitButton.innerHTML;
    
    // Show loading state
    submitButton.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';
    submitButton.disabled = true;

    const formData = new FormData(this);
    
    fetch(this.action, {
        method: 'POST',
        body: formData,
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
        }
    })
    .then(response => {
        // If we get a redirect (success), handle it
        if (response.redirected) {
            return { success: true };
        }
        
        // Try to parse as JSON, if fails assume success
        return response.text().then(text => {
            try {
                return JSON.parse(text);
            } catch (e) {
                // If it's not JSON but we got here, assume success
                return { success: true };
            }
        });
    })
    .then(data => {
        if (data.success) {
            closeEditModal();
            showSuccessMessage('User updated successfully!');
            setTimeout(() => {
                window.location.reload();
            }, 1500);
        } else {
            throw new Error(data.message || 'Failed to update user');
        }
    })
    .catch(error => {
        console.error('Edit error:', error);
        showErrorMessage('Failed to update user: ' + error.message);
        submitButton.innerHTML = originalText;
        submitButton.disabled = false;
    });
});

// ========== VIEW MODAL FUNCTIONALITY ==========
let currentViewUserId = null;

function openViewModal(userId) {
    console.log('Opening view modal for user ID:', userId);
    currentViewUserId = userId;
    
    // Show loading state
    showInfoMessage('Loading user details...');
    
    // Try multiple endpoint approaches
    const endpoints = [
        `/admin/users/${userId}/view?ajax=1`,
        `/admin/users/${userId}?ajax=1`,
        `/admin/users/${userId}/show?ajax=1`
    ];
    
    // Get CSRF token
    const csrfToken = document.querySelector('input[name="_token"]').value;
    
    const tryEndpoint = (index) => {
        if (index >= endpoints.length) {
            // All endpoints failed, use fallback
            console.log('All API endpoints failed, using fallback data');
            loadBasicUserData(userId);
            return;
        }
        
        fetch(endpoints[index], {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            }
        })
    .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
    .then(data => {
            console.log('Received user details from endpoint:', endpoints[index], data);
            
            if (data.success) {
                populateViewModal(data.user);
            } else {
                throw new Error(data.message || 'Failed to load user details');
            }
        })
    .catch(error => {
            console.error(`Error with endpoint ${endpoints[index]}:`, error);
            // Try next endpoint
            tryEndpoint(index + 1);
        });
    };
    
    // Start trying endpoints
    tryEndpoint(0);
}

function populateViewModal(user) {
    // Populate view fields
    document.getElementById('view_name').textContent = user.name || 'N/A';
    document.getElementById('view_role').textContent = user.role || 'N/A';
    document.getElementById('view_registration_id').textContent = user.registration_id || 'N/A';
    document.getElementById('view_email').textContent = user.email || 'N/A';
    document.getElementById('view_user_id').textContent = user.id ? `#${user.id}` : 'N/A';
    document.getElementById('view_created_at').textContent = user.created_at_formatted || user.created_at || 'N/A';
    document.getElementById('view_updated_at').textContent = user.updated_at_formatted || user.updated_at || 'N/A';
    
    // Set up delete button properly
    const deleteBtn = document.getElementById('view_delete_btn');
    deleteBtn.onclick = () => {
        closeViewModal();
        setTimeout(() => {
            openDeleteModal(user.id, user.name);
        }, 300);
    };
    
    // Handle image
    const viewImage = document.getElementById('view_image');
    if (user.image && (user.image_exists !== false)) {
        viewImage.src = `/storage/${user.image}?v=${new Date().getTime()}`;
    } else {
        viewImage.src = "{{ asset('images/default-avatar.png') }}";
    }
    
    // Status badges
    const statusElement = document.getElementById('view_status');
    if (statusElement) {
        statusElement.innerHTML = user.is_active !== false ? 
            '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Active</span>' :
            '<span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Inactive</span>';
    }
    
    // Email verification badge
    const emailVerifiedElement = document.getElementById('view_email_verified');
    if (emailVerifiedElement) {
        emailVerifiedElement.innerHTML = user.email_verified_at ? 
            '<span class="px-2 py-1 bg-green-100 text-green-800 text-xs font-medium rounded-full">Verified</span>' :
            '<span class="px-2 py-1 bg-red-100 text-red-800 text-xs font-medium rounded-full">Not Verified</span>';
    }
    
    // Role badge
    const roleBadge = document.getElementById('view_role_badge');
    if (roleBadge) {
        const roleColors = {
            admin: 'bg-purple-100 text-purple-800',
            teacher: 'bg-blue-100 text-blue-800',
            student: 'bg-green-100 text-green-800'
        };
        const roleClass = roleColors[user.role] || 'bg-gray-100 text-gray-800';
        roleBadge.innerHTML = `<span class="px-2 py-1 ${roleClass} text-xs font-medium rounded-full capitalize">${user.role || 'N/A'}</span>`;
    }
    
    // Grade information
    const gradeElement = document.getElementById('view_grade');
    if (gradeElement) {
        if (user.grade) {
            gradeElement.textContent = `Grade ${user.grade.level}-${user.grade.section}`;
        } else {
            gradeElement.textContent = 'N/A';
        }
    }
    
    // Show modal
    const modal = document.getElementById('viewUserModal');
    if (modal) {
        modal.classList.remove('hidden');
        document.body.style.overflow = 'hidden';
    }
    
    console.log('View modal populated successfully');
}

// Fallback function if AJAX fails
function loadBasicUserData(userId) {
    console.log('Using fallback data for user ID:', userId);
    
    // Try to get basic data from the table row
    const button = document.querySelector(`button[onclick*="openViewModal(${userId})"]`);
    if (!button) {
        showErrorMessage('Could not find user data. Please try again.');
        return;
    }
    
    const userRow = button.closest('tr');
    if (userRow) {
        const cells = userRow.querySelectorAll('td');
        const userData = {
            id: userId,
            name: cells[2]?.textContent?.trim() || 'N/A',
            email: cells[3]?.textContent?.trim() || 'N/A',
            registration_id: cells[1]?.textContent?.trim() || 'N/A',
            role: cells[5]?.querySelector('span')?.textContent?.trim()?.toLowerCase() || 'N/A',
            created_at: cells[7]?.textContent?.trim() || 'N/A'
        };
        
        populateViewModal(userData);
        showSuccessMessage('User details loaded successfully!');
    } else {
        showErrorMessage('Could not load user data. Please try again.');
    }
}

function closeViewModal() {
    const modal = document.getElementById('viewUserModal');
    if (modal) {
        modal.classList.add('hidden');
        document.body.style.overflow = 'auto';
        // Don't reset currentViewUserId here - let switchToEditFromView handle it
        console.log('View modal closed, but keeping currentViewUserId:', currentViewUserId);
    }
}

function switchToEditFromView() {
    console.log('=== switchToEditFromView START ===');
    console.log('currentViewUserId:', currentViewUserId);
    const userIdToEdit = currentViewUserId;
    console.log('Stored userIdToEdit:', userIdToEdit);
    
    if (userIdToEdit) {
        console.log('Closing view modal and opening edit for user:', userIdToEdit);
        closeViewModal();
        
        // Give a small delay for modal to close, then open edit modal
        setTimeout(() => {
            console.log('Now calling openEditModal with stored ID:', userIdToEdit);
            openEditModal(userIdToEdit);
        }, 100);
    } else {
        console.error('No user ID available for editing');
        showErrorMessage('Could not identify user for editing. Please use the edit button in the table directly.');
    }
}

// Fix modal closing - Add event listener for view modal
document.addEventListener('click', function(event) {
    const viewModal = document.getElementById('viewUserModal');
    if (event.target === viewModal) {
        closeViewModal();
    }
    
    const editModal = document.getElementById('editUserModal');
    if (event.target === editModal) {
        closeEditModal();
    }
    
    const deleteModal = document.getElementById('deleteUserModal');
    if (event.target === deleteModal) {
        closeDeleteModal();
    }
    
    const createModal = document.getElementById('createUserModal');
    if (event.target === createModal) {
        closeCreateUserModal();
    }
});

    // ========== NOTIFICATION SYSTEM ==========
    function showNotification(message, type = 'success') {
        const notification = document.createElement('div');
        
        const styles = {
            success: 'bg-gradient-to-r from-green-500 to-green-600 border-l-4 border-green-700',
            error: 'bg-gradient-to-r from-red-500 to-red-600 border-l-4 border-red-700',
            warning: 'bg-gradient-to-r from-yellow-500 to-yellow-600 border-l-4 border-yellow-700',
            info: 'bg-gradient-to-r from-blue-500 to-blue-600 border-l-4 border-blue-700'
        };

        const icons = {
            success: 'fa-check-circle',
            error: 'fa-exclamation-triangle',
            warning: 'fa-exclamation-circle',
            info: 'fa-info-circle'
        };

        notification.className = `fixed top-4 right-4 z-50 transform translate-x-full opacity-0 transition-all duration-500 ease-in-out ${styles[type]} text-white p-4 rounded-xl shadow-2xl max-w-sm min-w-80 backdrop-blur-sm border-l-4`;
        
        notification.innerHTML = `
            <div class="flex items-center gap-3">
                <i class="fas ${icons[type]} text-xl flex-shrink-0"></i>
                <span class="flex-1 text-sm font-medium">${message}</span>
                <button onclick="this.parentElement.parentElement.remove()" 
                        class="flex-shrink-0 p-1 rounded-lg hover:bg-white hover:bg-opacity-20 transition-colors duration-200">
                    <i class="fas fa-times text-sm"></i>
                </button>
            </div>
        `;

        document.body.appendChild(notification);

        // Trigger animation
        setTimeout(() => {
            notification.classList.remove('translate-x-full', 'opacity-0');
            notification.classList.add('translate-x-0', 'opacity-100');
        }, 10);

        // Auto remove after 7 seconds
        setTimeout(() => {
            if (notification.parentElement) {
                notification.classList.remove('translate-x-0', 'opacity-100');
                notification.classList.add('translate-x-full', 'opacity-0');
                setTimeout(() => {
                    if (notification.parentElement) {
                        notification.remove();
                    }
                }, 500);
            }
        }, 7000);
    }

    // Helper functions for different notification types
    function showSuccessMessage(message) {
        showNotification(message, 'success');
    }

    function showErrorMessage(message) {
        showNotification(message, 'error');
    }

    function showWarningMessage(message) {
        showNotification(message, 'warning');
    }

    function showInfoMessage(message) {
        showNotification(message, 'info');
    }

    // ========== CARD ANIMATIONS ==========
    document.addEventListener('DOMContentLoaded', function() {
        const statCards = document.querySelectorAll('.stat-card');
        
        // Add a slight delay between each card animation
        statCards.forEach((card, index) => {
            setTimeout(() => {
                card.style.opacity = 1;
                card.style.transform = 'translateY(0)';
            }, 100 * index);
        });
        
        // Hide loading spinner initially
        hideLoadingSpinner();
    });


    /// passwordword match and mismatch message script 
    document.addEventListener("DOMContentLoaded", function () {

    const password = document.getElementById("password");
    const confirmPassword = document.getElementById("password_confirmation");
    const message = document.getElementById("passwordMatchMessage");

    function checkPasswords() {

        if (confirmPassword.value === "") {
            message.classList.add("hidden");
            return;
        }

        message.classList.remove("hidden");

        if (password.value === confirmPassword.value) {

            message.className = "mt-1 text-xs text-green-600";

            message.innerHTML =
                '<i class="fas fa-check-circle mr-1"></i> Passwords match';

        } else {

            message.className = "mt-1 text-xs text-red-600";

            message.innerHTML =
                '<i class="fas fa-times-circle mr-1"></i> Passwords do not match';

        }

    }

    password.addEventListener("input", checkPasswords);
    confirmPassword.addEventListener("input", checkPasswords);

});
</script>

@endsection