<?php

use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\BulkActionController;
use App\Http\Controllers\Admin\RecoveryController;
use App\Http\Controllers\Admin\SiteSettingsController;
use Illuminate\Support\Facades\Route;

Route::get('/admins', function () {
    return redirect()->route('admin.login');
})->name('admin.admin');

Route::middleware('guest')->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/auth', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/perform-login', [AdminLoginController::class, 'performLogin'])->name('admin.login.perform')->middleware('throttle:5,1');
});

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashController::class, 'dashboard'])->name('dashboard');
    Route::get('/logo', [SiteSettingsController::class, 'showLogo'])->name('logo.show');
    Route::post('/logo', [SiteSettingsController::class, 'saveLogo'])->name('logo.store');
    Route::get('/contact', [SiteSettingsController::class, 'showContact'])->name('contact.show');
    Route::post('/contact', [SiteSettingsController::class, 'saveContact'])->name('contact.store');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::post('bulk-actions/{resource}', [BulkActionController::class, 'handle'])->name('bulk-actions');
    Route::get('recovery/{resource}', [RecoveryController::class, 'index'])->name('recovery.index');
});
