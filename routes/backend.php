<?php


use Illuminate\Support\Facades\Route;

// Controllers
use App\Http\Controllers\backend\admin;
use App\Http\Controllers\backend\AuthController;
use App\Http\Controllers\backend\MenuController;
use App\Http\Controllers\backend\RoleController;
use App\Http\Controllers\backend\UserController;
use App\Http\Controllers\backend\ArticleController;
use App\Http\Controllers\backend\AttachmentController;
use App\Http\Controllers\backend\DesignationController;
use App\Http\Controllers\backend\MenuCategoryController;
use App\Http\Controllers\backend\PublicOpinionController;
use App\Http\Controllers\backend\ArticleCategoryController;
use App\Http\Controllers\backend\CommitteeMemberController;
use App\Http\Controllers\backend\AttachmentCategoryController;
use App\Http\Controllers\backend\MemberCategoryController;
use App\Http\Controllers\backend\SettingController;

/*
|--------------------------------------------------------------------------
| Admin Authentication Routes
|--------------------------------------------------------------------------
*/

// Guest-only routes (only accessible if NOT logged in as admin)
Route::middleware('guest:admin')->prefix('admin')->group(function () {
    Route::get('/login', [Admin::class, 'login'])->name('login');
    Route::post('/login/processing', [AuthController::class, 'adminLoginPost'])->name('admin-login-post');
});

// Logout (only for authenticated admins)
Route::post('/admin/logout', [Admin::class, 'logout'])
    ->name('admin.logout')
    ->middleware('auth:admin');

/*
|--------------------------------------------------------------------------
| Protected Admin Routes
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->middleware(['auth:admin'])->group(function () {
    // Dashboard
    Route::get('/dashboard', function () {
        return view('backend.dashboard.index');
    })->name('dashboard');

    Route::get('/', function () {
        return redirect()->route('dashboard');
    });

    // Roles & Users
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::post('/user-status-update/{id}', [UserController::class, 'updateStatus'])->name('user_status_update');

    // Menu Categories & Menus
    Route::resource('menu-categories', MenuCategoryController::class);
    Route::post('/category-status-update/{id}', [MenuCategoryController::class, 'updateStatus'])->name('update_status_category');
    Route::resource('menus', MenuController::class);
    Route::post('/menu-status-update/{id}', [MenuController::class, 'updateStatus'])->name('menu_status');

    // Article Categories & Articles
    Route::resource('article-categories', ArticleCategoryController::class);
    Route::post('/article-category-status-update/{id}', [ArticleCategoryController::class, 'updateStatus'])->name('article_category_status');
    Route::resource('articles', ArticleController::class);
    Route::post('/article-status-update/{id}', [ArticleController::class, 'updateStatus'])->name('article_status');

    // Designations & Committee Members
    Route::resource('designations', DesignationController::class);
    Route::post('/designation-status-update/{id}', [DesignationController::class, 'updateStatus'])->name('designation_status');
    Route::resource('committee-members', CommitteeMemberController::class);
    Route::post('/member-status-update/{id}', [CommitteeMemberController::class, 'updateStatus'])->name('member_status');

    // Attachment Categories & Attachments
    Route::resource('attachment-categories', AttachmentCategoryController::class);
    Route::post('/attachment-status-update/{id}', [AttachmentCategoryController::class, 'updateStatus'])->name('attachment_status');
    Route::resource('attachments', AttachmentController::class);
    Route::post('/attachments-status-update/{id}', [AttachmentController::class, 'updateStatus'])->name('attachments_status');

    Route::resource('member-categories', MemberCategoryController::class);
    Route::post('/member-status-update/{id}', [MemberCategoryController::class, 'updateStatus'])->name('member_status');

    Route::get('/comments-list', [PublicOpinionController::class, 'index'])->name('comments.index');
    Route::get('/comments-view/{id}', [PublicOpinionController::class, 'show'])->name('comments.show');
    Route::delete('/comments-delete/{id}', [PublicOpinionController::class, 'destroy'])->name('comments.destroy');

    // setting route
    Route::get('/about-us', [SettingController::class, 'aboutUs'])->name('about.us');
    Route::post('/about-store', [SettingController::class, 'aboutUpdateOrCreate'])->name('about_store');
    Route::get('/contact', [SettingController::class, 'contact'])->name('contact_update');
    Route::post('/contact-store', [SettingController::class, 'contactUpdateOrCreate'])->name('contact_store');
    Route::post('/commission-store', [SettingController::class, 'activityUpdateOrCreate'])->name('commission_activity_store');
});

Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web']], function () {
     \UniSharp\LaravelFilemanager\Lfm::routes();
});

/*
|--------------------------------------------------------------------------
| File Manager Routes
|--------------------------------------------------------------------------
*/


/*
|--------------------------------------------------------------------------
| Extra Role Check Example
|--------------------------------------------------------------------------
*/
Route::middleware(['check.role:admin,manager'])->group(function () {
    Route::get('/admin/blank', function () {
        return view('backend.blank');
    });
});
