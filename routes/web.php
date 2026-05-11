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
    Route::get('/export-laporan', [Controller::class, 'exportExcel'])->name('dashboard.export');
});
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('user', UserController::class);
    Route::prefix('users')->group(function () {
        Route::get('search-providers', [UserController::class, 'searchProviders'])->name('user.providers');
        Route::get('export', [UserController::class, 'export'])->name('users.export');
        Route::get('import-template', [UserController::class, 'template'])->name('users.template');
        Route::post('import-preview', [UserController::class, 'importPreview'])->name('users.import.preview');
        Route::post('import', [UserController::class, 'import'])->name('users.import');
    });
});
