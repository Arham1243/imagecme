<?php

use App\Http\Controllers\User\RecoveryController;
use App\Http\Controllers\User\UserDashController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\User\DiagnosticCaseController;
use App\Http\Controllers\BulkActionController;
use Illuminate\Support\Facades\Route;


Route::prefix('auth')->name('auth.')->middleware('user_guest')->group(function () {
    Route::get('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('signup', [AuthController::class, 'performSignup'])->name('signup.perform');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'performLogin'])->name('login.perform');
});


Route::middleware('auth')->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('bulk-actions/{resource}', [BulkActionController::class, 'handle'])->name('bulk-actions');
    Route::get('recovery/{resource}', [RecoveryController::class, 'index'])->name('recovery.index');
    Route::resource('cases', DiagnosticCaseController::class);
});