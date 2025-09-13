<?php

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
        $num= $num/10;
        $resto= $num%10;
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