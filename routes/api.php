<?php

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
Route::post('login', [\App\Http\Controllers\Api\Auth\LoginController::class, 'login'])->name('login');
Route::post('forgot/password', [\App\Http\Controllers\Api\Auth\LoginController::class, 'forgot'])->name('forgot');
Route::post('reset/password', [\App\Http\Controllers\Api\Auth\LoginController::class, 'reset'])->name('reset');

Route::middleware('auth:sanctum')->group(function () {
    Route::apiResources([
        'users' => \App\Http\Controllers\Api\UserController::class,
        'questions' => \App\Http\Controllers\Api\QuestionController::class,
        'answers' => \App\Http\Controllers\Api\AnswerController::class,
        'tags' => \App\Http\Controllers\Api\TagController::class,
    ]);

    Route::get('user', [\App\Http\Controllers\Api\UserController::class, 'user'])->name('user');
    Route::post('logout', [\App\Http\Controllers\Api\Auth\LoginController::class, 'logout'])->name('logout');
});
