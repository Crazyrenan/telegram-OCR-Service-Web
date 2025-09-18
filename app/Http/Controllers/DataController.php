<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Barryvdh\DomPDF\Facade\Pdf as PDF;

class DataController extends Controller
{
    /**
     * API endpoint for the bot to import a CSV file.
     * This includes robust validation.
     */
    public function importPurchasesApi(Request $request): JsonResponse
    {
        if (!$request->has('csv_content')) {
            return response()->json(['success' => false, 'errors' => ['No CSV content provided.']], 400);
        }

        $csvContent = $request->input('csv_content');
        $lines = explode(PHP_EOL, trim($csvContent));
        $header = str_getcsv(array_shift($lines));
        
        $errors = [];
        $totalImported = 0;
        $totalUpdated = 0;
        $rowNumber = 1;

        $allVendors = DB::connection('mysql_application')->table('vendors')->pluck('id')->all();
        $allProjects = DB::connection('mysql_application')->table('projects')->pluck('id')->all();
        $allUsers = DB::table('users')->pluck('id')->all(); 

        DB::beginTransaction();
        try {
            foreach ($lines as $line) {
                if (empty(trim($line))) continue;
                $rowNumber++;
                $data = str_getcsv($line);
                if (count($header) !== count($data)) {
                    $errors[] = "Row {$rowNumber}: Column count does not match header.";
                    continue;
                }
                $rowData = array_combine($header, $data);
                $vendorId = $rowData['vendor_id'] ?? null;
                if (!in_array($vendorId, $allVendors)) $errors[] = "Row {$rowNumber}: Invalid vendor_id ({$vendorId})";
                
                $projectId = $rowData['project_id'] ?? null;
                if (!in_array($projectId, $allProjects)) $errors[] = "Row {$rowNumber}: Invalid project_id ({$projectId})";

                $requestedBy = $rowData['requested_by'] ?? null;
                if (!in_array($requestedBy, $allUsers)) $errors[] = "Row {$rowNumber}: Invalid requested_by ({$requestedBy})";

                if (!empty($errors)) {
                    DB::rollBack();
                    return response()->json(['success' => false, 'errors' => $errors], 400);
                }

                $purchaseData = [
                    'vendor_id' => $vendorId, 'project_id' => $projectId, 'requested_by' => $requestedBy,
                    'purchase_order_number' => $rowData['purchase_order_number'], 'item_name' => $rowData['item_name'],
                    'item_code' => $rowData['item_code'], 'category' => $rowData['category'],
                    'quantity' => $rowData['quantity'] ?? 0, 'unit' => $rowData['unit'],
                    'buy_price' => $rowData['buy_price'] ?? 0.00, 'unit_price' => $rowData['unit_price'] ?? 0.00,
                    'total_price' => $rowData['total_price'] ?? 0.00, 'tax' => $rowData['tax'] ?? 0.00,
                    'grand_total' => $rowData['grand_total'] ?? 0.00,
                    'purchase_date' => $rowData['purchase_date'] ? Carbon::parse($rowData['purchase_date'])->toDateTimeString() : null,
                    'expected_delivery_date' => $rowData['expected_delivery_date'] ? Carbon::parse($rowData['expected_delivery_date'])->toDateString() : null,
                    'status' => $rowData['status'] ?? 'Pending', 'remarks' => $rowData['remarks'],
                ];

                $existing = DB::connection('mysql_application')->table('pembelian')
                    ->where('purchase_order_number', $purchaseData['purchase_order_number'])->first();

                if ($existing) {
                    DB::connection('mysql_application')->table('pembelian')->where('id', $existing->id)->update($purchaseData);
                    $totalUpdated++;
                } else {
                    DB::connection('mysql_application')->table('pembelian')->insert($purchaseData);
                    $totalImported++;
                }
            }
            DB::commit();
            return response()->json([
                'success' => true, 'message' => "Import successful!",
                'imported' => $totalImported, 'updated' => $totalUpdated,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'errors' => ["An error occurred on row {$rowNumber}: " . $e->getMessage()]], 500);
        }
    }
    public function exportPurchasesApi(Request $request)
    {
        $data = $this->fetchPurchaseReportData($request);
        if ($data->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'No data found for the selected criteria.'], 404);
        }

        // Check the requested format
        if ($request->input('format') === 'pdf') {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            $projectName = 'All Projects'; // Default value
            if ($request->filled('project')) {
                $project = DB::connection('mysql_application')->table('projects')->where('id', $request->project)->first();
                if ($project) {
                    $projectName = $project->name;
                }
            }

            $viewData = [
                'data' => $data,
                'startDate' => $startDate,
                'endDate' => $endDate,
                'projectName' => $projectName,
                'status' => $request->input('status', 'All Statuses')
            ];
            $pdf = PDF::loadView('reports.purchase-export', $viewData);
            return $pdf->download('purchase-report.pdf');

        } else {
            $headers = array_keys((array)$data[0]);
            $callback = function() use ($data, $headers) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $headers);
                foreach ($data as $row) {
                    fputcsv($file, (array)$row);
                }
                fclose($file);
            };
            return response()->stream($callback, 200, ['Content-Type' => 'text/csv', 'Content-Disposition' => 'attachment; filename="purchase-report.csv"']);
        }
    }

    public function getTemplateApi()
    {
        $headers = [
            'vendor_id', 'project_id', 'requested_by', 'purchase_order_number',
            'item_name', 'item_code', 'category', 'quantity', 'unit',
            'buy_price', 'unit_price', 'total_price', 'tax', 'grand_total',
            'purchase_date', 'expected_delivery_date', 'status', 'remarks'
        ];
        return response(implode(',', $headers), 200, ['Content-Type' => 'text/csv']);
    }
    
    private function fetchPurchaseReportData(Request $request)
    {
        $query = DB::connection('mysql_application')->table('pembelian as p')
            ->join('projects as pr', 'p.project_id', '=', 'pr.id')
            ->select('p.id', 'p.purchase_order_number', 'pr.name as project_name', 'p.item_name', 'p.quantity', 'p.unit', 'p.buy_price', 'p.total_price', 'p.tax', 'p.grand_total', 'p.purchase_date', 'p.expected_delivery_date', 'p.status');

        if ($request->filled('start_date')) {
            $query->whereDate('p.purchase_date', '>=', $request->start_date);
        }
        if ($request->filled('end_date')) {
            $query->whereDate('p.purchase_date', '<=', $request->end_date);
        }

        return $query->orderBy('p.purchase_date', 'desc')->get();
    }
}

