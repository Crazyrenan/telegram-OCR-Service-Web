<?php

namespace App\Http\Controllers;

use App\Models\PurchaseRequest;
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
        // For security, ensure the request is actually still pending before resending
        if ($purchaseRequest->status === 'pending') {
            $this->notifyManagerViaBot($purchaseRequest);
            return back()->with('success', 'Approval notification has been resent!');
        }

        return back()->with('error', 'This request is no longer pending and cannot be re-sent.');
    }

    private function notifyManagerViaBot(PurchaseRequest $purchaseRequest)
    {
        try {
            $flaskUrl = 'http://127.0.0.1:5001/send-approval-request';
            
            Http::post($flaskUrl, [
                'request_id' => $purchaseRequest->id,
                'user_name' => $purchaseRequest->user->name, // Get the name from the relationship
                'item_name' => $purchaseRequest->item_name,
                'amount' => $purchaseRequest->amount,
                'reason' => $purchaseRequest->reason,
            ]);

            Log::info('Successfully sent approval request to Flask service for request ID: ' . $purchaseRequest->id);
        } catch (\Exception $e) {
            Log::error('Failed to send approval request to Flask service: ' . $e->getMessage());
        }
    }
}

