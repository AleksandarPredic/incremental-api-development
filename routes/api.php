<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// Protect all routes
/*Route::middleware('auth.basic.static')->prefix('v1')->group(function () {
    Route::resource('lessons', \App\Http\Controllers\LessonController::class);
});*/

Route::prefix('v1')->group(function () {
    Route::apiResource('lessons', \App\Http\Controllers\LessonController::class, ['except' => ['store']]);
    Route::get('lessons/{lesson}/tags', [\App\Http\Controllers\LessonController::class, 'showTags'])->name('lessons.show.tags');
    Route::apiResource('tags', \App\Http\Controllers\TagController::class, ['only' => ['index', 'show']]);
});

// Protect only one route
Route::middleware('auth.basic.static')->prefix('v1')->group(function () {
    Route::apiResource('lessons', \App\Http\Controllers\LessonController::class, ['only' => ['store']]);
});

