<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Access Restricted SchoolGear Lib</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-[#F8FAFC] min-h-screen flex items-center justify-center px-4 py-10">

    @php
        $routeName = request()->route()?->getName() ?? '';

        $content = match (true) {
            str_contains($routeName, 'role-permissions') => [
                'title' => 'Role Permissions Restricted',
                'body' =>
                    'Role permissions are managed centrally by SchoolGear to keep access consistent and secure across every school.',
                'cta' => 'Need a role\'s permissions changed? Please contact SchoolGear Support.',
            ],
            str_contains($routeName, 'roles') => [
                'title' => 'Role Management Restricted',
                'body' =>
                    'Roles are managed centrally by SchoolGear to ensure consistent access and security across all schools.',
                'cta' => 'Need a new role or changes to an existing role? Please contact SchoolGear Support.',
            ],
            str_contains($routeName, 'permissions') => [
                'title' => 'Permission Management Restricted',
                'body' => 'Permissions are managed centrally by SchoolGear.',
                'cta' =>
                    'If your school needs a new permission or a change to an existing permission, please contact SchoolGear Support.',
            ],
            default => [
                'title' => 'Access Restricted',
                'body' => $exception->getMessage() ?: 'You do not have permission to access this page.',
                'cta' => 'If you believe this is a mistake, please contact SchoolGear Support.',
            ],
        };
    @endphp

    <div class="w-full max-w-md">
        <div class="bg-white rounded-2xl shadow-2xl ring-1 ring-black/5 overflow-hidden">

            {{-- Header band --}}
            <div class="relative bg-[#155E8A] px-6 pt-5 pb-6">
                <div class="absolute inset-x-0 bottom-0 h-1 bg-[#B91C1C]"></div>

                <div class="flex items-center gap-2.5 mb-3">
                    <div
                        class="h-9 w-9 shrink-0 rounded-full bg-white/10 border border-white/25 flex items-center justify-center">
                        <i class="fas fa-lock text-white text-sm"></i>
                    </div>
                    <p class="text-[11px] uppercase tracking-[0.14em] text-sky-200 font-semibold">
                        SchoolGear Liberia
                    </p>
                </div>

                <h1 class="text-white text-lg font-bold leading-tight">
                    {{ $content['title'] }}
                </h1>
            </div>

            {{-- Body --}}
            <div class="px-6 py-6 bg-[#F8FAFC] text-center space-y-4">
                <p class="text-sm text-slate-600 leading-relaxed">
                    {{ $content['body'] }}
                </p>

                <div class="flex items-start gap-2 bg-sky-50 border border-sky-100 rounded-xl px-4 py-3 text-left">
                    <i class="fas fa-circle-info text-[#0F4C81] mt-0.5 shrink-0"></i>
                    <p class="text-xs text-slate-600 leading-relaxed">
                        {{ $content['cta'] }}
                    </p>
                </div>
            </div>

            {{-- Footer actions --}}
            <div class="px-6 py-4 border-t border-[#E2E8F0] bg-white flex flex-col sm:flex-row justify-center gap-2">
                <button onclick="history.back()"
                    class="px-4 py-2.5 rounded-lg border border-slate-300 text-slate-600 font-medium text-sm hover:bg-slate-100 transition-colors">
                    <i class="fas fa-arrow-left text-xs mr-1"></i> Go Back
                </button>
                <a href="https://wa.me/231XXXXXXXXX" target="_blank" rel="noopener"
                    class="px-4 py-2.5 rounded-lg bg-[#25D366] hover:bg-[#1DA851] text-white font-semibold text-sm transition-colors text-center flex items-center justify-center gap-1.5">
                    <i class="fab fa-whatsapp text-sm"></i> Contact Support
                </a>
            </div>
        </div>
    </div>

</body>

</html>
