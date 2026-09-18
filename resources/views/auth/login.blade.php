<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In · SchoolGear</title>
    <script src="https://cdn.tailwindcss.com"></script>
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

        .glass-card {
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.16);
            backdrop-filter: blur(6px);
            -webkit-backdrop-filter: blur(6px);
        }

        .glass-card:hover {
            background: rgba(255, 255, 255, 0.12);
            border-color: rgba(255, 255, 255, 0.28);
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

        .spinner {
            border-top-color: transparent;
        }

        .toggle-pill {
            transition: all 0.25s ease;
        }

        @media (max-width: 1023px) {
            .left-panel {
                border-bottom-left-radius: 0 !important;
                border-top-right-radius: 1.5rem !important;
            }
        }

        /* ---- Floating education icons ---- */
        #floatingIcons {
            position: absolute;
            inset: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }

        .float-icon {
            position: absolute;
            line-height: 1;
            will-change: transform, filter;
            animation-name: iconFloat, iconGlow;
            animation-timing-function: ease-in-out, ease-in-out;
            animation-iteration-count: infinite, infinite;
            user-select: none;
        }

        @keyframes iconFloat {
            0% {
                transform: translate(0, 0) rotate(0deg);
            }

            25% {
                transform: translate(10px, -22px) rotate(6deg);
            }

            50% {
                transform: translate(-6px, -6px) rotate(-4deg);
            }

            75% {
                transform: translate(-12px, 14px) rotate(4deg);
            }

            100% {
                transform: translate(0, 0) rotate(0deg);
            }
        }

        @keyframes iconGlow {

            0%,
            100% {
                filter: drop-shadow(0 0 2px rgba(255, 255, 255, 0.15));
                opacity: var(--icon-opacity, 0.2);
            }

            50% {
                filter: drop-shadow(0 0 9px rgba(255, 255, 255, 0.65));
                opacity: calc(var(--icon-opacity, 0.2) + 0.15);
            }
        }

        .auth-card {
            position: relative;
        }

        .login-shell {
            position: relative;
            z-index: 10;
        }
    </style>
</head>

<body class="min-h-screen w-full font-sans">

    <!-- Ambient background glow shapes -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none">
        <div class="blob bg-sg-skyLight" style="width:420px;height:420px;top:-120px;left:-100px;"></div>
        <div class="blob bg-sg-accent" style="width:340px;height:340px;bottom:-100px;right:-80px;opacity:0.3;"></div>
        <div class="blob bg-sg-violetLight" style="width:280px;height:280px;bottom:20%;left:8%;opacity:0.25;"></div>
    </div>

    <!-- Floating education icons — sit on the page background, behind the card -->
    <div id="floatingIcons" class="fixed inset-0 overflow-hidden pointer-events-none"></div>

    <div class="login-shell relative min-h-screen w-full flex items-center justify-center px-4 py-8 lg:py-0">

        <div
            class="relative w-full max-w-5xl mx-auto rounded-3xl overflow-hidden shadow-2xl grid grid-cols-1 lg:grid-cols-2 bg-white/5">

            <!-- ============ LEFT PANEL — BRANDING ============ -->
            <div class="left-panel relative flex flex-col px-8 py-10 lg:py-12 lg:px-10 auth-card"
                style="background: linear-gradient(160deg, #3A2A99 0%, #5B3DE0 55%, #38BDF8 140%);">

                <a href="{{ url('/') }}"
                    class="inline-flex items-center gap-2 text-white/80 hover:text-white text-sm font-medium w-fit mb-8 transition">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd"
                            d="M9.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 111.414 1.414L7.414 9H15a1 1 0 110 2H7.414l2.293 2.293a1 1 0 010 1.414z"
                            clip-rule="evenodd" />
                    </svg>
                    Back to Home
                </a>

                <div class="flex flex-col items-center text-center mb-6">
                    <div
                        class="h-20 w-20 rounded-full bg-white/10 border border-white/20 flex items-center justify-center mb-5 overflow-hidden">

                        <img src="{{ asset('logo/download (1).png
                        ') }}" alt="SchoolGear Logo"
                            class="h-16 w-16 object-contain">

                    </div>
                    <h1 class="text-white text-2xl lg:text-[26px] font-bold tracking-tight">Welcome to SchoolGear
                        Liberia</h1>
                    <p class="text-white/70 text-sm mt-1 font-medium tracking-wide">School Management System</p>
                    <p class="text-white/70 text-sm mt-3 max-w-xs leading-relaxed">
                        Access your learning portal to manage academic information, grades, courses, and school
                        activities.
                    </p>
                </div>

                <div class="flex flex-col gap-3 mt-2">
                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3 transition">
                        <div
                            class="h-9 w-9 rounded-lg bg-sg-accent/30 border border-white/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M10 1.944A11.954 11.954 0 012.166 5C2.056 5.649 2 6.319 2 7c0 5.225 3.34 9.67 8 11.317C14.66 16.67 18 12.225 18 7c0-.681-.056-1.35-.166-2.001A11.954 11.954 0 0110 1.944zM11 14a1 1 0 11-2 0 1 1 0 012 0zm0-7a1 1 0 10-2 0v3a1 1 0 102 0V7z"
                                    clip-rule="evenodd" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-sm font-semibold leading-tight">Secure Access</p>
                            <p class="text-white/60 text-xs mt-0.5">Your school data, protected end to end</p>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3 transition">
                        <div
                            class="h-9 w-9 rounded-lg bg-sg-skyLight/30 border border-white/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M9 4.804A7.968 7.968 0 005.5 4c-1.255 0-2.443.29-3.5.804v10A7.969 7.969 0 015.5 14c1.669 0 3.218.51 4.5 1.385A7.962 7.962 0 0114.5 14c1.255 0 2.443.29 3.5.804v-10A7.968 7.968 0 0014.5 4c-1.255 0-2.443.29-3.5.804V12a1 1 0 11-2 0V4.804z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-sm font-semibold leading-tight">Academic Portal</p>
                            <p class="text-white/60 text-xs mt-0.5">Grades, fees, enrollment, and more in one place
                            </p>
                        </div>
                    </div>

                    <div class="glass-card rounded-xl px-4 py-3 flex items-center gap-3 transition">
                        <div
                            class="h-9 w-9 rounded-lg bg-white/15 border border-white/20 flex items-center justify-center shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4.5 w-4.5 text-white" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path
                                    d="M10.394 2.08a1 1 0 00-.788 0l-7 3a1 1 0 000 1.84L5.25 8.051a.999.999 0 01.356-.257l4-1.714a1 1 0 11.788 1.838L7.667 9.088l1.94.831a1 1 0 00.787 0l7-3a1 1 0 000-1.838l-7-3zM3.31 9.397L5 10.12v4.102a8.969 8.969 0 00-1.05-.174 1 1 0 01-.89-.89 11.115 11.115 0 01.25-3.762zM9.3 16.573A9.026 9.026 0 007 14.935v-3.957l1.818.78a3 3 0 002.364 0l5.508-2.361a11.026 11.026 0 01.25 3.762 1 1 0 01-.89.89 8.968 8.968 0 00-5.35 2.524 1 1 0 01-1.4 0z" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <p class="text-white text-sm font-semibold leading-tight">Built for Schools</p>
                            <p class="text-white/60 text-xs mt-0.5">Designed for secondary schools across Liberia
                            </p>
                        </div>
                    </div>
                </div>

                <p class="mt-auto pt-8 text-white/40 text-[11px] text-center hidden lg:block">
                    &copy; {{ date('Y') }} SchoolGear Liberia. All rights reserved.
                </p>
            </div>

            <!-- ============ RIGHT PANEL — AUTH FORM ============ -->
            <div class="relative bg-white px-8 py-10 lg:py-12 lg:px-10 flex flex-col justify-center auth-card">

                <div class="w-full max-w-sm mx-auto">
                    <h2 class="text-2xl font-bold text-sg-primaryDark">Sign In</h2>
                    <p class="text-slate-500 text-sm mt-1 mb-6">Enter your credentials to continue</p>

                    @include('partials.notifications')

                    <form method="POST" action="{{ route('login') }}" id="loginForm" class="space-y-5">
                        @csrf

                        <!-- Account Type Toggle (cosmetic only — always posts as `login`) -->
                        <div>
                            <label
                                class="block text-xs font-semibold text-slate-500 uppercase tracking-wide mb-2">Account
                                Type</label>
                            <div class="grid grid-cols-2 gap-2 bg-slate-100 rounded-xl p-1">
                                <button type="button" id="tabStudent"
                                    class="toggle-pill account-tab rounded-lg py-2 text-sm font-semibold"
                                    data-type="student">
                                    Student
                                </button>
                                <button type="button" id="tabStaff"
                                    class="toggle-pill account-tab rounded-lg py-2 text-sm font-semibold text-slate-500"
                                    data-type="staff">
                                    Staff / Admin
                                </button>
                            </div>
                        </div>

                        <!-- Dynamic credential field -->
                        <div>
                            <label for="credential" id="credentialLabel"
                                class="block text-sm font-medium text-slate-700 mb-1.5">
                                Registration ID
                            </label>
                            <div class="relative">
                                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                    <span class="h-8 w-8 rounded-md bg-sg-primary flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-white"
                                            viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd"
                                                d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                                clip-rule="evenodd" />
                                        </svg>
                                    </span>
                                </span>
                                <input type="text" name="login" id="credential" value="{{ old('login') }}"
                                    placeholder="EMMMBHS2026/001" required autofocus
                                    class="w-full rounded-lg border border-slate-300 pl-14 pr-4 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sg-sky focus:border-sg-sky transition">
                            </div>
                            @error('login')
                                <p class="text-xs text-red-700 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div>
                            <label for="password"
                                class="block text-sm font-medium text-slate-700 mb-1.5">Password</label>
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
                                <input type="password" name="password" id="password" placeholder="••••••••"
                                    required
                                    class="w-full rounded-lg border border-slate-300 pl-14 pr-11 py-2.5 text-sm text-slate-800 placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-sg-sky focus:border-sg-sky transition">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 flex items-center pr-3.5 text-slate-400 hover:text-slate-600">
                                    <svg id="eyeIcon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                        viewBox="0 0 20 20" fill="currentColor">
                                        <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                        <path fill-rule="evenodd"
                                            d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                            clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            @error('password')
                                <p class="text-xs text-red-700 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Remember + Forgot -->
                        <div class="flex items-center justify-between text-sm">
                            <label class="flex items-center gap-2 text-slate-600 select-none cursor-pointer">
                                <input type="checkbox" name="remember"
                                    class="rounded border-slate-300 text-sg-primary focus:ring-sg-sky">
                                Remember me
                            </label>
                            <a href="{{ route('password.request') }}"
                                class="text-sg-primary font-medium hover:underline">Forgot password?</a>
                        </div>

                        <!-- Submit -->
                        <button type="submit" id="submitBtn"
                            class="btn-signin w-full rounded-lg text-white font-semibold py-3 text-sm flex items-center justify-center gap-2 shadow-lg shadow-sg-primary/20">
                            <span id="btnText" class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M3 3a1 1 0 00-1 1v12a1 1 0 001 1h12a1 1 0 001-1V7.414a1 1 0 00-.293-.707L10.293 2.293A1 1 0 009.586 2H3zm7 6a1 1 0 011 1v.01a1 1 0 11-2 0V10a1 1 0 011-1zm-4 4a1 1 0 100 2h8a1 1 0 100-2H6z"
                                        clip-rule="evenodd" />
                                </svg>
                                Sign In to SchoolGear Liberia
                            </span>
                            <svg id="spinner" class="animate-spin h-4 w-4 text-white hidden spinner"
                                viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10"
                                    stroke="currentColor" stroke-width="4" fill="none"></circle>
                                <path class="opacity-75" fill="currentColor"
                                    d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                            </svg>
                        </button>
                    </form>

                    <div class="mt-8 flex items-center justify-between text-[11px] text-slate-400">
                        <span>&copy; {{ date('Y') }} SchoolGear Liberia </span>
                        <span>v0.1</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // ---- Account type toggle (cosmetic — both states submit as name="login") ----
        const tabStudent = document.getElementById('tabStudent');
        const tabStaff = document.getElementById('tabStaff');
        const credentialLabel = document.getElementById('credentialLabel');
        const credentialInput = document.getElementById('credential');

        function setActiveTab(type) {
            const isStudent = type === 'student';

            tabStudent.classList.toggle('bg-white', isStudent);
            tabStudent.classList.toggle('shadow', isStudent);
            tabStudent.classList.toggle('text-sg-primary', isStudent);
            tabStudent.classList.toggle('text-slate-500', !isStudent);

            tabStaff.classList.toggle('bg-white', !isStudent);
            tabStaff.classList.toggle('shadow', !isStudent);
            tabStaff.classList.toggle('text-sg-primary', !isStudent);
            tabStaff.classList.toggle('text-slate-500', isStudent);

            if (isStudent) {
                credentialLabel.textContent = 'Registration ID';
                credentialInput.type = 'text';
                credentialInput.placeholder = 'EMMMBHS2026/0001';
            } else {
                credentialLabel.textContent = 'Email Address';
                credentialInput.type = 'email';
                credentialInput.placeholder = 'admin@gmail.com.';
            }
            // name stays "login" in both cases — backend matches on registration_id OR email
        }

        tabStudent.addEventListener('click', () => setActiveTab('student'));
        tabStaff.addEventListener('click', () => setActiveTab('staff'));
        setActiveTab('student'); // default state on load

        // ---- Password visibility toggle ----
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');
        const eyeIcon = document.getElementById('eyeIcon');

        const eyeOpenPath =
            `<path d="M10 12a2 2 0 100-4 2 2 0 000 4z" /><path fill-rule="evenodd" d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z" clip-rule="evenodd" />`;
        const eyeClosedPath =
            `<path fill-rule="evenodd" d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.781-1.781zm4.261 4.26l1.514 1.515a2 2 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z" clip-rule="evenodd" /><path d="M2.458 10c.907 1.984 2.633 3.657 4.717 4.717l-1.98-1.981A5.019 5.019 0 013.958 10c.363-.798.875-1.516 1.502-2.113l1.427 1.427c-.114.278-.173.581-.173.898a5 5 0 006.928 4.622l1.44 1.44A9.958 9.958 0 0110 17c-4.478 0-8.268-2.943-9.542-7 .34-1.084.87-2.083 1.556-2.965l.444.444z" />`;

        togglePassword.addEventListener('click', () => {
            const isHidden = passwordInput.type === 'password';
            passwordInput.type = isHidden ? 'text' : 'password';
            eyeIcon.innerHTML = isHidden ? eyeClosedPath : eyeOpenPath;
        });

        // ---- Loading state on submit ----
        const loginForm = document.getElementById('loginForm');
        const submitBtn = document.getElementById('submitBtn');
        const btnText = document.getElementById('btnText');
        const spinner = document.getElementById('spinner');

        loginForm.addEventListener('submit', () => {
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-80', 'cursor-not-allowed');
            btnText.innerHTML = 'Signing you in...';
            spinner.classList.remove('hidden');
        });

        // ---- Floating education icons ----
        (function initFloatingIcons() {
            const container = document.getElementById('floatingIcons');
            if (!container) return;

            const isMobile = window.innerWidth < 768;
            const iconCount = isMobile ? 6 : 14;
            const icons = ['🎓', '📘', '📚', '✏️', '🧠', '🏫'];

            for (let i = 0; i < iconCount; i++) {
                const span = document.createElement('span');
                span.className = 'float-icon';
                span.textContent = icons[Math.floor(Math.random() * icons.length)];

                span.style.left = Math.random() * 100 + '%';
                span.style.top = Math.random() * 100 + '%';
                span.style.fontSize = (14 + Math.random() * 20) + 'px';

                const iconOpacity = (0.12 + Math.random() * 0.2).toFixed(2);
                span.style.setProperty('--icon-opacity', iconOpacity);

                const floatDuration = (8 + Math.random() * 10).toFixed(2); // 8s - 18s
                const floatDelay = (Math.random() * 6).toFixed(2); // 0s - 6s
                const glowDuration = (3 + Math.random() * 3).toFixed(2); // 3s - 6s
                const glowDelay = (Math.random() * 4).toFixed(2); // 0s - 4s

                span.style.animationDuration = `${floatDuration}s, ${glowDuration}s`;
                span.style.animationDelay = `${floatDelay}s, ${glowDelay}s`;

                container.appendChild(span);
            }
        })();
    </script>
</body>

</html>
