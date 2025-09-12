<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LogisticsController extends Controller
{
    /**
     * Provides a list of all purchases that are not yet delivered.
     */
    public function getUpcomingDeliveries()
    {
        $deliveries = DB::connection('mysql_application')
            ->table('pembelian')
            ->join('vendors', 'pembelian.vendor_id', '=', 'vendors.id')
            ->where('pembelian.status', '!=', 'Delivered')
            ->select(
                'pembelian.purchase_order_number',
                'pembelian.item_name',
                'pembelian.expected_delivery_date',
                'vendors.name as vendor_name'
            )
            ->orderBy('pembelian.expected_delivery_date', 'asc')
            ->get();

        return response()->json($deliveries);
    }

    /**
     * NEW: Provides detailed information for a single purchase order.
     */
    public function getDeliveryDetails($po_number)
    {
        $details = DB::connection('mysql_application')
            ->table('pembelian')
            ->join('vendors', 'pembelian.vendor_id', '=', 'vendors.id')
            ->where('pembelian.purchase_order_number', '=', $po_number)
            ->select(
                'pembelian.purchase_order_number',
                'pembelian.item_name',
                'pembelian.quantity',
                'pembelian.grand_total',
                'pembelian.status',
                'pembelian.expected_delivery_date',
                'vendors.name as vendor_name'
            )
            ->first(); // Use first() because we only expect one result

        return response()->json($details);
    }
}

