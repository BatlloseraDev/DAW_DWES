<?php


require ('./libreria.php');
$parametros = explode('/', $_SERVER["REQUEST_URI"]);
unset($parametros[0]);


if($_SERVER['REQUEST_METHOD']=='GET'){

    //EJERCICIOS
    switch($parametros[1]){
        
        case 'posNeg'://ejercicio 5

            
            if(count($parametros)==2){
                $cantidad = $parametros[2];
                $vector5= generarArrayAleatorio($cantidad);
                $vector5_2 = contarPositivosNegativos($vector5);
                $resultado = 'Hay '.$vector5_2[0].' números positivos y '.$vector5_2[1].' números negativos.';
                $arrayJSON = [
                    'resultado'=>$resultado
                ];
                header("HTTP/1.1 200 OK");
                echo json_encode($arrayJSON);
                
                //echo '<br>Hay '.$vector5_2[0].' números positivos y '.$vector5_2[1].' números negativos.<br>';
            }
            else{
                header("HTTP/1.1 400");
                
            }
            break; 
        
        
        case 'revertir': // Ejercicico 8
            if(count($parametros)==2){
                $numero = $parametros[2];
                $array8 = str_split($numero);
                $array8_2 = revertirArray($array8);
                //print_r($array8_2);
                $arrayJSON = [
                    'resultado'=>$array8_2
                ];

                header("HTTP/1.1 200");
                echo json_encode($arrayJSON);
            }else{
                header("HTTP/1.1 400");
                //echo 'Fallo en la cantidad de parametros';
            }
            
         break;


        case 'capicua'://ejercicio 9
            if(count($parametros)==2){
                
                header("HTTP/1.1 200");
                echo json_encode(comprobarCapicua($parametros[2]));
            }else{
                header("HTTP/1.1 400");
            }
        break; 

        case 'bisiesto':
            if(count($parametros)== 2){
                if(is_numeric($parametros[2])){
                    $resultado= '¿El año '.$parametros[2].' es bisiesto?'.esBisiesto($parametros[2]);
                    header("HTTP/1.1 200");
                    echo json_encode(esBisiesto($resultado));
                }else{
                     header("HTTP/1.1 400");
                }
            }

        break;

        case 'factorial':

            if(count($parametros)== 2){
                if(is_numeric($parametros[2])){
                    $resultado = 'El número es '.$parametros[2].' y su factorial: '.factorial($parametros[2])."<br>";
                    header("HTTP/1.1 200");
                    echo json_encode(factorial($resultado));


                }else{
                    header("HTTP/1.1 400");
                }
            }

        break; 

        case 'division':

            if(count($parametros)==3){
                if(is_numeric($parametros[2]) && is_numeric($parametros[3])){
                    $vect = division ($parametros[2], $parametros[3]);
                    $resultado= 'La division de '.$parametros[2].' entre '.$parametros[3].' da un cociente de '.$vect[1].' y un resto de '.$vect[0]."<br>";
                    header("HTTP/1.1 200");
                    echo json_encode(factorial($resultado));
                
                }
                else{
                    header("HTTP/1.1 400");
                }
            }else {
                header("HTTP/1.1 400");
            }

        break;



        
        default: 
            header("HTTP/1.1 404");
            echo 'ejemplo: ...../revertir/12345<br>';
            echo 'ejemplo: ...../capicua/34543<br>';
            echo 'ejemplo: ...../posNeg/5<br>';
            echo 'Ejemplo: ....../bisiesto/2000<br>';

        break; 


    }
 
    
}






?>




