<?php

use App\Http\Controllers\Admin\AdminDashController;
use App\Http\Controllers\Admin\AdminLoginController;
use App\Http\Controllers\Admin\Blog\BlogController;
use App\Http\Controllers\Admin\Blog\CategoriesController as BlogCategoriesController;
use App\Http\Controllers\Admin\Blog\TagsController as BlogTagsController;
use App\Http\Controllers\Admin\BulkActionController;
use App\Http\Controllers\Admin\IcalController;
use App\Http\Controllers\Admin\Locations\CityController;
use App\Http\Controllers\Admin\Locations\CountryController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\News\CategoriesController as NewsCategoriesController;
use App\Http\Controllers\Admin\News\NewsController;
use App\Http\Controllers\Admin\News\TagsController as NewsTagsController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\RecoveryController;
use App\Http\Controllers\Admin\SectionController;
use App\Http\Controllers\Admin\SiteSettingsController;
use App\Http\Controllers\Admin\TestimonialController;
use App\Http\Controllers\Admin\Tour\AttributesController;
use App\Http\Controllers\Admin\Tour\AvailabilityController;
use App\Http\Controllers\Admin\Tour\BookingController;
use App\Http\Controllers\Admin\Tour\CategoriesController as TourCategoriesController;
use App\Http\Controllers\Admin\Tour\ReviewController;
use App\Http\Controllers\Admin\Tour\TourController;
use Illuminate\Support\Facades\Route;

Route::get('/admins', function () {
    return redirect()->route('admin.login');
})->name('admin.admin');

Route::middleware('guest')->prefix('admin')->namespace('Admin')->group(function () {
    Route::get('/auth', [AdminLoginController::class, 'login'])->name('admin.login');
    Route::post('/perform-login', [AdminLoginController::class, 'performLogin'])->name('admin.performLogin')->middleware('throttle:5,1');
});

Route::middleware('admin')->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashController::class, 'dashboard'])->name('dashboard');
    Route::get('/logo', [SiteSettingsController::class, 'showLogo'])->name('logo.show');
    Route::post('/logo', [SiteSettingsController::class, 'saveLogo'])->name('logo.store');
    Route::get('/contact', [SiteSettingsController::class, 'showContact'])->name('contact.show');
    Route::post('/contact', [SiteSettingsController::class, 'saveContact'])->name('contact.store');
    Route::get('/logout', [AdminLoginController::class, 'logout'])->name('logout');
    Route::post('bulk-actions/{resource}', [BulkActionController::class, 'handle'])->name('bulk-actions');
});
