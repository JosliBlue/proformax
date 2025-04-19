<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SessionController;
use App\Http\Controllers\SettingsController;
use App\Http\Middleware\checkSession;
use App\Http\Middleware\checkAdmin;
use App\Http\Middleware\companyStyles;
use Illuminate\Support\Facades\Route;

// LOGIN LINK
Route::middleware([checkSession::class])->group(function () {
    Route::get('/loginsito', [SessionController::class, 'index'])->name('login');
    Route::post('login', [SessionController::class, 'login'])->name('login.submit');
});

// DESPUES DE INICIAR SESION LINKS
Route::middleware(['auth', companyStyles::class])->group(function () {
    Route::get('/', function () {
        return view('_general.home');
    })->name('home');

    // HEADER LINKS
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout');

    // USER LINKS
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::patch('/customers/{id}/soft_destroy', [CustomerController::class, 'soft_destroy'])->name('customers.soft_destroy');

    Route::get('/papers', [PaperController::class, 'index'])->name('papers');

    // ADMIN LINKS
    Route::middleware([checkAdmin::class])->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('/products/{id}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('/products/{id}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{id}', [ProductController::class, 'destroy'])->name('products.destroy');
        Route::patch('/products/soft_destroy/{id}', [ProductController::class, 'soft_destroy'])->name('products.soft_destroy');

        Route::get('/sellers', [SellerController::class, 'index'])->name('sellers');
        Route::get('/sellers/create', [SellerController::class, 'create'])->name('sellers.create');
        Route::post('/sellers', [SellerController::class, 'store'])->name('sellers.store');
        Route::get('/sellers/{id}/edit', [SellerController::class, 'edit'])->name('sellers.edit');
        Route::put('/sellers/{id}', [SellerController::class, 'update'])->name('sellers.update');
        Route::delete('/sellers/{id}', [SellerController::class, 'destroy'])->name('sellers.destroy');
        Route::patch('/sellers/soft_destroy/{id}', [SellerController::class, 'soft_destroy'])->name('sellers.soft_destroy');

        Route::get('/settings', [SettingsController::class, 'index'])->name('settings');
        Route::post('/settings', [SettingsController::class, 'update'])->name('settings.update');
    });
});
