<?php

namespace App\Http\Controllers\Students;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\Student;
use App\Notifications\PasswordResetSuccessNotification;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class StudentProfileController extends Controller
{
    public function show(Request $request): View
    {
        [$user, $student, $school, $enrollment] = $this->profileContext($request);

        $imagePath = $student->image ?: $user->image;
        $profileImage = $imagePath && Storage::disk('public')->exists($imagePath)
            ? $imagePath
            : null;
        $academicYear = $enrollment?->academicYear;
        $initials = collect(preg_split('/\s+/', trim($student->name ?: $user->name)) ?: [])
            ->filter()
            ->take(2)
            ->map(fn (string $part) => mb_substr($part, 0, 1))
            ->implode('');

        return view('student.profile', compact(
            'user',
            'student',
            'school',
            'enrollment',
            'academicYear',
            'profileImage',
            'initials'
        ));
    }

    public function updatePassword(Request $request): RedirectResponse
    {
        [$user] = $this->profileContext($request);

        $validated = $request->validate([
    'current_password' => ['required', 'string'],
    'password' => ['required', 'string', 'confirmed'],
]);

        $limiterKey = 'student-profile-password:' . hash('sha256', $user->id . '|' . $request->ip());

        if (RateLimiter::tooManyAttempts($limiterKey, 5)) {
            $seconds = RateLimiter::availableIn($limiterKey);

            throw ValidationException::withMessages([
                'current_password' => 'Too many incorrect password attempts. Try again in ' . ceil($seconds / 60) . ' minutes.',
            ]);
        }

        if (! Hash::check($validated['current_password'], $user->getAuthPassword())) {
            RateLimiter::hit($limiterKey, 300);

            throw ValidationException::withMessages([
                'current_password' => 'The current password is incorrect.',
            ]);
        }

        RateLimiter::clear($limiterKey);

        if (Hash::check($validated['password'], $user->getAuthPassword())) {
            throw ValidationException::withMessages([
                'password' => 'The new password must be different from your current password.',
            ]);
        }

        $user->password = Hash::make($validated['password']);
        $user->save();
        $request->session()->put('password_hash_' . Auth::getDefaultDriver(), $user->getAuthPassword());
        $request->replace($request->except(['current_password', 'password', 'password_confirmation']));
        unset($validated['current_password'], $validated['password'], $validated['password_confirmation']);

        $redirect = redirect()
            ->route('student.profile')
            ->with('success', 'Your password has been updated.');

        try {
            $user->notify(new PasswordResetSuccessNotification($user));
        } catch (\Throwable $exception) {
            Log::warning('Student password confirmation email could not be sent.', [
                'user_id' => $user->id,
                'exception' => $exception->getMessage(),
            ]);

            $redirect->with('error', 'Your password was changed, but the confirmation email could not be sent.');
        }

        return $redirect;
    }

    private function profileContext(Request $request): array
    {
        $user = $request->user();
        abort_unless($user && $user->school_id, 404);

        $student = Student::query()
            ->where('user_id', $user->id)
            ->where('school_id', $user->school_id)
            ->with([
                'admission' => fn ($query) => $query->where('school_id', $user->school_id),
                'school',
            ])
            ->firstOrFail();

        $school = $student->school;
        abort_unless($school, 404);

        $enrollment = Enrollment::query()
            ->with(['grade', 'academicYear'])
            ->where('school_id', $user->school_id)
            ->where('student_id', $student->id)
            ->where('status', 'active')
            ->latest('updated_at')
            ->first();

        return [$user->loadMissing('school'), $student, $school, $enrollment];
    }
}
