<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use App\Models\Category;
use App\Observers\CategoryObserver;
use App\Models\Exam;
use App\Observers\ExamObserver;

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
        Category::observe(CategoryObserver::class);
        Exam::observe(ExamObserver::class);
    }
}