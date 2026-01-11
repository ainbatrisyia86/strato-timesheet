<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;
use Illuminate\Validation\Rules\Password;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration page.
     */
    public function create(): View
    {
        return view('auth.register');
    }

     /**
     * Handle user registration form submission.
     * This function validates input and creates a new user.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => [
                'required', 
                'confirmed', 
                Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols(),
            ],
        ]);

        // Create new user record in database
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Trigger registered event (used for email verification if enabled)
        event(new Registered($user));

        // Redirect user to login page after successful registration
        return redirect()
        ->route('login')
        ->with('success', 'You have successfully registered!');
    }
}
