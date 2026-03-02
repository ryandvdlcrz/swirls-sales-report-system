<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create()
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only('username', 'password');

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            throw \Illuminate\Validation\ValidationException::withMessages([
                'username' => trans('auth.failed'),
            ]);
        }

        $user = Auth::user();

        // Check if user is active
        if (! $user->is_active) {
            Auth::logout();
            $request->session()->invalidate();

            throw \Illuminate\Validation\ValidationException::withMessages([
                'username' => 'Your account has been deactivated.',
            ]);
        }

        // Check if merchant's branch is active
        if ($user->role === 'merchant' && ($user->branch === null || ! $user->branch->is_active)) {
            Auth::logout();
            $request->session()->invalidate();

            throw \Illuminate\Validation\ValidationException::withMessages([
                'username' => 'Your branch has been deactivated.',
            ]);
        }

        $request->session()->regenerate();

        if ($user->role === 'admin') {
            return redirect('/admin');
        } elseif ($user->role === 'merchant') {
            return redirect()->route('index');
        }

        Auth::logout();
        $request->session()->invalidate();

        throw \Illuminate\Validation\ValidationException::withMessages([
            'username' => 'Your account does not have access to this system.',
        ]);
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
