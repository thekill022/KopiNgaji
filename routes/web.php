<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PushSubscriptionController;
use App\Http\Controllers\RegionController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\UmkmController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\OrderController;
use App\Http\Controllers\Seller\WithdrawalController;
use App\Http\Controllers\Seller\ShippingZoneController;
use App\Http\Controllers\Seller\FinanceReportController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    // show UMKM listing directly on buyer dashboard
    return redirect()->route('umkms.index');
})->middleware(['auth', 'verified', 'role:BUYER,OWNER'])->name('dashboard');

// buyer-facing UMKM marketplace
Route::get('/umkms', [\App\Http\Controllers\UmkmController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:BUYER,OWNER'])
    ->name('umkms.index');
Route::get('/umkms/{umkm}', [\App\Http\Controllers\UmkmController::class, 'show'])
    ->middleware(['auth', 'verified', 'role:BUYER,OWNER'])
    ->name('umkms.show');

// Buyer Cart
Route::middleware(['auth', 'verified', 'role:BUYER,OWNER'])->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/bulk-update', [\App\Http\Controllers\CartController::class, 'bulkUpdate'])->name('cart.bulk-update');
    Route::put('/cart/{cartItem}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    
    Route::get('/checkout', [\App\Http\Controllers\CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [\App\Http\Controllers\CheckoutController::class, 'store'])->name('checkout.store');
    
    Route::get('/orders', [\App\Http\Controllers\OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [\App\Http\Controllers\OrderController::class, 'show'])->name('orders.show');
    Route::post('/orders/{order}/complete', [\App\Http\Controllers\OrderController::class, 'complete'])->name('orders.complete');
    Route::post('/orders/{order}/refund', [\App\Http\Controllers\OrderController::class, 'requestRefund'])->name('orders.refund');
    
    Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
    Route::get('/reports/create', [\App\Http\Controllers\ReportController::class, 'create'])->name('reports.create');
    Route::post('/reports', [\App\Http\Controllers\ReportController::class, 'store'])->name('reports.store');

    Route::post('/push-subscriptions', [PushSubscriptionController::class, 'store'])->name('push-subscriptions.store');
    Route::delete('/push-subscriptions', [PushSubscriptionController::class, 'destroy'])->name('push-subscriptions.destroy');
});

// Doku Callback & Redirect endpoints (public)
Route::post('/doku/notify', [\App\Http\Controllers\OrderController::class, 'dokuNotify'])->name('doku.notify');
Route::get('/doku/redirect', [\App\Http\Controllers\OrderController::class, 'dokuRedirect'])->name('doku.redirect');

// Region API (public, used by AlpineJS cascade selects)
Route::prefix('api/regions')->group(function () {
    Route::get('/provinces', [RegionController::class, 'provinces'])->name('regions.provinces');
    Route::get('/provinces/{province}/cities', [RegionController::class, 'cities'])->name('regions.cities');
    Route::get('/cities/{city}/districts', [RegionController::class, 'districts'])->name('regions.districts');
    Route::get('/districts/{district}/villages', [RegionController::class, 'villages'])->name('regions.villages');
});

// Seller Routes
Route::middleware(['auth', 'verified', 'role:OWNER'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/finance', [FinanceReportController::class, 'index'])->name('finance.index');

    // UMKM registration / management
    Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm', [UmkmController::class, 'update'])->name('umkm.update');

    Route::resource('products', ProductController::class);
    Route::patch('products/{product}/toggle-active', [ProductController::class, 'toggleActive'])->name('products.toggle-active');
    Route::delete('product-images/{productImage}', [ProductController::class, 'deleteImage'])->name('product-images.destroy');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/scan/qr', [OrderController::class, 'scan'])->name('orders.scan');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::post('orders/{order}/notify-complete', [OrderController::class, 'notifyComplete'])->name('orders.notify-complete');
    Route::post('orders/{order}/refund', [OrderController::class, 'refund'])->name('orders.refund');

    Route::resource('withdrawals', WithdrawalController::class)->only(['index', 'create', 'store']);
    Route::resource('shipping-zones', ShippingZoneController::class);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
