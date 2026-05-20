<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        // 1. If the user is not logged in, kick them back to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Check if the user's role matches any of the allowed roles passed in the route
        $user = Auth::user();
        if (in_array($user->role, $roles)) {
            return $next($request);
        }

        // 3. If they don't have the right role, block them with an explicit 403 Forbidden page
        abort(403, 'Unauthorized action. You do not have the required role to view this page.');
    }
}