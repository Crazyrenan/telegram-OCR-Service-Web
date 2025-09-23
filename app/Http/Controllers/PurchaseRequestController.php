<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use App\Traits\NotifiesViaTelegram;

class PurchaseRequestController extends Controller
{
    use NotifiesViaTelegram; // Use the Trait for notifications

    /**
     * Display a listing of the user's purchase requests.
     */
    public function index()
    {
        $requests = PurchaseRequest::where('user_id', Auth::id())->latest()->get();
        return view('requests.index', ['requests' => $requests]);
    }

    /**
     * Show the form for creating a new purchase request.
     */
    public function create()
    {
        return view('requests.create');
    }

    /**
     * Store a newly created purchase request in storage and notify the bot.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
        ]);

        $purchaseRequest = PurchaseRequest::create([
            'user_id' => Auth::id(),
            'item_name' => $validated['item_name'],
            'amount' => $validated['amount'],
            'reason' => $validated['reason'],
        ]);

        $this->notifyManagerViaBot($purchaseRequest);

        return redirect()->route('requests.index')->with('success', 'Purchase request submitted for approval!');
    }

    /**
     * Show the form for editing an existing purchase request.
     */
    public function edit(PurchaseRequest $purchaseRequest)
    {
        if (Auth::user()->id !== $purchaseRequest->user_id) {
            abort(403);
        }
        if ($purchaseRequest->status !== 'pending') {
            return redirect()->route('requests.index')->with('error', 'This request can no longer be edited.');
        }
        return view('requests.edit', ['request' => $purchaseRequest]);
    }

    /**
     * Update the specified purchase request in storage.
     */
    public function update(Request $request, PurchaseRequest $purchaseRequest)
    {
        if (Auth::user()->id !== $purchaseRequest->user_id) {
            abort(403);
        }
        if ($purchaseRequest->status !== 'pending') {
            return redirect()->route('requests.index')->with('error', 'This request can no longer be edited as it has been processed.');
        }

        $validated = $request->validate([
            'item_name' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'reason' => 'required|string',
        ]);

        $purchaseRequest->update($validated);

        return redirect()->route('requests.index')->with('success', 'Purchase request updated successfully!');
    }

    /**
     * API endpoint for the bot to update the status of a request.
     */
    public function updateStatusApi(Request $request, PurchaseRequest $purchaseRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $purchaseRequest->status = $validated['status'];
        $purchaseRequest->save();

        // After updating, send a notification back to the original user.
        $this->notifyUserOfStatusUpdate($purchaseRequest);

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    /**
     * Resends the Telegram notification for a pending request.
     */
    public function resendNotification(PurchaseRequest $purchaseRequest)
    {
        if ($purchaseRequest->status === 'pending') {
            $this->notifyManagerViaBot($purchaseRequest);
            return back()->with('success', 'Approval notification has been resent!');
        }
        return back()->with('error', 'This request is no longer pending and cannot be re-sent.');
    }

    /**
     * Notifies the original user about the status update of their request.
     */
    private function notifyUserOfStatusUpdate(PurchaseRequest $purchaseRequest)
    {
        // Manually find the user from the default ('telegram') database
        $user = User::find($purchaseRequest->user_id);

        if (!$user || !$user->telegram_chat_id) {
            Log::info("User with ID {$purchaseRequest->user_id} has no Telegram chat ID, skipping notification.");
            return;
        }

        try {
            $flaskUrl = 'http://127.0.0.1:5001/notify-user';
            
            Http::post($flaskUrl, [
                'user_chat_id' => $user->telegram_chat_id,
                'item_name' => $purchaseRequest->item_name,
                'status' => $purchaseRequest->status,
                'type' => 'purchase' // Differentiate the notification type
            ]);

            Log::info("Successfully sent status update notification to user {$user->id}.");
        } catch (\Exception $e) {
            Log::error("Failed to send status update notification to user {$user->id}: " . $e->getMessage());
        }
    }
}

