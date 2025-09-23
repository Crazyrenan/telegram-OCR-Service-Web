<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use App\Traits\NotifiesViaTelegram; 

class VerificationManagementController extends Controller
{
    use NotifiesViaTelegram; 


    public function index()
    {
        // Ensure only managers can access this page
        Gate::authorize('manage-users');

        $verificationRequests = VerificationRequest::with('user') // Eager load the user
            ->latest()
            ->paginate(15);

        return view('manage.verifications.index', ['requests' => $verificationRequests]);
    }

    /**
     * Resends the Telegram notification for a pending verification request.
     */
    public function resendNotification(VerificationRequest $verificationRequest)
    {
        Gate::authorize('manage-users');

        if ($verificationRequest->status === 'pending') {
            $this->notifyManagerOfVerification($verificationRequest);
            return back()->with('success', 'Verification notification has been resent!');
        }

        return back()->with('error', 'This request is no longer pending and cannot be re-sent.');
    }
}
