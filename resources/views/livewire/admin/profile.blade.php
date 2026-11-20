<div class="space-y-6">
    @include('partials.notifications')

    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center">
            @if ($user->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image))
                <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                    class="h-20 w-20 shrink-0 rounded-full border border-slate-200 object-cover">
            @else
                <div aria-hidden="true"
                    class="flex h-20 w-20 shrink-0 items-center justify-center rounded-full bg-sky-100 text-2xl font-semibold text-[#155E8A]">
                    {{ strtoupper(collect(explode(' ', trim($user->name)))->filter()->take(2)->map(fn ($part) => mb_substr($part, 0, 1))->implode('')) ?: '?' }}
                </div>
            @endif
            <div class="min-w-0 flex-1">
                <h1 class="text-xl font-semibold text-slate-900">{{ $user->name }}</h1>
                <div class="mt-2 flex flex-wrap items-center gap-2">
                    @forelse ($roles as $role)
                        <span class="rounded-full bg-sky-50 px-2.5 py-1 text-xs font-medium text-[#155E8A]">
                            {{ $role }}
                        </span>
                    @empty
                        <span class="text-sm text-slate-500">No role assigned</span>
                    @endforelse
                </div>
                <p class="mt-2 text-sm text-slate-600">
                    {{ $user->school?->school_name ?? 'SchoolGear Platform' }}
                </p>
            </div>
        </div>
    </section>

    <form wire:submit.prevent="saveProfile" class="grid grid-cols-1 gap-6 lg:grid-cols-2">
        <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
            <h2 class="text-base font-semibold text-slate-900">Personal Information</h2>
            <p class="mt-1 text-sm text-slate-500">Update your name and review your account details.</p>

            <div class="mt-5 space-y-4">
                <div>
                    <label for="profile-name" class="mb-1.5 block text-sm font-medium text-slate-700">Name</label>
                    <input id="profile-name" type="text" wire:model="name" autocomplete="name"
                        class="w-full rounded-lg border border-slate-300 px-3 py-2.5 text-sm focus:border-[#155E8A] focus:outline-none focus:ring-2 focus:ring-[#155E8A]/15">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Registration ID</p>
                        <p class="mt-1 break-all font-mono text-sm text-slate-800">{{ $user->registration_id ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Email</p>
                        <p class="mt-1 break-all text-sm text-slate-800">{{ $user->email ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Account Status</p>
                        <p class="mt-1 text-sm capitalize text-slate-800">{{ $user->status ?: '—' }}</p>
                    </div>
                    <div>
                        <p class="text-xs font-medium uppercase tracking-wide text-slate-500">Member Since</p>
                        <p class="mt-1 text-sm text-slate-800">{{ $user->created_at?->format('d M Y') ?? '—' }}</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6">
            <h2 class="text-base font-semibold text-slate-900">Profile Photo</h2>
            <p class="mt-1 text-sm text-slate-500">Choose a JPG, PNG, or WebP image up to 2 MB.</p>

            <div class="mt-5 flex flex-col items-start gap-4 sm:flex-row sm:items-center">
                @if ($photo)
                    <img src="{{ $photo->temporaryUrl() }}" alt="New profile photo preview"
                        class="h-24 w-24 shrink-0 rounded-full border border-slate-200 object-cover">
                @elseif ($user->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($user->image))
                    <img src="{{ asset('storage/' . $user->image) }}" alt="{{ $user->name }}"
                        class="h-24 w-24 shrink-0 rounded-full border border-slate-200 object-cover">
                @else
                    <div aria-hidden="true"
                        class="flex h-24 w-24 shrink-0 items-center justify-center rounded-full bg-sky-100 text-2xl font-semibold text-[#155E8A]">
                        {{ strtoupper(collect(explode(' ', trim($user->name)))->filter()->take(2)->map(fn ($part) => mb_substr($part, 0, 1))->implode('')) ?: '?' }}
                    </div>
                @endif
                <div class="w-full">
                    <label for="profile-photo" class="mb-1.5 block text-sm font-medium text-slate-700">Upload photo</label>
                    <input id="profile-photo" type="file" wire:model="photo" accept=".jpg,.jpeg,.png,.webp"
                        class="block w-full text-sm text-slate-600 file:mr-3 file:rounded-md file:border-0 file:bg-slate-100 file:px-3 file:py-2 file:text-sm file:font-medium file:text-slate-700 hover:file:bg-slate-200">
                    @error('photo')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                    <div wire:loading wire:target="photo" class="mt-2 text-xs text-slate-500">Preparing photo preview...</div>
                    @if ($user->image)
                        <button type="button" wire:click="removePhoto" wire:loading.attr="disabled"
                            class="mt-3 text-sm font-medium text-red-700 underline underline-offset-2 hover:text-red-800">
                            Remove current photo
                        </button>
                    @endif
                </div>
            </div>
            <div class="mt-6 flex justify-end border-t border-slate-100 pt-4">
                <button type="submit" wire:loading.attr="disabled" wire:target="saveProfile,photo"
                    class="rounded-lg bg-[#155E8A] px-4 py-2.5 text-sm font-semibold text-white hover:bg-[#0F4A6E] disabled:opacity-60">
                    <span wire:loading.remove wire:target="saveProfile">Save Profile</span>
                    <span wire:loading wire:target="saveProfile">Saving...</span>
                </button>
            </div>
        </section>
    </form>

    <section class="rounded-xl border border-slate-200 bg-white p-5 sm:p-6" x-data="{ pass: '', confirm: '' }"
        x-on:profile-password-cleared.window="pass = ''; confirm = ''">
        <h2 class="text-base font-semibold text-slate-900">Security</h2>
        <p class="mt-1 text-sm text-slate-500">Change your account password.</p>

        <form wire:submit.prevent="updatePassword" class="mt-5 max-w-2xl space-y-4">
            <div>
                <label for="profile-current-password" class="mb-1.5 block text-sm font-medium text-slate-700">Current Password</label>
                @include('livewire.admin.partials.password-input', [
                    'inputId' => 'profile-current-password',
                    'field' => 'currentPassword',
                    'alpineModel' => '',
                    'label' => 'Current password',
                    'autocomplete' => 'current-password',
                ])
                @error('currentPassword')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div>
                    <label for="profile-new-password" class="mb-1.5 block text-sm font-medium text-slate-700">New Password</label>
                    @include('livewire.admin.partials.password-input', [
                        'inputId' => 'profile-new-password',
                        'field' => 'password',
                        'alpineModel' => 'pass',
                        'label' => 'New password',
                    ])
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label for="profile-password-confirmation" class="mb-1.5 block text-sm font-medium text-slate-700">Confirm New Password</label>
                    @include('livewire.admin.partials.password-input', [
                        'inputId' => 'profile-password-confirmation',
                        'field' => 'password_confirmation',
                        'alpineModel' => 'confirm',
                        'label' => 'Confirm new password',
                    ])
                </div>
            </div>
            <p class="text-xs" x-show="confirm.length > 0"
                x-text="pass === confirm ? '✓ Passwords match' : '✕ Passwords do not match'"
                :class="pass === confirm ? 'text-green-600' : 'text-red-600'"></p>

            <div class="flex justify-end border-t border-slate-100 pt-4">
                <button type="submit" wire:loading.attr="disabled" wire:target="updatePassword"
                    class="rounded-lg border border-[#155E8A] px-4 py-2.5 text-sm font-semibold text-[#155E8A] hover:bg-sky-50 disabled:opacity-60">
                    <span wire:loading.remove wire:target="updatePassword">Update Password</span>
                    <span wire:loading wire:target="updatePassword">Updating...</span>
                </button>
            </div>
        </form>
    </section>
</div>
