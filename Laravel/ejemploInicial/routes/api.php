<?php

use App\Http\Controllers\MiControlador;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ControladorUsuarios;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

// Route::get("/user/{id?}", [MiControlador::class, 'getUser'] )->whereNumber('id');

// Route::post('/iniciar/{tam?}/{moscas?}', [MiControlador::class ,'iniciarPartida']);

Route::get('users', [ControladorUsuarios::class, 'getUsers'])->middleware('mid1', 'mid2');
Route::get('user/{id}', [ControladorUsuarios::class, 'getUser'])->middleware('mid1')->whereNumber('id');
Route::post('user', [ControladorUsuarios::class, 'postUser'])->middleware('mid1');

// Route::prefix('admin') //todas las rutas tendrán /admin
//     ->middleware(['mid1', 'mid2']) //todos estos middleware aplican
//     ->group(function () {
//         Route::get('/user/{id}', [ControladorUsuarios::class, 'getUser']);
//         Route::post('user', [ControladorUsuarios::class, 'postUser']);
//     });
