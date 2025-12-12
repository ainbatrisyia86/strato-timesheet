<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->staff_name;
        $role = $request->role;

        $users = User::query()
            ->when($search, function ($query, $search) {
                $query->where('name', 'LIKE', "%$search%");
            })
            ->when($role, function ($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('name', 'asc') // <-- sort alphabetically A-Z
            ->get();

        return view('users', compact('users'));
    }

}
