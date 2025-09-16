<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class PurchaseReportController extends Controller
{
    /**
     * Display the main purchase report view.
     */
    public function index()
    {
        Gate::authorize('manage-users'); // Ensure only managers can see this page

        // Get projects for the filter dropdown
        $projects = DB::connection('mysql_application')->table('projects')->get();

        return view('reports.purchase-index', ['projects' => $projects]);
    }

    /**
     * Fetch purchase report data for the interactive table (API endpoint).
     */
    public function fetchData(Request $request)
    {
        Gate::authorize('manage-users');

        $data = $this->fetchPurchaseReportData($request);
        return response()->json($data);
    }

    /**
     * Export the filtered purchase report to either PDF or CSV.
     */
    public function export(Request $request)
    {
        Gate::authorize('manage-users');
        
        $data = $this->fetchPurchaseReportData($request);

        if ($data->isEmpty()) {
            return back()->with('error', 'No data found for the selected criteria to export.');
        }
        
        $format = $request->input('format', 'csv'); // Default to CSV

        if ($format === 'pdf') {
            $projectName = 'All Projects';
            if ($request->filled('project')) {
                $project = DB::connection('mysql_application')->table('projects')->where('id', $request->project)->first();
                if ($project) $projectName = $project->name;
            }

            $viewData = [
                'data' => $data,
                'startDate' => $request->input('start_date'),
                'endDate' => $request->input('end_date'),
                'projectName' => $projectName,
                'status' => $request->input('status', 'All Statuses')
            ];

            $pdf = PDF::loadView('reports.purchase-export', $viewData);
            return $pdf->download('purchase-report-' . date('Y-m-d') . '.pdf');
        } 
        else { // CSV Export
            $headers = array_keys((array)$data[0]);
            $filename = 'purchase-report-' . date('Y-m-d') . '.csv';

            $callback = function() use ($data, $headers) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $headers);
                foreach ($data as $row) {
                    fputcsv($file, (array)$row);
                }
                fclose($file);
            };

            return response()->stream($callback, 200, [
                'Content-Type' => 'text/csv',
                'Content-Disposition' => 'attachment; filename="' . $filename . '"',
            ]);
        }
    }

    /**
     * Reusable private method to fetch and filter the purchase data.
     */
    private function fetchPurchaseReportData(Request $request)
    {
        $query = DB::connection('mysql_application')->table('pembelian as p')
            ->join('projects as pr', 'p.project_id', '=', 'pr.id')
            ->select('p.id', 'p.purchase_order_number', 'pr.name as project_name', 'p.item_name', 'p.quantity', 'p.unit', 'p.grand_total', 'p.purchase_date', 'p.expected_delivery_date', 'p.status');

        if ($request->filled('start_date')) {
            $query->whereDate('p.purchase_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('p.purchase_date', '<=', $request->end_date);
        }
        if ($request->filled('project')) {
            $query->where('p.project_id', '=', $request->project);
        }
        if ($request->filled('status')) {
            $query->where('p.status', '=', $request->status);
        }

        return $query->orderBy('p.purchase_date', 'desc')->get();
    }
}
