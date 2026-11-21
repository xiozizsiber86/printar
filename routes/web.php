<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Admin\MerchantVerificationController as AdminMerchantVerificationController;
use App\Http\Controllers\Admin\ServiceVerificationController as AdminServiceVerificationController;
use App\Http\Controllers\Admin\ShopVerificationController as AdminShopVerificationController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\TransactionReportController as AdminTransactionReportController;

use App\Http\Controllers\Merchant\ShopController;
use App\Http\Controllers\Merchant\ServiceController;
use App\Http\Controllers\Merchant\OrderController;
use App\Http\Controllers\Merchant\DashboardController as MerchantDashboardController;
use App\Http\Controllers\Merchant\NotificationController as MerchantNotificationController;

use App\Http\Controllers\Customer\OrderController as CustomerOrderController;
use App\Http\Controllers\Customer\ShopController as CustomerShopController;
use App\Http\Controllers\Customer\AddressController as CustomerAddressController;
use App\Http\Controllers\Customer\CartController as CustomerCartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\OrderFileController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Customer\NotificationController;

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


    // ==================================================
    // DASHBOARD DAN FITUR ADMIN
    // ==================================================

    Route::middleware('role:admin')->group(function () {

        Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])
            ->name('admin.dashboard');


        // Kelola Kategori
        Route::get('/admin/categories', [AdminCategoryController::class, 'index'])
            ->name('admin.categories.index');

        Route::get('/admin/categories/create', [AdminCategoryController::class, 'create'])
            ->name('admin.categories.create');

        Route::post('/admin/categories', [AdminCategoryController::class, 'store'])
            ->name('admin.categories.store');

        Route::get('/admin/categories/{id}/edit', [AdminCategoryController::class, 'edit'])
            ->name('admin.categories.edit');

        Route::put('/admin/categories/{id}', [AdminCategoryController::class, 'update'])
            ->name('admin.categories.update');

        Route::post('/admin/categories/{id}/toggle-status', [AdminCategoryController::class, 'toggleStatus'])
            ->name('admin.categories.toggleStatus');

        Route::delete('/admin/categories/{id}', [AdminCategoryController::class, 'destroy'])
            ->name('admin.categories.destroy');


        // Kelola Pengguna
        Route::get('/admin/users', [AdminUserController::class, 'index'])
            ->name('admin.users.index');

        Route::get('/admin/users/{id}', [AdminUserController::class, 'show'])
            ->name('admin.users.show');

        Route::post('/admin/users/{id}/toggle-status', [AdminUserController::class, 'toggleStatus'])
            ->name('admin.users.toggleStatus');


        // Verifikasi Pembayaran
        Route::get('/admin/payments', [AdminPaymentController::class, 'index'])
            ->name('admin.payments.index');

        Route::get('/admin/payments/{paymentId}', [AdminPaymentController::class, 'show'])
            ->name('admin.payments.show');

        Route::get('/admin/payments/{paymentId}/proof', [AdminPaymentController::class, 'proof'])
            ->name('admin.payments.proof');

        Route::post('/admin/payments/{paymentId}/approve', [AdminPaymentController::class, 'approve'])
            ->name('admin.payments.approve');

        Route::post('/admin/payments/{paymentId}/reject', [AdminPaymentController::class, 'reject'])
            ->name('admin.payments.reject');


        // Verifikasi Merchant
        Route::get('/admin/merchants', [AdminMerchantVerificationController::class, 'index'])
            ->name('admin.merchants.index');

        Route::get('/admin/merchants/{id}', [AdminMerchantVerificationController::class, 'show'])
            ->name('admin.merchants.show');

        Route::post('/admin/merchants/{id}/approve', [AdminMerchantVerificationController::class, 'approve'])
            ->name('admin.merchants.approve');

        Route::post('/admin/merchants/{id}/reject', [AdminMerchantVerificationController::class, 'reject'])
            ->name('admin.merchants.reject');


        // Verifikasi Layanan Percetakan
        Route::get('/admin/services', [AdminServiceVerificationController::class, 'index'])
            ->name('admin.services.index');

        Route::get('/admin/services/{id}', [AdminServiceVerificationController::class, 'show'])
            ->name('admin.services.show');

        Route::post('/admin/services/{id}/approve', [AdminServiceVerificationController::class, 'approve'])
            ->name('admin.services.approve');

        Route::post('/admin/services/{id}/reject', [AdminServiceVerificationController::class, 'reject'])
            ->name('admin.services.reject');


        // Verifikasi Toko Percetakan
        Route::get('/admin/shops', [AdminShopVerificationController::class, 'index'])
            ->name('admin.shops.index');

        Route::get('/admin/shops/{id}', [AdminShopVerificationController::class, 'show'])
            ->name('admin.shops.show');

        Route::post('/admin/shops/{id}/approve', [AdminShopVerificationController::class, 'approve'])
            ->name('admin.shops.approve');

        Route::post('/admin/shops/{id}/reject', [AdminShopVerificationController::class, 'reject'])
            ->name('admin.shops.reject');


        // Laporan Transaksi
        Route::get('/admin/reports/transactions', [AdminTransactionReportController::class, 'index'])
            ->name('admin.reports.transactions');

        Route::get('/admin/reports/transactions/export', [AdminTransactionReportController::class, 'export'])
            ->name('admin.reports.transactions.export');
    });



    // ==================================================
    // DASHBOARD DAN FITUR MERCHANT
    // ==================================================

    Route::middleware('role:merchant')->group(function () {

        // Dashboard Merchant
        // Bisa diakses meskipun belum disetujui Admin.
        Route::get('/merchant/dashboard', [MerchantDashboardController::class, 'index'])
            ->name('merchant.dashboard');

        // Notifikasi Merchant
        Route::get('/merchant/notifications', [MerchantNotificationController::class, 'index'])
            ->name('merchant.notifications.index');

        Route::post('/merchant/notifications/read-all', [MerchantNotificationController::class, 'readAll'])
            ->name('merchant.notifications.readAll');

        Route::post('/merchant/notifications/{id}/read', [MerchantNotificationController::class, 'read'])
            ->name('merchant.notifications.read');


        // Fitur berikut hanya bisa digunakan Merchant yang sudah disetujui Admin.
        Route::middleware('role:merchant,approved')->group(function () {

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

            // Pengaturan Informasi Kurir
            Route::put('/merchant/orders/{id}/delivery', [OrderController::class, 'updateDelivery'])
                ->name('merchant.orders.delivery.update');

            // Download File Cetak Customer
            Route::get(
                '/merchant/orders/{id}/files/{fileId}/download',
                [OrderController::class, 'downloadFile']
            )->name('merchant.orders.files.download');

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
    });


    // ==================================================
    // DASHBOARD DAN FITUR CUSTOMER
    // ==================================================

    Route::middleware('role:customer')->group(function () {

        Route::get('/customer/dashboard', function () {
            return view('dashboard.customer');
        })->name('customer.dashboard');

        // Notifikasi Customer
        Route::get('/customer/notifications', [NotificationController::class, 'index'])
            ->name('customer.notifications.index');

        Route::post('/customer/notifications/read-all', [NotificationController::class, 'readAll'])
            ->name('customer.notifications.readAll');

        Route::post('/customer/notifications/{id}/read', [NotificationController::class, 'read'])
            ->name('customer.notifications.read');

        // Riwayat Pesanan Customer
        Route::get('/customer/orders', [CustomerOrderController::class, 'index'])
            ->name('customer.orders.index');

        Route::get('/customer/orders/{id}', [CustomerOrderController::class, 'show'])
            ->name('customer.orders.show');

        // Pembatalan Pesanan Customer
        Route::post('/customer/orders/{id}/cancel', [CustomerOrderController::class, 'cancel'])
            ->name('customer.orders.cancel');

        // Upload dan Hapus File Cetak
        Route::post(
            '/customer/orders/{orderId}/items/{itemId}/files',
            [OrderFileController::class, 'store']
        )->name('customer.orders.files.store');

        Route::delete(
            '/customer/orders/{orderId}/files/{fileId}',
            [OrderFileController::class, 'destroy']
        )->name('customer.orders.files.destroy');

        // Pembayaran Customer
        Route::get(
            '/customer/orders/{orderId}/payment',
            [PaymentController::class, 'show']
        )->name('customer.payments.show');

        Route::post(
            '/customer/orders/{orderId}/payment/proof',
            [PaymentController::class, 'uploadProof']
        )->name('customer.payments.proof');

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

        // Keranjang Belanja Customer
        Route::get('/customer/cart', [CustomerCartController::class, 'index'])
            ->name('customer.cart.index');

        Route::post('/customer/cart/{serviceId}', [CustomerCartController::class, 'add'])
            ->name('customer.cart.add');

        Route::put('/customer/cart/items/{itemId}', [CustomerCartController::class, 'update'])
            ->name('customer.cart.update');

        Route::delete('/customer/cart/items/{itemId}', [CustomerCartController::class, 'remove'])
            ->name('customer.cart.remove');

        Route::delete('/customer/cart', [CustomerCartController::class, 'clear'])
            ->name('customer.cart.clear');

        // Checkout Customer
        Route::get('/customer/checkout', [CheckoutController::class, 'index'])
            ->name('customer.checkout.index');

        Route::post('/customer/checkout', [CheckoutController::class, 'store'])
            ->name('customer.checkout.store');
    });
});
