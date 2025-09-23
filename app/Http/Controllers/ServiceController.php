<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\OcrRequestController;

class ServiceController extends Controller
{
    /**
     * Display the main services page with the dropdown.
     */
    public function index()
    {
        return view('services.index');
    }

    /**
     * Process the form submission based on the selected service type.
     */
    public function process(Request $request)
    {
        $serviceType = $request->input('service_type');

        if ($serviceType === 'item_request') {
            $purchaseController = new PurchaseRequestController();
            return $purchaseController->store($request);

        } elseif ($serviceType === 'invoice_ocr') {
            $ocrController = new OcrController();
            return $ocrController->processAndCreateRequest($request);
        }

        return back()->with('error', 'Invalid service type selected.');
    }
}
