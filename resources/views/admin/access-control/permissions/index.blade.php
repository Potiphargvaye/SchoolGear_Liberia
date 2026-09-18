@extends('layouts.admin')

@section('content')
    <div class="container mx-auto px-4 sm:px-6 py-6">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-6">

            <div>
                <h1 class="text-2xl sm:text-3xl font-bold text-slate-800">
                    Permission Management
                </h1>
                <p class="text-slate-500 text-sm mt-1">
                    Manage system permissions for LIPA LMS.
                </p>
            </div>

            <button onclick="openCreateModal()"
                class="inline-flex items-center justify-center gap-2 bg-[#155E8A] hover:bg-[#0F4A6E] text-white px-5 py-2.5 rounded-lg font-semibold text-sm transition-colors shadow-sm shrink-0">
                <i class="fas fa-plus text-xs"></i>
                Create Permission
            </button>

        </div>

        {{-- Messages --}}

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

        {{-- Toolbar: Search --}}
        <div class="bg-white border border-[#E2E8F0] rounded-xl p-3 sm:p-4 mb-5">
            <div class="flex flex-col sm:flex-row gap-3">

                <div class="relative flex-1">
                    <i
                        class="fas fa-magnifying-glass text-slate-400 text-sm absolute left-3.5 top-1/2 -translate-y-1/2"></i>
                    <input type="text" id="permissionSearchInput" value="{{ request('search') }}"
                        placeholder="Search permissions by name..." autocomplete="off"
                        class="w-full pl-10 pr-9 py-2.5 rounded-lg border border-slate-300 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                    <i id="permissionSearchSpinner"
                        class="fas fa-circle-notch fa-spin text-[#155E8A] text-sm absolute right-3.5 top-1/2 -translate-y-1/2 hidden"></i>
                </div>

                <button type="button" id="permissionSearchClear"
                    class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-50 transition-colors {{ request('search') ? '' : 'hidden' }}">
                    Clear
                </button>

            </div>
        </div>

        {{-- Table (live-updated via JS, no separate partial file) --}}

        <div class="bg-white shadow-sm rounded-xl border border-[#E2E8F0] overflow-hidden">

            <div id="permissionsTableWrapper">

                <div class="overflow-x-auto">

                    <table class="w-full min-w-[720px]">

                        <thead class="bg-[#155E8A] text-white">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">#</th>
                                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide">Permission
                                    Name</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Roles Using
                                </th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Created</th>
                                <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wide">Actions</th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-slate-100">

                            @forelse($permissions as $index => $permission)
                                <tr class="hover:bg-sky-50/60 transition-colors">

                                    <td class="px-6 py-4 text-sm text-slate-500">
                                        {{ $permissions->firstItem() + $index }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="font-semibold text-slate-800">
                                            {{ ucwords($permission->name) }}
                                        </div>
                                        <span class="text-xs text-slate-400">
                                            {{ $permission->guard_name }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center">
                                        <span
                                            class="inline-flex px-3 py-1 rounded-full bg-sky-100 text-[#155E8A] text-xs font-semibold">
                                            {{ $permission->roles_count }}
                                        </span>
                                    </td>

                                    <td class="px-6 py-4 text-center text-sm text-slate-500">
                                        {{ $permission->created_at->format('d M Y') }}
                                    </td>

                                    <td class="px-6 py-4">
                                        <div class="flex justify-center gap-2">

                                            {{-- EDIT --}}
                                            <button
                                                onclick="openEditModal('{{ $permission->id }}', '{{ $permission->name }}')"
                                                class="h-9 w-9 rounded-lg bg-amber-100 hover:bg-amber-500 hover:text-white text-amber-700 transition-colors flex items-center justify-center">
                                                <i class="fas fa-edit text-sm"></i>
                                            </button>

                                            {{-- DELETE --}}
                                            <form
                                                action="{{ route('admin.access-control.permissions.destroy', $permission) }}"
                                                method="POST" onsubmit="return confirm('Delete this permission?')">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="h-9 w-9 rounded-lg bg-red-100 hover:bg-[#B91C1C] hover:text-white text-[#B91C1C] transition-colors flex items-center justify-center">
                                                    <i class="fas fa-trash text-sm"></i>
                                                </button>
                                            </form>

                                        </div>
                                    </td>

                                </tr>

                            @empty

                                <tr>
                                    <td colspan="5" class="text-center py-16">
                                        <i class="fas fa-shield-halved text-5xl text-slate-300 mb-3"></i>
                                        <p class="text-slate-500 text-sm">
                                            @if (request('search'))
                                                No permissions found matching "<span
                                                    class="font-semibold">{{ request('search') }}</span>".
                                            @else
                                                No permissions found.
                                            @endif
                                        </p>
                                    </td>
                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

                <div class="bg-slate-50 px-4 sm:px-6 py-4 border-t border-[#E2E8F0]">
                    {{ $permissions->links() }}
                </div>

            </div>

        </div>

    </div>


    {{-- ========================= --}}
    {{-- CREATE PERMISSION MODAL --}}
    {{-- ========================= --}}

    <div id="createModal"
        class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center px-3 z-50">

        <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">

            <div class="relative bg-[#155E8A] px-6 py-5">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                <h2 class="text-white text-lg font-bold">
                    Create Permission
                </h2>
                <p class="text-sky-200 text-xs mt-0.5">Define a new system permission</p>
            </div>

            <form action="{{ route('admin.access-control.permissions.store') }}" method="POST">
                @csrf

                <div class="p-6 bg-[#F8FAFC]">
                    <label class="block mb-1.5 text-xs font-semibold text-slate-600">
                        Permission Name
                    </label>
                    <input name="name" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow"
                        placeholder="example: manage users">
                </div>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button type="button" onclick="closeCreateModal()"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors">
                        Save
                    </button>
                </div>
            </form>

        </div>

    </div>


    {{-- ========================= --}}
    {{-- EDIT PERMISSION MODAL --}}
    {{-- ========================= --}}

    <div id="editModal" class="fixed inset-0 bg-slate-900/70 backdrop-blur-sm hidden items-center justify-center px-3 z-50">

        <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 w-full max-w-md overflow-hidden">

            <div class="relative bg-[#155E8A] px-6 py-5">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>
                <h2 class="text-white text-lg font-bold">
                    Edit Permission
                </h2>
                <p class="text-sky-200 text-xs mt-0.5">Update an existing permission</p>
            </div>

            <form id="editForm" method="POST">
                @csrf
                @method('PUT')

                <div class="p-6 bg-[#F8FAFC]">
                    <label class="block mb-1.5 text-xs font-semibold text-slate-600">
                        Permission Name
                    </label>
                    <input id="editPermissionName" name="name" required
                        class="w-full rounded-lg border border-slate-300 px-3.5 py-2.5 text-sm text-slate-700 placeholder-slate-400 focus:ring-2 focus:ring-[#155E8A]/30 focus:border-[#155E8A] transition-shadow">
                </div>

                <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex justify-end gap-2">
                    <button type="button" onclick="closeEditModal()"
                        class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                        Cancel
                    </button>
                    <button
                        class="px-5 py-2.5 rounded-lg bg-[#155E8A] hover:bg-[#0F4A6E] text-white font-semibold text-sm transition-colors">
                        Update
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
        }

        function openEditModal(id, name) {
            document.getElementById('editPermissionName').value = name;
            document.getElementById('editForm').action = "/admin/access-control/permissions/" + id;

            document.getElementById('editModal').classList.remove('hidden');
            document.getElementById('editModal').classList.add('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
        }

        // ===================================================
        // LIVE SEARCH (instant filter, no page reload, no partial view)
        // Fetches the SAME full page for a given search/page URL,
        // then pulls out just the #permissionsTableWrapper content.
        // ===================================================
        (function() {
            const input = document.getElementById('permissionSearchInput');
            const clearBtn = document.getElementById('permissionSearchClear');
            const spinner = document.getElementById('permissionSearchSpinner');
            const wrapper = document.getElementById('permissionsTableWrapper');
            const baseUrl = "{{ route('admin.access-control.permissions.index') }}";

            let debounceTimer = null;

            function swapTable(url) {
                spinner.classList.remove('hidden');

                fetch(url)
                    .then(res => res.text())
                    .then(html => {
                        const parser = new DOMParser();
                        const doc = parser.parseFromString(html, 'text/html');
                        const newWrapper = doc.getElementById('permissionsTableWrapper');

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

            // Intercept pagination links inside the table wrapper so paging
            // also stays instant instead of reloading the page.
            wrapper.addEventListener('click', function(e) {
                const link = e.target.closest('a');
                if (!link) return;

                e.preventDefault();
                swapTable(link.href);
            });
        })();
    </script>
@endsection
