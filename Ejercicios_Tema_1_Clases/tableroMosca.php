<?php 

class TableroMosca{

    private $tablero; 

    
    public function __construct(array $tableroInicial){
        $this->tablero = $tableroInicial;
    }
    
    public function colocarMosca(){
        $this->restablecerTablero();
        $this->tablero[rand(0, count($this->tablero) -1)] = 1; 
    }


    private function restablecerTablero(){
        $this->tablero = array_fill(0, count($this->tablero),0);

    }

    public function devolverIntento(int $n){

        $texto = "";
        $resultado = -1; 
        if(isset($this->tablero[$n]))   {
            $resultado = $this-> comprobarIntento($n);
        }
        switch($resultado){
            case 0:$texto= "No ha ocurrido nada";break;
            case 1:$texto= "Has asustado a la mosca";break;
            case 2:$texto= "Has matado a la mosca";break;
            default:$texto= "Ha ocurrido un error"; break;
        }
        return $texto;

    }

    
    private function comprobarIntento(int $n): int
    {   
        $resultado = 0;
        if ($this->hayMoscaEn($n)) {
            $resultado = 2;
        }

        //izquierda
        if ($n > 0 && $this->hayMoscaEn($n - 1)) {
            $resultado = 1;
        }
        //derecha
        if ($n < count($this->tablero) - 1 && $this->hayMoscaEn($n + 1)) {
            $resultado = 1;
        }

       
        return $resultado;
    }

    private function hayMoscaEn(int $n): bool {
        
        return  $this->tablero[$n] == 1;
    }




    #Getters
    public function getTablero()
    {
        return $this->tablero;
    }

    #Setters
    public function setTablero($tablero)
    {
        $this->tablero = $tablero;

        return $this;
    }


    public static function Builder(){
        return new BuilderTableroMosca();
    }

}


class BuilderTableroMosca{
    private $tamanio;


    public function setTamanio(int $tamanio)
    {
        $this->tamanio = $tamanio;

        return $this;
    }

    public function build()
    {
        
        $tableroInicial = array_fill(0, $this->tamanio, 0);
        return new TableroMosca($tableroInicial);
    }
}