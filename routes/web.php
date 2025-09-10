<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ItemController;

Route::get('/', function () {
    return view('welcome');
});

// Route to display the button page
Route::get('/notify', [NotificationController::class, 'show'])->name('notify.show');

// Route that the JavaScript will call to send the message
Route::post('/notify', [NotificationController::class, 'send'])->name('notify.send');

Route::resource('items', ItemController::class);

Route::post('/items/send-to-telegram', [ItemController::class, 'sendToTelegram'])->name('items.sendToTelegram');