<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $user = Auth::user();

        // Check if user is suspended
        if ($user->is_suspended && $user->suspended_until && $user->suspended_until->isFuture()) {
            return redirect()->route('login')->with('error', 'Your account is suspended until ' . $user->suspended_until->format('Y-m-d H:i'));
        }

        // Check if user is active
        if (!$user->is_active) {
            return redirect()->route('login')->with('error', 'Your account has been deactivated. Please contact support.');
        }

        // Check role requirements
        if (!empty($roles)) {
            foreach ($roles as $role) {
                if ($user->hasRole($role)) {
                    return $next($request);
                }
            }
            
            // If no matching role found, redirect based on user's current role
            if ($user->hasRole('premium_user')) {
                return redirect()->route('chat.index')->with('error', 'You do not have permission to access this resource.');
            } elseif ($user->hasRole('admin')) {
                return redirect()->route('admin.dashboard')->with('error', 'You do not have permission to access this resource.');
            } else {
                return redirect()->route('chat.index')->with('error', 'You do not have permission to access this resource.');
            }
        }

        return $next($request);
    }
}