<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\V1\AuthController;
use App\Http\Controllers\V1\RoleController;
use App\Http\Controllers\V1\PermissionController;
use App\Http\Controllers\V1\CategoryController;
use App\Http\Controllers\V1\QuestionController;
use App\Http\Controllers\V1\AnswerController;
use App\Http\Controllers\V1\ExamController;
use App\Http\Controllers\V1\SocialiteController;

Route::prefix('v1')->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('/login', 'login');
        Route::post('/register', 'register');
    });

    Route::middleware([\Illuminate\Session\Middleware\StartSession::class])->controller(SocialiteController::class)->group(function () {
        Route::get('/auth/google/callback', 'callbackFromGoogle');

        Route::get('/auth/google', 'redirectToGoogle');
    });

    Route::group([
        "middleware" => ["auth:api"]
    ], function () {

        Route::controller(AuthController::class)->group(function () {
            Route::get('/profile', 'profile');
            Route::post('/logout',  'logout');
        });

        Route::prefix('/role')->controller(RoleController::class)->group(function () {
            Route::get('/', 'list');
            // Route::post('/', 'create');
            Route::post('/add-permissions/{id}', 'addPermission');
            Route::get('/{id}', 'detail');
            // Route::delete('/{id}', 'destroy');
        });

        Route::prefix('/permission')->controller(PermissionController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            // Route::post('/', 'create');
            // Route::delete('/{id}', 'destroy');
        });

        Route::prefix('/category')->controller(CategoryController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/by-user/{author_id}', 'listByAuthor');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

        Route::prefix('/question')->controller(QuestionController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

        Route::prefix('/answer')->controller(AnswerController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
            Route::delete('/{id}', 'destroy');
        });

        Route::prefix('/exam')->controller(ExamController::class)->group(function () {
            Route::get('/', 'list');
            Route::get('/{id}', 'detail');
            Route::post('/', 'create');
            Route::delete('/{id}', 'destroy');
        });

    });
});