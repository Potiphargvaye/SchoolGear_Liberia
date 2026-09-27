<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register Your School | SchoolGear Liberia</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/whatsapp-widget.css') }}">
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


    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/+231777987113" target="_blank" class="whatsapp-float" aria-label="Message us on WhatsApp">
        <svg class="whatsapp-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
            <path
                d="M12.001 2C6.478 2 2 6.477 2 12c0 1.9.526 3.68 1.44 5.2L2 22l4.943-1.397A9.955 9.955 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12.001 2zm0 18.29a8.27 8.27 0 01-4.216-1.155l-.303-.18-3.13.884.836-3.05-.198-.313A8.267 8.267 0 013.71 12c0-4.577 3.714-8.29 8.29-8.29 4.577 0 8.29 3.713 8.29 8.29 0 4.576-3.713 8.29-8.289 8.29z" />
        </svg>
        <span class="whatsapp-tooltip">Message us on WhatsApp</span>
    </a>

</body>

</html>
