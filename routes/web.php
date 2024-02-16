<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;

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
Route::get('/', [ProductController::class, 'index']);

Route::middleware('auth')->prefix('cart')->group(function () {
    Route::get('', [CartController::class, 'index']);
    Route::post('add', [CartController::class, 'addToCart'])->name('cart.add');
    Route::post('plus-quantity', [CartController::class, 'plusQuantity'])->name('cart.plusQuantity');
    Route::post('minus-quantity', [CartController::class, 'minusQuantity'])->name('cart.minusQuantity');
    Route::get('close', [CartController::class, 'close'])->name('cart.close');
});

Route::get('/dashboard', function () {
    return redirect('/');
    // return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/profile/logout', [ProfileController::class, 'logout'])->name('profile.logout');
});


require __DIR__.'/auth.php';
