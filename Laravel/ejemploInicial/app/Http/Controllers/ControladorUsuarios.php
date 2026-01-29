<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ControladorUsuarios extends Controller
{
    function getUser($id)
    {
        return response()->json([
            "función" => "Aceddiendo a getUser",
            "id" => $id
        ]);
    }

    function getUsers()
    {
        return response()->json([
            "función" => "Aceddiendo a getUser"
        ]);
    }

    function postUser(Request $request)
    {
        return response()->json([
            "función" => "Aceddiendo a postUser",
            "nombre" => $request->input("nombre"),
            "email" => $request->input("email")
        ]);
    }
}
