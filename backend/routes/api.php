<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\ProfileController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group(
    [
        'namespace' => '\App\Http\Controllers\Api'
    ],
    function () {
        Route::post('register', 'AuthController@register');
        Route::post('login', 'AuthController@login');
        Route::post('logout', 'AuthController@logout')->middleware('auth:sanctum');

        // パスワード忘れ
        Route::post('forgot_password', 'AuthController@forgot_password');
        Route::post('reset_password', 'AuthController@reset_password');
    }
);


Route::group(
    [
        'prefix' => 'v1',
        'namespace' => '\App\Http\Controllers\Api\V1',
        'middleware' => 'auth:sanctum'
    ],
    function () {
        Route::apiResource('bookmarks', BookmarkController::class);
        Route::apiResource('contacts', ContactController::class);
        Route::apiResource('favorites', FavoriteController::class);
        Route::apiResource('genres', GenreController::class);
        Route::apiResource('groups', GroupController::class);
        Route::post('profiles/create', [ProfileController::class, 'createProfile']);
        Route::post('profiles/update', [ProfileController::class, 'updateProfile']);
        Route::get('profiles/show', [profileController::class, 'showProfile']);
    }
);

Route::group(
    [
        'prefix' => 'v1',
        'namespace' => '\App\Http\Controllers\Api\V1'
    ],
    function () {
        Route::apiResource('information', InformationController::class)->only(['index', 'show']);
    }
);

