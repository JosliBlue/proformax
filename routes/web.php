<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\SessionController;
use App\Http\Middleware\checkSession;
use App\Http\Middleware\checkAdmin;
use App\Livewire\Auth\Login;
use App\Models\Customer;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

// LOGIN LINK
Route::middleware([checkSession::class])->group(function () {
    Route::get('/loginsito', [SessionController::class, 'index'])->name('login');
    Route::post('login', [SessionController::class, 'login'])->name('login-submit');
});

Route::middleware('auth')->group(function () {
    // PRINCIPAL LINK
    Route::get('/', function () {
        return view('_general.home');
    })->name('home');

    // HEADER LINKS
    Route::get('/profile', function () {
        return view('_general.profile');
    })->name('profile');
    Route::get('/logout', [SessionController::class, 'logout'])->name('logout');

    // USER LINKS
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::post('/customers-store', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{id}/edit-form', function ($id) {
        return view('components.sin-clase.forms.customer-edit', ['customer' => Customer::findOrFail($id)]);
    })->name('customers.edit-form');
    Route::put('/customers/{id}', [CustomerController::class, 'update'])->name('customers.update');
    Route::patch('/customers/{id}/soft_destroy', [CustomerController::class, 'soft_destroy'])
     ->name('customers.soft_destroy');
    Route::delete('/customers/{id}', [CustomerController::class, 'destroy'])->name('customers.destroy');
    Route::get('/papers', [PaperController::class, 'index'])->name('papers');

    // ADMIN LINKS
    Route::middleware([checkAdmin::class])->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/sellers', [SellerController::class, 'index'])->name('sellers');
        Route::get('/settings', function () {
            return view('_admin.settings');
        })->name('settings');
    });
});
