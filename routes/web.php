<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaperController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SellerController;
use App\Http\Middleware\checkSession;
use App\Http\Middleware\checkAdmin;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

// LOGIN LINK
Route::get('/login', Login::class)->name('login')->middleware([checkSession::class]);

Route::middleware('auth')->group(function () {
    // PRINCIPAL LINK
    Route::get('/', function () {
        return view('home');
    })->name('home');

    // HEADER LINKS
    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');
    Route::get('/logout', function () {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    // USER LINKS
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/papers', [PaperController::class, 'index'])->name('papers');

    // ADMIN LINKS
    Route::middleware([checkAdmin::class])->group(function () {
        Route::get('/products', [ProductController::class, 'index'])->name('products');
        Route::get('/sellers', [SellerController::class, 'index'])->name('sellers');
        Route::get('/settings', function () {
            return view('admin.settings');
        })->name('settings');
    });
});
