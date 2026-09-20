<!DOCTYPE html>
<html lang="en">

<head>
    <!-- SchoolGear Liberia Favicon -->
    <link rel="apple-touch-icon" sizes="57x57" href="{{ asset('apple-icon-57x57.png') }}">
    <link rel="apple-touch-icon" sizes="60x60" href="{{ asset('apple-icon-60x60.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('apple-icon-72x72.png') }}">
    <link rel="apple-touch-icon" sizes="76x76" href="{{ asset('apple-icon-76x76.png') }}">
    <link rel="apple-touch-icon" sizes="114x114" href="{{ asset('apple-icon-114x114.png') }}">
    <link rel="apple-touch-icon" sizes="120x120" href="{{ asset('apple-icon-120x120.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('apple-icon-144x144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('apple-icon-152x152.png') }}">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('apple-icon-180x180.png') }}">

    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('android-icon-192x192.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('favicon-32x32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('favicon-96x96.png') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('favicon-16x16.png') }}">
    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">

    <meta name="apple-mobile-web-app-title" content="SchoolGear Liberia">

    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="{{ asset('ms-icon-144x144.png') }}">
    <meta name="theme-color" content="#ffffff">

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('kiddos-school-master/css/templatemo-glass-admin-style.css') }}">
    <script src="{{ asset('kiddos-school-master/js/templatemo-glass-admin-script.js') }}"></script>

    @include('partials.admin.admin-head')
    @livewireStyles

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class'
        };
    </script>
</head>

<body class="text-gray-800 bg-[#F8FAFC] min-h-screen">

    {{-- Sidebar --}}
    @include('partials.admin.admin-sidebar')

    {{-- Mobile overlay --}}
    <div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay hidden"></div>

    {{-- Main 
   <main class="w-full md:w-[calc(100%-256px)] md:ml-64 bg-white min-h-screen transition-all main"> --}}
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
