@php
    $badge = [
        'pending' => 'bg-amber-50 text-amber-700 border-amber-200',
        'contacted' => 'bg-sky-50 text-sky-700 border-sky-200',
        'scheduled' => 'bg-violet-50 text-violet-700 border-violet-200',
        'completed' => 'bg-emerald-50 text-emerald-700 border-emerald-200',
        'cancelled' => 'bg-slate-100 text-slate-600 border-slate-200',
    ];
    $totalAll = $counts->sum();
@endphp


<div class="space-y-5">
    @include('partials.notifications')
    {{-- Page header --}}
    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <h1 class="text-xl font-semibold text-slate-800">Demo and consultation requests</h1>
            <p class="text-sm text-slate-500">Schools that asked to book a live demo or consultation.</p>
        </div>

        <a href="{{ route('admin.demo-requests.export', ['search' => $search, 'status' => $statusFilter]) }}"
            class="inline-flex items-center justify-center gap-2 rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
            <i class="fas fa-file-excel text-emerald-600"></i> Export to Excel
        </a>
    </div>

    {{-- Status filter with counts --}}
    <div class="flex flex-wrap gap-2">
        <button type="button" wire:click="$set('statusFilter', '')"
            class="rounded-md border px-3 py-1.5 text-sm {{ $statusFilter === '' ? 'border-[#5B3DE0] bg-[#5B3DE0] text-white' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
            All <span class="ml-1 opacity-80">{{ $totalAll }}</span>
        </button>

        @foreach (\App\Models\DemoRequest::STATUSES as $key => $statusLabel)
            <button type="button" wire:click="$set('statusFilter', '{{ $key }}')"
                wire:key="tab-{{ $key }}"
                class="rounded-md border px-3 py-1.5 text-sm {{ $statusFilter === $key ? 'border-[#5B3DE0] bg-[#5B3DE0] text-white' : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50' }}">
                {{ $statusLabel }} <span class="ml-1 opacity-80">{{ $counts[$key] ?? 0 }}</span>
            </button>
        @endforeach
    </div>

    {{-- Search --}}
    <div class="relative sm:max-w-md">
        <i
            class="fas fa-search pointer-events-none absolute left-3 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
        <input type="search" wire:model.live.debounce.300ms="search"
            placeholder="Search school, name, email, phone, city, or reference"
            class="w-full rounded-md border border-slate-300 bg-white py-2 pl-9 pr-3 text-sm outline-none focus:border-[#5B3DE0] focus:ring-2 focus:ring-[#5B3DE0]/20">
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto rounded-md border border-slate-200 bg-white">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-xs font-medium text-slate-500">
                <tr>
                    <th class="px-4 py-3">Reference</th>
                    <th class="px-4 py-3">School</th>
                    <th class="px-4 py-3">Contact</th>
                    <th class="px-4 py-3">Preferred slot</th>
                    <th class="px-4 py-3">Status</th>
                    <th class="px-4 py-3">Received</th>
                    <th class="px-4 py-3"><span class="sr-only">Actions</span></th>
                </tr>
            </thead>
            <tbody>
                @forelse ($requests as $r)
                    <tr wire:key="demo-{{ $r->id }}" class="border-t border-slate-100 hover:bg-slate-50">
                        <td class="whitespace-nowrap px-4 py-3 font-medium text-slate-700">{{ $r->reference }}</td>
                        <td class="px-4 py-3">
                            <div class="font-medium text-slate-800">{{ $r->school_name }}</div>
                            <div class="text-xs text-slate-500">{{ $r->city }}, {{ $r->category_label }}</div>
                        </td>
                        <td class="px-4 py-3">
                            <div class="text-slate-800">{{ $r->full_name }}</div>
                            <div class="text-xs text-slate-500">{{ $r->email }}</div>
                            <div class="text-xs text-slate-500">{{ $r->whatsapp_number }}</div>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3">
                            <div class="text-slate-800">{{ $r->preferred_date->format('D, M j, Y') }}</div>
                            <div class="text-xs text-slate-500">{{ $r->time_label }} GMT</div>
                        </td>
                        <td class="px-4 py-3">
                            <span
                                class="inline-flex rounded-full border px-2.5 py-0.5 text-xs font-medium {{ $badge[$r->status] ?? $badge['cancelled'] }}">
                                {{ $r->status_label }}
                            </span>
                        </td>
                        <td class="whitespace-nowrap px-4 py-3 text-slate-500">{{ $r->created_at->diffForHumans() }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-end gap-2">
                                <button type="button" wire:click="openDetails({{ $r->id }})"
                                    class="rounded-md border border-slate-300 px-3 py-1.5 text-xs font-medium text-slate-700 hover:bg-slate-100">
                                    View details
                                </button>
                                <button type="button" wire:click="confirmDelete({{ $r->id }})"
                                    title="Delete request" aria-label="Delete {{ $r->reference }}"
                                    class="rounded-md border border-red-200 px-2.5 py-1.5 text-xs text-red-600 hover:bg-red-50">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-12 text-center text-slate-500">
                            @if ($search !== '' || $statusFilter !== '')
                                No requests match these filters. Clear the search or pick another status.
                            @else
                                No demo requests yet. New bookings from the public page will appear here.
                            @endif
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div>{{ $requests->links() }}</div>

    {{-- Details + status modal --}}
    @if ($showDetails && $selected)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" wire:key="demo-modal"
            wire:keydown.escape="closeDetails">
            <div class="max-h-[90vh] w-full max-w-2xl overflow-y-auto rounded-md bg-white shadow-xl" role="dialog"
                aria-modal="true" aria-labelledby="demo-modal-title">

                <div class="flex items-start justify-between border-b border-slate-200 px-5 py-4">
                    <div>
                        <h2 id="demo-modal-title" class="text-lg font-semibold text-slate-800">
                            {{ $selected->school_name }}
                        </h2>
                        <p class="text-sm text-slate-500">
                            {{ $selected->reference }}, received {{ $selected->created_at->format('M j, Y g:i A') }}
                        </p>
                    </div>
                    <button type="button" wire:click="closeDetails" aria-label="Close"
                        class="rounded-md p-1.5 text-slate-400 hover:bg-slate-100 hover:text-slate-600">
                        <i class="fas fa-times"></i>
                    </button>
                </div>

                <div class="space-y-5 px-5 py-4 text-sm">
                    <dl class="grid grid-cols-1 gap-x-6 gap-y-3 sm:grid-cols-2">
                        <div>
                            <dt class="text-xs text-slate-500">Contact person</dt>
                            <dd class="font-medium text-slate-800">{{ $selected->full_name }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Email</dt>
                            <dd><a href="mailto:{{ $selected->email }}"
                                    class="font-medium text-[#5B3DE0] hover:underline">{{ $selected->email }}</a></dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">WhatsApp</dt>
                            <dd><a href="{{ $selected->whatsapp_link }}" target="_blank" rel="noopener"
                                    class="font-medium text-[#5B3DE0] hover:underline">{{ $selected->whatsapp_number }}</a>
                            </dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">School category</dt>
                            <dd class="font-medium text-slate-800">{{ $selected->category_label }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">City</dt>
                            <dd class="font-medium text-slate-800">{{ $selected->city }}</dd>
                        </div>
                        <div>
                            <dt class="text-xs text-slate-500">Preferred slot</dt>
                            <dd class="font-medium text-slate-800">
                                {{ $selected->preferred_date->format('l, M j, Y') }} at {{ $selected->time_label }}
                                GMT
                            </dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-slate-500">School address</dt>
                            <dd class="font-medium text-slate-800">{{ $selected->school_address }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-xs text-slate-500">Message</dt>
                            <dd class="whitespace-pre-line text-slate-700">
                                {{ $selected->message ?: 'No message provided.' }}</dd>
                        </div>
                        @if ($selected->status_changed_at)
                            <div class="sm:col-span-2">
                                <dt class="text-xs text-slate-500">Status last changed</dt>
                                <dd class="text-slate-700">{{ $selected->status_changed_at->format('M j, Y g:i A') }}
                                </dd>
                            </div>
                        @endif
                    </dl>

                    <form wire:submit="saveStatus" class="space-y-4 border-t border-slate-200 pt-4">
                        <div>
                            <label for="editStatus"
                                class="mb-1.5 block text-sm font-medium text-slate-700">Status</label>
                            <select id="editStatus" wire:model="editStatus"
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-[#5B3DE0] focus:ring-2 focus:ring-[#5B3DE0]/20 sm:max-w-xs">
                                @foreach (\App\Models\DemoRequest::STATUSES as $key => $statusLabel)
                                    <option value="{{ $key }}">{{ $statusLabel }}</option>
                                @endforeach
                            </select>
                            @error('editStatus')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label for="editNotes" class="mb-1.5 block text-sm font-medium text-slate-700">Internal
                                notes</label>
                            <textarea id="editNotes" rows="4" wire:model="editNotes" maxlength="2000"
                                placeholder="Call outcome, agreed time, follow-ups. Only platform admins can see this."
                                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-sm outline-none focus:border-[#5B3DE0] focus:ring-2 focus:ring-[#5B3DE0]/20"></textarea>
                            @error('editNotes')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="flex justify-end gap-3">
                            <button type="button" wire:click="closeDetails"
                                class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                                Cancel
                            </button>
                            <button type="submit" wire:loading.attr="disabled" wire:target="saveStatus"
                                class="inline-flex items-center gap-2 rounded-md bg-[#5B3DE0] px-4 py-2 text-sm font-medium text-white hover:bg-[#3A2A99] disabled:opacity-60">
                                <i class="fas fa-circle-notch fa-spin" wire:loading wire:target="saveStatus"></i>
                                Save changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif

    {{-- Delete confirmation modal (separate from the details modal) --}}
    @if ($showDeleteConfirm && $toDelete)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/50 p-4" style="z-index: 60;"
            wire:key="delete-modal" wire:keydown.escape="cancelDelete">
            <div class="w-full max-w-md rounded-md bg-white shadow-xl" role="alertdialog" aria-modal="true"
                aria-labelledby="delete-modal-title">
                <div class="px-5 py-5">
                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-red-50 text-red-600">
                        <i class="fas fa-trash"></i>
                    </div>
                    <h2 id="delete-modal-title" class="mt-4 text-lg font-semibold text-slate-800">
                        Delete this request?
                    </h2>
                    <p class="mt-1.5 text-sm text-slate-600">
                        You are about to permanently delete
                        <span class="font-medium">{{ $toDelete->reference }}</span>
                        from <span class="font-medium">{{ $toDelete->school_name }}</span>.
                        This cannot be undone.
                    </p>
                </div>
                <div class="flex justify-end gap-3 border-t border-slate-200 px-5 py-3">
                    <button type="button" wire:click="cancelDelete"
                        class="rounded-md border border-slate-300 bg-white px-4 py-2 text-sm font-medium text-slate-700 hover:bg-slate-50">
                        Cancel
                    </button>
                    <button type="button" wire:click="deleteRequest" wire:loading.attr="disabled"
                        wire:target="deleteRequest"
                        class="inline-flex items-center gap-2 rounded-md bg-red-600 px-4 py-2 text-sm font-medium text-white hover:bg-red-700 disabled:opacity-60">
                        <i class="fas fa-circle-notch fa-spin" wire:loading wire:target="deleteRequest"></i>
                        Yes, delete
                    </button>
                </div>
            </div>
        </div>
    @endif
</div>
