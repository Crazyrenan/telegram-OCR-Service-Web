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
    public function index()
    {
        $requests = PurchaseRequest::where('user_id', Auth::id())->latest()->get();
        return view('requests.index', ['requests' => $requests]);
    }

    public function create()
    {
        return view('requests.create');
    }

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

    public function updateStatusApi(Request $request, PurchaseRequest $purchaseRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:approved,rejected',
        ]);

        $purchaseRequest->status = $validated['status'];
        $purchaseRequest->save();

        return response()->json(['success' => true, 'message' => 'Status updated successfully.']);
    }

    public function resendNotification(PurchaseRequest $purchaseRequest)
    {
        if ($purchaseRequest->status === 'pending') {
            $this->notifyManagerViaBot($purchaseRequest);
            return back()->with('success', 'Approval notification has been resent!');
        }
        return back()->with('error', 'This request is no longer pending.');
    }


    private function notifyManagerViaBot(PurchaseRequest $purchaseRequest)
    {
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
}

