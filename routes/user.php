<?php

use App\Http\Controllers\BulkActionController;
use App\Http\Controllers\Frontend\Auth\AuthController;
use App\Http\Controllers\Frontend\Auth\PasswordResetController;
use App\Http\Controllers\User\AnalyticsController;
use App\Http\Controllers\User\DiagnosticCaseController;
use App\Http\Controllers\User\ProfileSettingsController;
use App\Http\Controllers\User\RecoveryController;
use App\Http\Controllers\User\UserDashController;
use Illuminate\Support\Facades\Route;

Route::prefix('auth')->name('auth.')->middleware('user_guest')->group(function () {
    Route::get('signup', [AuthController::class, 'signup'])->name('signup');
    Route::post('signup', [AuthController::class, 'performSignup'])->name('signup.perform');
    Route::get('login', [AuthController::class, 'login'])->name('login');
    Route::post('login', [AuthController::class, 'performLogin'])->name('login.perform');
});

Route::get('password/reset', [PasswordResetController::class, 'index'])->name('password.request');
Route::post('password/email', [PasswordResetController::class, 'sendResetLink'])->name('password.email');
Route::get('password/notify', [PasswordResetController::class, 'notify'])->name('password.notify');
Route::get('password/reset/{token}', [PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [PasswordResetController::class, 'resetPassword'])->name('password.update');

Route::middleware(['auth', 'check_user_status'])->prefix('user')->name('user.')->group(function () {
    Route::get('/dashboard', [UserDashController::class, 'dashboard'])->name('dashboard');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('bulk-actions/{resource}', [BulkActionController::class, 'handle'])->name('bulk-actions');
    Route::get('recovery/{resource}', [RecoveryController::class, 'index'])->name('recovery.index');

    Route::resource('cases', DiagnosticCaseController::class);
    Route::get('cases/delete-image/{id}', [DiagnosticCaseController::class, 'deleteImage'])->name('cases.deleteImage');
    Route::get('cases/{id}/chat', [DiagnosticCaseController::class, 'chat'])->name('cases.chat');
    Route::post('cases/{id}/chat-publish', [DiagnosticCaseController::class, 'publishConversation'])->name('cases.chat.publish');
    Route::post('/api/cases/update/{id}', [DiagnosticCaseController::class, 'updateTitle'])->name('api.cases.update');
    Route::get('/api/cases/{id}/chats', [DiagnosticCaseController::class, 'allChats'])->name('cases.chat.show');
    Route::post('/api/cases/{id}/save-chat', [DiagnosticCaseController::class, 'saveChat'])->name('cases.chat.save');

    Route::resource('profile', ProfileSettingsController::class);
    Route::get('profile/change/password', [ProfileSettingsController::class, 'changePassword'])->name('profile.changePassword');
    Route::post('profile/change/password/update', [ProfileSettingsController::class, 'updatePassword'])->name('profile.updatePassword');

    Route::get('analytics/cases', [AnalyticsController::class, 'cases'])->name('analytics.cases');
});
