<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\Auth\NewPasswordController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Students\StudentDashboardController;
use App\Http\Controllers\TeacherDashboardController;

use App\Http\Controllers\Admin\GradeAssignmentController;
use App\Http\Controllers\TeacherMaterialController; // Correct import for the teacher controller 

use App\Http\Controllers\Admin\UserPermissionController;

use App\Http\Controllers\Students\StudentPortalGradeController;






// Debugging routes (added at the top for easy access)
Route::get('/user-avatar/{user}', function ($user) {
    $user = App\Models\User::findOrFail($user);

    // If no image in database, return initials SVG
    if (empty($user->image)) {
        return $this->generateInitialsAvatar($user->name);
    }

    $filename = basename($user->image);
    $path = str_replace('/', '\\', storage_path('app/public/profile-images/' . $filename));

    // If image file doesn't exist, return initials
    if (!file_exists($path)) {
        return $this->generateInitialsAvatar($user->name);
    }

    return response()->file($path);
})->name('user.avatar');

// Helper function to generate SVG avatars
function generateInitialsAvatar($name)
{
    $initials = '';
    $words = explode(' ', $name);
    foreach ($words as $word) {
        $initials .= strtoupper(substr(trim($word), 0, 1));
        if (strlen($initials) >= 2) break;
    }

    $svg = '<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
              <rect width="100" height="100" fill="#eee"/>
              <text x="50" y="60" font-size="40" text-anchor="middle" fill="#555">'
        . ($initials ?: '?') . '</text>
            </svg>';

    return response($svg, 200)
        ->header('Content-Type', 'image/svg+xml');
}

// Landing page route
Route::get('/', function () {
    return view('auth.login');
})->name('auth.login');
// Landing page route (updated)
require __DIR__ . '/public-page.php'; // for my public page routes 
require __DIR__ . '/admin/fees.php';
require __DIR__ . '/admin/dashboard.php';
require __DIR__ . '/admin/roles.php';
require __DIR__ . '/admin/permissions.php';
require __DIR__ . '/admin/role-permissions.php';
require __DIR__ . '/admin/users.php';
require __DIR__ . '/admin/schools.php'; // ADD THIS LINE
require __DIR__ . '/admin/academic-years.php';
require __DIR__ . '/admin/admissions.php';
require __DIR__ . '/admin/students.php';
require __DIR__ . '/admin/enrollments.php';
require __DIR__ . '/admin/settings.php';
require __DIR__ . '/admin/grades.php';
require __DIR__ . '/admin/subjects.php';
require __DIR__ . '/admin/report-cards.php';
require __DIR__ . '/admin/attendance.php';


// Admin-only registration routes (added this new section)
// In routes/web.php this will redirect admin to the register page
Route::middleware(['auth', 'can:is-admin'])->group(function () {
    Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
    Route::post('/register', [RegisteredUserController::class, 'store']);
});

// Authenticated routes (keep exactly as is)
Route::middleware('auth')->group(function () {
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Role-specific dashboards
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])
        ->middleware('can:is-student')
        ->name('student.dashboard');
});


// Admin routes (keep exactly as is)
Route::prefix('admin')->middleware(['auth', 'can:is-admin'])->group(function () {
    // The admin dashboard now lives in routes/admin/dashboard.php
    // (required at the top of this file) — it is registered there as
    // `admin.dashboard`. Do NOT add another /admin/dashboard GET route
    // here: an identical URI registered later in this file would shadow
    // the one defined in routes/admin/dashboard.php.


    // Grade Assignments
    Route::prefix('grade-assignments')->group(function () {
        Route::get('/', [GradeAssignmentController::class, 'index'])
            ->name('admin.grade-assignments');

        Route::post('/assign-teacher', [GradeAssignmentController::class, 'assignTeacher'])
            ->name('admin.assign-teacher');

        Route::delete('/unassign-teacher/{assignment}', [GradeAssignmentController::class, 'unassignTeacher'])
            ->name('admin.unassign-teacher');

        Route::post('/assign-homeroom-teacher', [GradeAssignmentController::class, 'assignHomeroomTeacher'])
            ->name('admin.assign-homeroom-teacher');

        Route::post('/{grade}/unassign-homeroom-teacher', [GradeAssignmentController::class, 'unassignHomeroomTeacher'])
            ->name('admin.unassign-homeroom-teacher');

        Route::post('/assign-student', [GradeAssignmentController::class, 'assignStudent'])
            ->name('admin.assign-student');

        Route::post('/students/{student}/unassign', [GradeAssignmentController::class, 'unassignStudent'])
            ->name('admin.unassign-student');

        Route::put('/grades/{grade}/subjects', [GradeAssignmentController::class, 'updateSubjects'])
            ->name('admin.update-grade-subjects');
    });
});

// Modified auth routes (replace the require line with these exact routes)
Route::middleware('guest')->group(function () {
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
    Route::get('forgot-password', [PasswordResetLinkController::class, 'create'])->name('password.request');
    Route::post('forgot-password', [PasswordResetLinkController::class, 'store'])->name('password.email');
    Route::get('reset-password/{token}', [NewPasswordController::class, 'create'])->name('password.reset');
    Route::post('reset-password', [NewPasswordController::class, 'store'])->name('password.store');
});

Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');


// Add this at the bottom of your current web.php, before the closing PHP tag if any

// Announcements Management
Route::prefix('admin')->middleware(['auth', 'can:is-admin'])->group(function () {
    Route::prefix('announcements')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\AnnouncementController::class, 'index'])
            ->name('admin.announcements.index');

        Route::get('/create', [\App\Http\Controllers\Admin\AnnouncementController::class, 'create'])
            ->name('admin.announcements.create');

        Route::post('/', [\App\Http\Controllers\Admin\AnnouncementController::class, 'store'])
            ->name('admin.announcements.store');

        Route::get('/{announcement}/edit', [\App\Http\Controllers\Admin\AnnouncementController::class, 'edit'])
            ->name('admin.announcements.edit');

        Route::put('/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'update'])
            ->name('admin.announcements.update');

        Route::delete('/{announcement}', [\App\Http\Controllers\Admin\AnnouncementController::class, 'destroy'])
            ->name('admin.announcements.destroy');
    });
});






// routes/web.php 





// ======Rout for student information  displaying  and  students  materials 

Route::middleware(['auth'])->group(function () {
    // Student routes
    Route::prefix('student')->name('student.')->group(function () {
        Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
        Route::get('/materials', [StudentDashboardController::class, 'materials'])->name('materials');
        Route::get('/grades', [StudentPortalGradeController::class, 'index'])

            ->name('grades');
    });
});

// routes for subjects 
Route::get('/subjects', [GradeAssignmentController::class, 'getSubjects'])->name('subjects.get');
Route::post('/subjects', [GradeAssignmentController::class, 'storeSubject'])->name('subjects.store');
Route::put('/subjects/{subject}', [GradeAssignmentController::class, 'updateSubject'])->name('subjects.update');
// Add this route for fetching single subject
Route::get('/subjects/{subject}', [GradeAssignmentController::class, 'getSubject'])->name('subjects.show');
