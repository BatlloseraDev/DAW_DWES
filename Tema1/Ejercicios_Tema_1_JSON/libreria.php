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


function esBisiesto($anyo){
    $bisieto= false;
    
    
    if($anyo %4== 0){
        if($anyo %100 ==0 && $anyo %400 == 0){
            $bisieto=true;
        } 
    }
    if($bisieto){
        $bisieto= 'si';
    }
    else{
        $bisieto= 'no';
    }
    return $bisieto;
}


function factorial($num){
    $fact= 1;
    for($i = 1; $i <= $num; $i++){
        $fact= $fact * $i;
    }
    return $fact;

}


function division($num1,$num2){
    
    $cociente = 0;

    while($num1 > $num2){
        $num1-=$num2;
        $cociente++;
    }
    $vect= [$num1,$cociente]; //resto, cociente
    return $vect;
}


function sumarSeg(&$hora,&$min,&$seg){
    $seg++;
    if($seg>=60){
        $min+=$seg/60;
        $seg=$seg%60;
        if($min>=60){
            $hora+=$min/60;
            $min=$min%60;
            if($hora>=24){
                $hora=$hora%24;
            }
        }
    }
}



function paresImpares($num){
    $pares = 0;
    $impares = 0;
    while($num >=1 ){
        $resto= $num%10;
        $num= $num/10;
        if($resto%2==0){
            $pares++;
        }
        else{
            $impares++;
        }
        
    }
    $vect= [$pares,$impares];
    return $vect;
}