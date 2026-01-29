<?php

use App\Http\Controllers\PartesController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('partes', PartesController::class);
