<?php 



class factoria{


    public function __call($metodo, $args){
    
        if($metodo== "crearTableroMosca"){
            $tamanio = 10;
            
            if(count($args)== 1){
                $tamanio = $args[0];
            }

            $tableroInicial = array_fill(0, $tamanio, 0);
            return TableroMosca::Builder()->setTableroInic($tableroInicial)->Build();
            
        }
    }

    public static function convertirTableroaString($tablero){
        $cadenafinal= "";

        foreach($tablero as $value){
            $cadenafinal.=$value."/";
        }
        $cadenafinal= substr($cadenafinal,0,-1);
        return $cadenafinal;
    }

    public static function convertirStringaTablero($cadena){
        $cadenafinal= explode ("/", $cadena);
        return $cadenafinal;
    }



}