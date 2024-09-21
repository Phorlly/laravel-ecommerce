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

Route::get('/checkout', Checkout::class)->name('checkout');
Route::get('/my-orders', MyOrder::class)->name('order');
Route::get('/my-orders/{order}', OrderDetail::class)->name('order.detail');

//For routes authorization
Route::get('/login', Login::class)->name('login');
Route::get('/logup', Logup::class)->name('logup');
Route::get('/forgot-password', ForgotPassword::class)->name('forgot');
Route::get('/reset-password', ResetPassword::class)->name('reset');


Route::get('/cancel', Cancel::class)->name('cancel');
Route::get('/success', Success::class)->name('success');

