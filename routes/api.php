<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Note\NoteController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
*/

// Route::resource('notes', NoteController::class)->middleware('auth:api');

// OR custom middleware my created (JwtMiddleware) to custom massage
Route::resource('notes', NoteController::class)->middleware('jwt.verify');

Route::group(['middleware' => 'api', 'prefix' => 'auth'], function () {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});