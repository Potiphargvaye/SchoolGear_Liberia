<!-- Sidenav -->
<div class="fixed left-0 top-0 w-64 h-screen z-50 sidebar-menu transition-transform bg-[#001f4d] flex flex-col">

    <!-- Logo — current school's short name/logo + logged-in user's role -->
    @php
        $sidebarSchool = auth()->user()->school;
        $sidebarRole = auth()->user()->getRoleNames()->first();
    @endphp
    <a href="#"
        class="flex items-center gap-3 min-h-[76px] px-4 py-3 shrink-0 relative hover:bg-[#002966] rounded-md text-white">
        <div
            class="h-10 w-10 shrink-0 rounded-md bg-white/10 border border-white/20 flex items-center justify-center overflow-hidden">
            @if ($sidebarSchool && $sidebarSchool->logo)
                <img src="{{ asset('storage/' . $sidebarSchool->logo) }}" alt="{{ $sidebarSchool->school_name }}"
                    class="h-full w-full object-cover">
            @else
                <span class="font-bold text-sm">
                    {{ $sidebarSchool->display_short_name ?? 'SG' }}
                </span>
            @endif
        </div>
        <div class="min-w-0">
            <h2 class="font-bold text-base leading-tight truncate"
                title="{{ $sidebarSchool->school_name ?? 'SchoolGear Liberia' }}">
                {{ $sidebarSchool->display_short_name ?? 'SchoolGear Liberia' }}
            </h2>
            @if ($sidebarRole)
                <p class="text-[11px] text-white/60 truncate">
                    {{ $sidebarRole }}
                </p>
            @endif
        </div>
        <span class="absolute bottom-0 left-4 right-4 h-px bg-white/10"></span>
    </a>
    <!-- SCROLLABLE MENU AREA -->
    <div class="flex-1 overflow-y-auto nav-scroll px-3 pt-5 pb-6">

        <ul class="space-y-0.5">
            <li class="nav-section text-teal-500 font-bold">ADMIN</li>

            @php
                $usersActive =
                    request()->routeIs('admin.users.index') || request()->routeIs('admin.users.permissions.edit');
                $reportCardsActive = request()->routeIs('report.cards.index');
                $reportCardType = optional(request()->route())->parameter('type');
            @endphp

            @can('view dashboard')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.dashboard') }}"
                        class="nav-link {{ request()->routeIs('admin.dashboard') ? 'nav-active' : '' }}">
                        <i class="ri-home-2-line nav-icon"></i>
                        <span class="text-sm">Dashboard</span>
                    </a>
                </li>
            @endcan


            @can('view schools')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.schools.index') }}"
                        class="nav-link {{ request()->routeIs('admin.schools.index') ? 'nav-active' : '' }}">
                        <i class="ri-school-line nav-icon"></i>
                        <span class="text-sm">Schools</span>
                    </a>
                </li>
            @endcan

            @can('manage academic years')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.academic-years.index') }}"
                        class="nav-link {{ request()->routeIs('admin.academic-years.*') ? 'nav-active' : '' }}">
                        <i class="ri-calendar-line nav-icon"></i>
                        <span class="text-sm">Academic Years</span>
                    </a>
                </li>
            @endcan
            @can('manage users')
                <li class="mb-0.5 group {{ $usersActive ? 'active selected' : '' }}">
                    <!-- Main Users Link -->
                    <a href="{{ route('admin.access-control.users.index') }}"
                        class="nav-link sidebar-dropdown-toggle {{ $usersActive ? 'nav-active' : '' }}">
                        <i class='bx bx-user nav-icon'></i>
                        <span class="text-sm">Users</span>
                        <i
                            class="ri-arrow-right-s-line ml-auto transition-transform duration-200 group-[.selected]:rotate-90"></i>
                    </a>

                    <!-- Sub-links Dropdown -->
                    <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                        <li>
                            <a href="{{ route('admin.access-control.users.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.users.index') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                All
                            </a>
                        </li>



                    </ul>
                </li>
            @endcan

            @can('view students')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.students.index') }}"
                        class="nav-link {{ request()->routeIs('admin.students.*') ? 'nav-active' : '' }}">
                        <i class="ri-graduation-cap-line nav-icon"></i>
                        <span class="text-sm">Students</span>
                    </a>
                </li>
            @endcan

            @can('manage grade assignments')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.grade-assignments') }}"
                        class="nav-link {{ request()->routeIs('admin.grade-assignments') ? 'nav-active' : '' }}">
                        <i class="ri-file-list-3-line nav-icon"></i>
                        <span class="text-sm">Grade-Assignment</span>
                    </a>
                </li>
            @endcan

            <li class="mb-0.5 group">
                <a href="{{ route('admin.announcements.index') }}"
                    class="nav-link {{ request()->routeIs('admin.announcements.*') ? 'nav-active' : '' }}">
                    <i class="ri-megaphone-line nav-icon"></i>
                    <span class="text-sm">Announcement</span>
                </a>
            </li>


            <li class="nav-section text-teal-500 font-bold">ACCESS CONTROL</li>

            @php
                $accessControlActive =
                    request()->routeIs('admin.access-control.roles.*') ||
                    request()->routeIs('admin.access-control.permissions.*') ||
                    request()->routeIs('admin.access-control.role-permissions.*');
            @endphp

            <li class="mb-0.5 group {{ $accessControlActive ? 'active selected' : '' }}">

                <!-- Main Access Control Link -->
                <a href="{{ route('admin.access-control.roles.index') }}"
                    class="nav-link sidebar-dropdown-toggle {{ $accessControlActive ? 'nav-active' : '' }}">

                    <i class="ri-shield-keyhole-line nav-icon"></i>

                    <span class="text-sm">Access Control</span>

                    <i
                        class="ri-arrow-right-s-line ml-auto transition-transform duration-200 group-[.selected]:rotate-90"></i>

                </a>

                <!-- Sub-links -->
                <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                    @can('view roles')
                        <li>
                            <a href="{{ route('admin.access-control.roles.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.access-control.roles.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Roles
                            </a>
                        </li>
                    @endcan

                    @can('view permissions')
                        <li>
                            <a href="{{ route('admin.access-control.permissions.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.access-control.permissions.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Permissions
                            </a>
                        </li>
                    @endcan

                    @can('view permissions')
                        <li>
                            <a href="{{ route('admin.access-control.role-permissions.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.access-control.role-permissions.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Role Permissions
                            </a>
                        </li>
                    @endcan

                </ul>

            </li>


            <li class="nav-section text-teal-500 font-bold">STUDENT MANAGEMENT</li>

            @php
                $studentMgmtActive =
                    request()->routeIs('admin.admissions.*') ||
                    request()->routeIs('admin.students.*') ||
                    request()->routeIs('admin.enrollments.*') ||
                    request()->routeIs('admin.academic-years.*');
            @endphp

            <li class="mb-0.5 group {{ $studentMgmtActive ? 'active selected' : '' }}">

                <a href="{{ route('admin.students.index') }}"
                    class="nav-link sidebar-dropdown-toggle {{ $studentMgmtActive ? 'nav-active' : '' }}">

                    <i class="ri-user-star-line nav-icon"></i>
                    <span class="text-sm">Students</span>
                    <i
                        class="ri-arrow-right-s-line ml-auto transition-transform duration-200 group-[.selected]:rotate-90"></i>

                </a>

                <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                    @can('manage admissions')
                        <li>
                            <a href="{{ route('admin.admissions.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.admissions.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Admissions
                            </a>
                        </li>
                    @endcan

                    @can('view student details')
                        <li>
                            <a href="{{ route('admin.students.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.students.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Students
                            </a>
                        </li>
                    @endcan

                    @can('manage enrollments')
                        <li>
                            <a href="{{ route('admin.enrollments.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.enrollments.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Enrollments
                            </a>
                        </li>
                    @endcan

                    @can('manage academic years')
                        <li>
                            <a href="{{ route('admin.academic-years.index') }}"
                                class="nav-sublink {{ request()->routeIs('admin.academic-years.*') ? 'nav-sublink-active' : '' }}">
                                <span class="nav-dot"></span>
                                Academic Years
                            </a>
                        </li>
                    @endcan

                </ul>

            </li>
            <li class="nav-section text-gray-400 font-bold">Finance</li>

            @can('manage fees')
                <li class="mb-0.5 group">
                    <a href="{{ route('admin.fees.index') }}"
                        class="nav-link {{ request()->routeIs('admin.fees.*') ? 'nav-active' : '' }}">
                        <i class="ri-wallet-3-line nav-icon"></i>
                        <span class="text-sm">Fees-Management</span>
                    </a>
                </li>
            @endcan



            <li class="nav-section text-orange-500 hover:text-orange-700 font-bold">Report-Card</li>

            @can('enter student grades')
                <li class="mb-0.5 group">
                    <a href="{{ route('grades.entry') }}"
                        class="nav-link {{ request()->routeIs('grades.entry') ? 'nav-active' : '' }}">
                        <i class="ri-book-line nav-icon"></i>
                        <span class="text-sm">Grade Entry</span>
                    </a>
                </li>
            @endcan

            @can('view grade audit trail')
                <li class="mb-0.5 group">
                    <a href="{{ route('grades.audit-trail') }}"
                        class="nav-link {{ request()->routeIs('grades.audit-trail') ? 'nav-active' : '' }}">
                        <i class="ri-history-line nav-icon"></i>
                        <span class="text-sm">Grade Audit Trail</span>
                    </a>
                </li>
            @endcan

            <li class="mb-0.5 group {{ $reportCardsActive ? 'active selected' : '' }}">
                <!-- Main Report Card Link -->
                <a href="#"
                    class="nav-link sidebar-dropdown-toggle {{ $reportCardsActive ? 'nav-active' : '' }}">
                    <i class="ri-folder-4-line nav-icon"></i>
                    <span class="text-sm">Report Cards</span>
                    <i
                        class="ri-arrow-right-s-line ml-auto transition-transform duration-200 group-[.selected]:rotate-90"></i>
                </a>

                <!-- Sub-links Dropdown -->
                <ul class="mt-1 ml-[27px] pl-3 border-l border-white/15 hidden group-[.selected]:block space-y-1">

                    <!-- Junior -->
                    <li>
                        <a href="{{ route('report.cards.index', 'junior') }}"
                            class="nav-sublink {{ $reportCardType === 'junior' ? 'nav-sublink-active' : '' }}">
                            <span class="nav-dot"></span>
                            Junior Report Card
                        </a>
                    </li>

                    <!-- Elementary -->
                    <li>
                        <a href="{{ route('report.cards.index', 'elementary') }}"
                            class="nav-sublink {{ $reportCardType === 'elementary' ? 'nav-sublink-active' : '' }}">
                            <span class="nav-dot"></span>
                            Elementary Report Card
                        </a>
                    </li>

                    <!-- Senior -->
                    <li>
                        <a href="{{ route('report.cards.index', 'senior') }}"
                            class="nav-sublink {{ $reportCardType === 'senior' ? 'nav-sublink-active' : '' }}">
                            <span class="nav-dot"></span>
                            Senior Report Card
                        </a>
                    </li>

                    <li>
                        <a href="{{ route('report.cards.index', 'kindergarten') }}"
                            class="nav-sublink {{ $reportCardType === 'kindergarten' ? 'nav-sublink-active' : '' }}">
                            <span class="nav-dot"></span>
                            Kindergarten Report Card
                        </a>
                    </li>

                </ul>
            </li>




            @canany(['manage grades', 'assign grade teachers'])
                <li class="mb-0.5 group">
                    <a href="{{ route('grades.manage') }}"
                        class="nav-link {{ request()->routeIs('grades.manage') ? 'nav-active' : '' }}">
                        <i class="ri-graduation-cap-line nav-icon"></i>
                        <span class="text-sm">Grade Management</span>
                    </a>
                </li>
            @endcanany

            @can('manage academic subjects')
                <li class="mb-0.5 group">
                    <a href="{{ route('subjects.index') }}"
                        class="nav-link {{ request()->routeIs('subjects.index') ? 'nav-active' : '' }}">
                        <i class="ri-book-2-line nav-icon"></i>
                        <span class="text-sm">Subject Management</span>
                    </a>
                </li>
            @endcan


            <li class="nav-section text-orange-500 hover:text-orange-700 font-bold">Attendance Management</li>

            <li class="mb-0.5 group">
                <a href="{{ route('attendance.entry') }}"
                    class="nav-link {{ request()->routeIs('attendance.entry') ? 'active' : '' }}">
                    <i class='bx bxl-blogger nav-icon'></i>
                    <span class="text-sm">Attendance</span>
                </a>
            </li>

            @can('view attendance audit trail')
                <li class="mb-0.5 group">
                    <a href="{{ route('attendance.audit-trail') }}"
                        class="nav-link {{ request()->routeIs('attendance.audit-trail') ? 'active' : '' }}">
                        <i class='bx bx-archive nav-icon'></i>
                        <span class="text-sm">Attendance Audit Trail</span>
                    </a>
                </li>
            @endcan

            @can('manage periods')
                <li class="mb-0.5 group">
                    <a href="{{ route('attendance.periods') }}"
                        class="nav-link {{ request()->routeIs('attendance.periods') ? 'active' : '' }}">
                        <i class='bx bx-time-five nav-icon'></i>
                        <span class="text-sm">Manage Periods</span>
                    </a>
                </li>
            @endcan

            <li class="nav-section text-teal-500 font-bold">PERSONAL</li>

            <li class="mb-0.5 group">
                <a href="" class="nav-link">
                    <i class='bx bx-bell nav-icon'></i>
                    <span class="text-sm">Notifications</span>
                </a>
            </li>


            <li class="mb-0.5 group">
                <a href="{{ route('admin.settings.document-branding') }}" class="nav-link">
                    <i class='bx bx-paint nav-icon'></i>
                    <span class="text-sm">Document Branding</span>
                </a>
            </li>


            <div x-data="{ showLogoutModal: false }">

                <!-- Logout List Item -->
                <li class="mb-0.5 group mt-2 pt-2 border-t border-white/10">
                    <button type="button" @click="showLogoutModal = true"
                        class="flex font-bold items-center gap-3 py-2.5 px-3 w-full text-sm text-[#f84525] rounded-lg transition-all duration-200 hover:text-white hover:bg-[#002966]">
                        <i class="ri-shut-down-line nav-icon text-[#f84525]"></i>
                        <span>Logout</span>
                    </button>
                </li>

                <!-- Logout Confirm Modal -->
                <div x-show="showLogoutModal" x-cloak
                    class="fixed inset-0 z-50 flex items-center justify-center
               bg-black/60 backdrop-blur-sm px-2">
                    <div x-show="showLogoutModal" x-transition
                        class="bg-white w-full max-w-xs rounded-lg shadow-xl overflow-hidden">
                        <!-- Header -->
                        <div class="flex items-center justify-between px-3 py-2 bg-red-600 text-white">
                            <h3 class="text-xs font-semibold">Confirm Logout</h3>
                            <button @click="showLogoutModal = false"
                                class="p-1 rounded-full hover:bg-red-500 transition">
                                <i class="ri-close-line text-sm"></i>
                            </button>
                        </div>

                        <!-- Body -->
                        <div class="p-3 space-y-2 text-xs">
                            <p class="text-gray-700">
                                Are you sure you want to logout from the system?
                            </p>

                            <p class="text-red-600 flex items-center gap-1 text-[11px]">
                                <i class="ri-alert-line"></i>
                                You will need to login again to access the system.
                            </p>
                        </div>

                        <!-- Footer -->
                        <div class="px-3 py-2 bg-gray-50 border-t flex justify-end gap-1">
                            <button @click="showLogoutModal = false"
                                class="px-2 py-1 text-xs rounded border hover:bg-gray-100">
                                Cancel
                            </button>

                            <form method="POST" action="{{ route('logout') }}" x-data="{ submitting: false }"
                                @submit="submitting = true">
                                @csrf
                                <button type="submit"
                                    class="px-2 py-1 text-xs font-semibold bg-red-600 text-white rounded
                   hover:bg-red-700 flex items-center gap-2"
                                    :disabled="submitting">
                                    <!-- Spinner -->
                                    <svg x-show="submitting"
                                        class="animate-spin h-3 w-3 border-2 border-white border-t-transparent rounded-full"
                                        viewBox="0 0 24 24"></svg>

                                    <!-- Button text -->
                                    <span x-show="!submitting">Logout</span>
                                    <span x-show="submitting">Logging out…</span>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>

            </div>

        </ul>

    </div>
</div>

<div class="fixed top-0 left-0 w-full h-full bg-black/50 z-40 md:hidden sidebar-overlay"></div>

<!-- Sidebar-specific styles: spacing, hover, active states, scrollbar.
     Brand color (#001f4d), hover color (#002966), accent (#f84525) and all
     text colors are UNCHANGED — only spacing/interaction states are added. -->
<style>
    .sidebar-menu .nav-section {
        list-style: none;
        font-size: 11px;
        letter-spacing: 0.1em;
        text-transform: uppercase;
        padding: 0 12px;
        margin: 22px 0 8px;
    }

    .sidebar-menu .nav-section:first-child {
        margin-top: 4px;
    }

    .sidebar-menu .nav-link {
        display: flex;
        align-items: center;
        padding: 0.6rem 0.75rem;
        border-radius: 0.6rem;
        font-weight: 600;
        font-size: 0.875rem;
        color: #ffffff;
        border-left: 3px solid transparent;
        transition: background-color 0.2s ease, border-color 0.2s ease, transform 0.15s ease;
    }

    .sidebar-menu .nav-link:hover {
        background-color: #002966;
        color: #ffffff;
    }

    .sidebar-menu .nav-link:hover .nav-icon {
        color: #f84525;
        transform: translateX(2px);
    }

    /* Active (current page) link — locked to the hover color, orange accent border */
    .sidebar-menu .nav-link.nav-active {
        background-color: #002966;
        border-left-color: #f84525;
        box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
    }

    .sidebar-menu .nav-link.nav-active .nav-icon {
        color: #f84525;
    }

    .sidebar-menu .nav-icon {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 1.35rem;
        margin-right: 0.65rem;
        font-size: 1.05rem;
        flex-shrink: 0;
        transition: transform 0.2s ease, color 0.2s ease;
    }

    .sidebar-menu .nav-sublink {
        display: flex;
        align-items: center;
        gap: 0.55rem;
        font-size: 0.8125rem;
        color: #f84525;
        padding: 0.4rem 0.6rem;
        border-radius: 0.5rem;
        transition: background-color 0.2s ease, padding-left 0.2s ease;
    }

    .sidebar-menu .nav-sublink:hover {
        background-color: rgba(248, 69, 37, 0.12);
        color: #f84525;
        padding-left: 0.85rem;
    }

    .sidebar-menu .nav-sublink:hover .nav-dot {
        background-color: #f84525;
        transform: scale(1.3);
    }

    /* Active (current page) sub-link */
    .sidebar-menu .nav-sublink.nav-sublink-active {
        background-color: rgba(248, 69, 37, 0.16);
        padding-left: 0.85rem;
    }

    .sidebar-menu .nav-sublink.nav-sublink-active .nav-dot {
        background-color: #f84525;
        transform: scale(1.3);
    }

    .sidebar-menu .nav-dot {
        width: 5px;
        height: 5px;
        border-radius: 9999px;
        background-color: #f84525;
        opacity: 0.5;
        flex-shrink: 0;
        transition: background-color 0.2s ease, transform 0.2s ease, opacity 0.2s ease;
    }

    .sidebar-menu .nav-sublink:hover .nav-dot,
    .sidebar-menu .nav-sublink-active .nav-dot {
        opacity: 1;
    }

    /* Thin scrollbar using the existing accent color */
    .nav-scroll {
        scrollbar-width: thin;
        scrollbar-color: rgba(248, 69, 37, 0.5) transparent;
    }

    .nav-scroll::-webkit-scrollbar {
        width: 6px;
    }

    .nav-scroll::-webkit-scrollbar-track {
        background: transparent;
    }

    .nav-scroll::-webkit-scrollbar-thumb {
        background-color: rgba(248, 69, 37, 0.45);
        border-radius: 9999px;
    }

    .nav-scroll::-webkit-scrollbar-thumb:hover {
        background-color: rgba(248, 69, 37, 0.75);
    }
</style>
<!-- End Sidenav -->
