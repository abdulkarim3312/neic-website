<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\MenuCategory;

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
            $menuCategories = MenuCategory::with('menus')
                                ->where('status', 1)
                                ->orderBy('id')
                                ->get();
            $view->with('menuCategories', $menuCategories);
        });
    }
}
