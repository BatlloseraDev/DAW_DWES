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

function devolverRespuesta($n,&$t){
    #comprobar que sucedió 1= nada, 2= mosca asustada, 3= mosca atrapada
    $resultado = comprobarMosca($n-1,$t); #Hago un -1 para igualarlo con el array
    $devolverInfo = '';
    if($resultado ==1){
        $devolverInfo = 'No ha ocurrido nada<br>';
    }
    else if ($resultado == 2){
        $devolverInfo = 'Has asustado a la mosca<br>';
        colocarMosca($t);
        #print_r($tablero); para comprobar cual es la nueva pos
    }
    else if ($resultado == 3){
        $devolverInfo = 'Has matado a la mosca<br>Juego reiniciado<br>';
        colocarMosca($t);
    }
    else{
        $devolverInfo= 'Sucedió algo inesperado<br>';
    }
    return $devolverInfo;
}
/*
if (!isset($_SESSION['tablero'])) {
    $_SESSION['tablero'] = devolverArrayConTamanio(9);
    colocarMosca($_SESSION['tablero']);
}
$tablero = $_SESSION['tablero'];
#print_r($tablero); para ver la posicion y probar
echo '<br>';

if (isset($_POST['mosca'])){
    $numero = $_POST['mosca'];
    #comprobar que sucedió 1= nada, 2= mosca asustada, 3= mosca atrapada
   
    $resultado = comprobarMosca($numero-1,$tablero);
    if($resultado ==1){
        echo 'No ha ocurrido nada<br>';
    }
    else if ($resultado == 2){
        echo 'Has asustado a la mosca<br>';
        colocarMosca($tablero);
        $_SESSION['tablero'] = $tablero;
        #print_r($tablero); para comprobar cual es la nueva pos
    }
    else if ($resultado == 3){
        echo 'Has matado a la mosca<br>';
        unset($_SESSION['tablero']);
        echo 'Juego reiniciado';
    }

}else{
    echo 'Aun no has introducido un número';
}


*/
