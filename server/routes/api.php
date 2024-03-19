<?php

use App\Http\Controllers\Client\Auth\LoginController;
use App\Http\Controllers\Client\Auth\RegisterController;
use App\Http\Controllers\Client\Me\MeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileManagerController;

// admin controllers
use App\Http\Controllers\Admin\Auth\RegisterController as AdminRegisterController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\Me\MeController as AdminMeController;


Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('register', [RegisterController::class, 'register']);
    Route::post('verify', [RegisterController::class, 'verify']);

    Route::group([
        'middleware' => 'api'
    ], function () {
        Route::post('login', [LoginController::class, 'login']);
        Route::post('logout', [LoginController::class, 'logout']);
        Route::post('refresh', [LoginController::class, 'refresh']);

        Route::group([
            'prefix' => 'me'
        ], function () {
            Route::post('/', [LoginController::class, 'me']);
            Route::get('/profile', [MeController::class, 'profile']);
        });
    });

});

Route::group([
    'middleware' => 'api'
], function () {
    Route::group([
        'prefix' => 'teams'
    ], function () {
        Route::get('', [\App\Http\Controllers\TeamController::class, 'list']);
        Route::get('{id}', [\App\Http\Controllers\TeamController::class, 'detail'])->where('id', '[0-9]+');
        Route::post('', [\App\Http\Controllers\TeamController::class, 'save']);
        Route::post('{id}', [\App\Http\Controllers\TeamController::class, 'save'])->where('id', '[0-9]+');
        Route::delete('{id}', [\App\Http\Controllers\TeamController::class, 'delete'])->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'groups'
    ], function () {
        Route::get('', [\App\Http\Controllers\GroupController::class, 'list']);
        Route::get('{id}', [\App\Http\Controllers\GroupController::class, 'detail'])->where('id', '[0-9]+');
        Route::post('', [\App\Http\Controllers\GroupController::class, 'save']);
        Route::post('{id}', [\App\Http\Controllers\GroupController::class, 'save'])->where('id', '[0-9]+');
        Route::delete('{id}', [\App\Http\Controllers\GroupController::class, 'delete'])->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'games'
    ], function () {
        Route::get('', [\App\Http\Controllers\GameController::class, 'list']);
        Route::get('{id}', [\App\Http\Controllers\GameController::class, 'detail'])->where('id', '[0-9]+');
        Route::post('', [\App\Http\Controllers\GameController::class, 'save']);
        Route::post('{id}', [\App\Http\Controllers\GameController::class, 'save'])->where('id', '[0-9]+');
        Route::delete('{id}', [\App\Http\Controllers\GameController::class, 'delete'])->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'tips'
    ], function () {
        Route::get('', [\App\Http\Controllers\TipController::class, 'list']);
        Route::get('{id}', [\App\Http\Controllers\TipController::class, 'detail'])->where('id', '[0-9]+');
        Route::post('', [\App\Http\Controllers\TipController::class, 'save']);
        Route::post('{id}', [\App\Http\Controllers\TipController::class, 'save'])->where('id', '[0-9]+');
        Route::delete('{id}', [\App\Http\Controllers\TipController::class, 'delete'])->where('id', '[0-9]+');
    });

    Route::group([
        'prefix' => 'users',
    ], function () {
        Route::get('', [\App\Http\Controllers\Admin\UserController::class, 'list']);
    });
});

Route::group([
    'prefix' => 'users',
    'middleware' => 'api'
], function () {
    Route::get('', [\App\Http\Controllers\Admin\UserController::class, 'list']);
});

Route::group([
    'prefix' => 'files',
    'middleware' => 'api'
], function () {
    Route::post('image', [FileManagerController::class, 'uploadImage']);
});
