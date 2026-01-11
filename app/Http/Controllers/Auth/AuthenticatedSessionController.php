<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
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

    protected function ensureIsNotRateLimited(Request $request): void
    {
        // Check if the user has made more than 3 attempts in 1 minute (60 seconds)
        if (! RateLimiter::tooManyAttempts($this->throttleKey($request), 3)) {
            return;
        }

        $seconds = RateLimiter::availableIn($this->throttleKey($request));

        // Flash the seconds to the session for the frontend countdown
        session()->flash('login_lock_seconds', $seconds);

        throw ValidationException::withMessages([
            'email' => __('Too many login attempts. Please try again later.'),
        ]);
    }

    protected function throttleKey(Request $request): string
    {
        return Str::lower($request->input('email')).'|'.$request->ip();
    }


    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        // 1. Check if user is already locked
        $this->ensureIsNotRateLimited($request);

        try {
            // 2. Attempt login
            $request->authenticate();
        } catch (ValidationException $e) {
            // 3. Increment attempts on failure (set to 300 seconds/5 mins)
            RateLimiter::hit($this->throttleKey($request), 300);
            throw $e;
        }

        // 4. Clear attempts on success
        RateLimiter::clear($this->throttleKey($request));

        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
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
