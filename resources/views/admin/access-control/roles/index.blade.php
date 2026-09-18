@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">

        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">
            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                    Role Management
                </h1>

                <p class="text-slate-500 text-sm mt-1">
                    Create and manage user roles for the LIPA Learning Management System.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="inline-flex items-center justify-center gap-2 bg-[#155E8A] hover:bg-[#0F4A6E] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm shrink-0">
                <i class="fas fa-plus text-xs"></i>
                Create Role
            </button>
        </div>

        <!-- Alerts -->

        @if (session('success'))
            <div
                class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div
                class="flex items-center gap-2 bg-red-50 border border-red-200 text-[#B91C1C] px-4 py-3 rounded-xl mb-5 text-sm">
                <i class="fas fa-circle-exclamation"></i>
                {{ session('error') }}
            </div>
        @endif

        <!-- Toolbar: Search -->
        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3 sm:p-4 mb-5">
            <div class="flex flex-col sm:flex-row gap-3">

                <div class="relative flex-1">
                    <i
                        class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" id="roleMgmtSearchInput" value="{{ request('search') }}"
                        placeholder="Search roles by name..." autocomplete="off"
                        class="w-full pl-10 pr-9 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    <i id="roleMgmtSearchSpinner"
                        class="fas fa-circle-notch fa-spin text-[#155E8A] text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden"></i>
                </div>

                <button type="button" id="roleMgmtSearchClear"
                    class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-50 transition-colors {{ request('search') ? '' : 'hidden' }}">
                    Clear
                </button>

            </div>
        </div>

        <!-- Roles Table -->

        <div class="bg-white rounded-xl shadow-sm border border-[#E2E8F0] overflow-hidden">

            <div id="rolesManagementTableWrapper">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[640px]">

                        <thead class="bg-[#155E8A] text-white">

                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Role Name</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Users</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Created</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                            </tr>

                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($roles as $index => $role)
                                <tr class="hover:bg-sky-50/60 transition-colors">

                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $roles->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4 font-semibold text-slate-800">
                                        {{ $role->name }}
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-sky-100 text-[#155E8A] text-xs font-semibold">
                                            {{ $role->users_count }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-slate-500">
                                        {{ $role->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">

                                        <div class="flex justify-center gap-2">

                                            <button onclick="editRole({{ $role->id }}, '{{ $role->name }}')"
                                                class="h-9 w-9 rounded-lg bg-amber-100 hover:bg-amber-500 hover:text-white text-amber-700 transition-colors flex items-center justify-center">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>

                                            @if ($role->name != 'Super Admin')
                                                <form method="POST"
                                                    action="{{ route('admin.access-control.roles.destroy', $role) }}"
                                                    onsubmit="return confirm('Delete this role?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button
                                                        class="h-9 w-9 rounded-lg bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] transition-colors flex items-center justify-center">
                                                        <i class="fas fa-trash text-sm"></i>
                                                    </button>

                                                </form>
                                            @endif

                                        </div>

                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <i class="fas fa-user-shield text-5xl text-slate-300 mb-3"></i>
                                        <p class="text-slate-500 text-sm">
                                            @if (request('search'))
                                                No roles found matching "<span
                                                    class="font-semibold">{{ request('search') }}</span>".
                                            @else
                                                No roles found.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <!-- Pagination -->

                <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
                    {{ $roles->links() }}
                </div>

            </div>

        </div>

    </div>


    <!-- ========================= -->
    <!-- CREATE ROLE MODAL -->
    <!-- ========================= -->

    <div id="createModal"
        class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center px-3 z-50">

        <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">

            <div class="relative bg-[#155E8A] px-6 py-5">

                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                <div class="flex items-center gap-3">

                    <div
                        class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo"
                            class="h-full w-full object-contain">
                    </div>

                    <div>
                        <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                            Liberia Institute of Public Administration
                        </p>
                        <h2 class="text-white text-lg font-bold leading-tight mt-0.5">
                            Create New Role
                        </h2>
                    </div>

                </div>

            </div>

            <form method="POST" action="{{ route('admin.access-control.roles.store') }}">

                @csrf

                <div class="p-6 bg-[#F8FAFC]">

                    <label class="block mb-1.5 text-xs font-semibold text-slate-600">
                        Role Name
                    </label>

                    <input type="text" name="name" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"
                        placeholder="e.g. Course Coordinator">

                </div>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">

                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>

                    <button
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors">
                        Save Role
                    </button>

                </div>

            </form>

        </div>

    </div>


    <!-- ========================= -->
    <!-- EDIT ROLE MODAL -->
    <!-- ========================= -->

    <div id="editModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center px-3 z-50">

        <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">

            <div class="relative bg-[#155E8A] px-6 py-5">

                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                <div class="flex items-center gap-3">

                    <div
                        class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                        <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}" alt="LIPA Logo"
                            class="h-full w-full object-contain">
                    </div>

                    <div>
                        <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                            Liberia Institute of Public Administration
                        </p>
                        <h2 class="text-white text-lg font-bold leading-tight mt-0.5">
                            Edit Role
                        </h2>
                    </div>

                </div>

            </div>

            <form method="POST" id="editForm">

                @csrf
                @method('PUT')

                <div class="p-6 bg-[#F8FAFC]">

                    <label class="block mb-1.5 text-xs font-semibold text-slate-600">
                        Role Name
                    </label>

                    <input id="editRoleName" name="name" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">

                </div>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">

                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>

                    <button
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors">
                        Update Role
                    </button>

                </div>

            </form>

        </div>

    </div>


    <script>
        function openCreateModal() {

            document.getElementById('createModal').classList.remove('hidden');
            document.getElementById('createModal').classList.add('flex');

        }

        function closeCreateModal() {

            document.getElementById('createModal').classList.add('hidden');
            document.getElementById('createModal').classList.remove('flex');

        }

        function editRole(id, name) {

            document.getElementById('editRoleName').value = name;

            document.getElementById('editForm').action =
                '/admin/access-control/roles/' + id;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');

        }

        function closeEditModal() {

            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');

        }

        // ===================================================
        // LIVE SEARCH for the Roles Management table
        // Same technique used on Permissions / Role-Permissions pages:
        // fetch the same full page for a given search/page URL, then
        // swap only the #rolesManagementTableWrapper content.
        // ===================================================
        (function() {
            const input = document.getElementById('roleMgmtSearchInput');
            const clearBtn = document.getElementById('roleMgmtSearchClear');
            const spinner = document.getElementById('roleMgmtSearchSpinner');
            const wrapper = document.getElementById('rolesManagementTableWrapper');
            const baseUrl = "{{ route('admin.access-control.roles.index') }}";

            let debounceTimer = null;

            function swapTable(url) {
                spinner.classList.remove('hidden');

                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newWrapper = doc.getElementById('rolesManagementTableWrapper');

                        if (newWrapper) {
                            wrapper.innerHTML = newWrapper.innerHTML;
                        }

                        window.history.replaceState({}, '', url);
                    })
                    .catch(() => {
                        // fail silently, leave existing table as-is
                    })
                    .finally(() => {
                        spinner.classList.add('hidden');
                    });
            }

            function runSearch(term) {
                const url = new URL(baseUrl, window.location.origin);
                if (term) url.searchParams.set('search', term);
                clearBtn.classList.toggle('hidden', !term);
                swapTable(url.toString());
            }

            input.addEventListener('input', function() {
                clearTimeout(debounceTimer);
                const term = this.value.trim();
                debounceTimer = setTimeout(() => runSearch(term), 350);
            });

            clearBtn.addEventListener('click', function() {
                input.value = '';
                runSearch('');
            });

            // Delegated click handler: works for pagination links (and any
            // future buttons) even after the wrapper's HTML gets swapped out.
            wrapper.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;

                e.preventDefault();
                swapTable(link.href);
            });
        })();
    </script>
@endsection
