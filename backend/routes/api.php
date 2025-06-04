<?php

use App\Http\Controllers\PostController;

Route::get('/posts', [PostController::class, 'index']);
Route::get('/posts/search', [PostController::class, 'search']);
Route::post('/posts/sync', [PostController::class, 'sync']); 