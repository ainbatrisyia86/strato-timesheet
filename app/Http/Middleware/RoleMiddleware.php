<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string  $role
     * @return mixed
     */
    public function handle($request, Closure $next, $role)
    {
        // Check if the user is authenticated
        if (!Auth::check()) {
            return redirect('login'); // Redirect to login if not authenticated
        }

        // Check if the authenticated user has the required role
        $user = Auth::user();
        if ($user->role !== $role) {
            abort(403, 'Unauthorized action.'); // Deny access if role does not match
        }

        return $next($request); // Allow access if role matches
    }
}
