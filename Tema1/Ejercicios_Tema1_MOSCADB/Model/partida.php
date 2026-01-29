<?php

class Partida implements JsonSerializable{
    private $id;
    private $cadena;
    private $finalizada;
    private $creadorId;


    function __construct($id, $cadena, $finalizada, $creadorId){
        $this->id = $id;
        $this->cadena = $cadena;
        $this->finalizada = $finalizada;
        $this->creadorId = $creadorId;
    }

    public function jsonSerialize(){
        return[
            "id"=> $this->id,
            "cadena"=> $this->cadena,
            "finalizada"=> $this->finalizada,
            "creadorId"=> $this->creadorId
        ];
    }

    public function getId(){
        return $this->id;
    }

    public function getCadena(){
        return $this->cadena;
    }

    public function getFinalizada(){
        return $this->finalizada;
    }

    public function getCreadorId(){
        return $this->creadorId;
    }

    public static function Builder(){
        return new BuilderPartida();
    }
}

class BuilderPartida{
    private $id= 0;
    private $cadena;
    private $finalizada= false;
    private $creadorId;

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function setCadena($cadena){
        $this->cadena = $cadena;
        return $this;
    }

    public function setFinalizada($finalizada){
        $this->finalizada = $finalizada;
        return $this;
    }

    public function setCreadorId($creadorId){
        $this->creadorId = $creadorId;
        return $this;
    }

    public function build(){
        return new Partida($this->id, $this->cadena, $this->finalizada, $this->creadorId);
    }

}