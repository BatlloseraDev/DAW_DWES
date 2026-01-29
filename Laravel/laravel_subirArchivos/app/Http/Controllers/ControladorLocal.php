<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ControladorLocal extends Controller
{
     public function subirImagenLocal(Request $request){
        $messages = [
            'max' => 'El campo se excede del tamaño máximo',
            'required' => 'Falta el archivo',
            'mimes' => 'Tipo no soportado'
        ];

        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ], $messages);

        if ($validator->fails()){
            return response()->json($validator->errors(),202);
        }

        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $file = $request->file('image');
            $filename = uniqid('img_') . $file->getClientOriginalName();
            $path = $file->storeAs('perfiles', $filename, 'public');
            //$url = Storage::disk('local')->url($path);
            //Generamos la URL completa accesible por el cliente. Con esta url la imagen es accesible.
            $url = asset("storage/perfiles/$filename");



            return response()->json(['path' => $path, 'url' => $url], 200);
        }
        return response()->json(['error' => 'No se recibió ningún archivo.'], 400);

    }
}
