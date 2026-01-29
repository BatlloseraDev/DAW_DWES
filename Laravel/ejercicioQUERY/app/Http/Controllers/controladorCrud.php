<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class controladorCrud extends Controller
{
    public function getUsers()
    {
        $personas = DB::table('personas')->get();
        $datos = [
            'personas' => $personas
        ];


        return response()->json($datos, 200);
    }

    public function getUser($dni = null)
    {
        $personas = DB::table('personas')
            ->select('dni', 'nombre', 'tfno', 'edad')
            ->where('dni', '=', $dni)
            ->get();

        $datos = [
            'persona' => $personas
        ];
        return response()->json($datos, 200);

    }

    public function createUser(Request $request)
    {
        try {

            $dni = $request->get('dni');
            $nombre = $request->get('nombre');
            $tfno = $request->get('tfno');
            $edad = $request->get('edad');

            $registro = DB::table('personas')->insert(
                ['dni' => $dni, 'nombre' => $nombre, 'tfno' => $tfno, 'edad' => $edad]
            );
            return response()->json(['mensaje' => 'El registro ha sido insertado', 'registro' => $registro], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['mensaje' => 'Error al insertar', 'error' => $e->getMessage()], 500);
        }


    }


    public function updateUser(Request $request, $dni = null)
    {
        try {

            $nombre = $request->get('nombre');
            $tfno = $request->get('tfno');
            $edad = $request->get('edad');

            $registro = DB::table('personas')->where('dni', '=', $dni)->update([
                'nombre' => $nombre,
                'tfno' => $tfno,
                'edad' => $edad
            ]);
            return response()->json(['mensaje' => 'El registro ha sido actualizado', 'registro' => $registro], 200);
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['mensaje' => 'Error al actualizar', 'error' => $e->getMessage()], 500);
        }
    }

    public function deleteUser($dni = null)
    {
        try {
            $registro = DB::table('personas')->where('dni', '=', $dni)->delete();
            if ($registro == 0) {
                return response()->json(['mensaje' => 'no se ha eliminado ningun registro'], 200);
            } else {
                return response()->json(['mensaje' => 'El registro ha sido borrado'], 200);

            }
        } catch (\Illuminate\Database\QueryException $e) {
            return response()->json(['mensaje' => 'Error al borrar', 'error' => $e->getMessage()], 500);
        }
    }
}
