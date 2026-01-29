<?php

use App\Http\Controllers\CloudinaryController;
use App\Http\Controllers\ControladorLocal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('/subirlocal', [ControladorLocal::class,'subirImagenLocal']);
Route::post('/subircloud', [CloudinaryController::class,'subirImagenCloud']);
