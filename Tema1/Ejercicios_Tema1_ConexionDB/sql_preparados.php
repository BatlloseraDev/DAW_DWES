<?php 


class SQL_PREPARADOS{

    //Persona
    public const SELECT_PERSONA_BY_DNI = "SELECT * FROM personas WHERE dni = ?";
    public const SELECT_ALL_PERSONA = "SELECT * FROM personas";

    public const INSERT_PERSONA = "INSERT INTO personas (dni, nombre, clave, tfno) VALUES (?,?,?,?)";

    public const UPDATE_PERSONA = "UPDATE personas SET nombre = ?, clave = ? ,tfno = ? WHERE dni = ?";


    public const DELETE_PERSONA = "DELETE FROM personas WHERE dni = ?";
    
}