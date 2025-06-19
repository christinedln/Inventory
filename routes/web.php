<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use App\Http\Controllers\InventoryManagerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\SalesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;

// Guest routes
Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});

Route::get('/', function () {
    if (auth()->check()) {
        $dashboardRoute = auth()->user()->getDashboardRoute();
        return redirect()->route($dashboardRoute);
    }
    return redirect()->route('login');
});



// Admin routes
Route::middleware(['auth'])->prefix('admin')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== User::ROLE_ADMIN) {
            return redirect()->route(auth()->user()->getDashboardRoute());
        }
        return view('admin.admindashboard');
    })->name('admin.dashboard');
});

// Inventory Manager routes
Route::middleware(['auth'])->prefix('inventory')->group(function () {
    Route::get('/dashboard', [InventoryManagerController::class, 'dashboard'])->name('inventory.dashboard');
    Route::get('/products', [InventoryManagerController::class, 'products'])->name('inventory.products');
});

// User routes
Route::middleware(['auth'])->prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== User::ROLE_USER) {
            return redirect()->route(auth()->user()->getDashboardRoute());
        }
        return view('user.userdashboard');
    })->name('user.dashboard');
});

// Shared authenticated routes
Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::get('/admin/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');

Route::post('/inventory', [ProductController::class, 'store'])->name('inventory.store');
Route::get('/inventory', [ProductController::class, 'index'])->name('inventory');
Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');

Route::get('/notification', [NotificationController::class, 'index'])->name('notification');
Route::post('/notifications/{id}/resolve', [NotificationController::class, 'resolve'])->name('notifications.resolve');
Route::post('/notifications/{id}/toggle-status', [NotificationController::class, 'toggleStatus'])->name('notifications.toggleStatus');

Route::get('/salesreport', [SalesReportController::class, 'index'])->name('salesreport');