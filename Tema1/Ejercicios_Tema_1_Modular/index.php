<?php

require ('./libreria.php');


$parametros = explode('/', $_SERVER["REQUEST_URI"]);
unset($parametros[0]);

#----------- Ejercicio 5--------------
echo '<h1>EJERCICIO 5</h1>';
echo '<br>';
echo '¿el año 2000 es bisiesto?';
echo esBisiesto(2000).'<br>';

echo '¿el año 1900 es bisiesto?';
echo esBisiesto(1900).'<br>';
//Con url
echo 'CON URL<br>';
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if($parametros[1]=="bisiesto"){
        if(count($parametros)==2){
            if(is_numeric($parametros[2])){
                echo '¿El año '.$parametros[2].' es bisiesto?'.esBisiesto($parametros[2])."<br>";
            }
            else{
                echo 'no es un número<br>';
            }
        }
        else{
            echo 'Has introducido demasiados parametros<br>';
        } 
    }
    else{
        echo 'Ejemplo: ....../bisiesto/2000<br>';
    }
}




#----------- Ejercicio 11--------------

echo '<h1>EJERCICIO 11</h1>';
echo '<br>';
echo 'el factorial de 4 es ';
echo factorial(4).'<br>';

echo 'el factorial de 5 es ';
echo factorial(5).'<br>';
#Con URL
echo 'CON URL<br>';
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if($parametros[1]=="factorial"){
        if(count($parametros)==2){
            if(is_numeric($parametros[2])){
                echo 'El número es '.$parametros[2].' y su factorial: '.factorial($parametros[2])."<br>";
            }
            else{
                echo 'no es un número<br>';
            }
        }
        else{
            echo 'Has introducido demasiados parametros<br>';
        } 
    }
    else{
        echo 'Ejemplo: ....../factorial/5<br>';
    }
}


#----------- Ejercicio 15--------------
echo '<h1>EJERCICIO 15</h1>';
echo '<br>';
echo 'El resto y el cociente de 18:4 es:';
$vect = division(18,4);

#print_r($vect);
echo '<br>';
echo 'El resto es '.$vect[0].' y el cociente es '.$vect[1].'<br>';


#Con URL
echo 'CON URL<br>';
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if($parametros[1]=="division"){
        if(count($parametros)==3){
            if(is_numeric($parametros[2]) && is_numeric($parametros[3])){
                $vect = division ($parametros[2], $parametros[3]);

                echo 'La division de '.$parametros[2].' entre '.$parametros[3].' da un cociente de '.$vect[1].' y un resto de '.$vect[0]."<br>";
            }
            else{
                echo 'Alguno de los dos números no es un número<br>';
            }
        }
        else{
            echo 'Has introducido los parametros incorrectos<br>';
        } 
    }
    else{
        echo 'Ejemplo: ....../division/18/4<br>';
    }
}



#----------- Ejercicio 16--------------
echo '<h1>EJERCICIO 16</h1>';
echo '<br>';
$hora = 23;
$minuto = 59;
$segundos = 59;

echo 'La hora acutal es '.sprintf('%02d',$hora).':'.sprintf('%02d',$minuto).':'.sprintf('%02d',$segundos).'<br>';

sumarSeg( $hora, $minuto, $segundos);

echo 'La hora sumada un segundo es '.sprintf('%02d',$hora).':'.sprintf('%02d',$minuto).':'.sprintf('%02d',$segundos).'<br>';

#Con url
echo 'CON URL<br>';
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if($parametros[1]=="hora"){
        if(count($parametros)==4){
            if(is_numeric($parametros[2]) && is_numeric($parametros[3])&& is_numeric($parametros[4])){
                $hora = $parametros[2];
                $minuto = $parametros[3];
                $segundos = $parametros[4];
                echo 'La hora acutal es '.sprintf('%02d',$hora).':'.sprintf('%02d',$minuto).':'.sprintf('%02d',$segundos).'<br>';
                sumarSeg( $hora, $minuto, $segundos);
                echo 'La hora sumada un segundo es '.sprintf('%02d',$hora).':'.sprintf('%02d',$minuto).':'.sprintf('%02d',$segundos).'<br>';

            }
            else{
                echo 'Alguno de los dos números no es un número<br>';
            }
        }
        else{
            echo 'Has introducido los parametros incorrectos<br>';
        } 
    }else{
        echo 'Ejemplo: ....../hora/23/59/59<br>';
    }
}


#----------- Ejercicio 22--------------
echo '<h1>EJERCICIO 22</h1>';
echo '<br>';
$numero22 = 25436;
echo 'cuantos digitos pares e impares tiene el número '.$numero22.'<br>';
$vect22 = paresImpares($numero22);
echo 'El numero '.$numero22.' tiene '.$vect22[0].' digitos pares y '.$vect22[1].' digitos impares.'.'<br>';

#Con url

echo 'CON URL<br>';
if($_SERVER["REQUEST_METHOD"]=="GET"){
    if($parametros[1]=="pares"){
        if(count($parametros)==2){
            if(is_numeric($parametros[2])){
                $vect22 = paresImpares($parametros[2]);
                echo 'El número es '.$parametros[2].' y tiene '.$vect22[0].' digitos pares y '.$vect22[1].' digitos impares.'."<br>";
            }
            else{
                echo 'no es un número<br>';
            }
        }
        else{
            echo 'Has introducido demasiados parametros<br>';
        } 
    }
    else{
        echo 'Ejemplo: ....../pares/25436<br>';
    }
}

