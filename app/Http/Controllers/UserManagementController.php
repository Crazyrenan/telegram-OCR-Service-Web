<?php

    namespace App\Http\Controllers;

    use App\Models\User;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Gate;
    use Illuminate\Support\Facades\DB; // Import the DB facade

    class UserManagementController extends Controller
    {
        /**
         * Display a listing of all users for role management.
         */
        public function index()
        {
            Gate::authorize('manage-users');
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

        /**
         * NEW: Show a list of all users with a connected Telegram account.
         */
        public function listTelegramUsers()
        {
            Gate::authorize('manage-users');

            $connected_users = DB::table('telegram_connections as tc')
                ->join('users as u', 'tc.user_id', '=', 'u.id')
                ->select('tc.id', 'u.name', 'u.email', 'u.role', 'tc.chat_id')
                ->paginate(15);

            return view('manage.telegram.index', ['connections' => $connected_users]);
        }

        /**
         * NEW: Remove (unsubscribe) a user's Telegram connection by its connection ID.
         */
        public function removeTelegramUser($connectionId)
        {
            Gate::authorize('manage-users');

            DB::table('telegram_connections')->where('id', $connectionId)->delete();

            return back()->with('success', "Successfully disconnected the Telegram account.");
        }
    }
    
