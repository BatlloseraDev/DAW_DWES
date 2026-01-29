<?php

use App\Http\Controllers\controladorCrud;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');


/*
get -> listado user
get/dni -> un usuario
delete/dni -> borra
put/dni -> actualizar todos los campos
patch/dni -> actualizar un campo
post-> crear usuario

*/


Route::get('', [controladorCrud::class,'getUsers']);
Route::get('/{dni}', [controladorCrud::class,'getUser'])->whereAlphaNumeric('dni');
Route::post('/newUser',[controladorCrud::class,'createUser']);
Route::put('/{dni}',[controladorCrud::class,'updateUser'])->whereAlphaNumeric('dni');
Route::delete('/{dni}',[controladorCrud::class,'deleteUser'])->whereAlphaNumeric('dni');

