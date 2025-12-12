<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class SettingsController extends Controller
{
    /**
     * Display the Manage Users page.
     */
    public function manageUsers(Request $request)
    {
        $search = $request->staff_name;
        $role = $request->role;

        $users = User::query()
            ->when($search, fn($q) => $q->where('name', 'LIKE', "%$search%"))
            ->when($role, fn($q) => $q->where('role', $role))
            ->orderBy('name')
            ->get();

        return view('settings.users', compact('users'));
    }

    /**
     * Show the form to edit a user.
     */
    public function editUser($id)
    {
        $user = User::findOrFail($id);
        return view('settings.editUser', compact('user'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('manage.users')->with('success', 'User deleted successfully.');
    }


    /**
     * Update a user in the database.
     */
    public function updateUser(Request $request, $id)
    {
        $user = User::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|string',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('manage.users')->with('success', 'User updated successfully.');
    }

    /**
     * Display the Manage Projects page.
     */
    public function manageProjects()
    {
        return view('settings.projects');
    }

    /**
     * Display the Configuration Settings page.
     */
    public function config()
    {
        return view('settings.configuration');
    }
}
