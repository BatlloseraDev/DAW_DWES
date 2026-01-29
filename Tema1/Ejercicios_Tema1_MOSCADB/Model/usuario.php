<?php

class Usuario implements JsonSerializable
{

    private $id;
    private $nombre;
    private $password;

    private $correo;



    public function __construct($id, $nombre, $password, $correo)
    {
        $this->id = $id;
        $this->nombre = $nombre;
        $this->password = $password;
        $this->correo = $correo;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->id,
            'nombre' => $this->nombre,
            'password' => $this->password,
            'correo'=> $this->correo
        ];
    }

    public function getId()
    {
        return $this->id;
    }

    public function getNom()
    {
        return $this->nombre;
    }

    public function getPass()
    {
        return $this->password;
    }
    public function getCorreo()
    {
        return $this->correo;
    }





    //builder

    public static function Builder()
    {
        return new BuilderUsuarios();
    }

}

class BuilderUsuarios
{
    private $id = 0;
    private $nombre;
    private $password;
    private $correo;

    //Getters y Setters
    public function getId()
    {
        return $this->id;
    }


    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }


    public function getNombre()
    {
        return $this->nombre;
    }


    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }


    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword($password)
    {
        $this->password = md5($password);

        return $this;
    }


    
    public function getCorreo()
    {
        return $this->correo;
    }

 
    public function setCorreo($correo)
    {
        $this->correo = $correo;

        return $this;
    }


    public function build()
    {
        return new Usuario($this->id, $this->nombre, $this->password, $this->correo);
    }



}