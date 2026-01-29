<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MiControlador extends Controller
{
    function iniciarPartida(Request $request, $tam = 10, $moscas = 5)
    {

        $nombre = $request->get('nombre');
        $par = $request->get('partes');
        return response()->json(["Nombre"=>$nombre, "partes"=>$par],200);
        // if ($moscas >= $tam) {
        //     return response()->json(["Error"=>"El numero de moscas no puede ser mayor o igual al tamaño del tablero"], 400);
        // }

        // return response()->json(["Tamanio" => $tam, "Moscas" => $moscas], 201);
    }

    function getUser(Request $request, $id = 1){
        return response()->json(["datos"=> $id],200);
    }
}

