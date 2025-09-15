<?php


require ('./libreria.php');
$parametros = explode('/', $_SERVER["REQUEST_URI"]);
unset($parametros[0]);



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
#Con URL
echo 'Con URL<br>';
if($_SERVER['REQUEST_METHOD']=='GET'){
    if($parametros[1]=='posNeg'){
        if(count($parametros)==2){
            $cantidad = $parametros[2];
            $vector5= generarArrayAleatorio($cantidad);
            $vector5_2 = contarPositivosNegativos($vector5);
            print_r($vector5);
            echo '<br>Hay '.$vector5_2[0].' números positivos y '.$vector5_2[1].' números negativos.<br>';
        }
        
        else{
            echo 'Fallo en la cantidad de parametros';
        }
    }else{
        echo 'ejemplo: ...../posNeg/5<br>';
    }
}



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
echo '<br>';


#con URL
echo 'Con URL<br>';
if($_SERVER['REQUEST_METHOD']=='GET'){
    if($parametros[1]=='revertir'){
        if(count($parametros)==2){
            $numero = $parametros[2];
            $array8 = str_split($numero);
            $array8_2 = revertirArray($array8);
            print_r($array8_2);
        }
        
        else{
            echo 'Fallo en la cantidad de parametros';
        }
    }else{
        echo 'ejemplo: ...../revertir/12345<br>';
    }
}



#-----------Ejercicio 9-----------------
/*
Crea una aplicación que pida un numero por teclado y después comprobaremos si
el numero introducido es capicúa, es decir, que se lee igual sin importar la dirección.
Por ejemplo, si introducimos 30303 es capicúa, si introducimos 30430 no es capicúa.
Utiliza vectores para resolver el problema.
*/

echo '<h1>Ejercicio 9</h1><br>';
?>

<!-- METODO CON POST
<form method="post">
    <p>Ingresa un número en la caja de abajo</p>
    <input type="number" id="ejercicio9" name="ejercicio9" required>
    <button  type="submit">Comprobar capicúa</button>
</form>
-->


<?php
echo '¿el número 34543 es capicúa?<br>';
if (comprobarCapicua(34543)){
    echo 'El número es capicúa<br>';
}else{
    echo 'El número no es capicúa<br>';
}
echo 'Con URL<br>';


if($_SERVER['REQUEST_METHOD']=='GET'){
    if($parametros[1]=='capicua'){
        if(count($parametros)==2){
            if(comprobarCapicua($parametros[2])){
                echo 'El número '.$parametros[2].' es capicúa<br>';
            }
            else{
                echo 'El número '.$parametros[2].' no es capicúa<br>';
            }
        }
        
        else{
            echo 'Fallo en la cantidad de parametros';
        }
    }else {
        echo 'ejemplo: ...../capicua/34543<br>';
    }
}



/* metodo con post
if (isset($_POST['ejercicio9'])){
    $numero = $_POST['ejercicio9'];
    $resultado= comprobarCapicua( $numero);
    if ($resultado) echo 'El número '.$numero.' es capicúa<br>';
    else echo 'El número '.$numero.' no es capicúa<br>';
    
}else{
    echo 'Aun no has introducido un número';
}
*/ 

?>


<?php
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
<!-- Metodo con POST
<form method="post">
    <p>Ingresa un número en la caja de abajo del 1 al 9</p>
    <input type="number" id="mosca" name="mosca" min="1" max="9" required>
    <button  type="submit">Comprobar resultado</button>
</form>
-->
<p>Ingresa un número en la caja de abajo del 1 al 9</p>
<?php
echo 'En este caso simulo que le he puesto 5<br>';
$tamanio = 9;
$posicion = 5;
$tablero = devolverArrayConTamanio($tamanio);
colocarMosca($tablero);
print_r($tablero);
echo '<br>';
echo 'El resultado para la posicion '.$posicion.' es: '.devolverRespuesta($posicion, $tablero);

#con URL
echo 'Con URL<br>';

if($_SERVER['REQUEST_METHOD']=='GET'){
    if($parametros[1]=='mosca_tablero'){
        if(count($parametros)==2){
            $tamanio = $parametros[2];
            $tablero = devolverArrayConTamanio($tamanio);
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
            $tamanio = 9;
            $tablero = devolverArrayConTamanio($tamanio);
            colocarMosca($tablero);
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
            $tamanio = 9;
            $tablero = devolverArrayConTamanio($tamanio);
            colocarMosca($tablero);
            $posicion = $tablero[2];
            print_r($tablero);
            echo 'resultado del intento<br>';
            echo 'El resultado para la posicion '.$posicion.' es: '.devolverRespuesta($posicion, $tablero);
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



/* Metodo con Post
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
?>

<?php
#------------------BUSCAMINAS-----------------

echo '<h1>Buscaminas</h1><br>';

/*
Realizaremos el juego del buscaminas con un vector. Para aquellos que no hayan
jugado nunca (ni siquiera mientras estoy explicando algo) os recuerdo que el juego
consiste en destapar todas las casillas de un vector menos las minas; si pisamos una
mina el juego acaba y hemos perdido.
El juego nos proporcionará pistas, de forma que si destapamos una casilla y no hay una
mina, esta casilla nos indicará cuantas minas hay adyacentes a esa posición.
Por lo tanto el ordenador debe preparar un panel de 20 casillas para nosotros en el
que colocará 6 minas y las pistas correspondientes.
*/
if($_SERVER['REQUEST_METHOD']=='GET'){
    
    if($parametros[1]=='buscaminas_tablero'){
       if(count($parametros)== 3){
            if($parametros[2]<$parametros[3]){
                echo 'No puede haber más minas que casillas<br>';
            }
            else{
                $tablero = generarTablero($parametros[2],$parametros[3]);//n es tamanio y b es minas
                echo 'tablero creado:<br>';
                printear_tablero($tablero);
            }
       }
       else{
            echo 'Fallo en la cantidad de parametros<br>';
       }
    }
    else if($parametros[1]=='buscaminas_destapar'){
        if(count($parametros)== 2){
            $tamanio = 10;
            $bombas = 3;
            $tablero = generarTablero($tamanio, $bombas);
            echo 'Resultado de la posición escogida:<br>';
            printear_tabero_casilla($tablero, $parametros[2]);
        }else{
            echo 'Fallo en la cantidad de parametros<br>';
        }
    }
    else {
        echo 'ejemplo1: ...../buscaminas_tablero/10/9<br>';
        echo 'ejemplo2: ...../buscaminas_destapar/3<br>';
    }
}





?>




