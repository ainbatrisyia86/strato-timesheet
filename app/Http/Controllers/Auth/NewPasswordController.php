<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password; // This is for Password::reset()
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password as PasswordRule; // Alternative import if needed

class NewPasswordController extends Controller
{
    /**
     * Display the password reset view.
     * when user clicks the reset link in their email
     */
    public function create(Request $request): View
    {
        return view('auth.reset-password', ['request' => $request]);
    }

    /**
     * Handle new password submission.
     * this functions update user's password.
     */
    public function store(Request $request): RedirectResponse
        {
        $request->validate([
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => [
                'required', 
                'confirmed', 
                PasswordRule::min(8)
                    ->letters()   
                    ->mixedCase() 
                    ->numbers()   
                    ->symbols(),  
            ],
        ]);

        /**
         * Attempt to reset the password.
         * Laravel automatically checks:
         * - token validity
         * - email existence
         */
        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            
            //callback if reset is successful
            function (User $user) use ($request) {
                $user->forceFill([
                    'password' => Hash::make($request->password),
                    'remember_token' => Str::random(60),
                ])->save();

                event(new PasswordReset($user));
            }
        );

        /**
         * If password reset is successful:
         * - Redirect to login page
         * Otherwise:
         * - Return back with error message
         */
        return $status == Password::PASSWORD_RESET
                    ? redirect()->route('login')->with('status', __($status))
                    : back()->withInput($request->only('email'))
                        ->withErrors(['email' => __($status)]);
    }
}
