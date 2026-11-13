<?php

use App\Http\Controllers\Merchant\ShopController;
use App\Http\Controllers\Merchant\ServiceController;
use App\Http\Controllers\Merchant\OrderController;
use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ShopController as CustomerShopController;
use App\Http\Controllers\Customer\AddressController as CustomerAddressController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {

    // Pengalihan Dashboard Berdasarkan Role
    Route::get('/dashboard', function () {
        $user = auth()->user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'merchant') {
            return redirect()->route('merchant.dashboard');
        }

        if ($user->role === 'customer') {
            return redirect()->route('customer.dashboard');
        }

        abort(403, 'Role tidak dikenali.');
    })->name('dashboard');

    // Dashboard Admin
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin/dashboard', function () {
            return view('dashboard.admin');
        })->name('admin.dashboard');
    });

    // Dashboard Merchant
    Route::middleware('role:merchant')->group(function () {

        Route::get('/merchant/dashboard', function () {
            return view('dashboard.merchant');
        })->name('merchant.dashboard');

        // Pengelolaan Toko
        Route::get('/merchant/shops', [ShopController::class, 'index'])
            ->name('merchant.shops.index');

        Route::get('/merchant/shops/create', [ShopController::class, 'create'])
            ->name('merchant.shops.create');

        Route::post('/merchant/shops', [ShopController::class, 'store'])
            ->name('merchant.shops.store');

        Route::get('/merchant/shops/{id}/edit', [ShopController::class, 'edit'])
            ->name('merchant.shops.edit');

        Route::put('/merchant/shops/{id}', [ShopController::class, 'update'])
            ->name('merchant.shops.update');

        Route::delete('/merchant/shops/{id}', [ShopController::class, 'destroy'])
            ->name('merchant.shops.destroy');

        // Pengelolaan Layanan Percetakan
        Route::get('/merchant/services', [ServiceController::class, 'index'])
            ->name('merchant.services.index');

        Route::get('/merchant/services/create', [ServiceController::class, 'create'])
            ->name('merchant.services.create');

        Route::post('/merchant/services', [ServiceController::class, 'store'])
            ->name('merchant.services.store');

        Route::get('/merchant/services/{id}/edit', [ServiceController::class, 'edit'])
            ->name('merchant.services.edit');

        Route::put('/merchant/services/{id}', [ServiceController::class, 'update'])
            ->name('merchant.services.update');

        Route::delete('/merchant/services/{id}', [ServiceController::class, 'destroy'])
            ->name('merchant.services.destroy');

        // Pengelolaan Pesanan Masuk
        Route::get('/merchant/orders', [OrderController::class, 'index'])
            ->name('merchant.orders.index');

        Route::get('/merchant/orders/{id}', [OrderController::class, 'show'])
            ->name('merchant.orders.show');

        Route::post('/merchant/orders/{id}/accept', [OrderController::class, 'accept'])
            ->name('merchant.orders.accept');

        Route::post('/merchant/orders/{id}/reject', [OrderController::class, 'reject'])
            ->name('merchant.orders.reject');

        Route::post('/merchant/orders/{id}/process', [OrderController::class, 'startProcessing'])
            ->name('merchant.orders.process');

        Route::post('/merchant/orders/{id}/ready', [OrderController::class, 'markReady'])
            ->name('merchant.orders.ready');

        Route::post('/merchant/orders/{id}/shipped', [OrderController::class, 'markShipped'])
            ->name('merchant.orders.shipped');

        Route::post('/merchant/orders/{id}/complete', [OrderController::class, 'complete'])
            ->name('merchant.orders.complete');
    });

    // Dashboard dan Fitur Customer
    Route::middleware('role:customer')->group(function () {

        Route::get('/customer/dashboard', function () {
            return view('dashboard.customer');
        })->name('customer.dashboard');

        // Riwayat Pesanan Customer
        Route::get('/customer/orders', [CustomerOrderController::class, 'index'])
            ->name('customer.orders.index');

        Route::get('/customer/orders/{id}', [CustomerOrderController::class, 'show'])
            ->name('customer.orders.show');

        // Pencarian dan Detail Toko Percetakan
        Route::get('/customer/shops', [CustomerShopController::class, 'index'])
            ->name('customer.shops.index');

        Route::get('/customer/shops/{id}', [CustomerShopController::class, 'show'])
            ->name('customer.shops.show');

        // Pengelolaan Alamat Customer
        Route::get('/customer/addresses', [CustomerAddressController::class, 'index'])
            ->name('customer.addresses.index');

        Route::get('/customer/addresses/create', [CustomerAddressController::class, 'create'])
            ->name('customer.addresses.create');

        Route::post('/customer/addresses', [CustomerAddressController::class, 'store'])
            ->name('customer.addresses.store');

        Route::get('/customer/addresses/{id}/edit', [CustomerAddressController::class, 'edit'])
            ->name('customer.addresses.edit');

        Route::put('/customer/addresses/{id}', [CustomerAddressController::class, 'update'])
            ->name('customer.addresses.update');

        Route::delete('/customer/addresses/{id}', [CustomerAddressController::class, 'destroy'])
            ->name('customer.addresses.destroy');

        Route::post('/customer/addresses/{id}/default', [CustomerAddressController::class, 'setDefault'])
            ->name('customer.addresses.default');
    });

});
