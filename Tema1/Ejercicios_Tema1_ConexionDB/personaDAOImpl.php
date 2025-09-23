<?php

require_once("./personaDAO.php");
require_once("./conexionDB.php");
require_once("./sql_preparados.php");
require_once("./persona.php");
class PersonaDAOImpl implements PersonaDAO{

    //private $conexionDB = conexionDB();
    private $conexionDB;

    public function __construct() {
        $this->conexionDB = new ConexionDB();
    }

    public function get_Persona_by_dni($dni){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_PERSONA_BY_DNI);
        
        mysqli_stmt_bind_param($stmt,'s',$dni);
        mysqli_stmt_execute($stmt);
        
        $resultados = mysqli_stmt_get_result($stmt);
        
        $personas = [];
        while($fila = mysqli_fetch_array( $resultados )){
            $personas[] = //new Persona($fila['dni'],$fila['nombre'],$fila['clave'],$fila['tfno']);     
            Persona::Builder()
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
    public function update_Persona_by_id($dni,$persona){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::UPDATE_PERSONA);
        $nombre = $persona->getNombre();
        $clave = $persona->getClave();
        $tfno = $persona->getTfno();
        mysqli_stmt_bind_param($stmt, 'siss', $nombre, $clave, $tfno , $dni);
        $resultado= mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        $this->conexionDB->desconectar();

        return $resultado;

    }
    public function delete_Persona_by_id($dni){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::DELETE_PERSONA);

        mysqli_stmt_bind_param($stmt, 's', $dni,);
        $resultado= mysqli_stmt_execute($stmt);

        mysqli_stmt_close($stmt);
        $this->conexionDB->desconectar();

        return $resultado;

    }
    public function insert_Persona($persona){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::INSERT_PERSONA);

        $dni = $persona->getDni();
        $nombre = $persona->getNombre();
        $clave = $persona->getClave();
        $tfno = $persona->getTfno();

        mysqli_stmt_bind_param($stmt, 'ssis', $dni, $nombre, $clave, $tfno);
        //mysqli_stmt_bind_param($stmt, 'ssis',$persona->getDni(), $persona->getNombre(), $persona->getClave(), $persona->getTfno());
        $resultado= mysqli_stmt_execute($stmt);


        mysqli_stmt_close($stmt);
        $this->conexionDB->desconectar();

        return $resultado;
    }

    public function get_all_personas(){
    
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_ALL_PERSONA);
        mysqli_stmt_execute($stmt);
        $resultados = mysqli_stmt_get_result($stmt);

       
        $personas = [];
        while($fila = mysqli_fetch_array( $resultados )){
            $personas[] = //new Persona($fila['dni'],$fila['nombre'],$fila['clave'],$fila['tfno']);     
            Persona::Builder()
                ->setDni($fila['dni'])
                ->setNombre($fila['nombre'])
                ->setClave($fila['clave'])
                ->setTfno($fila['tfno'])
                ->build();
        }    


        mysqli_stmt_close($stmt);
        $this->conexionDB->desconectar();
        print_r($personas);
        return $personas;
    }
}