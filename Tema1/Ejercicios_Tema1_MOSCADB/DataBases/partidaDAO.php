<?php


interface PartidaDAO{
    public function getPartida($id);
    public function getPartidas($idUsuario);
    public function getPartidasEmpezadas($idUsuario);
    public function updatePartida($partida);
    public function deletePartida($id);
    public function insertPartida($partida);
}