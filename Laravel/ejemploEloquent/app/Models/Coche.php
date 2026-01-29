<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coche extends Model
{
    //protected $table = 'coches'; //Por defecto tomaría la tabla 'coches'.
    protected $primaryKey = 'matricula';  //Por defecto el campo clave es 'id', entero y autonumérico.
    public $incrementing = false; //Para indicarle que la clave no es autoincremental.
    protected $keyType = 'string';   //Indicamos que la clave no es entera.
    public $timestamps = false;   //Con esto Eloquent no maneja automáticamente created_at ni updated_at.
    // protected $hidden = [ 'pivot'];

    public function propietarios()
    {
        return $this->belongsToMany(
            Persona::class,     // Modelo relacionado
            'propiedades',      // Tabla pivote
            'matricula',        // Clave foránea local (en pivot)
            'dni'               // Clave foránea del otro modelo (en pivot)
        );
    }
}
