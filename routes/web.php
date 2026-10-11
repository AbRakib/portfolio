<?php

use App\Http\Controllers\Backend\AdminDashboardController;
use App\Http\Controllers\Backend\BlogController;
use App\Http\Controllers\Backend\ProfileController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', [AdminDashboardController::class, 'index'])
        ->name('dashboard');
    Route::get('/portfolio/edit', [ProfileController::class, 'edit'])->name('portfolio.edit');
    Route::put('/portfolio', [ProfileController::class, 'update'])->name('portfolio.update');
    Route::resource('blogs', BlogController::class)->except('show');
});

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'index'])->name('login');
    Route::post('/login', [LoginController::class, 'authenticate'])->middleware('throttle:5,1')->name('login.store');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');
