<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;


Route::get('/', [ShortLinkController::class, 'index']);
Route::post('/shorten', [ShortLinkController::class, 'store'])->name('shorten');
Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);

Route::middleware(['auth'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/link/{id}', [AdminController::class, 'destroy'])->name('link.delete');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
