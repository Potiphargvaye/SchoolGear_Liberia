@extends('layouts.student')

@section('title', 'My Profile')

@push('styles')
<style>
    .student-profile { min-width: 0; color: var(--ink); }
    .student-profile-heading { margin-bottom: 22px; }
    .student-profile-heading h1 { margin: 0; font-size: clamp(22px, 3vw, 29px); line-height: 1.25; }
    .student-profile-heading p { margin: 7px 0 0; color: var(--muted); }
    .student-profile-grid { display: grid; grid-template-columns: minmax(0, 1fr) minmax(300px, .82fr); gap: 20px; align-items: start; }
    .student-profile-card { min-width: 0; padding: 22px; border: 1px solid var(--line); border-radius: 17px; background: #fff; }
    .student-profile-identity { display: flex; min-width: 0; align-items: center; gap: 15px; padding-bottom: 20px; border-bottom: 1px solid var(--line); }
    .student-profile-photo { display: flex; width: 72px; height: 72px; flex: 0 0 72px; align-items: center; justify-content: center; overflow: hidden; border-radius: 50%; background: #E9E5FF; color: var(--purple); font-size: 22px; font-weight: 600; }
    .student-profile-photo img { width: 100%; height: 100%; object-fit: cover; }
    .student-profile-identity-copy { min-width: 0; }
    .student-profile-identity h2 { margin: 0; overflow-wrap: anywhere; font-size: 19px; line-height: 1.35; }
    .student-profile-identity p { margin: 5px 0 0; color: var(--muted); overflow-wrap: anywhere; }
    .student-profile-details { display: grid; grid-template-columns: repeat(2, minmax(0, 1fr)); gap: 16px 18px; padding-top: 20px; }
    .student-profile-detail { min-width: 0; }
    .student-profile-detail dt { color: var(--muted); font-size: 11px; font-weight: 600; letter-spacing: .04em; text-transform: uppercase; }
    .student-profile-detail dd { margin: 4px 0 0; overflow-wrap: anywhere; font-weight: 500; }
    .student-profile-note { margin: 20px 0 0; padding: 11px 13px; border-radius: 10px; background: var(--yellow-soft); color: var(--yellow-ink); font-size: 12px; }
    .student-profile-card h2.student-profile-section-title { margin: 0; font-size: 17px; }
    .student-password-intro { margin: 5px 0 18px; color: var(--muted); font-size: 12.5px; }
    .student-password-fields { display: grid; gap: 14px; }
    .student-password-field label { display: block; margin-bottom: 6px; font-size: 12px; font-weight: 600; }
    .student-password-input-wrap { position: relative; }
    .student-password-input { display: block; width: 100%; min-height: 44px; padding: 10px 46px 10px 12px; border: 1px solid #D9D6E8; border-radius: 10px; background: #fff; color: var(--ink); font: inherit; font-size: 13px; }
    .student-password-input:focus { border-color: var(--purple-bright); outline: 3px solid rgba(91, 63, 224, .14); }
    .student-password-toggle { position: absolute; top: 2px; right: 2px; display: flex; width: 40px; height: 40px; align-items: center; justify-content: center; border: 0; border-radius: 8px; background: transparent; color: var(--muted); cursor: pointer; }
    .student-password-toggle:hover { color: var(--purple); }
    .student-profile-error { margin: 5px 0 0; color: #B42318; font-size: 12px; }
    .student-password-match { min-height: 18px; margin: 0; font-size: 12px; }
    .student-password-match.is-match { color: #16803C; }
    .student-password-match.is-mismatch { color: #B42318; }
    .student-password-submit { display: inline-flex; min-height: 42px; align-items: center; justify-content: center; gap: 8px; padding: 9px 16px; border: 0; border-radius: 10px; background: var(--purple); color: #fff; font: inherit; font-size: 13px; font-weight: 600; cursor: pointer; }
    .student-password-submit:hover { background: var(--purple-deep); }
    .student-password-submit:disabled { opacity: .7; cursor: wait; }
    .student-password-spinner { width: 15px; height: 15px; animation: student-password-spin .7s linear infinite; }
    @keyframes student-password-spin { to { transform: rotate(360deg); } }
    #notificationContainer { position: fixed; z-index: 9999; top: 20px; right: 20px; display: grid; width: max-content; max-width: calc(100vw - 40px); gap: 12px; }
    #notificationContainer > div { max-width: 100%; padding: 12px 16px; border-radius: 10px; box-shadow: 0 8px 24px rgba(34, 28, 83, .18); color: #fff; font-size: 13px; font-weight: 600; overflow-wrap: anywhere; transition: opacity .3s ease, transform .3s ease; }
    #notificationContainer > div.bg-green-600 { background: #16a34a; }
    #notificationContainer > div.bg-red-600 { background: #dc2626; }
    #notificationContainer > div.bg-blue-600 { background: #2563eb; }
    #notificationContainer > div.opacity-0 { opacity: 0; }
    #notificationContainer > div.-translate-y-2 { transform: translateY(-8px); }
    @media (max-width: 420px) { #notificationContainer { top: 12px; right: 12px; max-width: calc(100vw - 48px); } }
    @media (max-width: 760px) {
        .student-profile-grid { grid-template-columns: minmax(0, 1fr); gap: 14px; }
        .student-profile-card { padding: 16px; }
    }
    @media (max-width: 420px) {
        .student-profile-details { grid-template-columns: minmax(0, 1fr); gap: 12px; }
        .student-profile-photo { width: 60px; height: 60px; flex-basis: 60px; }
    }
</style>
@endpush

@section('content')
@include('partials.notifications')
<div class="student-profile">
    <header class="student-profile-heading">
        <h1>My Profile</h1>
        <p>Review your school and student information or change your password.</p>
    </header>

    <div class="student-profile-grid">
        <section class="student-profile-card" aria-labelledby="student-profile-information">
            <div class="student-profile-identity">
                <span class="student-profile-photo">
                    @if($profileImage)
                        <img src="{{ asset('storage/'.$profileImage) }}" alt="" onerror="this.hidden=true; this.nextElementSibling.hidden=false">
                        <span hidden>{{ $initials ?: '?' }}</span>
                    @else
                        {{ $initials ?: '?' }}
                    @endif
                </span>
                <div class="student-profile-identity-copy">
                    <h2 id="student-profile-information">{{ $student->name ?: $user->name }}</h2>
                    <p>{{ $user->registration_id ?: 'Registration ID not available' }}</p>
                </div>
            </div>

            <dl class="student-profile-details">
                <div class="student-profile-detail"><dt>Email</dt><dd>{{ $user->email ?: 'Not available' }}</dd></div>
                <div class="student-profile-detail"><dt>Class</dt><dd>{{ $enrollment?->grade?->full_name ?? 'Not enrolled' }}</dd></div>
                <div class="student-profile-detail"><dt>Academic year</dt><dd>{{ $academicYear?->name ?? 'Not available' }}</dd></div>
                <div class="student-profile-detail"><dt>Admission number</dt><dd>{{ $student->admission?->admission_number ?? 'Not available' }}</dd></div>
                <div class="student-profile-detail"><dt>Admission date</dt><dd>{{ $student->admission?->date_of_admission?->format('M j, Y') ?? 'Not available' }}</dd></div>
                <div class="student-profile-detail"><dt>Age</dt><dd>{{ $student->age ?: 'Not available' }}</dd></div>
                <div class="student-profile-detail"><dt>Gender</dt><dd>{{ $student->gender ?: 'Not available' }}</dd></div>
                <div class="student-profile-detail"><dt>Parent/guardian phone</dt><dd>{{ $student->parent_phone ?: 'Not available' }}</dd></div>
                @if($student->admission?->student_type)
                    <div class="student-profile-detail"><dt>Student type</dt><dd>{{ $student->admission->student_type }}</dd></div>
                @endif
                @if($student->admission?->last_school_attended)
                    <div class="student-profile-detail"><dt>Previous school</dt><dd>{{ $student->admission->last_school_attended }}</dd></div>
                @endif
                <div class="student-profile-detail"><dt>School</dt><dd>{{ $school->school_name }}</dd></div>
                @if($school->address || $school->city || $school->country)
                    <div class="student-profile-detail"><dt>School address</dt><dd>{{ collect([$school->address, $school->city, $school->country])->filter()->implode(', ') }}</dd></div>
                @endif
                @if($school->phone)
                    <div class="student-profile-detail"><dt>School phone</dt><dd>{{ $school->phone }}</dd></div>
                @endif
            </dl>

            <p class="student-profile-note">To change these details, contact your school.</p>
        </section>

        <section class="student-profile-card" aria-labelledby="student-password-heading">
            <h2 id="student-password-heading" class="student-profile-section-title">Change password</h2>
            <p class="student-password-intro">Choose a password with at least 8 characters.</p>

            <form method="POST" action="{{ route('student.profile.password') }}"
                x-data="{ currentVisible: false, newVisible: false, confirmVisible: false, newPassword: '', confirmation: '', isSubmitting: false }"
                @submit="isSubmitting = true"
                @pageshow.window="isSubmitting = false"
            >
                @csrf
                @method('PUT')

                <div class="student-password-fields">
                    <div class="student-password-field">
                        <label for="student-current-password">Current password</label>
                        <div class="student-password-input-wrap">
                            <input id="student-current-password" class="student-password-input" name="current_password" required autocomplete="current-password" type="password" :type="currentVisible ? 'text' : 'password'">
                            <button type="button" class="student-password-toggle" @click="currentVisible = !currentVisible" :aria-label="currentVisible ? 'Hide current password' : 'Show current password'" :title="currentVisible ? 'Hide current password' : 'Show current password'">
                                <i class="fa-regular" :class="currentVisible ? 'fa-eye-slash' : 'fa-eye'" aria-hidden="true"></i>
                            </button>
                        </div>
                        @error('current_password')<p class="student-profile-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="student-password-field">
                        <label for="student-new-password">New password</label>
                        <div class="student-password-input-wrap">
                            <input id="student-new-password" class="student-password-input" name="password" required autocomplete="new-password" type="password" x-model="newPassword" :type="newVisible ? 'text' : 'password'">
                            <button type="button" class="student-password-toggle" @click="newVisible = !newVisible" :aria-label="newVisible ? 'Hide new password' : 'Show new password'" :title="newVisible ? 'Hide new password' : 'Show new password'">
                                <i class="fa-regular" :class="newVisible ? 'fa-eye-slash' : 'fa-eye'" aria-hidden="true"></i>
                            </button>
                        </div>
                        @error('password')<p class="student-profile-error">{{ $message }}</p>@enderror
                    </div>

                    <div class="student-password-field">
                        <label for="student-password-confirmation">Confirm new password</label>
                        <div class="student-password-input-wrap">
                            <input id="student-password-confirmation" class="student-password-input" name="password_confirmation" required autocomplete="new-password" type="password" x-model="confirmation" :type="confirmVisible ? 'text' : 'password'">
                            <button type="button" class="student-password-toggle" @click="confirmVisible = !confirmVisible" :aria-label="confirmVisible ? 'Hide password confirmation' : 'Show password confirmation'" :title="confirmVisible ? 'Hide password confirmation' : 'Show password confirmation'">
                                <i class="fa-regular" :class="confirmVisible ? 'fa-eye-slash' : 'fa-eye'" aria-hidden="true"></i>
                            </button>
                        </div>
                        <p class="student-password-match" x-show="confirmation.length > 0" x-text="newPassword === confirmation ? 'Passwords match' : 'Passwords do not match'" :class="newPassword === confirmation ? 'is-match' : 'is-mismatch'"></p>
                    </div>

                    <div>
                        <button class="student-password-submit" type="submit" :disabled="isSubmitting" :aria-busy="isSubmitting.toString()">
                            <svg x-cloak x-show="isSubmitting" class="student-password-spinner" viewBox="0 0 24 24" fill="none" aria-hidden="true">
                                <circle cx="12" cy="12" r="9" stroke="currentColor" stroke-opacity=".3" stroke-width="3"></circle>
                                <path d="M21 12a9 9 0 0 0-9-9" stroke="currentColor" stroke-width="3" stroke-linecap="round"></path>
                            </svg>
                            <span x-text="isSubmitting ? 'Updating...' : 'Update password'">Update password</span>
                        </button>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
@endsection
