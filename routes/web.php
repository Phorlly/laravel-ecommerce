<?php

use App\Livewire\Auth\ForgotPassword;
use App\Livewire\Auth\Login;
use App\Livewire\Auth\Logup;
use App\Livewire\Auth\ResetPassword;
use App\Livewire\Pages\Cancel;
use App\Livewire\Pages\Cart;
use App\Livewire\Pages\Category;
use App\Livewire\Pages\Checkout;
use App\Livewire\Pages\Home;
use App\Livewire\Pages\MyOrder;
use App\Livewire\Pages\OrderDetail;
use App\Livewire\Pages\Product;
use App\Livewire\Pages\ProductDetail;
use App\Livewire\Pages\Success;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes for Ecommerce website using laravel with livewire and tailwindcss
|--------------------------------------------------------------------------
 */

Route::get('/', Home::class)->name('home');
Route::get('/categories', Category::class)->name('category');
Route::get('/products', Product::class)->name('product');
Route::get('/products/{slug}', ProductDetail::class)->name('product.detail');
Route::get('/cart', Cart::class)->name('cart');

//For routes guest
Route::middleware('guest')->group(function () {
    Route::get('/login', Login::class)->name('login');
    Route::get('/logup', Logup::class)->name('logup');
    Route::get('/forgot', ForgotPassword::class)->name('password.request');
    Route::get('/reset/{token}', ResetPassword::class)->name('password.reset');
});

//For routes authorization
Route::middleware('auth')->group(function () {
    Route::get('/checkout', Checkout::class)->name('checkout');
    Route::get('/my-orders', MyOrder::class)->name('order');
    Route::get('/my-orders/{order_id}', OrderDetail::class)->name('order.detail');

    Route::get('/success', Success::class)->name('success');
    Route::get('/cancel', Cancel::class)->name('cancel');
});
