<?php 



class factoria{


    public function __call($metodo, $args){
    
        if($metodo=="crearBuscaminas"){

            $tamanio = 10;
            $bombas = 3;

            if(count($args)== 2){
                $tamanio = $args[0];
                $bombas = $args[1];
            }
            else if (count($args)== 1){
                $tamanio = $args[0];
            }

            $tableroInicial = array_fill(0, $tamanio, 0);
            $this->colocarBombas($tableroInicial,$bombas);
            $this->formatearCasillas($tableroInicial);
            return buscaMinas::Builder()->setTableroInic($tableroInicial)->Build();
        }
        else if($metodo== "crearTableroMosca"){
            $tamanio = 10;
            
            if(count($args)== 1){
                $tamanio = $args[0];
            }

            $tableroInicial = array_fill(0, $tamanio, 0);
            return TableroMosca::Builder()->setTableroInic($tableroInicial)->Build();
            
        }
    }


    private function colocarBombas(&$tableroIni,$bombas){
        $c = 0;
        $tamanio = count($tableroIni);
        while($bombas>$c){
            $numeroRandom = rand(0,$tamanio-1);
            $colocada = false;
            while(!$colocada){
                if($tableroIni[$numeroRandom]!=9){
                    $colocada = true;
                    $tableroIni[$numeroRandom]=9;
                }
                else{
                    $numeroRandom++;
                    if($numeroRandom>=$tamanio){
                        $numeroRandom=0;
                    }
                }
            }
            $c++;
        }
    }

    private function formatearCasillas(&$tableroIni){
        $tamanio = count($tableroIni);
        foreach($tableroIni as $key=>$value){
            if($value!=9){
                $minasAdyacentes = 0;
                if($key >0 && $tableroIni[$key-1]!=9){
                    $minasAdyacentes++;
                }
                if($key < $tamanio-1 && $tableroIni[$key+1]!= 9){
                    $minasAdyacentes++;
                }
                $tableroIni[$key]= $minasAdyacentes;
            }
        }
    }

}