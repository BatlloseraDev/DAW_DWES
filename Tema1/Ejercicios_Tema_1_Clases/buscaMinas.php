<?php

class buscaMinas{
    private $tablero;

    public function __construct(array $tablero){
        $this->tablero = $tablero;
    }


    public function __call($nombre, $args){
        if($nombre == "printTablero"){
            $cadenaTexto = "";
            if(count($args) == 0){
                foreach ($this->tablero as $key => $value){
                    $cadenaTexto .= "[_]";
                }
            }
            else if (count($args) == 1){
                foreach ($this->tablero as $key => $value){
                    $cadenaTexto .= "[";
                    if($args[0] == $key){
                        if($value == 9){
                            $cadenaTexto .= "*";
                        }
                        else{
                            $cadenaTexto .= "$value";
                        }
                    }else{
                        $cadenaTexto .= "_";
                    }
                    $cadenaTexto .= "]";

                }
            }
            return $cadenaTexto;
        }
    }


    public function getTablero()
    {
        return $this->tablero;
    }


    public function setTablero($tablero)
    {
        $this->tablero = $tablero;

        return $this;
    }





    public static function Builder(){
        return new BuilderBuscaMinas();
    }
}

class BuilderBuscaMinas{
    
    private $tableroInic;
    
    /*
    private $tamanio= 9;
    private $bombas=3;

 
    public function setTamanio($tamanio)
    {
        $this->tamanio = $tamanio;

        return $this;
    }

    public function setBombas($bombas)
    {
        $this->bombas = $bombas;

        return $this;
    }
    
    private function colocarBombas(&$tableroIni){
        $c = 0;
        while($this->bombas>$c){
            $numeroRandom = rand(0,$this->tamanio-1);
            $colocada = false;
            while(!$colocada){
                if($tableroIni[$numeroRandom]!=9){
                    $colocada = true;
                    $tableroIni[$numeroRandom]=9;
                }
                else{
                    $numeroRandom++;
                    if($numeroRandom>=$this->tamanio){
                        $numeroRandom=0;
                    }
                }
            }
            $c++;
        }
    }

    private function formatearCasillas(&$tableroIni){
        foreach($tableroIni as $key=>$value){
            if($value!=9){
                $minasAdyacentes = 0;
                if($key >0 && $tableroIni[$key-1]!=9){
                    $minasAdyacentes++;
                }
                if($key < $this->tamanio-1 && $tableroIni[$key+1]!= 9){
                    $minasAdyacentes++;
                }
                $tableroIni[$key]= $minasAdyacentes;
            }
        }
    }

    public function Build(){
        $tableroInicial = array_fill(0, $this->tamanio, 0);
        $this->colocarBombas($tableroInicial);
        $this->formatearCasillas($tableroInicial);
        return new buscaMinas($tableroInicial);
    }*/

    public function setTableroInic($tableroInic)
    {
        $this->tableroInic = $tableroInic;

        return $this;
    }

    public function Build()
    {
        return new buscaMinas($this->tableroInic);
    }
}
