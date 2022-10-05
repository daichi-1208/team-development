<?php

use App\Http\Controllers\Api\V1\GenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\BookmarkController;
use App\Http\Controllers\Api\V1\CommentController;
use App\Http\Controllers\Api\V1\GroupController;
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
        // Bookmark API
        Route::post('bookmarks/create', [BookmarkController::class, 'createBookmark']);
        Route::post('bookmarks/update', [BookmarkController::class, 'updateBookmark']);
        Route::post('bookmarks/delete', [BookmarkController::class, 'deleteBookmark']);
        Route::get('bookmarks/fetch_group_bookmarks', [BookmarkController::class, 'fetchGroupBookmarks']);
        Route::get('bookmarks/fetch_group_user_bookmarks', [BookmarkController::class, 'fetchGroupUserBookmarks']);
        Route::get('bookmarks/show', [BookmarkController::class, 'showBookmark']);

        Route::apiResource('contacts', ContactController::class);
        Route::apiResource('favorites', FavoriteController::class);

        // Genre API
        Route::get('genres', [GenreController::class, 'fetchGenreLists']);
        Route::apiResource('groups', GroupController::class);
        Route::apiResource('profiles', ProfileController::class);
        // Comment API
        Route::post('comments/create', [CommentController::class, 'createComment']);
        Route::post('comments/update', [CommentController::class, 'updateComment']);
        Route::post('comments/delete', [CommentController::class, 'deleteComment']);
        Route::get('comments/fetch_bookmark_comment', [CommentController::class, 'fetchBookmarkComments']);

        Route::apiResource('genres', GenreController::class);
        Route::apiResource('groups', GroupController::class)->only(['show', 'update', 'destroy']);
        Route::post('groups/inviteUser/{id}',[GroupController::class,'inviteUser']);
        Route::post('groups/joinGroup/{id}',[GroupController::class,'joinGroup']);
        Route::apiResource('group_manage', GroupManageController::class)->only(['index', 'store', 'update', 'destroy']);
        Route::apiResource('profiles', ProfileController::class);
        Route::get('profiles/show', [ProfileController::class, 'showProfile']);
        Route::post('profiles/create', [ProfileController::class, 'createProfile']);
        Route::post('profiles/update', [ProfileController::class, 'updateProfile']);
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

