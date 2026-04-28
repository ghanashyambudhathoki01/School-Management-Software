<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAccessExpiry
{
    /**
     * Check if user's account access has expired.
     * Super admins bypass this check.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user) {
            return $next($request);
        }

        // Super admins bypass expiry checks
        if ($user->isSuperAdmin()) {
            return $next($request);
        }

        // Check if account is suspended
        if ($user->isSuspended()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Your account has been suspended. Please contact the Software owner.');
        }

        // Check if account is disabled
        if ($user->isDisabled()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Your account has been disabled. Please contact the Software owner.');
        }

        // Check if account has expired
        if ($user->isExpired()) {
            // Update status to expired if not already
            if ($user->access_status !== 'expired') {
                $user->update(['access_status' => 'expired']);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Your account access has expired. Please contact Software owner.');
        }

        // Check if account is not active
        if (!$user->isActive()) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect()->route('login')
                ->with('error', 'Your account is not active. Please contact Software owner.');
        }

        return $next($request);
    }
}
