<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon; 

class DailyBriefingController extends Controller
{

    public function generateBriefing($manualDate = null)
    {
        if ($manualDate) {
            $reportDate = Carbon::parse($manualDate)->subDay();
        } else {
            $reportDate = Carbon::yesterday();
        }

        $stats = DB::connection('mysql_application')
            ->table('pembelian')
            ->whereDate('purchase_date', '=', $reportDate)
            ->select(
                DB::raw('SUM(grand_total) as total_spending'),
                DB::raw('COUNT(id) as total_purchases')
            )
            ->first();


        $message = $this->formatBriefingForTelegram($stats, $reportDate);
        $this->sendToFlaskService(['message' => $message]);
        return "Daily briefing has been generated and sent!";
    }

    private function formatBriefingForTelegram($stats, $date)
    {

        $formattedDate = $date->format('l, j F Y');
        
        $message = "☀️ <b>Good Morning! Here's your daily briefing for {$formattedDate}:</b>\n\n";
        $totalSpending = $stats->total_spending ?? 0;
        $totalPurchases = $stats->total_purchases ?? 0;

        $message .= "<pre>";
        $message .= "💰 Total Spending Yesterday : Rp " . number_format($totalSpending, 2, ',', '.') . "\n";
        $message .= "🛒 Total Purchases Made   : {$totalPurchases}";
        $message .= "</pre>";

        return $message;
    }

    private function sendToFlaskService(array $payload)
    {
        try {
            $flaskUrl = 'http://127.0.0.1:5001/send-message';
            Http::post($flaskUrl, $payload);
            Log::info('Successfully sent daily briefing to Flask service.');
        } catch (\Exception $e) {
            Log::error('Failed to send daily briefing to Flask service: ' . $e->getMessage());
        }
    }
}

