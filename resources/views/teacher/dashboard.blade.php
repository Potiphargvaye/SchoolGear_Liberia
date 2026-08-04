@extends('layouts.teacher')

@section('title', 'Teacher Dashboard - WKG')

@section('content')
<!-- Welcome Header -->
<div class="welcome-banner bg-gradient-to-r from-blue-600 to-purple-700 rounded-xl shadow-lg overflow-hidden mb-8">
    <div class="flex flex-col md:flex-row items-center justify-between p-6 md:p-8">
        <div class="flex items-center mb-4 md:mb-0">
            <div class="teacher-avatar mr-5">
                @if(Auth::user()->image)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" class="w-16 h-16 md:w-20 md:h-20 rounded-full object-cover border-4 border-white/30 shadow-md">
                @else
                    <div class="w-16 h-16 md:w-20 md:h-20 rounded-full bg-white/20 flex items-center justify-center border-4 border-white/30 shadow-md">
                        <span class="text-white text-2xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
            </div>
            <div class="text-white">
                <h1 class="text-2xl md:text-3xl font-bold mb-1">Teacher Dashboard</h1>
                <p class="text-blue-100 text-lg">Welcome, {{ Auth::user()->name }}!</p>
            </div>
        </div>
        <div class="teacher-status bg-white/20 py-2 px-4 rounded-full">
            <span class="text-white text-sm flex items-center">
                <span class="w-3 h-3 bg-green-400 rounded-full mr-2 animate-pulse"></span>
                Teaching Status: Active
            </span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <!-- Teacher Info Card -->
    <div class="bg-white shadow rounded-lg p-6 border border-blue-100 lg:col-span-1">
        <div class="flex flex-col items-center text-center">
            <!-- Teacher Image -->
            <div class="relative mb-4">
                @if(Auth::user()->image)
                    <img src="{{ asset('storage/' . Auth::user()->image) }}" alt="{{ Auth::user()->name }}" 
                         class="w-32 h-32 rounded-full object-cover border-4 border-blue-100 shadow-md">
                @else
                    <div class="w-32 h-32 rounded-full bg-blue-100 flex items-center justify-center border-4 border-blue-200 shadow-md">
                        <span class="text-blue-600 text-4xl font-bold">{{ substr(Auth::user()->name, 0, 1) }}</span>
                    </div>
                @endif
                <div class="absolute bottom-0 right-0 bg-green-500 rounded-full p-1 border-2 border-white">
                    <i class="fas fa-check text-white text-xs"></i>
                </div>
            </div>

            <!-- Teacher Info -->
            <h2 class="text-xl font-bold text-gray-800 mb-2">{{ Auth::user()->name }}</h2>
            <p class="text-sm text-gray-600 mb-1"><i class="fas fa-id-card text-blue-500 mr-2"></i> ID: {{ Auth::user()->registration_id ?? 'N/A' }}</p>
            <p class="text-sm text-gray-600 mb-1"><i class="fas fa-envelope text-blue-500 mr-2"></i> {{ Auth::user()->email }}</p>
            <p class="text-sm text-gray-600 mb-3"><i class="fas fa-user-tag text-blue-500 mr-2"></i> {{ ucfirst(Auth::user()->role) }}</p>
            
            
            
            <button class="bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-lg text-sm transition duration-200 flex items-center">
                <i class="fas fa-edit mr-2"></i> Edit Profile
            </button>
        </div>
    </div>

    <!-- Teaching Stats -->
    <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
        <!-- Classes Card -->
        
        <div class="lg:col-span-2 grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Classes Card -->
    <div class="stats-card bg-white rounded-xl p-6 shadow-md border-l-4 border-blue-500 hover-shock">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-blue-100 text-blue-600 mr-4">
                <i class="fas fa-chalkboard text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">Classes Assigned</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $classesAssigned }}</h3>
            </div>
        </div>
    </div>
    
    <!-- Students Card -->
    <div class="stats-card bg-white rounded-xl p-6 shadow-md border-l-4 border-green-500 hover-shock">
        <div class="flex items-center">
            <div class="p-3 rounded-full bg-green-100 text-green-600 mr-4">
                <i class="fas fa-user-graduate text-xl"></i>
            </div>
            <div>
                <p class="text-sm text-gray-600 font-medium">Total Students</p>
                <h3 class="text-2xl font-bold text-gray-800">{{ $totalStudents }}</h3>
            </div>
        </div>
    </div>
</div>
        
        <!-- Performance Card -->
        <div class="stats-card bg-white rounded-xl p-6 shadow-md border-l-4 border-red-500 hover-shock">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-red-100 text-red-600 mr-4">
                    <i class="fas fa-chart-line text-xl"></i>
                </div>
                <div>
                    <p class="text-sm text-gray-600 font-medium">Avg. Performance</p>
                    <h3 class="text-2xl font-bold text-gray-800">87%</h3>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Upcoming Classes Section -->
<div class="bg-white rounded-xl shadow-md overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-calendar-alt text-blue-500 mr-3"></i> Today's Classes Schedule
        </h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            <!-- Class 1 -->
            <div class="bg-blue-50 p-4 rounded-lg border border-blue-200">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-blue-800">Grade 10A - Mathematics</h3>
                    <span class="bg-blue-100 text-blue-700 text-xs px-2 py-1 rounded-full">08:00 - 09:30</span>
                </div>
                <p class="text-sm text-gray-600 mb-3">Algebra: Quadratic Equations</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500"><i class="fas fa-users mr-1"></i> 32 students</span>
                    <button class="bg-blue-600 hover:bg-blue-700 text-white text-xs py-1 px-3 rounded transition duration-200">View Class</button>
                </div>
            </div>
            
            <!-- Class 2 -->
            <div class="bg-green-50 p-4 rounded-lg border border-green-200">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-green-800">Grade 9B - Science</h3>
                    <span class="bg-green-100 text-green-700 text-xs px-2 py-1 rounded-full">10:00 - 11:30</span>
                </div>
                <p class="text-sm text-gray-600 mb-3">Physics: Newton's Laws</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500"><i class="fas fa-users mr-1"></i> 28 students</span>
                    <button class="bg-green-600 hover:bg-green-700 text-white text-xs py-1 px-3 rounded transition duration-200">View Class</button>
                </div>
            </div>
            
            <!-- Class 3 -->
            <div class="bg-purple-50 p-4 rounded-lg border border-purple-200">
                <div class="flex justify-between items-start mb-2">
                    <h3 class="font-semibold text-purple-800">Grade 11C - Mathematics</h3>
                    <span class="bg-purple-100 text-purple-700 text-xs px-2 py-1 rounded-full">13:00 - 14:30</span>
                </div>
                <p class="text-sm text-gray-600 mb-3">Calculus: Derivatives</p>
                <div class="flex justify-between items-center">
                    <span class="text-xs text-gray-500"><i class="fas fa-users mr-1"></i> 30 students</span>
                    <button class="bg-purple-600 hover:bg-purple-700 text-white text-xs py-1 px-3 rounded transition duration-200">View Class</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="bg-white rounded-xl shadow-md overflow-hidden">
    <div class="px-6 py-4 border-b border-gray-100">
        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
            <i class="fas fa-bolt text-yellow-500 mr-3"></i> Quick Actions
        </h2>
    </div>
    <div class="p-6">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('teacher.materials.index') }}" class="quick-action-btn bg-blue-100 hover:bg-blue-200 text-blue-700 p-4 rounded-lg text-center transition duration-200">
    <i class="fas fa-tasks text-2xl mb-2"></i>
    <p class="font-medium">Create Assignment And Notes</p>
</a>
            <a href="#" class="quick-action-btn bg-green-100 hover:bg-green-200 text-green-700 p-4 rounded-lg text-center transition duration-200">
                <i class="fas fa-clipboard-check text-2xl mb-2"></i>
                <p class="font-medium">Grade Assignments</p>
            </a>
            <a href="#" class="quick-action-btn bg-purple-100 hover:bg-purple-200 text-purple-700 p-4 rounded-lg text-center transition duration-200">
                <i class="fas fa-calendar-plus text-2xl mb-2"></i>
                <p class="font-medium">Schedule Class</p>
            </a>
            <a href="#" class="quick-action-btn bg-red-100 hover:bg-red-200 text-red-700 p-4 rounded-lg text-center transition duration-200">
                <i class="fas fa-chart-bar text-2xl mb-2"></i>
                <p class="font-medium">View Reports</p>
            </a>
        </div>
    </div>
</div>

<style>
    /* Welcome Banner Styles */
    .welcome-banner {
        background: linear-gradient(135deg, #4f46e5 0%, #7c3aed 100%);
        box-shadow: 0 10px 15px -3px rgba(79, 70, 229, 0.3), 0 4px 6px -2px rgba(79, 70, 229, 0.1);
    }
    
    /* Stats Card Hover Animation */
    .stats-card {
        transition: all 0.3s ease;
    }
    
    .hover-shock:hover {
        transform: translateY(-5px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        animation: shock 0.5s ease;
    }
    
    @keyframes shock {
        0% { transform: translateY(-5px); }
        25% { transform: translateY(-7px) rotate(1deg); }
        50% { transform: translateY(-5px) rotate(-1deg); }
        75% { transform: translateY(-7px) rotate(1deg); }
        100% { transform: translateY(-5px); }
    }
    
    /* Quick Action Button Styles */
    .quick-action-btn {
        transition: all 0.3s ease;
    }
    
    .quick-action-btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
    }
    
    /* Teacher avatar animation */
    .teacher-avatar img, .teacher-avatar div {
        transition: all 0.3s ease;
    }
    
    .teacher-avatar:hover img, .teacher-avatar:hover div {
        transform: scale(1.05);
        box-shadow: 0 0 0 4px rgba(255, 255, 255, 0.4);
    }
</style>
@endsection 















