<?php

use App\Http\Controllers\Api\ActivityController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ArticleController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\StoryController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Support\Facades\Route;
use NormanHuth\HelpersLaravel\App\Http\Middleware\SanctumOrGuest;

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

Route::post('auth', [AuthController::class, 'getToken'])->name('auth');
Route::middleware(SanctumOrGuest::class)->group(function () {
    Route::get('/', function () {
        return [
            'message' => 'It work’s!',
            'authenticated' => auth()->check(),
            'time' => now(),
        ];
    });

    /* Article Routes */
    Route::post('articles/{article}/restore', [ArticleController::class, 'restore'])
        ->name('articles.restore');
    Route::delete('articles/{article}/force-delete', [ArticleController::class, 'forceDelete'])
        ->name('articles.force-delete');
    Route::post('articles/{article}/attach-tags', [ArticleController::class, 'attachSpatieTags'])
        ->name('articles.attach-tags');
    Route::post('articles/{article}/detach-tags', [ArticleController::class, 'detachSpatieTags'])
        ->name('articles.detach-tags');
    Route::post('articles/{article}/sync-tags', [ArticleController::class, 'syncSpatieTags'])
        ->name('articles.sync-tags');
    Route::resource('articles', ArticleController::class)->except(['create', 'edit']);
    // Comments
    Route::put('articles/{article}/morph/{relation}', [ArticleController::class, 'morph'])
        ->name('articles.morph')->where('relation', 'comments');


    /* Story Routes */
    Route::post('stories/{story}/attach-tags', [StoryController::class, 'attachSpatieTags'])
        ->name('stories.attach-tags');
    Route::post('stories/{story}/detach-tags', [StoryController::class, 'detachSpatieTags'])
        ->name('stories.detach-tags');
    Route::post('stories/{story}/sync-tags', [StoryController::class, 'syncSpatieTags'])
        ->name('stories.sync-tags');
    Route::resource('stories', StoryController::class)->except(['create', 'edit']);
    // Comments
    Route::put('stories/{story}/morph/{relation}', [StoryController::class, 'morph'])
        ->name('stories.morph')->where('relation', 'comments');

    /* Comment Routes */
    Route::post('comments/{comment}/restore', [CommentController::class, 'restore'])
        ->name('comments.restore');
    Route::delete('comments/{comment}/force-delete', [CommentController::class, 'forceDelete'])
        ->name('comments.force-delete');
    Route::resource('comments', CommentController::class)->except(['create', 'edit', 'store']);

    /* Activity Routes */
    Route::resource('activities', ActivityController::class)->only(['index', 'show']);
});

/* User Routes */
Route::resource('users', UserController::class)->only(['index', 'show'])->middleware('auth:sanctum');
