<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard - EDMOL')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Favicon for various devices -->
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<meta name="apple-mobile-web-app-title" content="Edmol-MBHS Portal">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#28a745',
                        secondary: '#218838',
                        accent: '#17a2b8',
                        dark: '#343a40',
                        light: '#f8f9fa'
                    }
                }
            }
        }
    </script>
    <style>
        .sidebar {
            background: linear-gradient(180deg, #ec4909ff, #e7ac0aff);
        }
        
        .nav-item:hover, .nav-item.active {
            background: rgba(255,255,255,0.1);
            border-left: 4px solid white;
        }
        
        .stat-icon.classes {
            background: rgba(40, 167, 69, 0.1);
            color: #f73f07ff;
        }
        
        .stat-icon.students {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }
        
        .stat-icon.assignments {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .status.pending {
            background: rgba(255, 193, 7, 0.15);
            color: #ffc107;
        }
        
        .status.submitted {
            background: rgba(40, 167, 69, 0.15);
            color: #28a745;
        }
        
        .status.late {
            background: rgba(220, 53, 69, 0.15);
            color: #dc3545;
        }
        
        .action-btn.grade {
            background: rgba(40, 167, 69, 0.1);
            color: #28a745;
        }
        
        .action-btn.grade:hover {
            background: #28a745;
            color: white;
        }
        
        .action-btn.view {
            background: rgba(23, 162, 184, 0.1);
            color: #17a2b8;
        }
        
        .action-btn.view:hover {
            background: #17a2b8;
            color: white;
        }
        
        .action-btn.edit {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .action-btn.edit:hover {
            background: #ffc107;
            color: white;
        }
        
        .schedule-cell {
            transition: all 0.2s ease;
        }
        
        .schedule-cell:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        .grade-progress {
            height: 8px;
            border-radius: 4px;
        }
    </style>
    @stack('styles')
</head>
<body class="bg-gray-50 min-h-screen flex">
    <!-- Sidebar -->
    <div class="sidebar w-64 text-white p-4 fixed h-full shadow-lg z-50">
        <div class="sidebar-header pb-4 border-b border-white/10">
            <div class="logo flex items-center gap-3">
                <div class="bg-white/20 p-2 rounded-lg">
                    <i class="fas fa-chalkboard-teacher text-xl"></i>
                </div>
                <h2 class="text-xl font-semibold">Student Portal</h2>
            </div>
        </div>
        <div class="nav-links py-5">
            <div class="nav-item active py-3 px-5 flex items-center gap-3 cursor-pointer">
                <i class="fas fa-home w-6 text-center"></i>
                <span>Dashboard</span>
            </div>
            <!-- Other nav items -->
              <a href="#" class="nav-item py-3 px-5 flex items-center gap-3 cursor-pointer">
                <i class="fas fa-users w-6 text-center"></i>
                <span>Users</span>
            </a>

            <!-- Proper Logout POST form with icon -->

 <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="nav-item py-3 px-5 flex items-center gap-3 cursor-pointer w-full">
                    <i class="fas fa-sign-out-alt w-6 text-center"></i>
                    <span>Logout</span>
                </button>
            </form>

        </div>
    </div>
    
    <!-- Main Content -->
    <div class="main-content ml-64 p-5 flex-grow">
        <!-- Top Bar -->
        <div class="top-bar bg-white rounded-xl shadow-sm p-5 mb-6 flex justify-between items-center">
            <!-- Top bar content -->
        </div>
        
        @yield('content')
    </div>

    <script>
        // Common JavaScript for sidebar navigation
        document.addEventListener('DOMContentLoaded', function() {
            // Highlight active nav item
            const navItems = document.querySelectorAll('.nav-item');
            navItems.forEach(item => {
                item.addEventListener('click', function() {
                    navItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });
    </script>
    
    @stack('scripts')
</body>
</html> 