<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
//Añadimos el espacio de direcciones de los modelos.
use App\Models\Persona;
use App\Models\Propiedad;
use App\Models\Coche;
use App\Models\Comentario;

class MiControlador extends Controller
{
    public function verPersonas()
    {
        $pers = Persona::all();//mapeo

        return response()->json($pers, 200);
    }

    //------------------------------------------------------------------------
    public function buscarPersona($dni)
    {
        //Opción A.
        //$pers = Persona::where('dni', '=', $dni)->get();
        //Opción B.
        $pers = Persona::find($dni);//Persona::find([$dni,$dfg]);


        return response()->json($pers, 200);
    }

    //------------------------------------------------------------------------
    public function insertarPersona(Request $req)
    {


        $pe = new Persona;

        //Opción A)
        // $pe->dni = $req->get('dni');
        // $pe->nombre = $req->get('nombre');
        // $pe->tfno = $req->get('tfno');
        // $pe->edad = $req->get('edad');

        try {
            //Opción A)
            // $pe->save();
            //Opción B)
            $pe = $pe->create($req->all());
            return response()->json(['mens' => $pe], 200);
        } catch (\Exception $e) {
            $mensaje = 'Clave duplicada';
            return response()->json(['mens' => $mensaje], 404);
        }

    }

    //------------------------------------------------------------------------
    public function vermayores()
    {
        $pers = Persona::where('edad', '>', 18)
            ->orderBy('nombre', 'asc')
            ->get();

        return response()->json($pers, 200);
    }


    //------------------------------------------------------------------------
    public function insertarPropiedad(Request $req)
    {


        $pe = new Propiedad;

        try {
            $pe = $pe->create($req->all());
            return response()->json($pe, 200);
        } catch (\Exception $e) {
            $mensaje = 'Clave duplicada';
            return response()->json($pe, 404);
        }

    }


    //------------------------------------------------------------------------
    public function modificarPersona(Request $req, $dni)
    {
        $persona = Persona::find($dni);

        if ($persona) {
            $persona->update([
                'nombre' => $req->input('nombre'),
                'tfno' => $req->input('tfno'),
                'edad' => $req->input('edad')
            ]);

            return response()->json(['mensaje' => 'Persona modificada correctamente.'], 200);
        } else {
            return response()->json(['mensaje' => 'Persona no encontrada.'], 404);
        }
    }

    //------------------------------------------------------------------------
    public function borrarPersona($dni)
    {
        $persona = Persona::find($dni);

        if ($persona) {
            $persona->delete();
            return response()->json(['mensaje' => 'Persona eliminada correctamente.'], 200);
        } else {
            return response()->json(['mensaje' => 'Persona no encontrada.'], 404);
        }
    }


    //------------------------------------------------------------------------

    public function comentariosPersona($dni)
    {
        $pers = Persona::with('comentariosDe')->where('dni', '=', $dni)->get();

        return response()->json($pers, 200);
    }

    //------------------------------------------------------------------------
    public function mostrarComentarios()
    {
        $pers = Comentario::with('perteneceA')->get();

        return response()->json($pers, 200);
    }

    //------------------------------------------------------------------------
    public function cochesDe($dni)
    {
        try {
            // $info = Persona::with('coches')->where('dni',$dni)->get();
            // return response()->json($info,200);

            //Si solo queremos las matrículas de los coches de la persona
            $persona = Persona::findOrFail($dni); //Usamos findOrFail para lanzar excepción si no existe porque find devolvería null.
            $matriculas = $persona->coches()->get()->pluck('matricula');
            //$matriculas es Collection de strings
            return response()->json($matriculas, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las propiedades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //------------------------------------------------------------------------
    public function propietariosDe($matricula)
    {
        $info = Coche::with('propietarios')->where('matricula', $matricula)->get();
        //$info = Coche::find($matricula)->propietarios()->get();
        return response()->json($info, 200);
    }

    //------------------------------------------------------------------------
    public function todaspropiedades()
    {
        try {
            // Opción A)
            // $info = Propiedad::with(['infoCoche','infoPersona'])->get();

            // Opción B) - usando relaciones correctamente definidas
            $info = Propiedad::with(['coche', 'persona'])->get();

            return response()->json($info, 200);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al obtener las propiedades',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //------------------------------------------------------------------------
    // Attach: asociar uno o varios coches a la persona
    public function attachCoche(Request $request, $dni)
    {
        try {
            $persona = Persona::findOrFail($dni);

            $coches = $request->input('coches');

            if (empty($coches) || !is_array($coches)) {
                return response()->json([
                    'message' => 'Debe enviar un array de matrículas'
                ], 400);
            }

            // Asociar los coches a la persona
            $persona->coches()->attach($coches);

            return response()->json([
                'message' => 'Coches asociados correctamente',
                'coches' => $persona->coches()->get()->pluck('matricula')
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Persona no encontrada'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al asociar coches',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    //------------------------------------------------------------------------
    // Detach: eliminar la relación con uno o varios coches
    public function detachCoche(Request $request, $dni)
    {
        try {
            $persona = Persona::findOrFail($dni);

            $coches = $request->input('coches');

            if (empty($coches) || !is_array($coches)) {
                return response()->json([
                    'message' => 'Debe enviar un array de matrículas'
                ], 400);
            }

            // Desasociar los coches
            $persona->coches()->detach($coches);

            return response()->json([
                'message' => 'Coches desasociados correctamente',
                'coches' => $persona->coches()->get()->pluck('matricula')
            ], 200);

        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Persona no encontrada'
            ], 404);

        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Error al desasociar coches',
                'error' => $e->getMessage()
            ], 500);
        }
    }


}
