<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\IsAdmin;


Route::get('/', [ShortLinkController::class, 'index']);
Route::post('/shorten', [ShortLinkController::class, 'store'])->name('shorten');
Route::get('/s/{code}', [ShortLinkController::class, 'redirect']);

Route::middleware(['auth',IsAdmin::class])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
    Route::delete('/link/{id}', [AdminController::class, 'destroy'])->name('link.delete');
});

Route::middleware('auth')->group(function () {
    Route::delete('/user/link/{id}', [ShortLinkController::class, 'destroy'])->name('user.link.delete');
});


Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);


