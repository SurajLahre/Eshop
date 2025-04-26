<?php

use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Home page
Route::get('/', [HomeController::class, 'index'])->name('home');

// Shop routes
Route::get('/shop', [ShopController::class, 'products'])->name('shop.products');
Route::get('/shop/product/{slug}', [ShopController::class, 'show'])->name('shop.product');
Route::get('/shop/category/{slug}', [ShopController::class, 'category'])->name('shop.category');

// Cart routes
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/cart/clear', [CartController::class, 'clear'])->name('cart.clear');

// Checkout routes
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::post('/checkout/process', [CheckoutController::class, 'process'])->name('checkout.process');
Route::get('/checkout/complete/{order}', [CheckoutController::class, 'complete'])->name('checkout.complete');

// User routes (protected by auth)
Route::middleware('auth')->group(function () {
    // Default Laravel Breeze routes
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Custom user routes
    Route::get('/user/profile', [UserController::class, 'profile'])->name('user.profile');
    Route::post('/user/profile', [UserController::class, 'updateProfile'])->name('user.profile.update');
    Route::get('/user/change-password', [UserController::class, 'changePassword'])->name('user.change-password');
    Route::post('/user/change-password', [UserController::class, 'updatePassword'])->name('user.update-password');
    Route::get('/user/orders', [UserController::class, 'orders'])->name('user.orders');
    Route::get('/user/orders/{id}', [UserController::class, 'showOrder'])->name('user.orders.show');
});

// Admin routes (protected by admin middleware)
Route::prefix('admin')->name('admin.')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Admin Product routes
    Route::resource('products', AdminProductController::class);
    Route::delete('products/image/{id}', [AdminProductController::class, 'deleteImage'])->name('products.delete-image');

    // Admin Category routes
    Route::resource('categories', AdminCategoryController::class);

    // Admin Order routes
    Route::resource('orders', AdminOrderController::class);
});

require __DIR__.'/auth.php';
