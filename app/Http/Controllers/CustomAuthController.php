<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomAuthController extends Controller
{

    /**
     * Show the registration page
     */
    public function register()
    {
        return view('auth.register');
    }

    /**
     * Handle user registration form submission
     */
    public function storeUser(Request $request)
    {
        // Validate registration input
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
        ]);

        // Create new user
        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
        ]);

        //redirect to login with success message
        return redirect()->route('login')
        ->with('success', 'Account created successfully');
    }

    /**
     * Show custom login form
     */
    public function showLoginForm()
    {
       // If user is already logged in, redirect to timesheets page
        if (Auth::check()) {
            return redirect('/timesheets');
        }
        
        return view('auth.custom-login');
    }

    /**
     * Handle login request
     */
    public function login(Request $request)
    {
        //Validate login credentials
        $request->validate([
            'email'    => 'required|email',
            'password' => 'required|min:6',
        ]);

        // Get only email and password from request
        $credentials = $request->only('email','password');

        // Attempt to authenticate user
        if (Auth::attempt($credentials, $request->filled('remember'))) {
            $request->session()->regenerate();

            // Redirect to timesheet page after login
            return redirect()->route('timesheet.index');

        }

        // If login fails, return back with error message
        return back()
        ->withErrors(['email' => 'These credentials do not match our records.'])
        ->withInput();
    }

    /**
     * Handle user logout
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    }
}
