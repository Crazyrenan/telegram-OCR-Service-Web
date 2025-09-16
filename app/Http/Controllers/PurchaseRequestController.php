<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class PurchaseRequestController extends Controller
{
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


    private function notifyManagerViaBot(PurchaseRequest $purchaseRequest)
    {
        // Find the user with the 'manager' role from the default ('telegram') database
        $manager = User::where('role', 'manager')->first();

        if (!$manager || !$manager->telegram_chat_id) {
            Log::error('Manager with role "manager" not found or has not connected their Telegram account.');
            return;
        }

        try {
            $flaskUrl = 'http://127.0.0.1:5001/send-approval-request';
            
            Http::post($flaskUrl, [
                'manager_chat_id' => $manager->telegram_chat_id,
                'request_id' => $purchaseRequest->id,
                'user_name' => Auth::user()->name, 
                'item_name' => $purchaseRequest->item_name,
                'amount' => $purchaseRequest->amount,
                'reason' => $purchaseRequest->reason,
            ]);

            Log::info('Successfully sent approval request to Flask service.');
        } catch (\Exception $e) {
            Log::error('Failed to send approval request to Flask service: ' . $e->getMessage());
        }
    }

    /**
     * Notifies the original user about the status update of their request.
     */
    private function notifyUserOfStatusUpdate(PurchaseRequest $purchaseRequest)
    {
        $user = $purchaseRequest->user; // Get the user who made the request

        if (!$user || !$user->telegram_chat_id) {
            Log::info("User {$user->id} has no Telegram chat ID, skipping notification.");
            return;
        }

        try {
            // Call a new, dedicated endpoint on our Python service
            $flaskUrl = 'http://127.0.0.1:5001/notify-user';
            
            Http::post($flaskUrl, [
                'user_chat_id' => $user->telegram_chat_id,
                'item_name' => $purchaseRequest->item_name,
                'status' => $purchaseRequest->status,
            ]);

            Log::info("Successfully sent status update notification to user {$user->id}.");
        } catch (\Exception $e) {
            Log::error("Failed to send status update notification to user {$user->id}: " . $e->getMessage());
        }
    }
}

