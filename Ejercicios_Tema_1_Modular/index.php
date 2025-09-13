<?php

require ('./libreria.php');

#----------- Ejercicio 5--------------
echo '<h1>EJERCICIO 5</h1>';
echo '<br>';
echo '¿el año 2000 es bisiesto?';
echo esBisiesto(2000).'<br>';

echo '¿el año 1900 es bisiesto?';
echo esBisiesto(1900).'<br>';

#----------- Ejercicio 11--------------

echo '<h1>EJERCICIO 11</h1>';
echo '<br>';
echo 'el factorial de 4 es ';
echo factorial(4).'<br>';

echo 'el factorial de 5 es ';
echo factorial(5).'<br>';

#----------- Ejercicio 15--------------
echo '<h1>EJERCICIO 15</h1>';
echo '<br>';
echo 'El resto y el cociente de 18:4 es:';
$vect = division(18,4);

#print_r($vect);
echo '<br>';

echo 'El resto es '.$vect[0].' y el cociente es '.$vect[1].'<br>';


#----------- Ejercicio 16--------------
echo '<h1>EJERCICIO 16</h1>';
echo '<br>';
$hora = 23;
$minuto = 59;
$segundos = 59;

echo 'La hora acutal es '.sprintf('%02d',$hora).':'.sprintf('%02d',$minuto).':'.sprintf('%02d',$segundos).'<br>';

sumarSeg($hora, $minuto, $segundos);

echo 'La hora sumada un segundo es '.sprintf('%02d',$hora).':'.sprintf('%02d',$minuto).':'.sprintf('%02d',$segundos).'<br>';


#----------- Ejercicio 22--------------
echo '<h1>EJERCICIO 22</h1>';
echo '<br>';
$numero22 = 25436;
echo 'cuantos digitos pares e impares tiene el número '.$numero22.'<br>';

$vect22 = paresImpares($numero22);

echo 'El numero '.$numero22.' tiene '.$vect22[0].' digitos pares y '.$vect22[1].' digitos impares.','<br>';

