<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Platform/Super Admin only: users that do not belong to any school.
 * Reuses the normal auth session; adds no new authentication.
 */
class EnsurePlatformAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        abort_unless($user && $user->school_id === null, 403);

        return $next($request);
    }
}
