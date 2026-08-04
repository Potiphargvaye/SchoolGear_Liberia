<!DOCTYPE html>
<html lang="en">
<head>
     <!-- Favicon for various devices -->
<link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
<link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
<link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
<link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-touch-icon.png') }}">
<meta name="apple-mobile-web-app-title" content="Edmol-MBHS Portal">
<link rel="manifest" href="{{ asset('site.webmanifest') }}">
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('kiddos-school-master/css/templatemo-glass-admin-style.css') }}">
<script src="{{ asset('kiddos-school-master/js/templatemo-glass-admin-script.js') }}"></script>

    @include('partials.admin.admin-head')
    @livewireStyles
</head>

<body class="text-gray-800 bg-[#F8FAFC] min-h-screen">

    {{-- Sidebar --}} 
    @include('partials.admin.admin-sidebar')

    {{-- Mobile overlay --}}
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay hidden"></div>

    {{-- Main 
   <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-white min-h-screen transition-all main">--}}
    <main class="w-full md:w-[calc(100%-256px)] md:ml-64 min-h-screen transition-all main bg-transparent">



        {{-- Navbar --}} 
        @include('partials.admin.admin-navbar')

        {{-- Page Content --}}
        <section class="p-6">
    <div class="dashboard-glass">
        @yield('content')
    </div>
     </section>


    </main>

    {{-- Scripts --}}
    @include('partials.admin.admin-scripts')
 @livewireScripts

 {{-- Page specific scripts --}}
@stack('scripts')
</body>
</html>



