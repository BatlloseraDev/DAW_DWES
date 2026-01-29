<?php


class SQL_PREPARADOS
{

    //Usuario
    public const SELECT_USUARIO_BY_ID = "SELECT * FROM usuario WHERE id = ?";
    
    public const SELECT_USUARIO_BY_NAME = "SELECT * FROM usuario WHERE usuario = ?";
    public const SELECT_ALL_USUARIOS = "SELECT * FROM usuario";

    public const INSERT_USUARIO = "INSERT INTO usuario ( usuario, password, correo) VALUES (?,?,?)";

    public const UPDATE_USUARIO = "UPDATE usuario SET usuario = ?, password = ?, correo = ? WHERE id = ?";


    public const DELETE_USUARIO = "DELETE FROM usuario WHERE id = ?";





    //Rol-usuario
    public const SELECT_ROL_BY_ID_USUARIO = "SELECT r.nombre FROM rol r JOIN usuario_rol ur ON r.id = ur.rol WHERE ur.usuario = ?";
    public const INSERT_ROL_TO_USER = "INSERT INTO usuario_rol (usuario, rol) VALUES (?,?)";
    
    

    //Partida

    public const SELECT_PARTIDA_BY_ID = "SELECT * FROM tablero WHERE id = ?";
    public const SELECT_PARTIDAS_BY_ID_USUARIO = "SELECT * FROM tablero WHERE creador = ?";

    public const SELECT_PARTIDAS_EMPEZADAS_BY_ID_USUARIO = "SELECT * FROM tablero WHERE creador = ? AND finalizada = 0";
    public const SELECT_ALL_PARTIDAS = "SELECT * FROM tablero";
    public const INSERT_PARTIDA= "INSERT INTO tablero (cadena, finalizada, creador) VALUES (?,?,?)";
    public const UPDATE_PARTIDA_BY_ID= "UPDATE tablero SET cadena = ?, finalizada = ? WHERE id = ?";

    public const DELETE_PARTIDA_BY_ID = "DELETE FROM tablero WHERE id = ?";
    

}