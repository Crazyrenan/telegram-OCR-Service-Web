<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);
        $user = $request->user();
        Auth::logout();
        $user->delete();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return Redirect::to('/');
    }

    /**
     * API endpoint for the bot to connect a user via email.
     */
    public function registerTelegramUserApi(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'chat_id' => 'required|string', // chat_id can be a string
        ]);

        $user = User::where('email', $validated['email'])->first();

        if (!$user) {
            return response()->json(['success' => false, 'message' => 'No user account was found with that email address.'], 404);
        }

        // Check if this chat ID is already connected to any user
        $existingConnection = DB::table('telegram_connections')
            ->where('chat_id', $validated['chat_id'])
            ->first();

        if ($existingConnection) {
            return response()->json(['success' => false, 'message' => 'This Telegram account is already connected to a user.'], 400);
        }

        // Create the new connection
        DB::table('telegram_connections')->insert([
            'user_id' => $user->id,
            'chat_id' => $validated['chat_id'],
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        return response()->json(['success' => true, 'message' => 'Account connected successfully!']);
    }

    /**
     * API endpoint for the bot to check a user's permissions.
     * This now checks the new pivot table.
     */
    public function checkTelegramUserApi(Request $request)
    {
        $chatId = $request->input('chat_id');
        
        // Find the connection in the new table
        $connection = DB::table('telegram_connections')->where('chat_id', $chatId)->first();

        if (!$connection) {
            return response()->json(['status' => 'unauthorized'], 401);
        }

        // Find the associated user and return their role
        $user = User::find($connection->user_id);

        if (!$user) {
            return response()->json(['status' => 'unauthorized', 'message' => 'User not found.'], 401);
        }

        return response()->json([
            'status' => 'authorized',
            'role' => $user->role,
        ]);
    }
}

