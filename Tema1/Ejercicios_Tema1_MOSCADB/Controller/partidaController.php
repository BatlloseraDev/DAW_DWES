<?php

require_once("./DataBases/partidaDAOImpl.php");

class PartidasController
{
/**
 * Ha quedado por terminar de implementar por motivos de salud
 */
    private $partidaDAO;

    public function __construct()
    {
        $this->partidaDAO = new PartidaDAOImpl();
    }

    public function getPartidasAbiertas($usuario)
    {

        $tableros = $this->partidaDAO->getPartidasEmpezadas($usuario["id"]);
        if ($tableros == null) {
            header("HTTP/1.1 400");
            echo "el usuario no tiene partidas empezadas";
        } else {
            header("HTTP/1.1 200");
            print json_encode($tableros);
        }
    }


    public function getPartidaByID($id, $usuario)
    {
        $tableroDao = new PartidaDAOImpl();
        $tablero = $tableroDao->getPartida($id);
        if ($tablero == null) {
            header("HTTP/1.1 400");
            echo "el tablero no existe";
        } else {
            if ($tablero["creador"] != $usuario["id"]) {
                header("HTTP/1.1 400");
                echo "no eres el creador de la partida";
            } else {
                header("HTTP/1.1 200");
                print json_encode($tablero);
            }
        }
    }


    public function getHistoricoPartidas($usuario)
    {
        $tableroDao = new PartidaDAOImpl();
        $tableros = $tableroDao->getPartidas($usuario["id"]);

        //print_r($tableros);
        if (empty($tableros)) {
            header("HTTP/1.1 400");
            echo "el usuario aun no tiene partidas";
        } else {
            header("HTTP/1.1 200");
            print json_encode($tableros);
        }

    }

}
