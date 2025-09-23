<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\VendorManagementController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\PurchaseReportController;
use App\Http\Controllers\OcrController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\VerificationManagementController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Public Route (Visible to Everyone) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');


// --- Authenticated Routes (Visible Only to Logged-In Users) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/telegram-connect', [ProfileController::class, 'startTelegramConnection'])->name('profile.telegram.connect');

    // User's Own Purchase Requests
    Route::get('/requests', [PurchaseRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [PurchaseRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [PurchaseRequestController::class, 'store'])->name('requests.store');
    Route::get('/requests/{purchaseRequest}/edit', [PurchaseRequestController::class, 'edit'])->name('requests.edit');
    Route::put('/requests/{purchaseRequest}', [PurchaseRequestController::class, 'update'])->name('requests.update');
    Route::post('/requests/{purchaseRequest}/resend', [PurchaseRequestController::class, 'resendNotification'])->name('requests.resend');

    // Unified Services Page
    Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
    Route::post('/services/process', [ServiceController::class, 'process'])->name('services.process');
    
    // OCR Search & Viewer
    Route::get('/ocr/upload', [OcrController::class, 'showUploadForm'])->name('ocr.upload.form');
    Route::post('/ocr/process', [OcrController::class, 'processAndCreateRequest'])->name('ocr.process.request');
    Route::get('/ocr/search', [OcrController::class, 'showSearchForm'])->name('search.form');
    Route::get('/ocr/search/results', [OcrController::class, 'handleSearch'])->name('search.results');
    Route::get('/ocr/documents/{id}', [OcrController::class, 'showDocumentViewer'])->name('document.viewer');
    Route::get('/ocr/images/{id}', [OcrController::class, 'showImageViewer'])->name('image.viewer');
    Route::get('/manage/verifications', [VerificationManagementController::class, 'index'])->name('verifications.manage.index');
    Route::post('/manage/verifications/{verificationRequest}/resend', [VerificationManagementController::class, 'resendNotification'])->name('verifications.manage.resend');


    // --- Manager-Only Routes (Nested for extra security) ---
    Route::middleware(['can:manage-users'])->group(function () {
        // User Role Management
        Route::get('/manage/users', [UserManagementController::class, 'index'])->name('users.manage.index');
        Route::post('/manage/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.manage.updateRole');
        
        // Vendor Management
        Route::get('/manage/vendors', [VendorManagementController::class, 'index'])->name('vendors.manage.index');
        Route::get('/manage/vendors/create', [VendorManagementController::class, 'create'])->name('vendors.manage.create');
        Route::post('/manage/vendors', [VendorManagementController::class, 'store'])->name('vendors.manage.store');
        Route::get('/manage/vendors/{id}/edit', [VendorManagementController::class, 'edit'])->name('vendors.manage.edit');
        Route::put('/manage/vendors/{id}', [VendorManagementController::class, 'update'])->name('vendors.manage.update');

        // Interactive Purchase Report
        Route::get('/reports/purchases', [PurchaseReportController::class, 'index'])->name('reports.purchases.index');
        Route::get('/reports/purchases/export', [PurchaseReportController::class, 'export'])->name('reports.purchases.export');
        Route::get('/web-api/reports/purchases', [PurchaseReportController::class, 'fetchData'])->name('reports.purchases.data');
    });

});

// This loads all the default authentication routes like /login, /register, /logout
require __DIR__.'/auth.php';

