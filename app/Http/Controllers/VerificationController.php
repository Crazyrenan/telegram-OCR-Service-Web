<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use App\Models\OcrDocument; 
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class VerificationController extends Controller
{
    /**
     * API endpoint for the bot to update the status of a verification request.
     */
    public function updateStatusApi(Request $request, VerificationRequest $verificationRequest)
    {
        $validated = $request->validate([
            'status' => 'required|in:verified,rejected',
        ]);

        if ($validated['status'] === 'verified' && !empty($verificationRequest->metadata)) {
            $metadata = json_decode($verificationRequest->metadata, true);
            $ocrResponse = $metadata['ocr_response'] ?? [];
            $originalPath = $metadata['original_path'] ?? null;

            if ($originalPath) {
                OcrDocument::create([
                    'original_filename' => $verificationRequest->original_filename,
                    'stored_path' => $originalPath,
                    'extracted_text' => $ocrResponse['text'] ?? 'No text extracted.',
                    'word_data' => json_encode($ocrResponse['word_data'] ?? []),
                    'thumbnail_path' => $ocrResponse['thumbnail_path'] ?? null,
                ]);
                Log::info("Archived OCR data for verification request ID: {$verificationRequest->id}");
            }
        }

        $verificationRequest->status = $validated['status'];
        $verificationRequest->save();

        $this->notifyUserOfStatusUpdate($verificationRequest);

        return response()->json(['success' => true, 'message' => 'Verification status updated successfully.']);
    }

    /**
     * Notifies the original user about the status update of their verification request.
     */
    private function notifyUserOfStatusUpdate(VerificationRequest $verificationRequest)
    {
        // We must manually find the user from the default ('telegram') database
        $user = User::find($verificationRequest->user_id);

        if (!$user || !$user->telegram_chat_id) {
            Log::info("User {$verificationRequest->user_id} has no Telegram chat ID, skipping verification notification.");
            return;
        }

        try {
            $flaskUrl = 'http://127.0.0.1:5001/notify-user';
            
            Http::post($flaskUrl, [
                'user_chat_id' => $user->telegram_chat_id,
                'item_name' => $verificationRequest->original_filename, 
                'status' => $verificationRequest->status,
                'type' => 'verification' 
            ]);

            Log::info("Successfully sent verification status update to user {$user->id}.");
        } catch (\Exception $e) {
            Log::error("Failed to send verification status update to user {$user->id}: " . $e->getMessage());
        }
    }
}

