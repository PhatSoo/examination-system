<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Permission;
use App\Observers\PermissionObserver;
use App\Models\Category;
use App\Observers\CategoryObserver;

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
        Permission::observe(PermissionObserver::class);
        Category::observe(CategoryObserver::class);
    }
}