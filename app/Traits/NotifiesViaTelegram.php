<?php

namespace App\Traits;

use App\Models\PurchaseRequest;
use App\Models\VerificationRequest;
use App\Models\User;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

trait NotifiesViaTelegram
{
    /**
     * Helper to notify the manager about a NEW PURCHASE request.
     */
    private function notifyManagerViaBot(PurchaseRequest $purchaseRequest)
    {
        $manager = User::where('role', 'manager')->first();
        if (!$manager || !$manager->telegram_chat_id) {
            Log::error('Manager not found or has not connected their Telegram account for a purchase request.');
            return;
        }

        try {
            $flaskUrl = 'http://127.0.0.1:5001/send-approval-request';
            
            Http::post($flaskUrl, [
                'manager_chat_id' => $manager->telegram_chat_id,
                'request_id' => $purchaseRequest->id,
                'user_name' => $purchaseRequest->user->name,
                'item_name' => $purchaseRequest->item_name,
                'amount' => $purchaseRequest->amount,
                'reason' => $purchaseRequest->reason,
            ]);
            Log::info('Successfully sent purchase approval request to Flask service.');
        } catch (\Exception $e) {
            Log::error('Failed to send purchase approval request to Flask service: ' . $e->getMessage());
        }
    }


    private function notifyManagerOfVerification(VerificationRequest $verificationRequest)
    {
        $manager = User::where('role', 'manager')->first();
        if (!$manager || !$manager->telegram_chat_id) {
            Log::error('Manager not found or has not connected their Telegram account for a verification request.');
            return;
        }
        
        try {
            $flaskUrl = 'http://127.0.0.1:5001/send-verification-request'; 
            
            Http::post($flaskUrl, [
                'manager_chat_id' => $manager->telegram_chat_id,
                'request_id' => $verificationRequest->id,
                'user_name' => $verificationRequest->user->name,
                'document_name' => $verificationRequest->original_filename,
                'extracted_name' => $verificationRequest->extracted_name,
            ]);
            Log::info('Successfully sent verification request to Flask service.');
        } catch (\Exception $e) {
            Log::error('Failed to send verification request to Flask service: ' . $e->getMessage());
        }
    }
}

