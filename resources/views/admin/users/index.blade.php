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
                <div
                    class="stat-card bg-gradient-to-r from-blue-500 to-blue-600 text-white rounded-lg p-4 shadow-md flex items-center">
                    <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
                        <i class="fas fa-users text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-white">Total Users</p>
                        <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalUsers }}</h3>
                    </div>
                </div>

                <!-- Teachers Card -->
                <div
                    class="stat-card bg-gradient-to-r from-green-500 to-green-600 text-white rounded-lg p-4 shadow-md flex items-center">
                    <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
                        <i class="fas fa-chalkboard-teacher text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-white">Staff</p>
                        <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalStaff }}</h3>
                    </div>
                </div>

                <!-- Students Card -->
                <div
                    class="stat-card bg-gradient-to-r from-purple-500 to-purple-600 text-white rounded-lg p-4 shadow-md flex items-center">
                    <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
                        <i class="fas fa-user-graduate text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-white">Students</p>
                        <h3 class="text-lg sm:text-xl font-bold text-white">{{ $totalStudents }}</h3>
                    </div>
                </div>

                <!-- Administrators Card -->
                <div
                    class="stat-card bg-gradient-to-r from-red-500 to-red-600 text-white rounded-lg p-4 shadow-md flex items-center">
                    <div class="stat-icon bg-white/20 p-2 rounded-full text-white mr-3 flex-shrink-0">
                        <i class="fas fa-user-shield text-sm sm:text-base"></i>
                    </div>
                    <div class="flex-1">
                        <p class="text-xs sm:text-sm font-medium text-white">Active Users</p>
                        <h3 class="text-lg sm:text-xl font-bold text-white">{{ $activeUsers }}</h3>
                    </div>
                </div>
            </div>


            <!-- Top Bar with Search -->
            <div
                class="top-bar bg-white rounded-lg shadow-sm p-3 mb-4 flex flex-col md:flex-row justify-between items-start md:items-center gap-3">
                <div class="flex justify-between items-center w-full md:w-auto">
                    <h1 class="text-xl md:text-2xl font-semibold text-gray-800">Users Management</h1>
                </div>

                <div class="flex flex-col md:flex-row items-start md:items-center gap-3 w-full md:w-auto">
                    <!-- Search Bar -->
                    <div class="search-bar flex items-center bg-gray-100 py-1.5 px-3 rounded-full w-full md:w-80">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-gray-400" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" id="searchInput" placeholder="Search users..."
                            class="bg-transparent py-1 px-2 w-full focus:outline-none text-sm search-input">
                    </div>

                    <!-- Add New User Button -->
                    <button onclick="openCreateUserModal()"
                        class="flex items-center gap-1.5 bg-indigo-600 text-white px-3 py-1.5 rounded-md hover:bg-indigo-700 transition-colors whitespace-nowrap text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Add New User
                    </button>

                    <!-- Admin Profile -->
                    <div class="user-profile cursor-pointer">
                        @if (auth()->user()->image)
                            <img src="{{ asset('storage/' . auth()->user()->image) }}" alt="Admin"
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full object-cover border-2 border-indigo-300 shadow-sm">
                        @else
                            <div
                                class="w-10 h-10 md:w-12 md:h-12 rounded-full bg-gradient-to-br from-indigo-100 to-purple-100 text-indigo-700 flex items-center justify-center font-semibold text-lg md:text-xl shadow-sm">
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


            <!-- Staff Users Table -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">

                <div class="overflow-x-auto">

                    <table class="min-w-full divide-y divide-gray-200">

                        <!-- Table Header -->
                        <thead class="bg-sky-50">

                            <tr>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Photo
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Staff ID
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Staff Name
                                </th>

                                <th class="px-6 py-4 text-left text-xs font-semibold text-gray-600 uppercase">
                                    Email
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Role
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Status
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Last Login
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Joined
                                </th>

                                <th class="px-6 py-4 text-center text-xs font-semibold text-gray-600 uppercase">
                                    Actions
                                </th>

                            </tr>

                        </thead>

                        <!-- Table Body -->

                        <tbody id="usersTable" class="divide-y divide-gray-100">

                            @forelse($users as $user)
                                @php

                                    $initials = collect(explode(' ', $user->name))
                                        ->take(2)
                                        ->map(fn($name) => strtoupper(substr($name, 0, 1)))
                                        ->implode('');

                                    $role = $user->getRoleNames()->first();

                                @endphp

                                <tr class="hover:bg-sky-50 transition">

                                    <!-- Photo -->

                                    <td class="px-6 py-4">

                                        @if ($user->image)
                                            <img src="{{ asset('storage/' . $user->image) }}"
                                                class="h-11 w-11 rounded-full object-cover border border-gray-200">
                                        @else
                                            <div
                                                class="h-11 w-11 rounded-full bg-sky-100 text-sky-700 flex items-center justify-center font-bold">

                                                {{ $initials }}

                                            </div>
                                        @endif

                                    </td>

                                    <!-- Staff ID -->

                                    <td class="px-6 py-4 font-medium text-gray-700">

                                        {{ $user->registration_id }}

                                    </td>

                                    <!-- Name -->

                                    <td class="px-6 py-4">

                                        <div class="font-semibold text-gray-800">

                                            {{ $user->name }}

                                        </div>

                                    </td>

                                    <!-- Email -->

                                    <td class="px-6 py-4 text-gray-600">

                                        {{ $user->email }}

                                    </td>

                                    <!-- Role -->

                                    <td class="px-6 py-4 text-center">

                                        @if ($role)
                                            <span
                                                class="inline-flex px-3 py-1 rounded-full bg-sky-100 text-sky-700 text-xs font-semibold">

                                                {{ $role }}

                                            </span>
                                        @else
                                            <span
                                                class="inline-flex px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                                No Role Assign!

                                            </span>
                                        @endif

                                    </td>

                                    <!-- Status -->

                                    <td class="px-6 py-4 text-center">

                                        @if ($user->status == 'active')
                                            <span
                                                class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">

                                                Active

                                            </span>
                                        @elseif($user->status == 'inactive')
                                            <span
                                                class="px-3 py-1 rounded-full bg-yellow-100 text-yellow-700 text-xs font-semibold">

                                                Inactive

                                            </span>
                                        @else
                                            <span
                                                class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">

                                                Suspended

                                            </span>
                                        @endif

                                    </td>

                                    <!-- Last Login -->

                                    <td class="px-6 py-4 text-center text-gray-500 text-sm">

                                        {{ $user->last_login_at ? $user->last_login_at->diffForHumans() : 'Never' }}

                                    </td>

                                    <!-- Joined -->

                                    <td class="px-6 py-4 text-center text-gray-500 text-sm">

                                        {{ $user->created_at->format('d M Y') }}

                                    </td>

                                    <!-- Actions -->

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <!-- View -->
                                            <button onclick="openViewModal({{ $user->id }})" title="View User"
                                                class="h-9 w-9 rounded-lg bg-sky-100 text-sky-700 hover:bg-sky-700 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm">
                                                <i class="fas fa-eye"></i>
                                            </button>

                                            <!-- Edit -->
                                            <button onclick="openEditModal({{ $user->id }})" title="Edit User"
                                                class="h-9 w-9 rounded-lg bg-amber-100 text-amber-700 hover:bg-amber-700 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm">
                                                <i class="fas fa-edit"></i>
                                            </button>

                                            <!-- Delete -->
                                            <button onclick="openDeleteModal({{ $user->id }}, '{{ $user->name }}')"
                                                title="Delete User"
                                                class="h-9 w-9 rounded-lg bg-red-100 text-red-700 hover:bg-red-700 hover:text-white transition-all duration-200 flex items-center justify-center shadow-sm">
                                                <i class="fas fa-trash"></i>
                                            </button>

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="9" class="text-center py-16">

                                        <i class="fas fa-users text-5xl text-gray-300 mb-3"></i>

                                        <p class="text-gray-500">

                                            No staff accounts found.

                                        </p>

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="bg-gray-50 px-6 py-4 border-t">

                    {{ $users->links() }}

                </div>

            </div>
        </div>

        <!-- Add User Modal -->
        <div id="createUserModal"
            class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">
            <div class="relative top-4 md:top-8 mx-auto w-full max-w-4xl px-3 pb-8">
                <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden">

                    <!-- Modal Header: institute-style letterhead band -->
                    <div class="relative bg-[#155E8A]  px-6 pt-5 pb-6">
                        <!-- thin institutional rule under the header -->
                        <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                        @php
                            $sgModalSchool = auth()->user()->school;
                        @endphp

                        <div class="flex items-start justify-between">
                            <div class="flex items-center gap-3">
                                <div
                                    class="h-11 w-11 rounded-full bg-white/10 border border-white/25 flex items-center justify-center shrink-0 overflow-hidden p-1.5">
                                    @if ($sgModalSchool && $sgModalSchool->logo)
                                        <img src="{{ asset('storage/' . $sgModalSchool->logo) }}"
                                            alt="{{ $sgModalSchool->school_name }}" class="h-full w-full object-contain">
                                    @else
                                        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                            alt="LIPA Logo" class="h-full w-full object-contain">
                                    @endif
                                </div>
                                <div>
                                    <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                                        {{ $sgModalSchool->school_name ?? 'Liberia Institute of Public Administration' }}
                                    </p>
                                    <h3 class="text-white text-lg font-bold leading-tight mt-0.5">
                                        Staff Account Registration
                                    </h3>
                                </div>
                            </div>

                            <button type="button" onclick="closeCreateUserModal()"
                                class="text-sky-100 hover:text-white hover:bg-white/10 transition-colors p-2 rounded-lg -mt-1 -mr-1">
                                <i class="fas fa-times text-sm"></i>
                            </button>
                        </div>
                    </div>

                    <!-- Modal Body -->
                    <div class="p-6 max-h-[75vh] overflow-y-auto bg-[#F8FAFC]">

                        <!-- Institutional Notice -->
                        <div class="flex items-start gap-3 bg-sky-50 border border-sky-100 rounded-xl px-4 py-3 mb-5">
                            <i class="fas fa-circle-info text-[#0F4C81] mt-0.5"></i>
                            <p class="text-xs text-slate-600 leading-relaxed">
                                <span class="font-semibold text-slate-700">Staff Account Registration.</span>
                                Complete the information below to create a new staff account. A unique Staff ID
                                will automatically be generated after successful registration.
                            </p>
                        </div>

                        <form method="POST" action="{{ route('admin.access-control.users.store') }}"
                            enctype="multipart/form-data" id="registrationForm" class="space-y-5">
                            @csrf

                            <!-- Section: Staff Photograph -->
                            <div class="bg-white rounded-xl border border-[#E2E8F0] p-4">
                                <div class="flex items-center gap-4">
                                    <div class="relative shrink-0">
                                        <img id="image-preview" src="{{ asset('images/default-avatar.png') }}"
                                            class="h-16 w-16 rounded-full object-cover border-2 border-sky-100 shadow-sm">
                                        <div
                                            class="absolute -bottom-1 -right-1 bg-[#0F4C81] rounded-full p-1.5 ring-2 ring-white">
                                            <i class="fas fa-camera text-white text-[10px]"></i>
                                        </div>
                                    </div>
                                    <div class="flex-1">
                                        <p class="text-sm font-semibold text-slate-700 mb-1">Staff Photograph</p>
                                        <label class="file-upload block">
                                            <input type="file" id="image" name="image" accept="image/*"
                                                class="hidden">
                                            <div
                                                class="file-upload-label border-2 border-dashed border-slate-300 rounded-lg px-3 py-2.5 text-center cursor-pointer hover:border-[#0F4C81] hover:bg-sky-50/50 transition-colors">
                                                <p class="text-xs font-medium text-slate-600">Click to upload photo</p>
                                                <p class="text-[10px] text-slate-400 mt-0.5">Passport size (JPG/PNG), up to
                                                    2MB</p>
                                            </div>
                                        </label>
                                        @error('image')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Personal Information -->
                            <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 pt-4 pb-1">
                                    <span class="h-4 w-1 rounded-full bg-[#0F4C81]"></span>
                                    <p class="text-xs font-bold uppercase tracking-wide text-[#0F4C81]">Personal
                                        Information</p>
                                </div>

                                <div class="p-4 pt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Name -->
                                    <div>
                                        <label for="name" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                            Full Name <span class="text-[#B91C1C]">*</span>
                                        </label>
                                        <input type="text" id="name" name="name" value="{{ old('name') }}"
                                            required
                                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0F4C81]/30 focus:border-[#0F4C81] text-sm text-slate-700 placeholder-slate-400 transition-shadow"
                                            placeholder="John Doe">
                                        @error('name')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Email -->
                                    <div>
                                        <label for="email" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                            Email Address <span class="text-[#B91C1C]">*</span>
                                        </label>
                                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                                            required
                                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0F4C81]/30 focus:border-[#0F4C81] text-sm text-slate-700 placeholder-slate-400 transition-shadow"
                                            placeholder="user@example.com">
                                        @error('email')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                    </div>

                                    <!-- Staff ID (readonly, auto-generated) -->
                                    <div>
                                        <label for="registration_id"
                                            class="block text-xs font-semibold text-slate-600 mb-1.5">
                                            Staff ID
                                        </label>
                                        <input type="text" id="registration_id" name="registration_id"
                                            value="{{ old('registration_id') }}" readonly
                                            placeholder="Generated automatically on save"
                                            class="w-full px-3 py-2 rounded-lg border border-slate-200 bg-slate-100 text-sm text-slate-500 placeholder-slate-400 font-mono cursor-not-allowed">
                                        @error('registration_id')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-[10px] text-slate-400">
                                            <i class="fas fa-lock text-[9px] mr-0.5"></i>Automatically generated, e.g.
                                            LIPA/2026/0001
                                        </p>
                                    </div>

                                    <!-- Role Selection -->
                                    <!-- Assign Role -->
                                    <div>
                                        <label for="role" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                            Assign System Role
                                            <span class="text-[#B91C1C]">*</span>
                                        </label>

                                        <div class="relative">
                                            <select id="role" name="role" required
                                                class="w-full appearance-none px-3 py-2 pr-9 rounded-lg border border-slate-300
                   focus:ring-2 focus:ring-[#0F4C81]/30
                   focus:border-[#0F4C81]
                   text-sm text-slate-700 bg-white transition-shadow">

                                                <option value="">Select System Role</option>

                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}"
                                                        {{ old('role') == $role->name ? 'selected' : '' }}>
                                                        {{ $role->name }}
                                                    </option>
                                                @endforeach

                                            </select>

                                            <i
                                                class="fas fa-chevron-down text-slate-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                            </i>
                                        </div>

                                        <p class="mt-1 text-[11px] text-slate-500">
                                            Select the access role this staff member will use in the system.
                                        </p>

                                        @error('role')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">
                                                {{ $message }}
                                            </p>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <!-- Section: Login Credentials -->
                            <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">
                                <div class="flex items-center gap-2 px-4 pt-4 pb-1">
                                    <span class="h-4 w-1 rounded-full bg-[#B91C1C]"></span>
                                    <p class="text-xs font-bold uppercase tracking-wide text-[#B91C1C]">Login Credentials
                                    </p>
                                </div>

                                <div class="p-4 pt-3 grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <!-- Password -->
                                    <div>
                                        <label for="password" class="block text-xs font-semibold text-slate-600 mb-1.5">
                                            Password <span class="text-[#B91C1C]">*</span>
                                        </label>
                                        <input type="password" id="password" name="password" required
                                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0F4C81]/30 focus:border-[#0F4C81] text-sm text-slate-700 placeholder-slate-400 transition-shadow"
                                            placeholder="••••••">
                                        @error('password')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                        <p class="mt-1 text-[10px] text-slate-400">Enter a password for this account.</p>
                                    </div>

                                    <!-- Confirm Password -->
                                    <div>
                                        <label for="password_confirmation"
                                            class="block text-xs font-semibold text-slate-600 mb-1.5">
                                            Confirm Password <span class="text-[#B91C1C]">*</span>
                                        </label>
                                        <input type="password" id="password_confirmation" name="password_confirmation"
                                            required
                                            class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:ring-2 focus:ring-[#0F4C81]/30 focus:border-[#0F4C81] text-sm text-slate-700 placeholder-slate-400 transition-shadow"
                                            placeholder="••••••">
                                        @error('password_confirmation')
                                            <p class="mt-1 text-xs text-[#B91C1C] font-medium">{{ $message }}</p>
                                        @enderror
                                        <p id="passwordMatchMessage" class="mt-1 text-xs hidden"></p>
                                    </div>
                                </div>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex flex-col sm:flex-row justify-end gap-2 pt-1">
                                <button type="button" onclick="closeCreateUserModal()"
                                    class="px-4 py-2.5 border border-slate-300 text-slate-600 font-medium rounded-lg hover:bg-slate-100 transition-colors text-sm">
                                    Cancel
                                </button>
                                <button type="submit"
                                    class="px-5 py-2.5 bg-[#0F4C81] hover:bg-[#0A3C67] text-white font-semibold rounded-lg transition-colors text-sm flex items-center justify-center gap-2 shadow-sm">
                                    <i class="fas fa-user-plus text-xs"></i> Register Staff
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Delete Confirmation Modal -->
        <div id="deleteUserModal" class="fixed inset-0 bg-blue-900/60 backdrop-blur-sm z-50 hidden">

            <div class="fixed inset-0 flex items-center justify-center p-3">
                <div class="bg-white w-full max-w-sm rounded-xl shadow-xl border border-red-100">

                    <!-- Header -->
                    <div
                        class="flex items-center justify-between px-4 py-3 bg-gradient-to-r from-red-600 to-red-700 rounded-t-xl">
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
                        <button type="button" onclick="closeDeleteModal()"
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
        <!-- ========================================= -->
        <!-- EDIT STAFF MODAL -->
        <!-- ========================================= -->

        <div id="editUserModal"
            class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm overflow-y-auto h-full w-full z-50 hidden">

            <div class="relative top-4 md:top-8 mx-auto w-full max-w-2xl px-3 pb-8">

                <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden">

                    <!-- Header -->
                    <div class="relative bg-[#155E8A] px-5 sm:px-6 pt-5 pb-6">

                        <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                        @php
                            $sgEditModalSchool = auth()->user()->school;
                        @endphp

                        <div class="flex items-start justify-between gap-3">

                            <div class="flex items-center gap-3 min-w-0">

                                <div
                                    class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/20 flex items-center justify-center overflow-hidden p-1.5">

                                    @if ($sgEditModalSchool && $sgEditModalSchool->logo)
                                        <img src="{{ asset('storage/' . $sgEditModalSchool->logo) }}"
                                            alt="{{ $sgEditModalSchool->school_name }}"
                                            class="h-full w-full object-contain">
                                    @else
                                        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                            alt="LIPA Logo" class="h-full w-full object-contain">
                                    @endif

                                </div>

                                <div class="min-w-0">

                                    <p
                                        class="text-[11px] uppercase tracking-[0.14em] text-blue-100 font-semibold truncate">

                                        {{ $sgEditModalSchool->school_name ?? 'Liberia Institute of Public Administration' }}

                                    </p>

                                    <h3 class="text-white text-base sm:text-lg font-bold leading-tight mt-0.5">

                                        Update Staff Account

                                    </h3>

                                </div>

                            </div>

                            <button type="button" onclick="closeEditModal()"
                                class="shrink-0 text-sky-100 hover:text-white hover:bg-white/10 rounded-lg p-2 transition-colors">

                                <i class="fas fa-times text-sm"></i>

                            </button>

                        </div>

                    </div>

                    <!-- Body -->

                    <div class="bg-[#F8FAFC] p-4 sm:p-6 max-h-[75vh] overflow-y-auto">

                        <form id="editUserForm" method="POST" enctype="multipart/form-data" class="space-y-5">

                            @csrf
                            @method('PUT')

                            <!-- Photo -->

                            <div class="bg-white rounded-xl border border-[#E2E8F0] p-4">

                                <div class="flex items-center gap-4">

                                    <div class="relative shrink-0">

                                        <img id="edit_image_preview" src="{{ asset('images/default-avatar.png') }}"
                                            class="h-16 w-16 rounded-full object-cover border-2 border-sky-100 shadow-sm">

                                        <div
                                            class="absolute -bottom-1 -right-1 bg-[#155E8A] rounded-full p-1.5 ring-2 ring-white">

                                            <i class="fas fa-camera text-white text-[10px]"></i>

                                        </div>

                                    </div>

                                    <div class="flex-1 min-w-0">

                                        <p class="text-sm font-semibold text-slate-700 mb-1">Staff Photograph</p>

                                        <label class="block">

                                            <input type="file" id="edit_image" name="image" accept="image/*"
                                                onchange="displayEditImagePreview(this)" class="hidden">

                                            <div
                                                class="border-2 border-dashed border-slate-300 rounded-lg px-3 py-2.5 text-center cursor-pointer hover:border-[#155E8A] hover:bg-sky-50/50 transition-colors">

                                                <p class="text-xs font-semibold text-slate-600">

                                                    Click to upload new photo

                                                </p>

                                                <p class="text-[10px] text-slate-400 mt-0.5">

                                                    JPG or PNG • Max 2MB

                                                </p>

                                            </div>

                                        </label>

                                    </div>

                                </div>

                            </div>

                            <!-- Account Details -->
                            <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

                                <div class="px-4 pt-4 pb-1 flex items-center gap-2">

                                    <span class="w-1 h-4 rounded-full bg-[#155E8A]"></span>

                                    <p class="text-xs font-bold uppercase tracking-wide text-[#155E8A]">

                                        Account Details

                                    </p>

                                </div>

                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 p-4 pt-3">

                                    <!-- Name -->

                                    <div>

                                        <label for="edit_name" class="block text-xs font-semibold text-slate-600 mb-1.5">

                                            Full Name

                                        </label>

                                        <input id="edit_name" name="name" type="text" required
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    </div>

                                    <!-- Email -->

                                    <div>

                                        <label for="edit_email" class="block text-xs font-semibold text-slate-600 mb-1.5">

                                            Email Address

                                        </label>

                                        <input id="edit_email" name="email" type="email" required
                                            class="w-full rounded-lg border border-slate-300 px-3 py-2 text-sm text-slate-700 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                    </div>

                                    <!-- Registration ID -->

                                    <div>

                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">

                                            Registration ID

                                        </label>

                                        <div id="edit_registration_id"
                                            class="w-full rounded-lg border border-slate-200 bg-slate-100 px-3 py-2 text-sm font-mono font-semibold text-slate-500">

                                            -

                                        </div>

                                    </div>

                                    <!-- Role -->

                                    <div>

                                        <label for="edit_role" class="block text-xs font-semibold text-slate-600 mb-1.5">

                                            Assigned Role

                                        </label>

                                        <div class="relative">

                                            <select id="edit_role" name="role" required
                                                class="w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 pr-9 text-sm text-slate-700 bg-white focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->name }}">

                                                        {{ $role->name }}

                                                    </option>
                                                @endforeach

                                            </select>

                                            <i
                                                class="fas fa-chevron-down text-slate-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>

                                        </div>

                                    </div>

                                    <!-- Status -->

                                    <div>

                                        <label for="edit_status"
                                            class="block text-xs font-semibold text-slate-600 mb-1.5">

                                            Account Status

                                        </label>

                                        <div class="relative">

                                            <select id="edit_status" name="status" required
                                                class="w-full appearance-none rounded-lg border border-slate-300 px-3 py-2 pr-9 text-sm text-slate-700 bg-white focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                                                <option value="active">

                                                    Active

                                                </option>

                                                <option value="inactive">

                                                    Inactive

                                                </option>

                                                <option value="suspended">

                                                    Suspended

                                                </option>

                                            </select>

                                            <i
                                                class="fas fa-chevron-down text-slate-400 text-xs absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>

                                        </div>

                                    </div>

                                    <!-- Verification -->

                                    <div>

                                        <label class="block text-xs font-semibold text-slate-600 mb-1.5">

                                            Email Verification

                                        </label>

                                        <div id="verificationBadge"
                                            class="inline-flex px-3 py-1 rounded-full text-xs font-semibold">

                                        </div>

                                    </div>

                                </div>

                            </div>

                            <!-- Footer -->

                            <div class="flex flex-col-reverse sm:flex-row justify-end gap-2 pt-1">

                                <button type="button" onclick="closeEditModal()"
                                    class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium hover:bg-slate-100 transition-colors text-sm">

                                    Cancel

                                </button>

                                <button type="submit"
                                    class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold transition-colors text-sm flex items-center justify-center gap-2 shadow-sm">

                                    <i class="fas fa-save text-xs"></i>

                                    Save Changes

                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>
        <!-- ==========================================
                                                         VIEW USER MODAL
                                                    =========================================== -->
        <div id="viewUserModal"
            class="fixed inset-0 hidden z-50 bg-slate-900/70 backdrop-blur-sm flex items-center justify-center px-3 sm:px-4 py-6 overflow-y-auto">

            <div class="w-full max-w-4xl bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden">

                <!-- Header -->
                <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5">

                    <div class="absolute bottom-0 left-0 right-0 h-1 bg-[#B91C1C]"></div>

                    @php
                        $sgViewModalSchool = auth()->user()->school;
                    @endphp

                    <div class="flex items-start justify-between gap-3">

                        <div class="flex items-center gap-3 min-w-0">

                            <div
                                class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                                @if ($sgViewModalSchool && $sgViewModalSchool->logo)
                                    <img src="{{ asset('storage/' . $sgViewModalSchool->logo) }}"
                                        alt="{{ $sgViewModalSchool->school_name }}" class="h-full w-full object-contain">
                                @else
                                    <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                        alt="LIPA Logo" class="h-full w-full object-contain">
                                @endif
                            </div>

                            <div class="min-w-0">
                                <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold truncate">
                                    {{ $sgViewModalSchool->school_name ?? 'Liberia Institute of Public Administration' }}
                                </p>
                                <h2 class="text-white text-base sm:text-xl font-bold leading-tight mt-0.5">
                                    Staff Account Details
                                </h2>
                            </div>

                        </div>

                        <button onclick="closeViewModal()"
                            class="shrink-0 h-9 w-9 sm:h-10 sm:w-10 rounded-lg bg-white/10 hover:bg-red-600 text-white transition-colors flex items-center justify-center">
                            <i class="fas fa-times text-sm"></i>
                        </button>

                    </div>

                </div>

                <!-- Body -->
                <div class="p-4 sm:p-6 bg-[#F8FAFC] max-h-[80vh] overflow-y-auto">

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-5 sm:gap-6">

                        <!-- ================================= -->
                        <!-- PROFILE -->
                        <!-- ================================= -->

                        <div class="bg-white rounded-xl border border-[#E2E8F0] p-6 text-center h-fit">

                            <img id="view_image" src="{{ asset('images/default-avatar.png') }}"
                                class="h-28 w-28 rounded-full object-cover border-4 border-sky-100 shadow-sm mx-auto">

                            <h3 id="view_name" class="mt-4 text-lg font-bold text-slate-800"></h3>

                            <p id="view_registration_id" class="text-sm text-slate-500 mt-1 font-mono"></p>

                            <div class="mt-4 flex items-center justify-center">
                                <span id="view_role_badge"
                                    class="inline-flex px-3 py-1 rounded-full text-xs font-semibold bg-sky-100 text-sky-700">
                                </span>
                            </div>

                            <div class="mt-3 flex items-center justify-center">
                                <span id="view_status" class="inline-flex px-3 py-1 rounded-full text-xs font-semibold">
                                </span>
                            </div>

                        </div>

                        <!-- ================================= -->
                        <!-- DETAILS -->
                        <!-- ================================= -->

                        <div class="lg:col-span-2 space-y-5">

                            <!-- Personal -->

                            <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

                                <div class="px-4 sm:px-5 pt-4 pb-1 flex items-center gap-2">
                                    <span class="h-4 w-1 rounded-full bg-[#155E8A]"></span>
                                    <h4 class="text-xs font-bold uppercase tracking-wide text-[#155E8A]">
                                        Personal Information
                                    </h4>
                                </div>

                                <div class="p-4 sm:p-5 pt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                                    <div>
                                        <label class="text-xs text-slate-500">Full Name</label>
                                        <p id="view_name2" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Email Address</label>
                                        <p id="view_email" class="font-semibold text-slate-800 break-all mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Registration ID</label>
                                        <p id="view_registration_id2"
                                            class="font-semibold text-slate-800 font-mono mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Assigned Role</label>
                                        <p id="view_role" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                </div>

                            </div>

                            <!-- Account -->

                            <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

                                <div class="px-4 sm:px-5 pt-4 pb-1 flex items-center gap-2">
                                    <span class="h-4 w-1 rounded-full bg-[#155E8A]"></span>
                                    <h4 class="text-xs font-bold uppercase tracking-wide text-[#155E8A]">
                                        Account Information
                                    </h4>
                                </div>

                                <div class="p-4 sm:p-5 pt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                                    <div>
                                        <label class="text-xs text-slate-500">User ID</label>
                                        <p id="view_user_id" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Email Verified</label>
                                        <p id="view_email_verified" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Created On</label>
                                        <p id="view_created_at" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Updated On</label>
                                        <p id="view_updated_at" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Last Login</label>
                                        <p id="view_last_login" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                </div>

                            </div>

                            <!-- Audit -->

                            <div class="bg-white rounded-xl border border-[#E2E8F0] overflow-hidden">

                                <div class="px-4 sm:px-5 pt-4 pb-1 flex items-center gap-2">
                                    <span class="h-4 w-1 rounded-full bg-[#B91C1C]"></span>
                                    <h4 class="text-xs font-bold uppercase tracking-wide text-[#B91C1C]">
                                        Audit Trail
                                    </h4>
                                </div>

                                <div class="p-4 sm:p-5 pt-3 grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">

                                    <div>
                                        <label class="text-xs text-slate-500">Created By</label>
                                        <p id="view_created_by" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Creator Registration ID</label>
                                        <p id="view_created_by_id" class="font-semibold text-slate-800 font-mono mt-0.5">
                                        </p>
                                    </div>

                                    <div>
                                        <label class="text-xs text-slate-500">Creator Role</label>
                                        <p id="view_created_by_role" class="font-semibold text-slate-800 mt-0.5"></p>
                                    </div>

                                </div>

                            </div>

                            <!-- Buttons -->

                            <div class="flex flex-col sm:flex-row justify-end gap-2 pt-2">

                                <button onclick="switchToEditFromView()"
                                    class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-edit text-xs"></i>
                                    Edit User
                                </button>

                                <button id="view_delete_btn"
                                    class="px-5 py-2.5 rounded-lg bg-[#B91C1C] hover:bg-red-800 text-white font-semibold text-sm transition-colors flex items-center justify-center gap-2">
                                    <i class="fas fa-trash text-xs"></i>
                                    Delete User
                                </button>

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
                                    return {
                                        success: true
                                    };
                                }

                                // Try to parse as JSON, if fails assume success
                                return response.text().then(text => {
                                    try {
                                        return JSON.parse(text);
                                    } catch (e) {
                                        // If it's not JSON but we got here, assume success
                                        return {
                                            success: true
                                        };
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

                                console.error(error);

                                submitButton.innerHTML = originalText;
                                submitButton.disabled = false;

                                // Show actual Laravel validation/server error
                                showErrorMessage(error.message);

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
                document.getElementById('deleteUserForm').action = `/admin/access-control/users/${userId}`;

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
                            return {
                                success: true
                            };
                        }

                        // Try to parse as JSON, if fails assume success
                        return response.text().then(text => {
                            try {
                                return JSON.parse(text);
                            } catch (e) {
                                // If it's not JSON but we got here, assume success
                                return {
                                    success: true
                                };
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


            // ======================================================
            // EDIT USER MODAL
            // ======================================================

            function openEditModal(userId) {

                console.log("Loading user:", userId);

                showInfoMessage("Loading user data...");

                fetch(`/admin/access-control/users/${userId}`, {

                        method: "GET",

                        headers: {

                            "Accept": "application/json",

                            "X-Requested-With": "XMLHttpRequest"

                        }

                    })

                    .then(response => {

                        if (!response.ok) {
                            throw new Error(`HTTP ${response.status}`);
                        }

                        return response.json();

                    })

                    .then(data => {

                        console.log(data);

                        if (!data.success) {
                            throw new Error(data.message ?? "Unable to load user.");
                        }

                        const user = data.user;

                        // ----------------------------
                        // Populate Form
                        // ----------------------------

                        document.getElementById("edit_name").value = user.name ?? "";

                        document.getElementById("edit_email").value = user.email ?? "";

                        const registration = document.getElementById("edit_registration_id");

                        if (registration) {
                            registration.textContent = user.registration_id ?? "-";
                        }

                        document.getElementById("edit_role").value = user.role ?? "";

                        if (document.getElementById("edit_status")) {

                            document.getElementById("edit_status").value = user.status ?? "active";

                        }

                        // ----------------------------
                        // Form Action
                        // ----------------------------

                        document.getElementById("editUserForm").action =
                            `/admin/access-control/users/${user.id}`;

                        // ----------------------------
                        // Image
                        // ----------------------------

                        const preview = document.getElementById("edit_image_preview");

                        const currentImageContainer = document.getElementById("currentImageContainer");

                        const currentImageText = document.getElementById("currentImageText");

                        if (preview) {

                            if (user.image && user.image_exists) {

                                preview.src = `/storage/${user.image}?${Date.now()}`;

                            } else {

                                preview.src = "{{ asset('images/default-avatar.png') }}";

                            }

                        }

                        if (currentImageContainer) {

                            currentImageContainer.classList.remove("hidden");

                        }

                        if (currentImageText) {

                            currentImageText.innerHTML = user.image && user.image_exists ?
                                "Current profile photo" :
                                "No profile photo uploaded.";

                        }

                        // ----------------------------
                        // Show Modal
                        // ----------------------------

                        const modal = document.getElementById("editUserModal");

                        if (modal) {

                            modal.classList.remove("hidden");

                        }

                    })

                    .catch(error => {

                        console.error(error);

                        showErrorMessage(error.message);

                    });

            }
            // ======================================================
            // CLOSE MODAL
            // ======================================================

            function closeEditModal() {

                const modal = document.getElementById("editUserModal");

                if (modal) {

                    modal.classList.add("hidden");

                }

                resetEditForm();

            }
            // ======================================================
            // IMAGE PREVIEW
            // ======================================================

            function displayEditImagePreview(input) {

                if (!input.files.length) return;

                const preview = document.getElementById("edit_image_preview");

                const currentImageContainer = document.getElementById("currentImageContainer");

                const currentImageText = document.getElementById("currentImageText");

                preview.src = URL.createObjectURL(input.files[0]);

                if (currentImageContainer) {

                    currentImageContainer.classList.remove("hidden");

                }

                if (currentImageText) {

                    currentImageText.innerHTML = "New image selected.";

                }

            }
            // ======================================================
            // RESET FORM
            // ======================================================

            function resetEditForm() {

                const form = document.getElementById("editUserForm");

                if (form) {

                    form.reset();

                }

            }
            // ======================================================
            // AJAX UPDATE
            // ======================================================

            const editForm = document.getElementById("editUserForm");

            if (editForm) {

                editForm.addEventListener("submit", function(e) {

                    e.preventDefault();

                    const submitButton = this.querySelector("button[type='submit']");

                    const originalText = submitButton.innerHTML;

                    submitButton.disabled = true;

                    submitButton.innerHTML =
                        '<i class="fas fa-spinner fa-spin mr-2"></i> Updating...';

                    const formData = new FormData(this);


                    fetch(this.action, {

                            method: "POST",

                            body: formData,

                            headers: {

                                "Accept": "application/json",

                                "X-Requested-With": "XMLHttpRequest",

                                "X-CSRF-TOKEN": document.querySelector('input[name="_token"]').value

                            }

                        })

                        .then(async response => {

                            const data = await response.json();

                            if (!response.ok) {

                                throw new Error(data.message || "Update failed.");

                            }

                            return data;

                        })

                        .then(data => {

                            closeEditModal();

                            showSuccessMessage(data.message ?? "User updated successfully.");

                            setTimeout(() => {

                                location.reload();

                            }, 1200);

                        })

                        .catch(error => {

                            console.error(error);

                            showErrorMessage(error.message);

                            submitButton.disabled = false;

                            submitButton.innerHTML = originalText;

                        });

                });

            }

            // ======================================================
            // VIEW USER MODAL
            // ======================================================

            let currentViewUserId = null;

            function openViewModal(userId) {

                currentViewUserId = userId;

                showInfoMessage('Loading user details...');

                fetch(`/admin/access-control/users/${userId}`, {

                        method: 'GET',

                        headers: {

                            'X-Requested-With': 'XMLHttpRequest',

                            'Accept': 'application/json'

                        }

                    })

                    .then(response => {

                        if (!response.ok) {

                            throw new Error('Unable to load user.');

                        }

                        return response.json();

                    })

                    .then(data => {

                        if (!data.success) {

                            throw new Error(data.message);

                        }

                        populateViewModal(data.user);

                    })

                    .catch(error => {

                        console.error(error);

                        showErrorMessage(error.message);

                    });

            }

            function populateViewModal(user) {

                //----------------------------------------------------
                // PERSONAL
                //----------------------------------------------------

                document.getElementById('view_name').textContent = user.name ?? '-';

                document.getElementById('view_name2').textContent = user.name ?? '-';

                document.getElementById('view_email').textContent = user.email ?? '-';

                document.getElementById('view_registration_id').textContent = user.registration_id ?? '-';

                document.getElementById('view_registration_id2').textContent = user.registration_id ?? '-';

                document.getElementById('view_role').textContent = user.role ?? '-';

                //----------------------------------------------------
                // ROLE BADGE
                //----------------------------------------------------

                const roleBadge = document.getElementById('view_role_badge');

                roleBadge.className =
                    'inline-flex px-3 py-1 rounded-full text-xs font-semibold';

                switch ((user.role || '').toLowerCase()) {

                    case 'administrator':

                    case 'admin':

                        roleBadge.classList.add('bg-red-100', 'text-red-700');

                        break;

                    case 'teacher':

                    case 'instructor':

                        roleBadge.classList.add('bg-blue-100', 'text-blue-700');

                        break;

                    case 'student':

                        roleBadge.classList.add('bg-green-100', 'text-green-700');

                        break;

                    default:

                        roleBadge.classList.add('bg-slate-100', 'text-slate-700');

                }

                roleBadge.textContent = user.role ?? '-';



                //----------------------------------------------------
                // STATUS BADGE
                //----------------------------------------------------

                const statusBadge = document.getElementById('view_status');

                statusBadge.className =
                    'inline-flex px-3 py-1 rounded-full text-xs font-semibold';

                switch ((user.status || '').toLowerCase()) {

                    case 'active':

                        statusBadge.classList.add('bg-green-100', 'text-green-700');

                        break;

                    case 'inactive':

                        statusBadge.classList.add('bg-yellow-100', 'text-yellow-700');

                        break;

                    case 'suspended':

                        statusBadge.classList.add('bg-red-100', 'text-red-700');

                        break;

                    default:

                        statusBadge.classList.add('bg-slate-100', 'text-slate-700');

                }

                statusBadge.textContent = user.status ?? '-';



                //----------------------------------------------------
                // ACCOUNT INFO
                //----------------------------------------------------

                document.getElementById('view_user_id').textContent =
                    user.registration_id ?? '-';

                document.getElementById('view_created_at').textContent =
                    user.created_at ?? '-';

                document.getElementById('view_updated_at').textContent =
                    user.updated_at ?? '-';

                document.getElementById('view_last_login').textContent =
                    user.last_login ?? 'Never';



                //----------------------------------------------------
                // EMAIL VERIFIED
                //----------------------------------------------------

                document.getElementById('view_email_verified').innerHTML =
                    user.email_verified_at ?
                    '<span class="px-3 py-1 rounded-full bg-green-100 text-green-700 text-xs font-semibold">Verified</span>' :
                    '<span class="px-3 py-1 rounded-full bg-red-100 text-red-700 text-xs font-semibold">Not Verified</span>';

                //----------------------------------------------------
                // AUDIT TRAIL
                //----------------------------------------------------

                document.getElementById('view_created_by').textContent =
                    user.created_by ?? '-';

                document.getElementById('view_created_by_id').textContent =
                    user.created_by_registration_id ?? '-';

                document.getElementById('view_created_by_role').textContent =
                    user.created_by_role ?? '-';



                //----------------------------------------------------
                // PROFILE IMAGE
                //----------------------------------------------------

                const image = document.getElementById('view_image');

                if (user.image_exists) {

                    image.src = `/storage/${user.image}?${Date.now()}`;

                } else {

                    image.src = "{{ asset('images/default-avatar.png') }}";

                }



                //----------------------------------------------------
                // DELETE BUTTON
                //----------------------------------------------------

                document.getElementById('view_delete_btn').onclick = function() {

                    closeViewModal();

                    setTimeout(function() {

                        openDeleteModal(user.id, user.name);

                    }, 250);

                };



                //----------------------------------------------------
                // SHOW MODAL
                //----------------------------------------------------

                document.getElementById('viewUserModal').classList.remove('hidden');

                document.body.style.overflow = 'hidden';

            }



            function closeViewModal() {

                document.getElementById('viewUserModal').classList.add('hidden');

                document.body.style.overflow = 'auto';

            }



            function switchToEditFromView() {

                if (!currentViewUserId) {

                    showErrorMessage('Unable to determine selected user.');

                    return;

                }

                closeViewModal();

                setTimeout(() => {

                    openEditModal(currentViewUserId);

                }, 200);

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

                notification.className =
                    `fixed top-4 right-4 z-50 transform translate-x-full opacity-0 transition-all duration-500 ease-in-out ${styles[type]} text-white p-4 rounded-xl shadow-2xl max-w-sm min-w-80 backdrop-blur-sm border-l-4`;

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
            document.addEventListener("DOMContentLoaded", function() {

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
