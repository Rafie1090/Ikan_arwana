<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\KolamController;
use App\Http\Controllers\MonitoringAirController;
use App\Http\Controllers\Pemilik\ManajemenPakanController;
use App\Http\Controllers\Pemilik\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// ======================
// CHECKOUT
// ======================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout', [CheckoutController::class, 'process'])->name('checkout.process');

Route::controller(\App\Http\Controllers\Client\ClientOrderController::class)->prefix('orders')->group(function () {
    Route::get('/', 'index')->name('client.orders.index');
    Route::put('/{id}/cancel', 'cancel')->name('client.orders.cancel');
});

// ======================
// WELCOME PAGE
// ======================
Route::get('/', function () {
    return view('welcome');
});

Route::get('/debug-db', function () {
    try {
        \DB::connection()->getPdo();
        $tables = \DB::select('SHOW TABLES');
        $tableNames = array_map(function($table) {
            return array_values((array)$table)[0];
        }, $tables);
        
        return [
            'status' => 'Connected',
            'database' => \DB::connection()->getDatabaseName(),
            'tables' => $tableNames,
            'users_count' => \App\Models\User::count(),
        ];
    } catch (\Exception $e) {
        return "Could not connect to the database. Error: " . $e->getMessage();
    }
});

Route::get('/debug-cloudinary', function () {
    return [
        'env_has_url' => !empty(env('CLOUDINARY_URL')),
        'config_cloud_url' => config('cloudinary.cloud_url'),
        'config_all' => config('cloudinary'),
        'filesystems_cloudinary' => config('filesystems.disks.cloudinary'),
    ];
});

// ======================
// CART
// ======================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::post('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');



// ======================
// CLIENT ROUTES
// ======================
Route::middleware(['auth', 'role:client'])->group(function () {
    Route::get('/client', [ClientController::class, 'dashboard'])
        ->name('client.dashboard');
});

// ======================
// STAFF ROUTES
// ======================
Route::middleware(['auth', 'role:staff'])->prefix('staff')->group(function () {
    Route::get('/', [StaffController::class, 'dashboard']); // Handle /staff
    Route::get('/dashboard', [StaffController::class, 'dashboard'])->name('staff.dashboard');
    Route::get('/product-stock', [StaffController::class, 'productStock'])->name('staff.product.stock');
    Route::post('/product-stock/{id}', [StaffController::class, 'updateStock'])->name('staff.product.update-stock');
    
    // User Management
    Route::resource('users', UserController::class)->names([
        'index' => 'staff.users.index',
        'create' => 'staff.users.create',
        'store' => 'staff.users.store',
        'edit' => 'staff.users.edit',
        'update' => 'staff.users.update',
        'destroy' => 'staff.users.destroy',
    ]);
});

// ======================
// PEMILIK ROUTES
// ======================
Route::middleware(['auth', 'role:pemilik'])->prefix('pemilik')->group(function () {

    // Dashboard
    Route::get('/', [DashboardController::class, 'pemilik'])
        ->name('pemilik.dashboard');

    // Produk
    Route::controller(ProductController::class)->prefix('produk')->group(function () {
        Route::get('/', 'index')->name('pemilik.product.index');
        Route::get('/list', 'list')->name('pemilik.product.list');
        Route::post('/store', 'store')->name('pemilik.product.store');
        Route::get('/edit/{id}', 'edit')->name('pemilik.product.edit');
        Route::put('/update/{id}', 'update')->name('pemilik.product.update');
        Route::delete('/delete/{id}', 'destroy')->name('pemilik.product.delete');
    });

    // User Management
    Route::resource('users', UserController::class)->names([
        'index' => 'pemilik.users.index',
        'create' => 'pemilik.users.create',
        'store' => 'pemilik.users.store',
        'edit' => 'pemilik.users.edit',
        'update' => 'pemilik.users.update',
        'destroy' => 'pemilik.users.destroy',
    ]);
});

// ======================
// DASHBOARD DEFAULT (Client E-commerce)
// ======================
Route::get('/dashboard', [ClientController::class, 'dashboard'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// ======================
// PROFILE
// ======================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

// ======================
// AUTH
// ======================
require __DIR__.'/auth.php';

// ======================
// CHECK AUTH
// ======================
Route::get('/check-auth', function () {
    if (Auth::check()) {
        return redirect()->route(Auth::user()->role.'.dashboard');
    }

    return redirect('/')->with('showAuthModal', true);
})->name('check.auth');

// ======================
// DETAIL PRODUK (CLIENT)
// ======================
Route::get('/product/{id}', [ClientController::class, 'show'])->name('product.detail');

// ======================
// KOLAM (PEMILIK & STAFF)
// ======================
Route::middleware(['auth', 'role:pemilik,staff'])->group(function () {
    Route::controller(KolamController::class)->prefix('kolam')->group(function () {
        Route::get('/', 'index')->name('pemilik.kolam');
        Route::post('/store', 'store')->name('pemilik.kolam.store');
        Route::post('/update/{id}', 'update')->name('pemilik.kolam.update');
        Route::delete('/delete/{id}', 'delete')->name('pemilik.kolam.delete');
    });
});

// ======================
// MANAJEMEN PAKAN (PEMILIK & STAFF)
// ======================
Route::middleware(['auth', 'role:pemilik,staff'])->group(function () {
    Route::controller(ManajemenPakanController::class)->prefix('pakan')->group(function () {
        Route::get('/', 'index')->name('manajemen.pakan.index');
        Route::post('/', 'store')->name('manajemen.pakan.store');
        Route::put('/{id}', 'update')->name('manajemen.pakan.update');
        Route::delete('/{id}', 'destroy')->name('manajemen.pakan.destroy');
    });
});

// ======================
// MANAJEMEN PESANAN (PEMILIK & STAFF)
// ======================
Route::middleware(['auth', 'role:pemilik,staff'])->group(function () {
    Route::controller(\App\Http\Controllers\Pemilik\ManajemenPesananController::class)->prefix('pesanan')->group(function () {
        Route::get('/', 'index')->name('pemilik.pesanan.index');
        Route::put('/{id}/status', 'updateStatus')->name('pemilik.pesanan.update-status');
        Route::get('/export', 'export')->name('pemilik.pesanan.export');
    });
});

// ======================
// MONITORING AIR (PEMILIK & STAFF)
// ======================
Route::middleware(['auth', 'role:pemilik,staff'])->group(function () {
    Route::get('/monitoring-air', [MonitoringAirController::class, 'index'])
        ->name('monitoring.air');
    Route::post('/monitoring-air/store', [MonitoringAirController::class, 'store'])
        ->name('monitoring.air.store');
    Route::delete('/monitoring-air/{id}', [MonitoringAirController::class, 'delete'])
        ->name('monitoring.air.delete');
    Route::get('/monitoring-air/export-excel/{kolam}', [MonitoringAirController::class, 'exportExcel'])
        ->name('monitoring.air.export.excel');
});

// ======================
// MANAGE KOLAM (PEMILIK)
// ======================
