<?php

interface RolDAO{
    public function getRolByIDUsuario($idUsuario);
    
    public function getRolByID($id);
    public function updateRol($rol);
    public function deleteRol($idRol);
    public function insertRol($rol);
    public function addRolToUser($idUsuario, $idRol);

}