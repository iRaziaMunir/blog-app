<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\VideoController;

Route::controller(AuthController::class)->group(function () {

    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');
    Route::get('profile', 'profile');

});

Route::middleware('auth:api')->group(function() {

    Route::controller(PostController::class)->group(function () {

        Route::post('/create-post', 'createPost');
    });

    Route::controller(ImageController::class)->group(function () {

        Route::post('/post-image', 'postImage');
    });

    Route::controller(VideoController::class)->group(function () {

        Route::post('/post-video', 'postVideo');
    });

    Route::controller(CommentController::class)->group(function () {

        Route::post('/post-comment', 'postComment');
        Route::put('/comments/{comment}',  'editComment');
        Route::delete('/comments/{comment}',  'deleteComment');
    });


});

Route::controller(CommentController::class)->group(function () {

    Route::get('/comments/count/{commentable_type}/{commentable_id}', 'getTotalCommentsFor');
    Route::get('/comments/{commentable_type}/{commentable_id}', 'getCommentsFor');
});
