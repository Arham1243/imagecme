<?php

use App\Http\Controllers\Frontend\CommentController;
use App\Http\Controllers\Frontend\DiagnosticCaseController;
use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/image-types/{slug}', [IndexController::class, 'imageTypeDetail'])->name('image-types.details');
    Route::prefix('cases')->name('cases.')->group(function () {
        Route::get('/{slug}', [DiagnosticCaseController::class, 'details'])->name('details');
        Route::resource('/{slug}/comments', CommentController::class);
        Route::post('/{slug}/submit-mcq-answers', [CommentController::class, 'submitAnswer'])->name('comments.submitMcqAnswer');
        Route::get('/{slug}/comments/delete-item/{id}', [CommentController::class, 'deleteItem'])->name('comments.deleteItem');
        Route::post('/{slug}/comments/{id}/reply/{parentReplyId?}', [CommentController::class, 'storeReply'])->name('comment.reply.store');

    });
});

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
