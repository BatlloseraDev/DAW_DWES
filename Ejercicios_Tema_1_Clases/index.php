<?php

require('./tableroMosca.php');
require('./buscaMinas.php');
$parametros= explode('/', $_SERVER['REQUEST_URI']);
unset($parametros[0]);


#Ejercicio Mosca

#con URL
echo '<h1>Ejercicio Mosca</h1><br>Con URL<br>';

if($_SERVER['REQUEST_METHOD']=='GET'){
    if($parametros[1]=='mosca_tablero'){
        if(count($parametros)==2){
            $tablero = TableroMosca::Builder()->setTamanio($parametros[2])->build();            
            echo 'tablero creado:<br>';
            print_r($tablero);
            echo '<br>';
        }
        
        else{
            echo 'Fallo en la cantidad de parametros';
        }
    }
    else if($parametros[1]=='mosca_colocar'){
        if(count($parametros)==1){
            $tablero = TableroMosca::Builder()->setTamanio(9)->build(); 
            $tablero->colocarMosca();
            echo 'mosca colocada:<br>';
            print_r($tablero);
            echo '<br>';
        }
        
        else{
            echo 'Fallo en la cantidad de parametros';
        }
    }
    else if($parametros[1]=='mosca_jugar'){
        if(count($parametros)==2){
            $tablero = TableroMosca::Builder()->setTamanio(9)->build(); 
            $tablero->colocarMosca();
            $posicion = $parametros[2];
            echo 'resultado del intento<br>';
            echo 'El resultado para la posicion '.$posicion.' es: '.$tablero->devolverIntento($posicion).'<br>';
        }
        else{
            echo 'Fallo en la cantidad de parametros';
        }
    }
    else {
        echo 'ejemplo1: ...../mosca_tablero/10<br>';
        echo 'ejemplo2: ...../mosca_colocar/<br>';
        echo 'ejemplo3: ...../mosca_jugar/5<br>';
    }

}
#Ejercicio Buscaminas

echo '<h1>Ejercicio Buscaminas</h1><br>Con URL<br>';

if($_SERVER['REQUEST_METHOD']=='GET'){
    
    if($parametros[1]=='buscaminas_tablero'){
       if(count($parametros)== 3){
            if($parametros[2]<$parametros[3]){
                echo 'No puede haber más minas que casillas<br>';
            }
            else{
                $tablero = buscaMinas::Builder()->setTamanio($parametros[2])->setBombas($parametros[3])->Build();
                echo 'tablero creado:<br>';
                echo $tablero->printTablero();
            }
       }
       else{
            echo 'Fallo en la cantidad de parametros<br>';
       }
    }
    else if($parametros[1]=='buscaminas_destapar'){
        if(count($parametros)== 2){

            $tablero = buscaMinas::Builder()->Build();
            echo 'Resultado de la posición escogida:<br>';
            echo $tablero->printTablero($parametros[2]-1);
        }else{
            echo 'Fallo en la cantidad de parametros<br>';
        }
    }
    else {
        echo 'ejemplo1: ...../buscaminas_tablero/10/9<br>';
        echo 'ejemplo2: ...../buscaminas_destapar/3<br>';
    }
}
