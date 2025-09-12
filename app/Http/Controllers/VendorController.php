<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class VendorController extends Controller
{
    /**
     * Provides a summary of total spending for all vendors.
     */
    public function totalSpendingByVendor()
    {
        $data = DB::connection('mysql_application')
            ->table('pembelian')
            ->join('vendors', 'pembelian.vendor_id', '=', 'vendors.id')
            ->select('vendors.name as vendor_name', 'vendors.id as vendor_id', DB::raw('SUM(pembelian.grand_total) as total_spending'))
            ->groupBy('vendors.id', 'vendors.name')
            ->orderBy('total_spending', 'desc')
            ->get();

        return response()->json($data);
    }

   
    public function monthlySpendingByVendor($vendor_id)
    {
        $data = DB::connection('mysql_application')
            ->table('pembelian')
            ->select(DB::raw("DATE_FORMAT(purchase_date, '%M %Y') as month"), DB::raw('SUM(grand_total) as monthly_total'))
            ->where('vendor_id', '=', $vendor_id)
            ->groupBy('month')
            ->orderBy(DB::raw("MIN(purchase_date)"), 'asc')
            ->get();

        return response()->json($data);
    }
}
