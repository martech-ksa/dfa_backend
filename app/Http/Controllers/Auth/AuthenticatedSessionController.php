<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle login request
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // Authenticate user
        $request->authenticate();

        // Regenerate session
        $request->session()->regenerate();

        $user = Auth::user();

        /*
        |--------------------------------------------------------------------------
        | 🚨 BLOCK DISABLED USERS
        |--------------------------------------------------------------------------
        */
        if (!$user->is_active) {
            Auth::logout();

            throw ValidationException::withMessages([
                'email' => 'Your account has been disabled. Contact administrator.',
            ]);
        }

        /*
        |--------------------------------------------------------------------------
        | ROLE-BASED REDIRECTION (SPATIE BEST PRACTICE)
        |--------------------------------------------------------------------------
        */

        if ($user->hasRole('Admin')) {
            return redirect()->intended(route('admin.dashboard'));
        }

        if ($user->hasRole('Teacher')) {
            return redirect()->intended(route('staff.attendance.dashboard'));
        }

        if ($user->hasRole('Parent')) {
            return redirect()->intended(route('parent.dashboard'));
        }

        if ($user->hasRole('Student')) {
            return redirect()->intended(route('student.dashboard'));
        }

        /*
        |--------------------------------------------------------------------------
        | FALLBACK (SAFETY)
        |--------------------------------------------------------------------------
        */
        return redirect()->route('dashboard');
    }

    /**
     * Logout
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}