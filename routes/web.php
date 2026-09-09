<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TreesController;

// Plantar arbol
Route::get('/trees/create/{user_id}/{seed_id}', [TreesController::class, 'create']);

// Mostrar lista de arboles
Route::get('/trees/list', [TreesController::class, 'index']);

// Mostrar arbol por id
Route::get('/trees/{id}', [TreesController::class, 'show']);

