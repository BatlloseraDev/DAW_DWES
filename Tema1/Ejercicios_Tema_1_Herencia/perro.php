<?php

require_once('./animal.php');
class Perro extends Animal{
    
    public function __construct($nombre, $raza, $peso, $color){
        parent::__construct($nombre, $raza, $peso, $color);
    }


    public function hacerRuido(){
        return parent::hacerRuido().'Guau';
    }
    public function hacerCaso(){
        return rand(0,100)<=90; 
    }
}