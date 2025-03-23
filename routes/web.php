<?php

use App\Http\Controllers\ConfigController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\PaperController;
use App\Http\Middleware\checkSession;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;


Route::get('/login', Login::class)->name('login')->middleware([checkSession::class]);

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        Session::flush();
        Auth::logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::get('/customers', [CustomerController::class, 'index'])->name('customers');
    Route::get('/papers', [PaperController::class, 'index'])->name('papers');
    Route::get('/configs', [ConfigController::class, 'index'])->name('configs');
});
