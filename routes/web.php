<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Seller\DashboardController;
use App\Http\Controllers\Seller\UmkmController;
use App\Http\Controllers\Seller\ProductController;
use App\Http\Controllers\Seller\OrderController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::get('/dashboard', function () {
    // show UMKM listing directly on buyer dashboard
    return redirect()->route('umkms.index');
})->middleware(['auth', 'verified', 'role:BUYER'])->name('dashboard');

// buyer-facing UMKM marketplace
Route::get('/umkms', [\App\Http\Controllers\UmkmController::class, 'index'])
    ->middleware(['auth', 'verified', 'role:BUYER'])
    ->name('umkms.index');
Route::get('/umkms/{umkm}', [\App\Http\Controllers\UmkmController::class, 'show'])
    ->middleware(['auth', 'verified', 'role:BUYER'])
    ->name('umkms.show');

// Buyer Cart
Route::middleware(['auth', 'verified', 'role:BUYER'])->group(function () {
    Route::get('/cart', [\App\Http\Controllers\CartController::class, 'index'])->name('cart.index');
    Route::post('/cart', [\App\Http\Controllers\CartController::class, 'store'])->name('cart.store');
    Route::put('/cart/{cartItem}', [\App\Http\Controllers\CartController::class, 'update'])->name('cart.update');
    Route::delete('/cart/{cartItem}', [\App\Http\Controllers\CartController::class, 'destroy'])->name('cart.destroy');
    
    Route::get('/products/{product}', [\App\Http\Controllers\ProductController::class, 'show'])->name('products.show');
});
// Seller Routes
Route::middleware(['auth', 'verified', 'role:OWNER'])->prefix('seller')->name('seller.')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // UMKM registration / management
    Route::get('/umkm/create', [UmkmController::class, 'create'])->name('umkm.create');
    Route::post('/umkm', [UmkmController::class, 'store'])->name('umkm.store');
    Route::get('/umkm/edit', [UmkmController::class, 'edit'])->name('umkm.edit');
    Route::put('/umkm', [UmkmController::class, 'update'])->name('umkm.update');

    Route::resource('products', ProductController::class);
    Route::delete('product-images/{productImage}', [ProductController::class, 'deleteImage'])->name('product-images.destroy');

    Route::get('orders', [OrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [OrderController::class, 'show'])->name('orders.show');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
