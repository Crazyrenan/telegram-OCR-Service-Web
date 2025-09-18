<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class ReportController extends Controller
{
    public function generateAndSendMonthlyReport()
    {
        $currentMonthNumber = date('m'); 

        $summaryQuery = DB::connection('mysql_application')
            ->table('pembelian')
            ->whereMonth('purchase_date', '=', $currentMonthNumber);

        $totalQuantity = $summaryQuery->clone()->sum('quantity');

        $topCategoryData = $summaryQuery->clone()->select('category', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('category')
            ->orderBy('total_quantity', 'desc')
            ->first();
        
        $topCategory = $topCategoryData ? $topCategoryData->category : 'N/A';
        $categoryCount = $summaryQuery->clone()->distinct()->count('category');

        $message = $this->formatScheduledReportForTelegram($totalQuantity, $topCategory, $categoryCount);
        
        $this->sendToFlaskService(['message' => $message]);
        
        return "Automated summary report has been sent to Telegram!";
    }

    public function apiReport(Request $request)
    {
        $year = $request->input('year', date('Y'));
        $month = $request->input('month');
        $reportData = $this->getReportData($year, $month);
        return response()->json($reportData);
    }

    private function getReportData($year, $month = null)
    {
        $baseQuery = DB::connection('mysql_application')
            ->table('pembelian')
            ->whereYear('purchase_date', '=', $year)
            ->when($month, function ($query, $month) {
                return $query->whereMonth('purchase_date', '=', $month);
            });

        $details = $baseQuery->clone()->select(
                DB::raw("DATE_FORMAT(purchase_date, '%M') as month_name"),
                'category',
                DB::raw('SUM(quantity) as total_quantity')
            )
            ->groupBy(DB::raw("DATE_FORMAT(purchase_date, '%M')"), 'category')
            ->orderBy(DB::raw("MIN(purchase_date)"), 'asc')
            ->orderBy('total_quantity', 'desc')
            ->get();

        $summaryQuery = $baseQuery->clone();
        $totalQuantity = $summaryQuery->sum('quantity');

        $topCategoryData = $summaryQuery->clone()->select('category', DB::raw('SUM(quantity) as total_quantity'))
            ->groupBy('category')
            ->orderBy('total_quantity', 'desc')
            ->first();

        $topCategory = $topCategoryData ? $topCategoryData->category : 'N/A';
        $categoryCount = $summaryQuery->clone()->distinct()->count('category');
        
        return [
            'summary' => [
                'total_quantity' => $totalQuantity,
                'top_category' => $topCategory,
                'category_count' => $categoryCount,
            ],
            'details' => $details
        ];
    }
    
    private function formatScheduledReportForTelegram($totalQuantity, $topCategory, $categoryCount)
    {
        $monthName = date('F');
        $message = "🤖 <b>Automated Report Summary - {$monthName} (All Years)</b> 🤖\n\n";
        $message .= "Here are the key facts for this month's purchases:\n\n";
        
        $labels = [
            "▫️ Total Quantity Purchased" => $totalQuantity,
            "⭐ Top Performing Category" => $topCategory,
            "📦 Number of Unique Categories" => $categoryCount
        ];
        
        $maxLength = 0;
        foreach (array_keys($labels) as $label) {
            $maxLength = max($maxLength, strlen($label));
        }

        $message .= "<pre>";
        foreach ($labels as $label => $value) {
            $message .= str_pad($label, $maxLength) . " : {$value}\n";
        }
        $message .= "</pre>\n";

        $message .= "<i>For a detailed breakdown, use the <code>/report</code> command.</i>";
        return $message;
    }

    private function sendToFlaskService(array $payload)
    {
        try {
            $flaskUrl = 'http://127.0.0.1:5001/send-message';
            Http::post($flaskUrl, $payload);
            Log::info('Successfully sent report to Flask service.');
        } catch (\Exception $e) {
            Log::error('Failed to send report to Flask service: ' . $e->getMessage());
        }
    }
}

