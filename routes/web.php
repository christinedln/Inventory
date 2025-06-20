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

    // Admin Maintenance: Categories
    Route::get('/maintenance/admincategory', [CategoryController::class, 'index'])->name('admin.maintenance.category');
    Route::post('/maintenance/admincategory/add', [CategoryController::class, 'store'])->name('admin.maintenance.category.add');
    Route::delete('/maintenance/admincategory/{category}', [CategoryController::class, 'destroy'])->name('admin.maintenance.category.delete');
    Route::put('/maintenance/admincategory/{category}', [CategoryController::class, 'update'])->name('admin.maintenance.category.update');
    Route::get('/maintenance/admincategory/{category}/edit', [CategoryController::class, 'edit'])->name('admin.maintenance.category.edit');

    // Admin Maintenance: Sizes
    Route::get('/maintenance/adminsize', [SizeController::class, 'index'])->name('admin.maintenance.size');
    Route::post('/maintenance/adminsize/add', [SizeController::class, 'store'])->name('admin.maintenance.size.add');
    Route::delete('/maintenance/adminsize/{size}', [SizeController::class, 'destroy'])->name('admin.maintenance.size.delete');
    Route::put('/maintenance/adminsize/{size}', [SizeController::class, 'update'])->name('admin.maintenance.size.update');
    Route::get('/maintenance/adminsize/{size}/edit', [SizeController::class, 'edit'])->name('maintenance.size.edit');

});

Route::middleware(['auth', NoCacheHeaders::class])->prefix('manager')->group(function () {
    Route::get('/dashboard', [ManagerDashboardController::class, 'index'])->name('manager.dashboard');
    Route::post('/inventory', [ManagerInventoryController::class, 'store'])->name('manager.inventory.store');
    Route::get('/inventory', [ManagerInventoryController::class, 'index'])->name('manager.inventory');
    Route::post('/product/update/{id}', [ManagerInventoryController::class, 'update'])->name('manager.products.update');
    Route::get('/notification', [ManagerNotificationController::class, 'index'])->name('manager.notification');
    Route::post('/notifications/{id}/resolve', [ManagerNotificationController::class, 'resolve'])->name('manager.notifications.resolve');
    Route::post('/notifications/{id}/toggle-status', [ManagerNotificationController::class, 'toggleStatus'])->name('manager.notifications.toggleStatus');

    // Inventory Manager Maintenance: Categories
    Route::get('/maintenance/managercategory', [CategoryController::class, 'index'])->name('manager.maintenance.category');
    Route::post('/maintenance/managercategory/add', [CategoryController::class, 'store'])->name('manager.maintenance.category.add');
    Route::put('/maintenance/managercategory/{category}', [CategoryController::class, 'update'])->name('manager.maintenance.category.update');
    Route::get('/maintenance/managercategory/{category}/edit', [CategoryController::class, 'edit'])->name('manager.maintenance.category.edit');

    // Inventory Manager Maintenance: Sizes
    Route::get('/maintenance/managersize', [SizeController::class, 'index'])->name('manager.maintenance.size');
    Route::post('/maintenance/managersize/add', [SizeController::class, 'store'])->name('manager.maintenance.size.add');
    Route::put('/maintenance/managersize/{size}', [SizeController::class, 'update'])->name('manager.maintenance.size.update');
    Route::get('/maintenance/managersize/{size}/edit', [SizeController::class, 'edit'])->name('manager.maintenance.size.edit');

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


        Route::put('/admin/maintenance/category/{category}', [\App\Http\Controllers\Maintenance\CategoryController::class, 'update'])->name('maintenance.category.update');
        Route::get('/admin/maintenance/category/{category}/edit', [\App\Http\Controllers\Maintenance\CategoryController::class, 'edit'])->name('maintenance.category.edit');
        Route::delete('/admin/maintenance/category/{category}', [\App\Http\Controllers\Maintenance\CategoryController::class, 'destroy'])->name('maintenance.category.delete');
    });
