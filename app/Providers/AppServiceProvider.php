<?php

namespace App\Providers;

use App\Models\MenuCategory;
use App\Models\MemberCategory;
use App\Models\CommitteeMemberInfo;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::composer('*', function ($view) {
            $view->with('members', CommitteeMemberInfo::where('status', 1)->get());
            $view->with('memberCategories', MemberCategory::where('status', 1)->get());
        });
    }
}
