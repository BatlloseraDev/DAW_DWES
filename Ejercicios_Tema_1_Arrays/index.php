<?php
session_start();
require ('./libreria.php');

#-------------Ejercicio 5-----------------
/*
Diseña un programa que genere un vector con números al azar que oscilan entre
[-100 y 100]. Después realiza un módulo que indique cuantos números positivos y
cuantos negativos hay.
*/

echo '<h1>Ejercicio 5</h1><br>';
$cantidad = 5;
$vector5= generarArrayAleatorio($cantidad);
$vector5_2 = contarPositivosNegativos($vector5);
print_r($vector5);

echo '<br>Hay '.$vector5_2[0].' números positivos y '.$vector5_2[1].' números negativos.<br>';



#-----------Ejercicio 8-----------------
/*
Dado un array de números de 5 posiciones con los siguiente valores {1,2,3,4,5},
guardar los valores de este array en otro array distinto pero con los valores invertidos,
es decir, que el segundo array deberá tener los valores {5,4,3,2,1}.
*/

echo '<h1>Ejercicio 8</h1><br>';

$array8 = [1,2,3,4,5];

$array8_2 = revertirArray($array8);
print_r($array8_2);


#-----------Ejercicio 9-----------------
/*
Crea una aplicación que pida un numero por teclado y después comprobaremos si
el numero introducido es capicúa, es decir, que se lee igual sin importar la dirección.
Por ejemplo, si introducimos 30303 es capicúa, si introducimos 30430 no es capicúa.
Utiliza vectores para resolver el problema.
*/

echo '<h1>Ejercicio 9</h1><br>';
?>
<form method="post">
    <p>Ingresa un número en la caja de abajo</p>
    <input type="number" id="ejercicio9" name="ejercicio9" required>
    <button  type="submit">Comprobar capicúa</button>
</form>

<?php
if (isset($_POST['ejercicio9'])){
    $numero = $_POST['ejercicio9'];
    $resultado= comprobarCapicua( $numero);
    if ($resultado) echo 'El número '.$numero.' es capicúa<br>';
    else echo 'El número '.$numero.' no es capicúa<br>';
    
}else{
    echo 'Aun no has introducido un número';
}


#-----------La mosca Gao-----------------
/*
Vamos a intentar cazar una mosca. La mosca será un valor que se introduce en una
posición de un vector; el jugador no ve el panel pero si ve las casillas a las que puede
golpear. Si la mosca está en esa posición se acaba el juego, mosca cazada. Si la mosca
no está en esa posición pueden ocurrir dos cosas: que la mosca esté en casillas
adyacentes en cuyo caso la mosca revolotea y se sitúa en otra casilla o que la mosca no
esté en casillas adyacentes, en este caso la mosca permanece donde está.
*/

echo '<h1>La mosca Gao</h1><br>';
?>

<p><b>Instrucciones:</b> A continuación verá una representación gráfica de un tablero en una sola dimension, 
este tablero representa graficamente los espacios donde puede estar la mosca, los cuales estan ordenados del 1 al 9
si quiere atrapar la mosca deberá introducir un número en la caja de abajo y comprobrar lo que ha sucedido
el juego termina cuando haya usted matado a la mosca y se reiniciará automaticamente a una nueva partida <br></p>

<pre>
    [ ] [ ] [ ] [ ] [ ] [ ] [ ] [ ] [ ]
     1   2   3   4   5   6   7   8   9
</pre>
<form method="post">
    <p>Ingresa un número en la caja de abajo del 1 al 9</p>
    <input type="number" id="mosca" name="mosca" min="1" max="9" required>
    <button  type="submit">Comprobar resultado</button>
</form>

<?php

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

?>




