<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [ProductController::class, 'index'])
        ->middleware(AdminMiddleware::class)
        ->name('admin.dashboard');
});



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::get('/produto/{id}', [ProductController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('produto.show');

Route::prefix('admin')->group(function () {
    Route::get('/produto/{id}', [ProductController::class, 'show'])
        ->middleware(AdminMiddleware::class)
        ->name('admin.produto.show');
    });

Route::get('/cart', [CartController::class, 'index'])->name('cart');

Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])->name('cart.add');

Route::get('/erro-pagamento', [CartController::class, 'purchaseError']);


Route::post('/checkout', [PagSeguroController::class, 'createCheckout']);

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/users/gerenciamento', [UserController::class, 'gerenciamento'])->name('users.gerenciamento');
