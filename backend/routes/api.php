<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\UserController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\QuestionController;
use App\Http\Controllers\V1\AnswerController;
use App\Http\Controllers\V1\ExamController;

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
            Route::get('/', 'list');
            Route::post('/', 'create');
            Route::post('/add-permissions/{id}', 'addPermission');
            Route::get('/{id}', 'detail');
        });

        Route::prefix('/permission')->controller(PermissionController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
        });

        Route::prefix('/category')->controller(CategoryController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
        });

        Route::prefix('/question')->controller(QuestionController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
        });

        Route::prefix('/answer')->controller(AnswerController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
        });

        Route::prefix('/exam')->controller(ExamController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
        });

    });
});