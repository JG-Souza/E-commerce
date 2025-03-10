<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminProfileController;
use App\Http\Controllers\PagSeguroController;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductManagementController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Dashboards
Route::get('/dashboard', [ProductController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::get('/admin/dashboard', [ProductController::class, 'index'])
    ->middleware(AdminMiddleware::class)
    ->name('admin.dashboard');


// Profile user
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Profile admin
Route::prefix('admin')->middleware(AdminMiddleware::class)->group(function () {
    Route::get('/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::patch('/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::delete('/profile', [AdminProfileController::class, 'destroy'])->name('admin.profile.destroy');
});

require __DIR__.'/auth.php';

// Visualização Individual de produto

Route::get('/produto/{id}', [ProductController::class, 'show'])
    ->middleware(['auth', 'verified'])
    ->name('produto.show');

Route::prefix('admin')->group(function () {
    Route::get('/produto/{id}', [ProductController::class, 'show'])
        ->middleware(AdminMiddleware::class)
        ->name('admin.produto.show');
    });

// Carrinho

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


// Barra de pesquisa
Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');


// Crud users
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

// Crud adms
Route::get('/admins/index', [AdminController::class, 'index'])
->middleware(AdminMiddleware::class)
->name('admins.index');

Route::put('/admins/{admin}', [AdminController::class, 'update'])
->middleware(AdminMiddleware::class)
->name('admins.update');

Route::post('/admins', [AdminController::class, 'store'])
->middleware(AdminMiddleware::class)
->name('admins.store');

Route::delete('/admins/{admin}', [AdminController::class, 'destroy'])
->middleware(AdminMiddleware::class)
->name('admins.destroy');


// Saque
Route::post('/withdraw', [ProfileController::class, 'withdraw'])
->middleware(['auth', 'verified'])
->name('users.withdraw');


// Crud produtos para usuarios
Route::middleware('auth')->group(function () {
    Route::get('/products', [ProductManagementController::class, 'index'])->name('index.products');
    Route::post('/products', [ProductManagementController::class, 'store'])->name('store.products');
    Route::put('/pruducts/{product}', [ProductManagementController::class, 'update'])->name('update.products');
    Route::delete('/pruducts/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
});


// Crud produtos para admins
Route::middleware(AdminMiddleware::class)->prefix('/admin')->group(function () {
    Route::get('/products', [ProductManagementController::class, 'index'])->name('admin.index.products');
    Route::put('/pruducts/{product}', [ProductManagementController::class, 'update'])->name('admin.products.update');
    Route::delete('/pruducts/{product}', [ProductManagementController::class, 'destroy'])->name('admin.products.destroy');
});
