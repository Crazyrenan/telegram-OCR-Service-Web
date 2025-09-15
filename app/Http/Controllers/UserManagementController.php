<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class UserManagementController extends Controller
{
    /**
     * Display a listing of all users for management.
     */
    public function index()
    {
        Gate::authorize('manage-users');

        // Fetch all users from the default database connection.
        $users = User::paginate(10);

        return view('manage.users.index', ['users' => $users]);
    }

    /**
     * Update the role of a specific user.
     */
    public function updateRole(Request $request, User $user)
    {
        Gate::authorize('manage-users');

        $validated = $request->validate([
            'role' => 'required|in:manager,user',
        ]);

        $user->role = $validated['role'];
        $user->save();

        return back()->with('success', "{$user->name}'s role has been updated.");
    }
}

