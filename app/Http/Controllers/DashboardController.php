<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    /**
     * Display the application dashboard with key statistics.
     */
    public function index()
    {
        $pendingRequests = DB::connection('mysql_application')
            ->table('purchase_requests')
            ->where('status', 'pending')
            ->count();

        $upcomingDeliveries = DB::connection('mysql_application')
            ->table('pembelian')
            ->where('status', '!=', 'Delivered')
            ->whereDate('expected_delivery_date', '>=', Carbon::today())
            ->count();

        $totalSpendingThisMonth = DB::connection('mysql_application')
            ->table('pembelian')
            ->whereMonth('purchase_date', Carbon::now()->month) // Only check the month number
            ->sum('grand_total');
            
        return view('dashboard', [
            'pendingRequests' => $pendingRequests,
            'upcomingDeliveries' => $upcomingDeliveries,
            'totalSpendingThisMonth' => $totalSpendingThisMonth,
        ]);
    }
}

