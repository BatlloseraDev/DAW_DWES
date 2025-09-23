<?php

require_once 'animalAbstracto.php';

class Elefante extends AnimalAbstracto {

    public function __construct($nombre, $raza, $peso, $color){
        parent::__construct($nombre, $raza, $peso, $color);
    }

    public function hacerRuido(){
        return '?';
    }

    public function comer() {
        //echo $this->nombre . " está comiendo cacahuetes.<br>";
    }

    public function dormir() {
        //echo $this->nombre . " está durmiendo de pie.<br>";
    }
    public function vacunar() {

    }
 
}
