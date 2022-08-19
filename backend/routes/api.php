<?php

use App\Http\Controllers\Api\V1\GenreController;
use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
        // Genre API
        Route::get('genres', [GenreController::class, 'fetchGenreLists']);
        Route::apiResource('groups', GroupController::class);
        Route::apiResource('profiles', ProfileController::class);
    }
);
