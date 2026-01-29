<?php

require_once("./DataBases/rolDAO.php");
require_once("./DataBases/conexionDB.php");
require_once("./Helper/sql_preparados.php");
require_once("./Model/rol.php");




class RolDAOImpl implements RolDAO{
    
    private $conexionDB;
    
    public function __construct() {
        $this->conexionDB = new ConexionDB();
    }
    public function getRolByID($id){

    }
    public function updateRol($rol){

    }
    public function deleteRol($idRol){

    }
    public function insertRol($rol){

    }

    public function addRolToUser($idUsuario, $idRol){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::INSERT_ROL_TO_USER);

        $stmt->bind_Param("ii", $idUsuario, $idRol);
        $result= $stmt->execute();

        $stmt->close();
        $this->conexionDB->desconectar();

        return $result;
    }


    public function getRolByIDUsuario($idUsuario){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_ROL_BY_ID_USUARIO);

        $stmt->bind_param("i", $idUsuario);
        $stmt->execute();
        $result = $stmt->get_result();

        $roles= [];
        while($fila = $result->fetch_assoc()){
            $roles[] = $fila;
        }
        
        $stmt->close();
        $this->conexionDB->desconectar();

        return $roles;
    }

}