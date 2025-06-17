<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/inventory', function () {
    return view('inventory');
})->name('inventory');

Route::get('/salesreport', function () {
    return view('salesreport');
})->name('salesreport');

Route::get('/notification', function () {
    return view('notification');
})->name('notification');

Route::post('/inventory', [ProductController::class, 'store'])->name('inventory.store');
Route::get('/inventory', [ProductController::class, 'index'])->name('inventory');
Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');


Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
Route::post('/notifications/{id}/resolve', [NotificationController::class, 'resolve'])->name('notifications.resolve');
