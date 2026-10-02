<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreesController;
use App\Http\Controllers\AuthController;


// Anyone can register or log in; throttle:5,1 caps abuse at 5 attempts per minute per IP.
Route::post('register', [AuthController::class, 'register']) ->middleware('throttle:5,1')->name('register');

Route::post('login', [AuthController::class, 'login'])->middleware('throttle:5,1')->name('login');

Route::middleware('auth:sanctum')->group(function (): void {
            Route::post('logout', [AuthController::class, 'logout'])->name('logout');
            Route::get('user', [AuthController::class, 'me'])->name('user');

            Route::get('/trees', [TreesController::class, 'index']);
            Route::get('/trees/{id}', [TreesController::class, 'show']);
            Route::post('/trees/{seed_id}', [TreesController::class, 'create']);
            });

