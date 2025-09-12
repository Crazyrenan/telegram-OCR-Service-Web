<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseManagementController;
use App\Http\Controllers\DashboardController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    // This route is now powered by our new controller
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});



Route::resource('items', ItemController::class);
Route::post('/items/send-telegram', [ItemController::class, 'sendToTelegram'])->name('items.sendToTelegram');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/requests', [PurchaseRequestController::class, 'index'])->name('requests.index');
Route::get('/requests/create', [PurchaseRequestController::class, 'create'])->name('requests.create');
Route::post('/requests', [PurchaseRequestController::class, 'store'])->name('requests.store');
Route::post('/requests/{purchaseRequest}/resend', [PurchaseRequestController::class, 'resendNotification'])->name('requests.resend');

 Route::get('/manage/purchases', [PurchaseManagementController::class, 'index'])->name('purchases.manage.index');
    Route::post('/manage/purchases/{id}/status', [PurchaseManagementController::class, 'updateStatus'])->name('purchases.manage.updateStatus');

require __DIR__.'/auth.php';
