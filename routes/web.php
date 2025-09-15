<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PurchaseRequestController;
use App\Http\Controllers\PurchaseManagementController;
use App\Http\Controllers\UserManagementController;

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

// --- Public Routes (Visible to Everyone) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');


// --- Authenticated Routes (Visible Only to Logged-In Users) ---
Route::middleware(['auth'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Profile Management (from Breeze)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile/telegram-connect', [ProfileController::class, 'startTelegramConnection'])->name('profile.telegram.connect');

    // User's Own Purchase Requests
    Route::get('/requests', [PurchaseRequestController::class, 'index'])->name('requests.index');
    Route::get('/requests/create', [PurchaseRequestController::class, 'create'])->name('requests.create');
    Route::post('/requests', [PurchaseRequestController::class, 'store'])->name('requests.store');
    Route::post('/requests/{purchaseRequest}/resend', [PurchaseRequestController::class, 'resendNotification'])->name('requests.resend');

    // Item Management (Assuming this is for logged-in users)
    Route::resource('items', ItemController::class);
    Route::post('/items/send-telegram', [ItemController::class, 'sendToTelegram'])->name('items.sendToTelegram');

    // --- Manager-Only Routes ---
    Route::middleware(['can:manage-users'])->group(function () {
        // User Role Management
        Route::get('/manage/users', [UserManagementController::class, 'index'])->name('users.manage.index');
        Route::post('/manage/users/{user}/role', [UserManagementController::class, 'updateRole'])->name('users.manage.updateRole');
        
        // Purchase Status Management
        Route::get('/manage/purchases', [PurchaseManagementController::class, 'index'])->name('purchases.manage.index');
        Route::post('/manage/purchases/{id}/status', [PurchaseManagementController::class, 'updateStatus'])->name('purchases.manage.updateStatus');
    });

});
require __DIR__.'/auth.php';

