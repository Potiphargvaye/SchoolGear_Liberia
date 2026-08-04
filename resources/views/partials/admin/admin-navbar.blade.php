<!-- Navbar -->
<div
    class="navbar-menu py-2.5 px-6 flex items-center gap-1 shadow-md shadow-black/10 sticky top-0 left-0 z-30 bg-[#0b2e59] border-b border-white/10">

    <button type="button" class="nav-icon-btn sidebar-toggle">
        <i class="ri-menu-line text-lg"></i>
    </button>


    <!-- EDMOL Logo -->
    <div class="flex items-center gap-2.5">
        <img src="{{ asset('logo/edmol-orginal-logo.png') }}" alt="EDMOL Logo"
            class="h-8 w-8 object-contain rounded-md bg-white/10 p-0.5">

        <span class="hidden sm:inline text-white font-bold text-sm tracking-wider">
            EDMOL SMS
        </span>
    </div>
    <ul class="ml-auto flex items-center gap-1">

        <!-- Search Dropdown -->
        <li class="dropdown">
            <button type="button" class="dropdown-toggle nav-icon-btn">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M19.023 16.977a35.13 35.13 0 0 1-1.367-1.384c-.372-.378-.596-.653-.596-.653l-2.8-1.337A6.962 6.962 0 0 0 16 9c0-3.859-3.14-7-7-7S2 5.141 2 9s3.14 7 7 7c1.763 0 3.37-.66 4.603-1.739l1.337 2.8s.275.224.653.596c.387.363.896.854 1.384 1.367l1.358 1.392.604.646 2.121-2.121-.646-.604c-.379-.372-.885-.866-1.391-1.36zM9 14c-2.757 0-5-2.243-5-5s2.243-5 5-5 5 2.243 5 5-2.243 5-5 5z">
                    </path>
                </svg>
            </button>
            <div class="nav-dropdown dropdown-menu z-30 hidden max-w-xs w-full">
                <form action="" class="p-4">
                    <div class="relative w-full">
                        <input type="text" class="nav-search-input" placeholder="Search...">
                        <i
                            class="ri-search-line absolute top-1/2 left-3.5 -translate-y-1/2 text-gray-400 text-base"></i>
                    </div>
                </form>
            </div>
        </li>

        <!-- Notifications / Messages Dropdown -->
        <li class="dropdown">
            <button type="button" class="dropdown-toggle nav-icon-btn relative">
                <svg xmlns="http://www.w3.org/2000/svg" width="19" height="19" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M19 13.586V10c0-3.217-2.185-5.927-5.145-6.742C13.562 2.52 12.846 2 12 2s-1.562.52-1.855 1.258C7.185 4.074 5 6.783 5 10v3.586l-1.707 1.707A.996.996 0 0 0 3 16v2a1 1 0 0 0 1 1h16a1 1 0 0 0 1-1v-2a.996.996 0 0 0-.293-.707L19 13.586zM19 17H5v-.586l1.707-1.707A.996.996 0 0 0 7 14v-4c0-2.757 2.243-5 5-5s5 2.243 5 5v4c0 .266.105.52.293.707L19 16.414V17zm-7 5a2.98 2.98 0 0 0 2.818-2H9.182A2.98 2.98 0 0 0 12 22z">
                    </path>
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full bg-[#f84525] ring-2 ring-[#0b2e59]"></span>
            </button>
            <div class="nav-dropdown dropdown-menu z-30 hidden max-w-xs w-full">
                <div class="flex items-center px-4 pt-3.5 border-b border-gray-100 notification-tab">
                    <button type="button" data-tab="notification" data-tab-page="notifications"
                        class="nav-tab mr-5 active">Notifications</button>
                    <button type="button" data-tab="notification" data-tab-page="messages"
                        class="nav-tab">Messages</button>
                </div>
                <div class="my-1.5">
                    <ul class="max-h-64 overflow-y-auto nav-scroll" data-tab-for="notification"
                        data-page="notifications">
                        <li>
                            <a href="#" class="nav-notif-item group">
                                <img src="https://placehold.co/32x32" alt=""
                                    class="w-9 h-9 rounded-full block object-cover align-middle ring-1 ring-gray-100">
                                <div class="ml-2.5 min-w-0">
                                    <div
                                        class="text-[13px] text-gray-700 font-semibold truncate group-hover:text-[#0b2e59]">
                                        New order</div>
                                    <div class="text-[11px] text-gray-400">from a user</div>
                                </div>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </li>

        <!-- Fullscreen button -->
        <button id="fullscreen-button" class="nav-icon-btn">
            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                fill="currentColor">
                <path d="M5 5h5V3H3v7h2zm5 14H5v-5H3v7h7zm11-5h-2v5h-5v2h7zm-2-4h2V3h-7v2h5z"></path>
            </svg>
        </button>
        <script>
            const fullscreenButton = document.getElementById('fullscreen-button');
            fullscreenButton.addEventListener('click', toggleFullscreen);

            function toggleFullscreen() {
                if (document.fullscreenElement) {
                    document.exitFullscreen();
                } else {
                    document.documentElement.requestFullscreen();
                }
            }
        </script>

        <!-- Admin image & name section -->
        <li class="dropdown ml-2 pl-3 border-l border-white/10">
            <button type="button"
                class="dropdown-toggle flex items-center gap-2.5 py-1 pr-1.5 rounded-lg transition-colors duration-200 hover:bg-white/10">
                <div class="flex-shrink-0 w-9 h-9 relative">
                    @auth

                        @if (auth()->user()->image)
                            <div class="p-0.5 bg-white rounded-full ring-2 ring-white/20 focus:outline-none focus:ring">
                                <img class="w-8 h-8 rounded-full object-cover"
                                    src="{{ asset('storage/' . auth()->user()->image) }}"
                                    alt="{{ auth()->user()->name }}" />
                                <div
                                    class="top-0 left-7 absolute w-3 h-3 bg-lime-400 border-2 border-white rounded-full animate-ping">
                                </div>
                                <div class="top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        @else
                            <div class="p-0.5 bg-white rounded-full ring-2 ring-white/20 flex items-center justify-center">
                                <span class="text-sm font-bold text-[#0b2e59]">
                                    {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                                </span>
                                <div
                                    class="top-0 left-7 absolute w-3 h-3 bg-lime-400 border-2 border-white rounded-full animate-ping">
                                </div>
                                <div class="top-0 left-7 absolute w-3 h-3 bg-lime-500 border-2 border-white rounded-full">
                                </div>
                            </div>
                        @endif
                    @else
                        <div
                            class="p-0.5 bg-white rounded-full ring-2 ring-white/20 flex items-center justify-center bg-gray-200">
                            <span class="text-sm font-bold text-gray-700">
                                ?
                            </span>
                        </div>

                    @endauth

                </div>


                <div class="hidden md:block text-left">
                    <h2 class="text-sm font-semibold text-white leading-tight">{{ Auth::user()->name }}</h2>
                    <p class="text-[11px] text-white/60 leading-tight">{{ ucfirst(Auth::user()->role) }}</p>
                </div>

                <i class="ri-arrow-down-s-line text-white/60 text-base hidden md:inline"></i>
            </button>

            <ul class="nav-dropdown dropdown-menu z-30 hidden py-1.5 w-full max-w-[160px]">
                <li>
                    <a href="#" class="nav-dropitem">
                        <i class="ri-user-line nav-dropicon"></i>
                        Profile
                    </a>
                </li>
                <li>
                    <a href="#" class="nav-dropitem">
                        <i class="ri-settings-3-line nav-dropicon"></i>
                        Settings
                    </a>
                </li>
                <li class="mt-1 pt-1 border-t border-gray-100">
                    <form method="POST" action="">
                        <a role="menuitem" class="nav-dropitem nav-dropitem-danger cursor-pointer"
                            onclick="event.preventDefault();
                            this.closest('form').submit();">
                            <i class="ri-logout-box-r-line nav-dropicon"></i>
                            Log Out
                        </a>
                    </form>
                </li>
            </ul>
        </li>
    </ul>
</div>
<!-- End Navbar -->

<!-- Navbar-specific styles: icon buttons, dropdown cards, tabs, search input, list items.
     Brand background (#0b2e59) and accent (#f84525) are UNCHANGED —
     only spacing/hover/active interaction states are added. -->
<style>
    .navbar-menu .nav-icon-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 2.25rem;
        height: 2.25rem;
        border-radius: 0.6rem;
        color: rgba(255, 255, 255, 0.75);
        transition: background-color 0.2s ease, color 0.2s ease, transform 0.15s ease;
    }

    .navbar-menu .nav-icon-btn:hover {
        background-color: rgba(255, 255, 255, 0.1);
        color: #ffffff;
    }

    .navbar-menu .nav-icon-btn:hover svg {
        color: #f84525;
    }

    .navbar-menu .nav-icon-btn:active {
        transform: scale(0.94);
    }

    .navbar-menu .nav-dropdown {
        margin-top: 0.6rem;
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 0.85rem;
        box-shadow: 0 12px 28px -8px rgba(11, 46, 89, 0.28), 0 2px 6px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    .navbar-menu .nav-search-input {
        width: 100%;
        padding: 0.55rem 0.75rem 0.55rem 2.25rem;
        background-color: #f9fafb;
        border: 1px solid #f3f4f6;
        border-radius: 0.6rem;
        font-size: 0.875rem;
        outline: none;
        transition: border-color 0.2s ease, background-color 0.2s ease;
    }

    .navbar-menu .nav-search-input:focus {
        border-color: #0b2e59;
        background-color: #ffffff;
    }

    .navbar-menu .nav-tab {
        font-size: 12.5px;
        font-weight: 600;
        color: rgba(107, 114, 128, 1);
        padding-bottom: 0.6rem;
        border-bottom: 2px solid transparent;
        transition: color 0.2s ease, border-color 0.2s ease;
    }

    .navbar-menu .nav-tab:hover {
        color: #0b2e59;
    }

    .navbar-menu .nav-tab.active {
        color: #0b2e59;
        border-bottom-color: #f84525;
    }

    .navbar-menu .nav-notif-item {
        display: flex;
        align-items: center;
        padding: 0.55rem 1rem;
        transition: background-color 0.2s ease;
    }

    .navbar-menu .nav-notif-item:hover {
        background-color: rgba(11, 46, 89, 0.06);
    }

    .navbar-menu .nav-dropitem {
        display: flex;
        align-items: center;
        gap: 0.6rem;
        font-size: 13px;
        font-weight: 500;
        padding: 0.5rem 1rem;
        color: rgba(75, 85, 99, 1);
        transition: background-color 0.2s ease, color 0.2s ease;
    }

    .navbar-menu .nav-dropitem:hover {
        background-color: rgba(248, 69, 37, 0.08);
        color: #f84525;
    }

    .navbar-menu .nav-dropitem-danger {
        color: #dc2626;
    }

    .navbar-menu .nav-dropitem-danger:hover {
        background-color: rgba(220, 38, 38, 0.08);
        color: #dc2626;
    }

    .navbar-menu .nav-dropicon {
        font-size: 1rem;
        width: 1.1rem;
        text-align: center;
        flex-shrink: 0;
    }

    .navbar-menu .nav-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(248, 69, 37, 0.4) transparent;
    }

    .navbar-menu .nav-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .navbar-menu .nav-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(248, 69, 37, 0.4);
        border-radius: 9999px;
    }
</style>
