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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/items', [ItemController::class, 'apiIndex']);


Route::get('/report', [ReportController::class, 'apiReport']);

Route::get('/top-vendors', [VendorController::class, 'totalSpendingByVendor']);
Route::get('/vendor-spending/{vendor_id}', [VendorController::class, 'monthlySpendingByVendor']);


Route::post('/requests/{purchaseRequest}/status', [PurchaseRequestController::class, 'updateStatusApi']);


Route::get('/projects', [ProjectController::class, 'projectSummary']);
Route::get('/project-details/{project_id}', [ProjectController::class, 'projectDetails']);

Route::get('/upcoming-deliveries', [LogisticsController::class, 'getUpcomingDeliveries']);
Route::get('/delivery-details/{po_number}', [LogisticsController::class, 'getDeliveryDetails']);


Route::post('/telegram-connect/verify', [ProfileController::class, 'verifyTelegramConnectionApi']);

require __DIR__.'/auth.php';