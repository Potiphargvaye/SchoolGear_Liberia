<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password · SchoolGear</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="{{ asset('schoolGear_liberia_public_site/css/whatsapp-widget.css') }}">
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        sg: {
                            primary: '#5B3DE0',
                            primaryDark: '#3A2A99',
                            violet: '#6E4BF0',
                            violetLight: '#A78BFF',
                            sky: '#38BDF8',
                            skyLight: '#5FD0FA',
                            accent: '#FFE29A',
                            success: '#2E7D5B',
                            bg: '#F4F6FE',
                        }
                    },
                    fontFamily: {
                        sans: ['Segoe UI', 'system-ui', 'sans-serif'],
                    }
                }
            }
        }
    </script>
    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            overflow-x: hidden;
        }

        body {
            background: linear-gradient(135deg, #A78BFF 0%, #5B3DE0 45%, #3A2A99 100%);
        }

        .blob {
            position: absolute;
            border-radius: 9999px;
            filter: blur(60px);
            opacity: 0.45;
            pointer-events: none;
        }

        .btn-signin {
            background: linear-gradient(90deg, #6E4BF0 0%, #38BDF8 100%);
            transition: filter 0.2s ease, transform 0.15s ease;
        }

        .btn-signin:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .btn-signin:disabled {
            opacity: 0.7;
            cursor: not-allowed;
            transform: none;
        }

        .spinner {
            border-top-color: transparent;
        }
    </style>
</head>

<body class="min-h-screen w-full font-sans">
    @php
        $schoolName = $school->school_name ?? 'SchoolGear Liberia';

        $logoUrl = asset('logo/schoolgear-logo.png');

        if ($school && $school->logo && \Illuminate\Support\Facades\Storage::disk('public')->exists($school->logo)) {
            $logoUrl = \Illuminate\Support\Facades\Storage::disk('public')->url($school->logo);
        }
    @endphp

    <!-- Ambient background glow shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob bg-sg-skyLight" style="width:420px;height:420px;top:-120px;left:-100px;"></div>
        <div class="blob bg-sg-accent" style="width:340px;height:340px;bottom:-100px;right:-80px;opacity:0.3;"></div>
        <div class="blob bg-sg-violetLight" style="width:280px;height:280px;bottom:20%;left:8%;opacity:0.25;"></div>
    </div>

    <div class="relative min-h-screen w-full flex items-center justify-center px-4 py-10">

        <div class="relative w-full max-w-md mx-auto">

            <a href="{{ url('/') }}"
                class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-medium mb-5 transition">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                    <path fill-rule="evenodd"
                        d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                        clip-rule="evenodd" />
                </svg>
                Back to Home
            </a>

            <div class="bg-white rounded-3xl shadow-2xl px-8 py-10">

                <div class="flex flex-col items-center text-center mb-6">
                    <div
                        class="h-20 w-20 rounded-full bg-sg-bg border border-sg-primary/15 flex items-center justify-center mb-5 overflow-hidden">
                        <img src="{{ $logoUrl }}" alt="{{ $schoolName }}" class="h-16 w-16 object-contain">
                    </div>
                    <h1 class="text-sg-primaryDark text-2xl font-bold tracking-tight">Reset Password</h1>
                    <p class="text-slate-500 text-sm mt-1.5 max-w-xs leading-relaxed">
                        Set a new secure password for your {{ $schoolName }} account
                    </p>
                </div>

                @if ($errors->any())
                    <div class="rounded-lg border border-red-200 bg-red-50 px-4 py-3 mb-5" role="alert">
                        <ul class="text-sm text-red-700 space-y-1 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif


                <form method="POST" action="{{ route('password.store') }}" id="resetForm" class="space-y-5">
                    @csrf

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

                    <!-- Email (readonly) -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="h-8 w-8 rounded-md bg-sg-primary flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path
                                            d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z" />
                                        <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z" />
                                    </svg>
                                </span>
                            </span>
                            <input type="email" id="email" name="email"
                                value="{{ old('email', $request->email) }}" readonly required
                                class="w-full rounded-lg border border-slate-300 bg-slate-50 pl-14 pr-4 py-2.5 text-sm text-slate-600 cursor-not-allowed">
                        </div>
                    </div>

                    <!-- New password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">New
                            Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="h-8 w-8 rounded-md bg-sg-primary flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                            <input type="password" name="password" id="password" placeholder="••••••••" required
                                class="w-full rounded-lg border border-slate-300 pl-14 pr-11 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sg-sky focus:border-sg-sky transition">
                            <button type="button"
                                class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600"
                                data-target="password" aria-label="Show password">
                                <svg class="eye-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Confirm password -->
                    <div>
                        <label for="password_confirmation"
                            class="block text-sm font-medium text-slate-700 mb-1.5">Confirm Password</label>
                        <div class="relative">
                            <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                <span class="h-8 w-8 rounded-md bg-sg-primary flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path fill-rule="evenodd"
                                            d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </span>
                            </span>
                            <input type="password" name="password_confirmation" id="password_confirmation"
                                placeholder="••••••••" required
                                class="w-full rounded-lg border border-slate-300 pl-14 pr-11 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sg-sky focus:border-sg-sky transition">
                            <button type="button"
                                class="toggle-password absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600"
                                data-target="password_confirmation" aria-label="Show password">
                                <svg class="eye-icon h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                    <path fill-rule="evenodd"
                                        d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <p id="password-match-message" class="text-xs mt-1.5 hidden font-medium"></p>
                    </div>

                    <!-- Submit -->
                    <button type="submit" id="resetBtn"
                        class="btn-signin w-full rounded-lg text-white font-semibold py-3 text-sm flex items-center justify-center gap-2 shadow-lg shadow-sg-primary/20">
                        <span id="btnText" class="flex items-center gap-2">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            Reset Password
                        </span>
                        <svg id="spinner" class="animate-spin h-4 w-4 text-white hidden spinner"
                            viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4" fill="none"></circle>
                            <path class="opacity-75" fill="currentColor"
                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                        </svg>
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-6">
                    <a href="{{ route('login') }}" class="text-sg-primary font-medium hover:underline">Back to Sign
                        In</a>
                </p>
            </div>

            <p class="mt-6 text-center text-white/60 text-[11px]">
                &copy; {{ date('Y') }} SchoolGear Liberia. All rights reserved.
                <span>v0.1</span>
            </p>
        </div>
    </div>

    <!-- WhatsApp Floating Button -->
    <a href="https://wa.me/+231777987113" target="_blank" class="whatsapp-float"
        aria-label="Message us on WhatsApp">
        <svg class="whatsapp-icon" viewBox="0 0 24 24" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path
                d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.71.306 1.263.489 1.694.626.712.226 1.36.194 1.872.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347z" />
            <path
                d="M12.001 2C6.478 2 2 6.477 2 12c0 1.9.526 3.68 1.44 5.2L2 22l4.943-1.397A9.955 9.955 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12.001 2zm0 18.29a8.27 8.27 0 01-4.216-1.155l-.303-.18-3.13.884.836-3.05-.198-.313A8.267 8.267 0 013.71 12c0-4.577 3.714-8.29 8.29-8.29 4.577 0 8.29 3.713 8.29 8.29 0 4.576-3.713 8.29-8.289 8.29z" />
        </svg>
        <span class="whatsapp-tooltip">Message us on WhatsApp</span>
    </a>

    <script>
        document.querySelectorAll('.toggle-password').forEach(function(btn) {
            btn.addEventListener('click', function() {
                var input = document.getElementById(btn.dataset.target);
                input.type = input.type === 'password' ? 'text' : 'password';
            });
        });

        var password = document.getElementById('password');
        var confirmPassword = document.getElementById('password_confirmation');
        var message = document.getElementById('password-match-message');

        function checkPasswords() {
            if (!confirmPassword.value) {
                message.classList.add('hidden');
                return;
            }

            message.classList.remove('hidden');

            if (password.value === confirmPassword.value) {
                message.textContent = '✓ Passwords match';
                message.style.color = '#2E7D5B';
            } else {
                message.textContent = '✗ Passwords do not match';
                message.style.color = '#dc2626';
            }
        }

        password.addEventListener('input', checkPasswords);
        confirmPassword.addEventListener('input', checkPasswords);

        var resetForm = document.getElementById('resetForm');
        var resetBtn = document.getElementById('resetBtn');
        var btnText = document.getElementById('btnText');
        var spinner = document.getElementById('spinner');

        resetForm.addEventListener('submit', function() {
            resetBtn.disabled = true;
            btnText.querySelector('svg').remove();
            btnText.textContent = 'Processing...';
            spinner.classList.remove('hidden');
        });
    </script>

</body>

</html>
