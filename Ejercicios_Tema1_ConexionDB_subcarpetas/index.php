<?php

require_once('./AccesoDatos/personaDAOImpl.php');
require_once("./personaDAO.php");
require_once("../Utilidades/conexionDB.php");
require_once("../Utilidades/sql_preparados.php");
require_once("../Negocio/persona.php");


$metodo = $_SERVER['REQUEST_METHOD'];
$parametros = explode('/', $_SERVER["REQUEST_URI"]);
unset($parametros[0]);


//header("Content-Type: JSON;");



//Toda la parafernalia

switch ($metodo) {
    case 'GET':
        switch ($parametros[1]) {
            case 'verPersona': 
                if(count($parametros) == 2) {
                    $personaDAO = new PersonaDAOImpl();
                    $personas = $personaDAO->get_Persona_by_id($parametros[2]);
                    
                    header("HTTP/1.1 200");
                    print json_encode($personas);
                }
                else {
                    header("HTTP/1.1 400");
                    print 'Fallo en la cantidad de parametros de: '.$parametros[1];
                }
                break;
            case 'verPersonas': break;
            default: break;
        }
        break;
    case 'POST': break;
    case 'PUT': break;
    case 'DELETE': break;
    default: break;
}


