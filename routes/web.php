<?php

use App\Http\Controllers\CetakUlangController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\GantiPasswordController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::resource('login', LoginController::class);
Route::get('register', [LoginController::class, 'register']);
Route::get('logout', [LoginController::class, 'logout'])->name('logout');
Route::middleware(['auth'])->group(function () {
    Route::get('/', [Controller::class, 'index'])->name('dashboard');
    Route::get('cetak-ulang', [CetakUlangController::class, 'datatable'])->name('dashboard.datatable');
    Route::resource('change-password', GantiPasswordController::class);
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('users', UserController::class);
});
