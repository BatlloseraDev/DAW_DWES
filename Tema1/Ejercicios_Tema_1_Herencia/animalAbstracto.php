<?php

abstract class AnimalAbstracto { 

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


    abstract public function vacunar();

    abstract public function comer();

    abstract public function dormir();
    

    abstract public function hacerRuido();

    public function hacerCaso(){
        return 'El animal: '.$this->nombre.' hace caso';
    }

}