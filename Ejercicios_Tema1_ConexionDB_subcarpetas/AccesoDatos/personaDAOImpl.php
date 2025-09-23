<?php

require_once(__DIR__."/personaDAO.php");
require_once(__DIR__."/../Utilidades/conexionDB.php");
require_once(__DIR__."/../Utilidades/sql_preparados.php");
require_once(__DIR__."/../Negocio/persona.php");
class PersonaDAOImpl implements PersonaDAO{

    //private $conexionDB = conexionDB();
    private $conexionDB;

    public function __construct() {
        $this->conexionDB = new ConexionDB();
    }

    public function get_Persona_by_id($id){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_PERSONA_BY_ID);
        
        mysqli_stmt_bind_param($stmt,'i',$id);
        mysqli_stmt_execute($stmt);
        
        $resultados = mysqli_stmt_get_result($stmt);
        
        $personas = [];
        while($fila = mysqli_fetch_array( $resultados )){
            $personas[] = Persona::Builder()
                ->setDni($fila['dni'])
                ->setNombre($fila['nombre'])
                ->setClave($fila['clave'])
                ->setTfno($fila['tfno'])
                ->build();
        }

        mysqli_stmt_close($stmt);
        $this->conexionDB->desconectar();

        return $personas;
    }
    public function update_Persona_by_id($id,$persona){
        return true;

    }
    public function delete_Persona_by_id($id){
        return true;

    }
    public function insert_Persona($persona){
        return true;
    
    }

    public function get_all_personas(){
        return false;
    }
}