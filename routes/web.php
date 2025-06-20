<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Models\User;
use App\Http\Controllers\InventoryManagerController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Manager\ManagerDashboardController;
use App\Http\Controllers\Admin\AdminInventoryController;
use App\Http\Controllers\Manager\ManagerInventoryController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Manager\ManagerNotificationController;
use App\Http\Controllers\Maintenance\AdminCategoryController;
use App\Http\Controllers\Maintenance\AdminSizeController;
use App\Http\Controllers\Maintenance\CategoryController;
use App\Http\Controllers\Maintenance\SizeController;
use App\Http\Controllers\MonthlySalesReportController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DailyInputController;
use App\Http\Controllers\TargetInputFormController;
use App\Http\Controllers\QuarterlySalesController;
use App\Http\Middleware\NoCacheHeaders;
use App\Http\Controllers\Manager\ManagerCategoryController;
use App\Http\Controllers\Admin\RoleController;

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

Route::middleware(['auth', NoCacheHeaders::class])->prefix('admin')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/inventory', [AdminInventoryController::class, 'store'])->name('admin.inventory.store');
    Route::get('/inventory', [AdminInventoryController::class, 'index'])->name('admin.inventory');
    Route::get('/product/delete/{id}', [AdminInventoryController::class, 'delete'])->name('admin.product.delete');
    Route::post('/product/update/{id}', [AdminInventoryController::class, 'update'])->name('admin.products.update');
    Route::patch('/product/approve/{id}', [AdminInventoryController::class, 'approve'])->name('admin.product.approve');
    Route::get('/notification', [AdminNotificationController::class, 'index'])->name('admin.notification');
    Route::post('/notifications/{id}/resolve', [AdminNotificationController::class, 'resolve'])->name('admin.notifications.resolve');
    Route::post('/notifications/{id}/toggle-status', [AdminNotificationController::class, 'toggleStatus'])->name('admin.notifications.toggleStatus');
    Route::get('/maintenance/category', [AdminCategoryController::class, 'index'])->name('admin.maintenance.category');
    Route::get('/maintenance/size', [AdminSizeController::class, 'index'])->name('admin.maintenance.size');
    Route::get('/maintenance/category', [CategoryController::class, 'index'])->name('admin.maintenance.category');
    Route::get('/maintenance/size', [SizeController::class, 'index'])->name('admin.maintenance.size');
    Route::get('/roles', [RoleController::class, 'index'])->name('admin.roles');
    Route::post('/roles', [RoleController::class, 'store'])->name('admin.roles.store');
    Route::post('/roles/{id}/toggle', [RoleController::class, 'toggle'])->name('admin.roles.toggle');
    Route::delete('/roles/{id}', [RoleController::class, 'destroy'])->name('admin.roles.destroy');
});

Route::middleware(['auth', NoCacheHeaders::class])->prefix('manager')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    Route::post('/inventory', [ManagerInventoryController::class, 'store'])->name('manager.inventory.store');
    Route::get('/inventory', [ManagerInventoryController::class, 'index'])->name('manager.inventory');
    Route::get('/product/delete/{id}', [ManagerInventoryController::class, 'delete'])->name('manager.product.delete');
    Route::post('/product/update/{id}', [ManagerInventoryController::class, 'update'])->name('manager.products.update');
    Route::get('/notification', [ManagerNotificationController::class, 'index'])->name('manager.notification');
    Route::post('/notifications/{id}/resolve', [ManagerNotificationController::class, 'resolve'])->name('manager.notifications.resolve');
    Route::post('/notifications/{id}/toggle-status', [ManagerNotificationController::class, 'toggleStatus'])->name('manager.notifications.toggleStatus');
    Route::get('/maintenance/category', [CategoryController::class, 'index'])->name('manager.maintenance.category');
    Route::get('/maintenance/size', [SizeController::class, 'index'])->name('manager.maintenance.size');
    Route::get('/manager/dropdowns', [CategoryController::class, 'getDropdownData'])->name('manager.dropdowns');
});

//Route::post('/inventory', [ProductController::class, 'store'])->name('inventory.store');
//Route::get('/inventory', [ProductController::class, 'index'])->name('inventory');
//Route::get('/product/delete/{id}', [ProductController::class, 'delete'])->name('product.delete');
//Route::post('/product/update/{id}', [ProductController::class, 'update'])->name('products.update');

// User routes
Route::middleware(['auth', NoCacheHeaders::class])->prefix('user')->group(function () {
    Route::get('/dashboard', function () {
        if (auth()->user()->role !== User::ROLE_USER) {
            return redirect()->route(auth()->user()->getDashboardRoute());
        }
        return view('user.userdashboard');
    })->name('user.dashboard');
});

// Shared authenticated routes
Route::middleware(['auth', NoCacheHeaders::class])->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

Route::prefix('sales-report')
    ->name('sales-report.')
    ->middleware(['auth', NoCacheHeaders::class])
    ->group(function () {
        Route::get('/daily-sales', [DailyInputController::class, 'index'])->name('daily-sales.index');
        Route::post('/daily-sales', [DailyInputController::class, 'store'])->name('daily-sales.store');
        Route::delete('/daily-sales/{id}', [DailyInputController::class, 'destroy'])->name('daily-sales.destroy');

        Route::get('/monthly-sales', [MonthlySalesReportController::class, 'index'])->name('monthly-sales.index');
        Route::post('/monthly-sales/export', [MonthlySalesReportController::class, 'export'])->name('monthly-sales.export');
        Route::delete('/monthly-sales/delete-all', [MonthlySalesReportController::class, 'deleteAll'])
            ->name('monthly-sales.delete-all');
        Route::delete('/monthly-sales/delete-month/{month}/{year}', [MonthlySalesReportController::class, 'deleteMonth'])
            ->name('monthly-sales.delete-month');

        Route::get('/target-input', [TargetInputFormController::class, 'index'])->name('target-input.index');
        Route::post('/target-input', [TargetInputFormController::class, 'store'])->name('target-input.store');
        Route::delete('/target-input/{id}', [TargetInputFormController::class, 'destroy'])->name('target-input.destroy');

        Route::get('/quarterly-sales', [QuarterlySalesController::class, 'index'])->name('quarterly-sales.index');
    });