<?php


class Rol implements JsonSerializable{
    private $id;
    private $name;



    function __construct($id, $name){
        $this->id = $id;
        $this->name = $name;
    }

    function jsonSerialize(){
        return [
            "id"=> $this->id,
            "name"=> $this->name
        ];
    }


    public function getId(){
        return $this->id;
    }

    public function getName(){
        return $this->name;
    }

       public static function Builder()
    {
        return new BuilderRol();
    }
}

class BuilderRol{
    private $id;
    private $name;

    public function setId($id){
        $this->id = $id;
        return $this;
    }

    public function setName($name){
        $this->name = $name;
        return $this;
    }

    public function build(){
        return new Rol($this->id, $this->name);
    }
}
