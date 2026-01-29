<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PartesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(['message' => 'Lista de partes']);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json(['message' => 'Parte creado'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(['message' => "Parte con ID: $id"]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if ($request->isMethod('put')) {
            // PUT: reemplazo completo
            return response()->json(['message' => "Parte con ID: $id remplazado"]);
        }

        if ($request->isMethod('patch')) {
            // PATCH: actualización parcial
            return response()->json(['message' => "Parte con ID: $id actualizado parcialmente"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return response()->json(['message' => "Parte con ID: $id borrado"]);
    }
}
