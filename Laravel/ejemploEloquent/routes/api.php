<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MiControlador;


// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');

Route::get('verpersonas',[MiControlador::class, 'verPersonas']);
Route::get('buscarpersona/{dni}',[MiControlador::class, 'buscarPersona']);
Route::get('vermayores',[MiControlador::class, 'vermayores']);
Route::post('insertarPersona',[MiControlador::class, 'insertarPersona']);
Route::post('insertarPropiedad',[MiControlador::class, 'insertarPropiedad']);
Route::delete('borrarPersona/{dni}',[MiControlador::class, 'borrarPersona']);
Route::put('modificarPersona/{dni}',[MiControlador::class, 'modificarPersona']);

Route::get('comentariosPersona/{dni}',[MiControlador::class, 'comentariosPersona']);
Route::get('mostrarComentarios',[MiControlador::class, 'mostrarComentarios']);
Route::get('cochesDe/{dni}',[MiControlador::class, 'cochesDe']);
Route::get('propietariode/{matricula}',[MiControlador::class, 'propietariosDe']);
Route::get('todaspropiedades',[MiControlador::class, 'todaspropiedades']);
Route::post('attach/{dni}', [MiControlador::class, 'attachCoche']);
Route::post('detach/{dni}', [MiControlador::class, 'detachCoche']);
