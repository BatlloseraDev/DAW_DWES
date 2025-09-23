<?php


require_once('./animalAbstracto.php');
class Gato2 extends AnimalAbstracto{
    
      public function __construct($nombre, $raza, $peso, $color){
        parent::__construct($nombre, $raza, $peso, $color);
    }

    public function hacerRuido(){
        return parent::hacerRuido().'Miau';
    }
    public function hacerCaso(){
        return rand(0,100)<=5; 
    }

    public function vacunar(){

     }

    public function comer(){}

    public function dormir(){
        
    }
}