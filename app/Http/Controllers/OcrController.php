<?php

namespace App\Http\Controllers;

use App\Models\VerificationRequest;
use App\Models\OcrDocument;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Traits\NotifiesViaTelegram;

class OcrController extends Controller
{
    use NotifiesViaTelegram;

    public function showUploadForm()
    {
        return view('ocr.upload');
    }

    public function processAndCreateRequest(Request $request)
    {
        $request->validate(['invoice_file' => 'required|mimes:jpeg,png,jpg,pdf|max:10240']);
        $file = $request->file('invoice_file');
        
        try {
            $ocrServiceUrl = config('services.ocr.url', 'http://127.0.0.1:5002');
            $response = Http::attach('file', file_get_contents($file), $file->getClientOriginalName())
                ->post($ocrServiceUrl . '/process');

            if (!$response->successful()) {
                Log::error('OCR service failed:', $response->json());
                return back()->with('error', 'The OCR service failed to process the document.');
            }

            $ocrData = $response->json();
            $path = $file->store('documents', 'public');

            $verificationRequest = VerificationRequest::create([
                'user_id' => Auth::id(),
                'original_filename' => $file->getClientOriginalName(),
                'extracted_name' => $ocrData['detected_name'] ?? 'N/A',
                'extracted_id_number' => $ocrData['detected_id'] ?? 'N/A',
                'status' => 'pending',
                'metadata' => json_encode([ // Store all OCR data temporarily
                    'ocr_response' => $ocrData,
                    'original_path' => $path,
                ]),
            ]);

            $this->notifyManagerOfVerification($verificationRequest);
            return redirect()->route('dashboard')->with('success', 'Document processed and submitted for verification!');

        } catch (\Exception $e) {
            Log::error('OCR processing or notification failed: ' . $e->getMessage());
            return back()->with('error', 'Could not process the document.');
        }
    }

    /**
     * Show the document search form.
     */
    public function showSearchForm()
    {
        $documents = OcrDocument::latest()->paginate(10);
        return view('ocr.search', ['documents' => $documents]);
    }

    /**
     * Handle the search query and display results.
     */
    public function handleSearch(Request $request)
    {
        $query = $request->input('query');
        if (empty($query)) {
            return redirect()->route('search.form');
        }
        
        $documents = OcrDocument::where('extracted_text', 'LIKE', "%{$query}%")
            ->latest()
            ->paginate(10);
        
        return view('ocr.search', [
            'documents' => $documents,
            'query' => $query
        ]);
    }

    /**
     * Show the PDF document viewer.
     */
    public function showDocumentViewer($id)
    {
        $document = OcrDocument::findOrFail($id);
        return view('ocr.viewer', ['document' => $document]);
    }

    /**
     * Show the image result viewer.
     */
    public function showImageViewer($id)
    {
        $document = OcrDocument::findOrFail($id);
        return view('ocr.result-image', [
            'text' => $document->extracted_text,
            'path' => $document->stored_path
        ]);
    }

    /**
     * Helper to notify the manager about a NEW VERIFICATION request.
     */
    private function notifyManagerOfVerification(VerificationRequest $verificationRequest)
    {
        $manager = User::where('role', 'manager')->first();
        if (!$manager || !$manager->telegram_chat_id) {
            Log::error('Manager not found or has not connected their Telegram account.');
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

