<?php

class Persona{
   private $dni;
   private $nombre;
   private $clave;
   private $tfno;



   public function __construct($dni, $nombre, $clave, $tfno){
        $this->dni = $dni;
        $this->nombre = $nombre;
        $this->clave = $clave;
        $this->tfno = $tfno;
   }


    //builder
   
    public static function Builder(){
        return new BuilderPersonas();
    }

}

class BuilderPersonas{
    private $dni=null;
    private $nombre= null;
    private $clave= null;
    private $tfno= null;

    //Getters y Setters
    public function getDni()
    {
        return $this->dni;
    }


    public function setDni($dni)
    {
        $this->dni = $dni;

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


    public function getClave()
    {
        return $this->clave;
    }

    public function setClave($clave)
    {
        $this->clave = $clave;

        return $this;
    }
 
    public function getTfno()
    {
        return $this->tfno;
    }

    public function setTfno($tfno)
    {
        $this->tfno = $tfno;

        return $this;
    }

    public function build(){
        return new Persona($this->dni, $this->nombre, $this->clave, $this->tfno);
    }

}