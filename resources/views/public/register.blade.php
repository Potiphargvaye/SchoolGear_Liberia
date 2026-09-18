<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your School | SchoolGear Liberia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    @livewireStyles
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sg: {
                            primary: '#5B3DE0',
                            primaryDark: '#3A2A99',
                            sky: '#38BDF8',
                            skyLight: '#5FD0FA',
                            accent: '#FFE29A',
                            bg: '#F4F6FE',
                        }
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-white min-h-screen flex flex-col">
    <header class="w-full px-4 sm:px-8 py-3 flex items-center justify-between border-b border-slate-200 bg-white">
        <!-- Brand Logo Container -->
        <a href="{{ route('home') }}" class="flex items-center shrink-0">
            <img src="{{ asset('logo/logo1.jpeg') }}" alt="SchoolGear Liberia"
                class="h-10 sm:h-12 w-auto object-contain mix-blend-multiply">
        </a>

        <!-- Go Back Link -->
        <a href="{{ url('/') }}"
            class="text-sm font-medium text-slate-500 hover:text-sg-primary transition inline-flex items-center gap-1.5 shrink-0">
            <i class="fas fa-chevron-left text-xs"></i> Go back
        </a>
    </header>
    <main class="flex-1 bg-sg-bg">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-10 sm:py-16">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-10 lg:gap-16 items-start">

                {{-- Left column: context + trust --}}
                <div class="lg:pt-8">
                    <h1 class="text-3xl sm:text-4xl font-bold text-sg-primaryDark leading-tight">
                        Start a 3-month free trial
                    </h1>
                    <p class="text-slate-500 mt-3 text-base">
                        Join Liberian schools using SchoolGear to manage admissions, academics, fees, and daily
                        operations in one place.
                    </p>

                    <ul class="mt-6 space-y-3">
                        <li class="flex items-start gap-2.5 text-sm text-slate-700">
                            <i class="fas fa-check text-sg-primary mt-0.5"></i>
                            No credit card required
                        </li>
                        <li class="flex items-start gap-2.5 text-sm text-slate-700">
                            <i class="fas fa-check text-sg-primary mt-0.5"></i>
                            Full setup and training support included
                        </li>
                        <li class="flex items-start gap-2.5 text-sm text-slate-700">
                            <i class="fas fa-check text-sg-primary mt-0.5"></i>
                            Real 3-month implementation window, not a limited demo
                        </li>
                    </ul>

                    <div class="mt-10 pt-8 border-t border-slate-200">
                        <h3 class="text-sm font-semibold text-slate-500 uppercase tracking-wide mb-4">Trusted by Schools
                        </h3>
                        <div class="bg-white rounded-xl border border-slate-200 p-5">
                            <p class="text-sm text-slate-600 leading-relaxed">
                                SchoolGear is already in use at <span class="font-semibold text-sg-primaryDark">EDMOL
                                    Memorial Baptists High School</span>,
                                helping their team manage student records, academics, and daily school operations
                                digitally.
                            </p>
                        </div>
                    </div>
                </div>

                {{-- Right column: registration card --}}
                <div>
                    <livewire:public.school-registration />
                </div>

            </div>
        </div>
    </main>

    <footer class="text-center py-6 text-xs text-slate-400 border-t border-slate-200">
        &copy; {{ date('Y') }} SchoolGear Liberia. All rights reserved. &middot; v0.1
    </footer>

    @livewireScripts
</body>

</html>
