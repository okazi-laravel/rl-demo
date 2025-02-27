<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function() {
    Route::post('register', [\App\Http\Controllers\API\Auth\RegisterController::class, 'register']);
    Route::post('forgot-password', [\App\Http\Controllers\API\Auth\ForgotPasswordController::class, 'forgotPassword'])->name('password.forgot');
    Route::post('reset-password', [\App\Http\Controllers\API\Auth\ResetPasswordController::class, 'resetPassword'])->name('password.reset');
    Route::post('login', [\App\Http\Controllers\API\Auth\LoginController::class, 'login']);

    Route::get('/notifications/email', [\App\Http\Controllers\API\Notifications\EmailNotificationController::class, 'notify']);

    Route::middleware(['auth:sanctum'])->group( function () {
        Route::post('update-profile', [\App\Http\Controllers\API\Profile\ProfileController::class, 'update']);
        Route::post('change-password', [\App\Http\Controllers\API\Profile\ChangePasswordController::class, 'update']);
        Route::post('logout', [\App\Http\Controllers\API\Auth\LoginController::class, 'logout']);
        Route::get('samples/list', [\App\Http\Controllers\API\Samples\SampleController::class, 'list']);
        Route::get('samples/show-common-arr/{sample}', [\App\Http\Controllers\API\Samples\SampleController::class, 'showCommon']);
        Route::resource('samples', \App\Http\Controllers\API\Samples\SampleController::class);
        Route::resource('categories', \App\Http\Controllers\API\Blogs\CategoryController::class);
        Route::get('categories/{category:slug}', [\App\Http\Controllers\API\Blogs\CategoryController::class, 'show']);
        Route::resource('posts', \App\Http\Controllers\API\Blogs\PostController::class);
        Route::get('posts/{post:slug}', [\App\Http\Controllers\API\Blogs\PostController::class, 'show']);
        Route::post('posts/{post:slug}/comments', [\App\Http\Controllers\API\Blogs\CommentController::class, 'store']);
        Route::post('posts/{post:slug}/comments/reply', [\App\Http\Controllers\API\Blogs\CommentController::class, 'storeReply']);
    });

});

