<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookmarkController;

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
        Route::post('bookmarks/create', [BookmarkController::class, 'createBookmark']);
        Route::get('bookmarks/fetch_group_bookmarks', [BookmarkController::class, 'fetchGroupBookmarks']);
        Route::get('bookmarks/fetch_group_user_bookmarks', [BookmarkController::class, 'fetchGroupUserBookmarks']);
        Route::get('bookmarks/show', [BookmarkController::class, 'showBookmark']);

        Route::apiResource('contacts', ContactController::class);
        Route::apiResource('favorites', FavoriteController::class);
        Route::apiResource('genres', GenreController::class);
        Route::apiResource('groups', GroupController::class);
        Route::apiResource('profiles', ProfileController::class);
    }
);
