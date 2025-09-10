<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class NotificationController extends Controller
{
    
    public function show()
    {
        return view('notification');
    }

    public function send(Request $request)
    {
        // 1. Validate the incoming request from the browser
        $request->validate([
            'message' => 'required|string|max:255',
        ]);

        // 2. Define the URL of your Python Flask service
        // This is running locally on port 5001
        $flaskServiceUrl = 'http://127.0.0.1:5001/send-message';
        $messageToSend = $request->input('message');

        try {
            // 3. Make a POST request from Laravel to Flask
            $response = Http::post($flaskServiceUrl, [
                'text' => $messageToSend,
            ]);

            // 4. Check if the request to Flask was successful
            if ($response->successful()) {
                Log::info('Successfully sent notification via Flask service.');
                return response()->json(['message' => 'Notification sent successfully!'], 200);
            } else {
                // Log the error if Flask returned an error
                Log::error('Flask service returned an error.', [
                    'status' => $response->status(),
                    'body' => $response->body()
                ]);
                return response()->json(['message' => 'The notification service is down.'], 503);
            }
        } catch (\Exception $e) {
            // Catch connection errors if the Flask service isn't running
            Log::error('Could not connect to the Flask service.', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Could not connect to the notification service.'], 500);
        }
    }
}
