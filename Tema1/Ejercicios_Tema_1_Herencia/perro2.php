<?php

require_once('./animalAbstracto.php');
class Perro2 extends AnimalAbstracto{
    
    public function __construct($nombre, $raza, $peso, $color){
        parent::__construct($nombre, $raza, $peso, $color);
    }

    public function hacerRuido(){
        return parent::hacerRuido().'Guau';
    }
    public function hacerCaso(){
        return rand(0,100)<=90; 
    }

    public function comer() {

    }

    public function dormir() {

    }

    public function vacunar() {

    }
}