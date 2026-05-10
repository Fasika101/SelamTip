<?php

use App\Http\Controllers\TipController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\BeggarController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use Illuminate\Support\Facades\Route;

// ─── Public tipping routes ────────────────────────────────────────────────────
Route::get('/tip/{code}', [TipController::class, 'show'])->name('tip.show');
Route::post('/tip/{code}/initiate', [TipController::class, 'initiate'])->name('tip.initiate');
Route::get('/tip/callback', [TipController::class, 'callback'])->name('tip.callback');
Route::post('/tip/webhook', [TipController::class, 'webhook'])->name('tip.webhook');
Route::get('/tip/success/{txRef}', [TipController::class, 'success'])->name('tip.success');

// ─── Landing page ─────────────────────────────────────────────────────────────
Route::get('/', function () {
    return view('welcome');
});

// ─── Admin auth (no middleware) ───────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('/login',   [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login',  [AuthController::class, 'login'])->name('login.post');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});

// ─── Admin protected routes ───────────────────────────────────────────────────
Route::prefix('admin')->name('admin.')->middleware(\App\Http\Middleware\AdminAuth::class)->group(function () {
    Route::get('/',                              [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('beggars', BeggarController::class);
    Route::get('beggars/{beggar}/qr',            [BeggarController::class, 'qrDownload'])->name('beggars.qr');
    Route::resource('users', UserController::class)->except(['show']);
});
