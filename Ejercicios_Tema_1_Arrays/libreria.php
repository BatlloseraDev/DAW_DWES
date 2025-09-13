<?php
#--- funciones ejercicio 5 ---

$generarAleatorio = function() {
    return rand(-100,100);
};
function generarArrayAleatorio($cantidad){
    global $generarAleatorio;
    $v = [];
    for ($i = 0; $i < $cantidad; $i++) {
        $v[] = $generarAleatorio(); 
    }
    return $v;
}

function contarPositivosNegativos($vector){
    $positivos = 0;
    $negativos= 0;
    
    foreach ($vector as $value) {
        if($value>=0) $positivos++;
        else $negativos++;
    }

    return [$positivos,$negativos];
}


#--- funciones ejercicio 8 ---


function revertirArray($array){
    $devolver = [];

    for ($i = count($array)-1; $i >= 0; $i--) {
        $devolver[] = $array[$i];
    }
    return $devolver;
}


#con claves (por cuenta propia por curiosidad)

function revertirArrayClave($array){
    $claves = array_keys($array);
    $devolver = [];
    
    for ($i = count($claves)-1; $i >=0; $i--) {
        $devolver[$claves[$i]]= $array[$claves[$i]];
    }
    return $devolver;
}




#--- funciones ejercicio 9 ---


function comprobarCapicua($numero){
    $array_n = str_split($numero);
    $array_r = revertirArray($array_n);
    
    $resultado= false;
    if($array_n== $array_r ){
        $resultado = true;
    }
    return $resultado;
}


#--- funciones ejercicio mosca ---
$comprobarPosicion = function ($n,$t){
    return $t[$n]==1;
};

function devolverArrayConTamanio ($numero){

    $array_t = [];
    for ($i = 0; $i<$numero; $i++){
        $array_t[] = 0;
    }
    return $array_t;
}


function colocarMosca (&$array){
    $array= devolverArrayConTamanio(count($array));#reinicio el tablero
    $numRandom = rand (0, count($array) -1);
    $array[$numRandom]= 1;
}


function comprobarMosca ($n,$t){
    
    $tamanioTar= count($t);
    global $comprobarPosicion;
    $resultado = 1;
    if($comprobarPosicion($n,$t)){#comprobar muerta
            $resultado= 3;
    }  
    else{#comprobar bordes
        if($n<=0){
            if($comprobarPosicion($n+1,$t)) $resultado=2;
       
        }
        else if($n>= $tamanioTar-1){
         
            if($comprobarPosicion($n-1,$t)) $resultado=2;
            
        }
        else{
        #dentro de la array
       
            if($comprobarPosicion($n-1,$t)||$comprobarPosicion($n+1,$t)) $resultado= 2;
            
        }
    }
   
    return $resultado;
}
/*
function comprobar1Posicion ($n,$t){
    return $t[$n]==1;
}*/

