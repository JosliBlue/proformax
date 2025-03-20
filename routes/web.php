<?php

use App\Http\Middleware\checkSession;
use App\Livewire\Auth\Login;
use Illuminate\Support\Facades\Route;


Route::get('/login', Login::class)->name('login')->middleware([checkSession::class]);

Route::middleware('auth')->group(function () {
    Route::get('/logout', function () {
        auth()->logout();
        return redirect()->route('login');
    })->name('logout');

    Route::get('/', function () {
        return view('welcome');
    })->name('principal');
});
