<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Show login form.
     */
    public function showLoginForm()
    {
        if (Auth::check()) {
            return $this->redirectToDashboard(Auth::user());
        }
        return view('auth.login');
    }

    /**
     * Handle login request.
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            $user = Auth::user();

            // Check access status for non-super-admin users
            if (!$user->isSuperAdmin()) {
                // Check if suspended
                if ($user->isSuspended()) {
                    Auth::logout();
                    return back()->with('error', 'Your account has been suspended. Please contact Software owner.');
                }

                // Check if disabled
                if ($user->isDisabled()) {
                    Auth::logout();
                    return back()->with('error', 'Your account has been disabled. Please contact Software owner.');
                }

                // Check if expired
                if ($user->isExpired()) {
                    if ($user->access_status !== 'expired') {
                        $user->update(['access_status' => 'expired']);
                    }
                    Auth::logout();
                    return back()->with('error', 'Your account access has expired. Please contact Software owner.');
                }
            }

            return $this->redirectToDashboard($user);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle logout.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login')->with('success', 'You have been logged out successfully.');
    }

    /**
     * Show forgot password form.
     */
    public function showForgotPasswordForm()
    {
        return view('auth.forgot-password');
    }

    /**
     * Handle forgot password request.
     */
    public function sendResetLink(Request $request)
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $status = Password::sendResetLink(
            $request->only('email')
        );

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Password reset link has been sent to your email.')
            : back()->withErrors(['email' => __($status)]);
    }

    /**
     * Show reset password form.
     */
    public function showResetPasswordForm(string $token)
    {
        return view('auth.reset-password', ['token' => $token]);
    }

    /**
     * Handle reset password.
     */
    public function resetPassword(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|min:8|confirmed',
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function ($user, string $password) {
                $user->forceFill([
                    'password' => Hash::make($password),
                ])->setRememberToken(Str::random(60));
                $user->save();
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Password has been reset successfully.')
            : back()->withErrors(['email' => [__($status)]]);
    }

    /**
     * Redirect user to their role-specific dashboard.
     */
    protected function redirectToDashboard($user)
    {
        return match ($user->role) {
            'super_admin' => redirect()->route('super_admin.dashboard'),
            'school_admin' => redirect()->route('school_admin.dashboard'),
            'teacher' => redirect()->route('teacher.dashboard'),
            default => abort(403, 'User role not recognized.'),
        };
    }
}
