<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Public\PublicStudentController;
use App\Http\Controllers\Public\SchoolRegistrationController;
use App\Http\Controllers\Public\DemoRequestController;

Route::get('/', function () {
    return view('public.index'); // <- note the dot notation for subfolders,
})->name('home');

Route::get('/about-us', function () {
    return view('public.about-us');
});

Route::get('/contact-us', function () {
    return view('public.contact-us');
});

Route::get('/sitemap.xml', function () {
    $host = parse_url(config('app.url'), PHP_URL_HOST) ?: 'schoolgearliberia.com';
    $host = preg_replace('/^www\./i', '', $host);
    $baseUrl = 'https://' . $host;
    $pages = [
        '/' => resource_path('views/public/index.blade.php'),
        '/about-us' => resource_path('views/public/about-us.blade.php'),
        '/contact-us' => resource_path('views/public/contact-us.blade.php'),
        '/book-demo' => resource_path('views/public/book-demo.blade.php'),
        '/school-registration' => resource_path('views/public/register.blade.php'),
    ];

    $urls = [];
    foreach ($pages as $path => $viewPath) {
        $urls[] = [
            'loc' => $baseUrl . ($path === '/' ? '/' : $path),
            'lastmod' => date(DATE_ATOM, filemtime($viewPath)),
        ];
    }

    return response()->view('public.sitemap', compact('urls'), 200, [
        'Content-Type' => 'application/xml; charset=UTF-8',
    ]);
});

Route::get('/registeration-form', function () {
    return view('public.registeration-form');
});




Route::get('/book-demo', [DemoRequestController::class, 'create'])
    ->name('public.book-demo');

Route::get('/school-registration', [SchoolRegistrationController::class, 'create'])
    ->name('public.register');


// Verification engine endpoint linking directly to your controller method above
// Verification engine endpoint explicitly looking for standard database primary IDs
// Verification engine endpoint looking for structural student_ids with slash character safety rules
Route::get('/verify/report-card/{id}', [PublicStudentController::class, 'verifyReportCard'])
    ->name('public.verify.report_card')
    ->where('id', '.*');

Route::get('/student/register', [PublicStudentController::class, 'create'])
    ->name('public.students.create');

Route::post('/student/register', [PublicStudentController::class, 'store'])
    ->name('public.students.store');
