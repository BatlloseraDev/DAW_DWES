<?php

require_once('./personaDAOImpl.php');
require_once('./persona.php');
// require_once("./personaDAO.php");
// require_once("../Utilidades/conexionDB.php");
// require_once("../Utilidades/sql_preparados.php");
// require_once("../Negocio/persona.php");


$metodo = $_SERVER['REQUEST_METHOD'];
$parametros = explode('/', $_SERVER["REQUEST_URI"]);
unset($parametros[0]);


//header("Content-Type: JSON;");
/*
    GET-> verPersona/ verPersonas
    POST-> crearPersona
    PUT-> actualizarPersona
    DELETE-> eliminarPersona

*/


switch ($metodo) {
    case 'GET':
        switch ($parametros[1]) {
            case 'verPersona': 
                if(count($parametros) == 2) {
                    $personaDAO = new PersonaDAOImpl();
                    $personas = $personaDAO->get_Persona_by_dni($parametros[2]);
                    
                    header("HTTP/1.1 200");
                    print json_encode($personas);
                }
                else {
                    header("HTTP/1.1 400");
                    print 'Fallo en la cantidad de parametros de: '.$parametros[1];
                }
                break;
            case 'verPersonas': 
                $personaDAO = new PersonaDAOImpl();
                $personas = $personaDAO->get_all_personas();
                
                header("HTTP/1.1 200");
                print json_encode($personas);
                
                break;
            default: 
                
            break;
        }
        break;
    case 'POST':
        
        switch ($parametros[1]) {
            case 'crearPersona': 
                $personaDAO = new PersonaDAOImpl();
                $datosRecibidos = file_get_contents("php://input");
                $data = json_decode($datosRecibidos, true); 
                
                try{
                    $persona= Persona::Builder()
                        ->setDni($data['dni'])
                        ->setNombre($data['nombre'])
                        ->setClave($data['clave'])
                        ->setTfno($data['tfno'])
                        ->build();

                    if($personaDAO->insert_Persona($persona)){
                        header("HTTP/1.1 201");
                        print json_encode($persona);
                    }else{
                        header("HTTP/1.1 400");
                    }
                   
                }
                catch(Exception $e){
                    header("HTTP/1.1 400");
                    print $e->getMessage();
                }
                break;
         
            default:
                header("HTTP/1.1 400");
                //echo "Entre en POST"; 
            break;
        }

        break;// crear
    
    case 'PUT': 
        switch ($parametros[1]) {
            case 'actualizarPersona': 
                $personaDAO = new PersonaDAOImpl();
                $datosRecibidos = file_get_contents("php://input");
                $data = json_decode($datosRecibidos, true); 
                
                try{
                    $persona= Persona::Builder()
                        ->setDni($data['dni'])
                        ->setNombre($data['nombre'])
                        ->setClave($data['clave'])
                        ->setTfno($data['tfno'])
                        ->build();

                    if($personaDAO->update_Persona_by_id($persona->getDni(),$persona)){
                        header("HTTP/1.1 200");
                        print json_encode($persona);
                    }else{
                        header("HTTP/1.1 400");
                    }
                   
                }
                catch(Exception $e){
                    header("HTTP/1.1 400");
                    print $e->getMessage();
                }
                break;
         
            default:
                header("HTTP/1.1 400");
                //echo "Entre en POST"; 
            break;
        }

        break; // actualizar
    case 'DELETE': 
        
        switch ($parametros[1]) {
            case 'eliminarPersona': 
                $personaDAO = new PersonaDAOImpl();
                $datosRecibidos = file_get_contents("php://input");
                $data = json_decode($datosRecibidos, true); 
                
                try{

                    $dni = $data['dni'];
                    if($personaDAO->delete_Persona_by_id($dni)){
                        header("HTTP/1.1 200");
                        
                    }else{
                        header("HTTP/1.1 400");
                    }
                   
                   
                }
                catch(Exception $e){
                    header("HTTP/1.1 400");
                    print $e->getMessage();
                }
                break;
         
            default:
                header("HTTP/1.1 400");
                //echo "Entre en POST"; 
            break;
        }
        
        break;
    default: break;
}


