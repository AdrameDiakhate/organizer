<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\WorkspaceController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\ReactionController;
use Illuminate\Support\Facades\Route;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/verify-otp', [AuthController::class,'verifyOtp']);
Route::post('/send-otp', [AuthController::class,'sendOtp']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::resource('workspaces', WorkspaceController::class);
    Route::resource('tasks', TaskController::class);
    Route::resource('comments', CommentController::class);
    Route::resource('reactions', ReactionController::class);

    Route::post('tasks/{task}/comments', [CommentController::class, 'store']);
    Route::post('comments/{comment}/reactions', [ReactionController::class, 'store']);
});
