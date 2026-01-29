<?php


require_once("./DataBases/partidaDAO.php");
require_once("./DataBases/conexionDB.php");
require_once("./Helper/sql_preparados.php");
require_once("./Model/partida.php");

class PartidaDAOImpl implements PartidaDAO{
    private $db;
    public function __construct(){
        $this->db = new ConexionDB();
    }
    public function getPartida($id){
        $this->db->conectar();
        $stmt = $this->db->getPreparedStatement(SQL_PREPARADOS::SELECT_PARTIDA_BY_ID);
        $stmt->bind_param("i",$id);
        $stmt->execute();
        $resultado = $stmt->get_result();
        $partida = $resultado->fetch_assoc();
        $stmt->close();
        $this->db->desconectar();
        return $partida;
    }
    public function getPartidas($idUsuario){
        $this->db->conectar();
        $stmt= $this->db->getPreparedStatement(SQL_PREPARADOS::SELECT_PARTIDAS_BY_ID_USUARIO);
        $stmt->bind_Param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $partidas=[];
        while($fila = $resultado->fetch_assoc()){
            $partidas[]= $fila;
        }
        $stmt->close();
        $this->db->desconectar();

        return $partidas;
    }

    public function getPartidasEmpezadas($idUsuario){
        $this->db->conectar();
        $stmt= $this->db->getPreparedStatement(SQL_PREPARADOS::SELECT_PARTIDAS_EMPEZADAS_BY_ID_USUARIO);
        $stmt->bind_Param("i", $idUsuario);
        $stmt->execute();
        $resultado = $stmt->get_result();

        $partidas=[];
        while($fila = $resultado->fetch_assoc()){
            $partidas[]= $fila;
        }
        $stmt->close();
        $this->db->desconectar();

        return $partidas;
    }

    public function updatePartida($partida){
        $this->db->conectar();
        $stmt= $this->db->getPreparedStatement(SQL_PREPARADOS::UPDATE_PARTIDA_BY_ID);
        $id = $partida->getId();
        $cadena= $partida->getCadena();
        $finalizada= $partida->getFinalizada();
        $stmt->bind_Param("sbi", $cadena, $finalizada, $id);
        $resultado = $stmt->execute();

        $stmt->close();
        $this->db->desconectar();

        return $resultado;
    }
    public function deletePartida($id){

    }
    public function insertPartida($partida){
        $this->db->conectar();
        $stmt = $this->db->getPreparedStatement(SQL_PREPARADOS::INSERT_PARTIDA);

        $cadena = $partida->getCadena();
        $finalizada = $partida->getFinalizada();
        $creador = $partida->getCreadorId();

        $stmt->bind_Param("sbi", $cadena,$finalizada, $creador );
        $resultado = $stmt->execute();

        $stmt->close();
        $this->db->desconectar();

        return $resultado;
    }
}
