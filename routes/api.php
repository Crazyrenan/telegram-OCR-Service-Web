<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\LogisticsController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DataController;
use App\Http\Controllers\OcrSearchController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PurchaseReportController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// --- Default Sanctum Route ---
Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


//==========================================================================
// BOT-FACING ROUTES (Used by the Python Service)
//==========================================================================

// --- Reporting Routes (GET requests for data) ---
Route::get('/items', [ItemController::class, 'apiIndex']);
Route::get('/report', [ReportController::class, 'apiReport']);
Route::get('/top-vendors', [VendorController::class, 'totalSpendingByVendor']);
Route::get('/vendor-spending/{vendor_id}', [VendorController::class, 'monthlySpendingByVendor']);
Route::get('/projects', [ProjectController::class, 'projectSummary']);
Route::get('/project-details/{project_id}', [ProjectController::class, 'projectDetails']);
Route::get('/upcoming-deliveries', [LogisticsController::class, 'getUpcomingDeliveries']);
Route::get('/delivery-details/{po_number}', [LogisticsController::class, 'getDeliveryDetails']);

// --- Data Management Routes (for Import/Export) ---
Route::get('/purchase-template', [DataController::class, 'getTemplateApi']);
Route::get('/export-purchases', [DataController::class, 'exportPurchasesApi']);
Route::post('/import-purchases', [DataController::class, 'importPurchasesApi']);

// --- Action Routes (POST requests that change data) ---
Route::post('/telegram-register', [ProfileController::class, 'registerTelegramUserApi']);
Route::post('/telegram-check-user', [ProfileController::class, 'checkTelegramUserApi']);

// --- OCR & Verification Routes ---
Route::get('/ocr/search', [OcrSearchController::class, 'searchDocumentsApi']);
Route::post('/verifications/{verificationRequest}/status', [VerificationController::class, 'updateStatusApi']);

//==========================================================================
// WEB APP-FACING ROUTES HAVE BEEN MOVED TO web.php
//==========================================================================