<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
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

Route::get('/cart', [CartController::class, 'index'])
->middleware(['auth', 'verified'])
->name('cart');

Route::post('/cart/add/{productId}', [CartController::class, 'addToCart'])
->middleware(['auth', 'verified'])
->name('cart.add');

Route::get('/erro-pagamento', [CartController::class, 'purchaseError'])
->middleware(['auth', 'verified']);


Route::post('/checkout', [PagSeguroController::class, 'createCheckout'])
->middleware(['auth', 'verified']);

Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

Route::get('/users/index', [UserController::class, 'index'])
->middleware(AdminMiddleware::class)
->name('users.index');

Route::put('/users/{user}', [UserController::class, 'update'])
->middleware(AdminMiddleware::class)
->name('users.update');

Route::post('/users', [UserController::class, 'store'])
->middleware(AdminMiddleware::class)
->name('users.store');

Route::delete('/users/{user}', [UserController::class, 'destroy'])
->middleware(AdminMiddleware::class)
->name('users.destroy');
