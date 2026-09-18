@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                Role Permission Management
            </h1>
            <p class="text-slate-500 text-sm mt-1">
                Assign permissions to system roles.
            </p>
        </div>

        {{-- Success Message --}}
        @if (session('success'))
            <div
                class="flex items-center gap-2 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl mb-5 text-sm">
                <i class="fas fa-circle-check"></i>
                {{ session('success') }}
            </div>
        @endif

        {{-- Toolbar: Search --}}
        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3 sm:p-4 mb-5">
            <div class="flex flex-col sm:flex-row gap-3">

                <div class="relative flex-1">
                    <i class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" id="roleSearchInput" value="{{ request('search') }}"
                        placeholder="Search roles by name..." autocomplete="off"
                        class="w-full pl-10 pr-9 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    <i id="roleSearchSpinner"
                        class="fas fa-circle-notch fa-spin text-[#155E8A] text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden"></i>
                </div>

                <button type="button" id="roleSearchClear"
                    class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-50 transition-colors {{ request('search') ? '' : 'hidden' }}">
                    Clear
                </button>

            </div>
        </div>

        {{-- Table Card --}}
        <div class="bg-white rounded-xl shadow-sm border border-[#E2E8F0] overflow-hidden">

            <div id="rolesTableWrapper">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[640px]">

                        <thead class="bg-[#155E8A] text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Role Name</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Permissions
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Action</th>
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
                                            class="inline-flex items-center px-3 py-1 bg-red-100 text-[#B91C1C] rounded-full text-xs font-semibold">
                                            {{ $role->permissions->count() }} Permissions
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <button type="button"
                                            class="managePermissionBtn inline-flex items-center gap-2 px-4 py-2 bg-[#155E8A] hover:bg-[#0F4A6E] text-white rounded-lg text-sm font-semibold transition-colors"
                                            data-role-id="{{ $role->id }}" data-role-name="{{ $role->name }}"
                                            data-permissions='@json($role->permissions->pluck('name')->values())'>
                                            <i class="fas fa-shield-alt text-xs"></i>
                                            Manage
                                        </button>
                                    </td>

                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center py-16">
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

                {{-- Pagination --}}
                <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
                    {{ $roles->links() }}
                </div>

            </div>

        </div>

    </div>

    {{-- ========================================================= --}}
    {{-- ASSIGN ROLE PERMISSIONS MODAL --}}
    {{-- ========================================================= --}}

    <div id="permissionModal"
        class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center z-50 p-3 sm:p-5">

        <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-5xl max-h-[92vh] overflow-hidden">

            {{-- Header --}}
            <div class="relative bg-[#155E8A] px-5 sm:px-6 py-5">

                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                <div class="flex items-start justify-between gap-3">

                    <div class="flex items-center gap-3 min-w-0">

                        <div
                            class="h-11 w-11 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center overflow-hidden p-1.5">
                            <img src="{{ asset('lipa-liberia-public-site/assets/img/logo/logo_header.png') }}"
                                alt="LIPA Logo" class="h-full w-full object-contain">
                        </div>

                        <div class="min-w-0">
                            <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold truncate">
                                Liberia Institute of Public Administration
                            </p>
                            <h2 class="text-white text-base sm:text-lg font-bold leading-tight mt-0.5">
                                Assign Permissions
                            </h2>
                            <p id="modalRoleName" class="text-sky-200 text-xs mt-0.5"></p>
                        </div>

                    </div>

                    <button type="button" onclick="closePermissionModal()"
                        class="shrink-0 h-9 w-9 rounded-lg bg-white/10 hover:bg-white/20 text-white transition-colors flex items-center justify-center">
                        <i class="fas fa-times text-sm"></i>
                    </button>

                </div>

            </div>

            <form id="permissionForm" method="POST">

                @csrf
                @method('PUT')

                <div class="p-4 sm:p-6 bg-[#F8FAFC] overflow-y-auto max-h-[65vh]">

                    {{-- Search --}}
                    <div class="relative mb-6">
                        <i
                            class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                        <input type="text" id="permissionSearch" placeholder="Search permissions..." autocomplete="off"
                            class="w-full pl-10 pr-3 py-3 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    </div>

                    @foreach ($permissions as $module => $modulePermissions)
                        <div class="mb-8 permission-group">

                            <h3
                                class="text-sm font-bold uppercase tracking-wide text-[#155E8A] mb-3 pb-2 border-b border-[#E2E8F0]">
                                {{ $module }}
                            </h3>

                            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-3">

                                @foreach ($modulePermissions as $permission)
                                    <label
                                        class="permission-card flex items-center gap-3 bg-white border border-slate-200 rounded-lg px-4 py-3 hover:border-[#155E8A] hover:bg-sky-50/60 cursor-pointer transition-colors">

                                        <input type="checkbox" class="permission-checkbox w-4 h-4 accent-[#155E8A]"
                                            value="{{ $permission->name }}" name="permissions[]">

                                        <span class="text-sm text-slate-700">
                                            {{ ucwords(str_replace('-', ' ', $permission->name)) }}
                                        </span>

                                    </label>
                                @endforeach

                            </div>

                        </div>
                    @endforeach

                </div>

                <div
                    class="bg-white border-t border-[#E2E8F0] px-4 sm:px-6 py-4 flex flex-col-reverse sm:flex-row justify-end gap-2">

                    <button type="button" onclick="closePermissionModal()"
                        class="px-4 py-2.5 border border-slate-300 text-slate-600 font-medium text-sm rounded-lg hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>

                    <button id="savePermissionBtn" type="submit"
                        class="px-6 py-2.5 bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm rounded-lg flex items-center justify-center gap-2 transition-colors">

                        <span id="savePermissionText">
                            Save Changes
                        </span>

                        <svg id="savePermissionSpinner" class="hidden animate-spin h-4 w-4"
                            xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">

                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                                stroke-width="4">
                            </circle>

                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                            </path>

                        </svg>

                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        document.addEventListener('click', function(e) {

            const button = e.target.closest('.managePermissionBtn');
            if (!button) return;

            let roleId = button.dataset.roleId;
            let roleName = button.dataset.roleName;
            let rolePermissions = JSON.parse(button.dataset.permissions);

            document.getElementById('permissionModal')
                .classList.remove('hidden');

            document.getElementById('permissionModal')
                .classList.add('flex');

            document.getElementById('modalRoleName').innerHTML = roleName;

            document.getElementById('permissionForm').action =
                "/admin/access-control/role-permissions/" + roleId;

            document.querySelectorAll('.permission-checkbox')
                .forEach(function(box) {

                    box.checked = rolePermissions.includes(box.value);

                });

        });

        function closePermissionModal() {

            document.getElementById('permissionModal')
                .classList.remove('flex');

            document.getElementById('permissionModal')
                .classList.add('hidden');

        }


        document.getElementById('permissionSearch')
            .addEventListener('keyup', function() {

                let value = this.value.toLowerCase();

                document.querySelectorAll('.permission-card').forEach(function(card) {

                    card.style.display =
                        card.innerText.toLowerCase().includes(value) ?
                        '' :
                        'none';

                });

            });

        // save button
        document.getElementById('permissionForm')
            .addEventListener('submit', function() {

                document
                    .getElementById('savePermissionSpinner')
                    .classList.remove('hidden');

                document
                    .getElementById('savePermissionText')
                    .innerHTML = 'Saving...';

                document
                    .getElementById('savePermissionBtn')
                    .disabled = true;

            });

        // ===================================================
        // LIVE SEARCH for the Roles table (instant, no reload)
        // Same technique as the Permissions page: fetch the same
        // full page for a given search/page URL, then swap only
        // the #rolesTableWrapper content — no extra partial file.
        // ===================================================
        (function() {
            const input = document.getElementById('roleSearchInput');
            const clearBtn = document.getElementById('roleSearchClear');
            const spinner = document.getElementById('roleSearchSpinner');
            const wrapper = document.getElementById('rolesTableWrapper');
            const baseUrl = "{{ route('admin.access-control.role-permissions.index') }}";

            let debounceTimer = null;

            function swapTable(url) {
                spinner.classList.remove('hidden');

                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newWrapper = doc.getElementById('rolesTableWrapper');

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

            wrapper.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;

                e.preventDefault();
                swapTable(link.href);
            });
        })();
    </script>
@endsection
