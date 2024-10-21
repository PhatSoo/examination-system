<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

use App\Models\Permission;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $permissions = Permission::all()->pluck('description', 'name')->toArray();
        /*
            convert 'name' & 'description' to array with key value
            example: [name => description]
        */

        Passport::tokensCan($permissions);
    }
}