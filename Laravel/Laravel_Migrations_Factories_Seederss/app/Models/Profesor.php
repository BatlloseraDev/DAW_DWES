<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Profesor extends Model
{
    use HasFactory;
    protected $table = "profesores";

    public function partesPuestos(){
        return $this->hasMany(Parte::class, 'idprofesor', 'id');
    }
}
