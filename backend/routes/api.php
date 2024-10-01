<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\PermissionController;

Route::prefix('v1')->group(function () {
    Route::controller(UserController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::group([
        "middleware" => ["auth:api"]
    ], function () {

        Route::controller(UserController::class)->group(function () {
            Route::get('/profile', 'profile');
            Route::post('/logout',  'logout');
        });


        Route::prefix('/role')->controller(RoleController::class)->group(function () {
            Route::get('/', 'listAll');
            Route::post('/', 'create');
            Route::post('/add-permissions/{id}', 'addPermission');
            Route::get('/{id}', 'detail');
        });

        Route::prefix('/permission')->controller(PermissionController::class)->group(function () {
            Route::get('/', 'listAll');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
        });

    });
});