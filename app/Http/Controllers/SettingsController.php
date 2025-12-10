<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    /**
     * Display the Manage Users page.
     */
    public function manageUsers()
    {
        // Return the view for managing users
        return view('settings.users');
    }

    /**
     * Display the Manage Projects page.
     */
    public function manageProjects()
    {
        // Return the view for managing projects
        return view('settings.projects');
    }

    /**
     * Display the Configuration Settings page.
     */
    public function config()
    {
        // Return the view for configuration settings
        return view('settings.configuration');
    }
}
