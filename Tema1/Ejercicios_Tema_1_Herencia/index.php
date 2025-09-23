<?php

require_once 'factoria.php';
require_once 'animalAbstracto.php';
require_once 'perro2.php';
require_once 'gato2.php';
require_once 'elefante.php';


$parametros = explode('/', $_SERVER['REQUEST_URI']);
unset($parametros[0]);
$factoria = new Factoria(); 

// EJERCICIOS 1-6-8

/*ENUNCIADOS

1
Vamos a realizar una estructura de clases en la que queden reflejados los dos tipos de
animales domésticos principales: perros y gatos.
Todos tendrán un nombre, una raza, un peso y un color. En cuanto a métodos tendrán los
siguientes: vacunar, comer, dormir, hacerRuido, hacerCaso. Los métodos vacunar, comer y
dormir son comunes. Los métodos hacerRuido y hacerCaso serán sobreescritos en las
especializaciones: hacerRuido para los perros será un ladrido y para los gatos un maullido;
hacerCaso para los perros será un método boolean que devolverá true el 90% de las veces y
para los gatos el 5%. Los perros tendrán un método particular: sacarPaseo. Los gatos tendrán
otro método que será: toserBolaPelo.

6
Sobre el ejercicio de animales domésticos realiza las siguientes variaciones: los métodos
comer, dormir y hacerRuido. deben ser obligatorios para cualquier nuevo animal doméstico
que se añada nuevo. Crea la clase Elefante que herede de la anterior y que incluya los métodos
obligatorios (el elefante barrita). Realiza el ejercicio en los supuestos de que la clase Animal no
se instancie nunca y en el supuesto que sí. 


8
Pues otra vez con los animales domésticos. Vamos a diseñar una simulación de un parque. En
este parque, dividido en sectores solo cabe un animal doméstico por sector.
Cada 10 segundos aparece un animal nuevo que se sitúa en una posición libre del parque; si no
hubiera el animal se va.
Cada 2 segundos los animales del parque hacen algunas de las acciones habituales: comer,
dormir o hacerRuido; al azar.
Cada 15 segundos un animal cambia de posición a otra adyacente. Si no hay hueco libre no se
mueve.
Cada 20 segundos alguno de los animales abandona el parque con una probabilidad del 50%.

*/
//Para el ejercicio8


$parque = array_fill(0,9,null);
$tiempoMax = 100;
$tiempoActual = 1;
print_r($parque); 


while ($tiempoActual < $tiempoMax) {

    if($tiempoActual%10==0){
        //aparecer nuevo animal
        $animal = $factoria->crearAnimalAleatorio();
        

        // Comprobamos si hay hueco libre (null) en el parque
        if (in_array(null, $parque, true)) {
            // Buscamos la primera posición libre (índice)
            $posicionLibre = array_search(null, $parque, true);
            $parque[$posicionLibre] = $animal;
            echo "Tiempo {$tiempoActual}: ¡Un {$animal->hacerRuido()} ha entrado en el parque en la posición {$posicionLibre}!<br>";
        }


    }
    if($tiempoActual%2==0){
        //accion al azar
    }
    if($tiempoActual%15==0){
        //un animal aleatorio cambia a una posicion adyacente si puede
    }
    if($tiempoActual%20==0){
        //un animal aleatorio abandona el parque con un random del 50%
    }


    $tiempoActual++;
}

