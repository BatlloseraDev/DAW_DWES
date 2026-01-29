<?php

require_once("./DataBases/usuarioDAO.php");
require_once("./DataBases/conexionDB.php");
require_once("./Helper/sql_preparados.php");
require_once("./Model/usuario.php");
class UsuarioDAOImpl implements UsuarioDAO{

    //private $conexionDB = conexionDB();
    private $conexionDB;

    public function __construct() {
        $this->conexionDB = new ConexionDB();
    }

    public function get_Usuario_by_id($id){
        $this->conexionDB->conectar();
        $stmt =  $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_USUARIO_BY_ID);

        $stmt->bind_param("i",$id);
        $stmt->execute();

        $result = $stmt->get_result();

        $usuario = $result->fetch_assoc();

        $stmt->close();
        $this->conexionDB->desconectar();

        return $usuario;
    }

    public function get_Usuario_by_name($name){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_USUARIO_BY_NAME);
        $stmt->bind_param("s",$name);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        $stmt->close();
        $this->conexionDB->desconectar();
        return $usuarios;
    }

    public function update_Usuario_by_id($id,$usuario){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::UPDATE_USUARIO);

    
        $nombre= $usuario->getNom();
        $password= $usuario->getPass();
        $correo= $usuario->getCorreo();

        $stmt->bind_param("sssi",$nombre, $password, $correo, $id);

        $resultado = $stmt->execute();

        $stmt->close();
        $this->conexionDB->desconectar();

        return $resultado;
    }
    public function delete_Usuario_by_id($id){
        $this->conexionDB->conectar();

        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::DELETE_USUARIO);
        $stmt->bind_param("i",$id);
        $resultado = $stmt->execute();
        
        $stmt->close();
        $this->conexionDB->desconectar();

        return $resultado;

    }
    public function insert_Usuario($usuario){
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::INSERT_USUARIO);

        $nombre = $usuario->getNom();
        $password = $usuario->getPass();
        $correo = $usuario->getCorreo();

        mysqli_stmt_bind_param($stmt, 'sss', $nombre, $password, $correo);
        $resultado = $stmt->execute();

        $stmt->close();
        $this->conexionDB->desconectar();

        return $resultado;

    }

    public function get_all_Usuarios(){
    
        $this->conexionDB->conectar();
        $stmt = $this->conexionDB->getPreparedStatement(SQL_PREPARADOS::SELECT_ALL_USUARIOS);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $usuarios = [];
        while ($fila = $resultado->fetch_assoc()) {
            $usuarios[] = $fila;
        }

        $stmt->close();
        $this->conexionDB->desconectar();

        return $usuarios;
    }
}