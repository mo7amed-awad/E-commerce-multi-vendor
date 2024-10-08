<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Front\Auth\TwoFactorAuthentcationController;
use App\Http\Controllers\Front\CartController;
use App\Http\Controllers\Front\CheckoutController;
use App\Http\Controllers\Front\HomeController;
use App\Http\Controllers\Front\ProductController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', [HomeController::class,'index'])->name('home');
Route::get('products',[ProductController::class,'index'])->name('products.index');
Route::get('products/{product:slug}',[ProductController::class,'show'])->name('products.show');
Route::resource('cart',CartController::class);
Route::get('checkout',[CheckoutController::class,'create'])->name('checkout');
Route::post('checkout',[CheckoutController::class,'store']);

Route::get('auth/user/2fa',[TwoFactorAuthentcationController::class,'index'])->name('front.');
//require __DIR__ . '/auth.php';
require __DIR__ . '/dashboard.php';
