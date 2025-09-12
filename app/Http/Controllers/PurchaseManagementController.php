<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PurchaseManagementController extends Controller
{
    /**
     * Display a listing of all purchases for management.
     */
    public function index()
    {
        $purchases = DB::connection('mysql_application')
            ->table('pembelian')
            ->join('vendors', 'pembelian.vendor_id', '=', 'vendors.id')
            ->join('projects', 'pembelian.project_id', '=', 'projects.id')
            ->select(
                'pembelian.*', 
                'vendors.name as vendor_name', 
                'projects.name as project_name'
            )
            ->orderBy('pembelian.purchase_date', 'desc')
            ->paginate(15); // Use pagination to handle large amounts of data

        return view('manage.purchases.index', ['purchases' => $purchases]);
    }
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Approved,Delivered',
        ]);
        
        // Find the purchase record in the 'pembelian' table and update its status
        DB::connection('mysql_application')
            ->table('pembelian')
            ->where('id', $id)
            ->update(['status' => $request->status]);

        return back()->with('success', 'Purchase status updated successfully!');
    }
}
