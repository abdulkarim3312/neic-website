<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\home;

use App\Http\Controllers\frontend\product;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\FrontPublicOpinionController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home.index');
    Route::get('/searchData', 'searchData')->name('home.searchData');
});


Route::post('/store', [FrontPublicOpinionController::class, 'store'])->name('comment.store');

Route::get('/person-details/{id}', [HomeController::class, 'details'])->name('person_details');
Route::get('/contact-page', [HomeController::class, 'contactPage'])->name('contact_page');
Route::get('/comment-page', [HomeController::class, 'commentPage'])->name('comment_page');

