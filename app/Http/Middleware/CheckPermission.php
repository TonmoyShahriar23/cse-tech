<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $permission): Response
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

        // Check permission
        if (!$user->hasPermission($permission)) {
            if ($request->expectsJson()) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }
            
            return redirect()->back()->with('error', 'You do not have permission to perform this action.');
        }

        return $next($request);
    }
}