<?php

use App\Http\Controllers\Frontend\DiagnosticCaseController;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/imaging/{slug}', [IndexController::class, 'imagingDetail'])->name('imagingDetail');
    Route::prefix('case')->name('case.')->group(function () {
        Route::get('/details', [DiagnosticCaseController::class, 'details'])->name('details');
        Route::get('/comments', [DiagnosticCaseController::class, 'comments'])->name('comments');
        Route::post('/comments', [DiagnosticCaseController::class, 'commentsStore'])->name('comments.store');
    });
});

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
