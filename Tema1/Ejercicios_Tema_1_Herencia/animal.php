<?php

class Animal { 

    protected $nombre;
    protected $raza;
    protected $peso;
    protected $color;

    public function __construct($nombre, $raza, $peso, $color){
        $this->nombre = $nombre;
        $this->raza = $raza;
        $this->peso = $peso;
        $this->color = $color;
    }



    //vacunar, comer, dormir, hacerRuido, hacerCaso.


    public function vacunar(){

     }

    public function comer(){}

    public function dormir(){
        
    }

    public function hacerRuido(){
        return 'Hace ruido ';
    }

    public function hacerCaso(){

    }


}