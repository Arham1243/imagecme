<?php

use App\Http\Controllers\Frontend\IndexController;
use Illuminate\Support\Facades\Route;

Route::name('frontend.')->group(function () {
    Route::get('/', [IndexController::class, 'index'])->name('index');
    Route::get('/imaging/{slug}', [IndexController::class, 'imagingDetail'])->name('imagingDetail');
});

require __DIR__.'/user.php';
require __DIR__.'/admin.php';
