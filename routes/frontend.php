<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\frontend\HomeController;
use App\Http\Controllers\frontend\FrontPublicOpinionController;

Route::controller(HomeController::class)->group(function () {
    Route::get('/', 'home')->name('home.index');
    Route::get('/searchData', 'searchData')->name('home.searchData');
});


Route::post('/store', [FrontPublicOpinionController::class, 'store'])->name('comment.store');

Route::get('/contact', [HomeController::class, 'contactPage'])->name('contact');
Route::get('/about', [HomeController::class, 'aboutPage'])->name('about');
Route::get('/commission-activities', [HomeController::class, 'commissionActivity'])->name('commission_activity');
Route::get('/comment', [HomeController::class, 'commentPage'])->name('comment');
Route::get('/notice', [HomeController::class, 'noticePage'])->name('notice');
Route::get('/commission-report', [HomeController::class, 'reportPage'])->name('commission-report');
Route::get('/commission-report-details/{slug}', [HomeController::class, 'reportDetails'])->name('commission-report-details');


// Route::get('/list-of-members', [HomeController::class, 'memberList'])->name('member_list');
Route::get('/members/{slug}', [HomeController::class, 'memberList'])->name('member_list');
Route::get('/members-details/{slug}', [HomeController::class, 'memberDetails'])->name('member_details');

Route::get('/gazettes/{slug}', [HomeController::class, 'gazettes'])->name('gazettes');

