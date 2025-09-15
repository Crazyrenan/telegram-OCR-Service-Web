<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProfileController extends Controller
{
    public function edit(Request $request): View
    {
        $currentUser = $request->user();
        $now = Carbon::now();

        // This now correctly queries the default ('telegram') database
        $token = DB::table('telegram_verification_tokens')
            ->where('user_id', $currentUser->id)
            ->where('expires_at', '>', $now)
            ->first();
        
        Log::info($token ? 'SUCCESS: A valid token was found.' : 'FAILURE: No valid token was found.');

        return view('profile.edit', [
            'user' => $currentUser,
            'telegramToken' => $token,
        ]);
    }

    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }
        $request->user()->save();
        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }
    
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

    public function startTelegramConnection(Request $request): RedirectResponse
    {
        $user = $request->user();
        if (!$user) {
            return back()->with('error', 'Your session may have expired. Please try again.');
        }

        try {
            $token = Str::random(16);
            $now = Carbon::now();

            // This now correctly writes to the default ('telegram') database
            DB::table('telegram_verification_tokens')->updateOrInsert(
                ['user_id' => $user->id],
                [
                    'token' => $token,
                    'expires_at' => $now->copy()->addMinutes(10),
                    'created_at' => $now,
                    'updated_at' => $now,
                ]
            );
            
            Log::info('SUCCESS: Generated a new Telegram token for user: ' . $user->id);

        } catch (\Exception $e) {
            Log::error('DATABASE ERROR while generating token: ' . $e->getMessage());
            return back()->with('error', 'Could not generate a connection token due to a database error.');
        }

        return Redirect::route('profile.edit');
    }

    public function verifyTelegramConnectionApi(Request $request)
    {
        $validated = $request->validate([
            'token' => 'required|string',
            'chat_id' => 'required|integer',
        ]);

        // This now correctly queries the default ('telegram') database
        $tokenRecord = DB::table('telegram_verification_tokens')
            ->where('token', $validated['token'])
            ->where('expires_at', '>', Carbon::now())
            ->first();

        if (!$tokenRecord) {
            return response()->json(['success' => false, 'message' => 'Token is invalid or has expired.'], 404);
        }

        $user = User::find($tokenRecord->user_id);
        if ($user) {
            $user->telegram_chat_id = $validated['chat_id'];
            $user->save();
        }

        // This now correctly deletes from the default ('telegram') database
        DB::table('telegram_verification_tokens')->where('id', $tokenRecord->id)->delete();

        return response()->json(['success' => true, 'message' => 'Account connected successfully!']);
    }
}

