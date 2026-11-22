<?php

use App\Http\Controllers\MediaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::apiResource('media', MediaController::class)->parameters([
    'media' => 'media',
]);

Route::get('users', [UserController::class, 'index']);
Route::get('users/{user}', [UserController::class, 'show']);
Route::post('users/{user}/media', [UserController::class, 'addMedia']);
Route::delete('users/{user}/media/{mediaId}', [UserController::class, 'removeMedia']);
