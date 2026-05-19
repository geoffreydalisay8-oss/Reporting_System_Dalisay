<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
// In AdminMiddleware.php
public function handle(Request $request, Closure $next)
{
    // Check if the user is logged in AND has either the 'admin' or 'staff' role
    if (auth()->check() && (auth()->user()->role === 'admin' || auth()->user()->role === 'staff')) {
        return $next($request);
    }

    // If they are just a regular user/employee, send them to the employee dashboard
    return redirect('/dashboard')->with('error', 'You do not have management access.');
}
}