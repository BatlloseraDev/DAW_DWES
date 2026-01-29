<?php

require_once('./DataBases/usuarioDAOImpl.php');
require_once('./Model/usuario.php');
require_once('./DataBases/rolDAOImpl.php');
require_once('./Model/rol.php');
require_once('./DataBases/partidaDAOImpl.php');
require_once('./Model/partida.php');
require_once('./Helper/factoria.php');
require_once('./Controller/tableroMosca.php');


require_once('./Controller/partidaController.php');


$metodo = $_SERVER['REQUEST_METHOD'];
$parametros = explode('/', $_SERVER["REQUEST_URI"]);
unset($parametros[0]);

$factoria = new factoria();
$partidaController = new PartidasController();

//header("Content-Type: JSON;");
/*
Ha quedado por implementar lo de generar un correo electronico por motivos de salud

*/

switch ($metodo) {
    case 'GET':
        switch ($parametros[1]) {
            case 'jugador':
                $datosRecibidos = file_get_contents('php://input');
                $data = json_decode($datosRecibidos, true);
                $cantidadDatos = count($parametros);
                $usuario = esUsuario($data);
                if ($usuario === null) {
                    header('HTTP/1.1 400');
                    echo json_encode(array('error' => 'El usuario no existe o contraseña mal introducida'));

                    break;
                }


                $tipoUsuario = comprobarUsuario($usuario, "jugador");


                if ($cantidadDatos == 1 && $tipoUsuario) {//devuelve los tableros abiertos

                    $partidaController->getPartidasAbiertas($usuario);

                } else if ($cantidadDatos == 2 && $tipoUsuario) {
                    //caso que tenga varios parametros

                    switch (true) {
                        case is_numeric($parametros[2])://devuele un tablero


                            $partidaController->getPartidaByID($parametros[2], $usuario);

                            break;
                        case $parametros[2] == "historico"://devuelve todos los tableros

                            $partidaController->getHistoricoPartidas($usuario);


                            break;
                        default:
                            header("HTTP/1.1 404");
                            echo "el dominio introducido no existe";
                            break;
                    }

                } else {
                    header("HTTP/1.1 404");
                    echo "el dominio introducido no existe";
                }
                break;

            case 'admin':
                $datosRecibidos = file_get_contents('php://input');
                $data = json_decode($datosRecibidos, true);
                $cantidadDatos = count($parametros);
                $usuario = esUsuario($data);
                if ($usuario === null) {
                    header('HTTP/1.1 400');
                    echo json_encode(array('error' => 'El usuario no existe'));
                    break;
                }

                $tipoUsuario = comprobarUsuario($usuario, "admin");
                if (!$tipoUsuario) {
                    header("HTTP/1.1 400");
                    echo json_encode(array('error' => 'El usuario no es administrador'));
                    break;
                }
                if ($cantidadDatos == 1 && $tipoUsuario) {
                    //caso que solo tenga un parametro
                } else if ($cantidadDatos == 2 && $tipoUsuario) {
                    //caso que tenga varios parametros

                    switch (true) {
                        case $parametros[2] == 'getUsuarios':

                            $usuarioDao = new UsuarioDAOImpl();
                            $usuario = $usuarioDao->get_all_Usuarios();

                            header("HTTP/1.1 200");
                            print json_encode($usuario);


                            break;

                        case is_numeric($parametros[2]):

                            $datosRecibidos = file_get_contents("php://input");
                            $data = json_decode($datosRecibidos, true);


                            $usuarioDao = new UsuarioDAOImpl();
                            $usuario = $usuarioDao->get_Usuario_by_id($data["id"]);

                            header("HTTP/1.1 200");
                            print json_encode($usuario);

                            break;
                        default:
                            break;
                    }

                } else {
                    header("HTTP/1.1 404");
                    echo "el dominio introducido no existe";
                }



                break;

            default:
                header("HTTP/1.1 404");
                echo "El dominio no existe";
                break;
        }
        break;
    case 'POST':

        switch ($parametros[1]) {

            case 'jugador':
                $datosRecibidos = file_get_contents('php://input');
                $data = json_decode($datosRecibidos, true);
                $cantidadDatos = count($parametros);
                $usuario = esUsuario($data);
                if ($usuario === null)
                    break;

                $tipoUsuario = comprobarUsuario($usuario, "jugador");

                if ($cantidadDatos == 2 && $tipoUsuario) {

                    switch ($parametros[2]) {
                        case 'iniciar':
                            $tablero = $factoria->crearTableroMosca($data['tamanio']);
                            $tablero->colocarMosca();
                            $cadena = factoria::convertirTableroaString($tablero->getTablero());
                            $tableroDao = new PartidaDAOImpl();

                            try {
                                $partida = Partida::Builder()
                                    ->setCadena(cadena: $cadena)
                                    ->setCreadorId($data['id'])
                                    ->build();
                                if ($tableroDao->insertPartida($partida)) {
                                    header("HTTP/1.1 201");
                                    echo "Partida creada";

                                } else {
                                    header("HTTP/1.1 400");
                                    echo "fallo en la creacion de partida";
                                }

                            } catch (Exception $e) {
                                header("HTTP/1.1 400");
                                echo $e->getMessage();
                            }

                            break;
                        case 'darmanotazo':

                            $idTablero = $data['partida']['idTablero'];
                            $posicion = $data['partida']['posicion'];

                            $partidaDAO = new PartidaDAOImpl();
                            $partida = $partidaDAO->getPartida($idTablero);

                            if ($partida == null) {
                                header('HTTP/1.1 400');
                                echo json_encode(array('error' => 'La partida no existe'));
                                break;
                            } else if ($partida["finalizada"] == 1) {
                                header("HTTP/1.1 400");
                                echo json_encode(array("error" => "La partida ya ha terminado"));
                                break;
                            }

                            $arrayTablero = factoria::convertirStringaTablero($partida["cadena"]);
                            $tablero = new TableroMosca($arrayTablero);
                            if ($posicion <= 0 && $posicion > count($arrayTablero)) {
                                header("HTTP/1.1 400");
                                echo json_encode(array("error" => "La posicion no es valida"));
                            }

                            $resultado = $tablero->comprobarIntento($posicion - 1);
                            switch ($resultado) {
                                case 0:
                                    header("HTTP/1.1 200");
                                    echo json_encode(array("resultado" => "No ha ocurrido nada"));
                                    break;
                                case 1:
                                    $tablero->colocarMosca();
                                    $cadena = factoria::convertirTableroaString($tablero->getTablero());
                                    try {

                                        $partidaFin = Partida::Builder()
                                            ->setId($idTablero)
                                            ->setCadena($cadena)
                                            ->setFinalizada(false)
                                            ->build();
                                        if ($partidaDAO->updatePartida($partidaFin)) {
                                            header("HTTP/1.1 200");
                                            echo json_encode(array("resultado" => "Has asustado a la mosca"));
                                        } else {
                                            header("HTTP/1.1 400");
                                            echo json_encode(array("error" => "Error al enviar la informacion del tablero"));
                                        }

                                    } catch (Exception $e) {
                                        header("HTTP/1.1 400");
                                        echo json_encode(array("error" => "Erro al recolocar la mosca: " . $e->getMessage()));

                                        break;
                                    }
                                    break;
                                case 2:
                                    $cadena = factoria::convertirTableroaString($tablero->getTablero());
                                    try {

                                        $partidaFin = Partida::Builder()
                                            ->setId($idTablero)
                                            ->setCadena($cadena)
                                            ->setFinalizada(true)
                                            ->build();
                                        if ($partidaDAO->updatePartida($partidaFin)) {
                                            header("HTTP/1.1 200");
                                            echo json_encode(array("resultado" => "Has matado a la mosca"));
                                        } else {
                                            header("HTTP/1.1 400");
                                            echo json_encode(array("error" => "Error al enviar la informacion del tablero"));
                                        }

                                    } catch (Exception $e) {
                                        header("HTTP/1.1 400");
                                        echo json_encode(array("error" => "Error al matar a la mosca: " . $e->getMessage()));

                                        break;
                                    }


                                    break;
                                default:
                                    header("HTTP/1.1 400");
                                    echo json_encode(array("error" => "Error desconocido en el resultado del manotaz "));
                                    break;
                            }
                            break;
                        default:
                            break;

                    }
                } else {
                    header("HTTP/1.1 400");
                    echo "Fallo en la cantidad de parametros: " . count($parametros) . " y " . comprobarUsuario($data, "jugador");
                }

                break;


            case 'admin':


                $datosRecibidos = file_get_contents('php://input');
                $data = json_decode($datosRecibidos, true);
                $cantidadDatos = count($parametros);


                $usuario = esUsuario($data);
                if ($usuario === null)
                    break;
                $tipoUsuario = comprobarUsuario($usuario, "admin");


                if ($cantidadDatos == 1 && $tipoUsuario) { // crea usuaario

                    $usuarioDAO = new UsuarioDAOImpl();
                    $nuevoUser = $data["nuevoUsuario"];
                    try {
                        $user = Usuario::Builder()
                            ->setNombre($nuevoUser["nombre"])
                            ->setPassword(md5($nuevoUser["password"]))
                            ->setCorreo($nuevoUser["correo"])
                            ->build();


                        if ($usuarioDAO->insert_Usuario($user)) {

                            $id = $usuarioDAO->get_Usuario_by_name($nuevoUser["nombre"])[0]["id"];
                            $rolDAO = new RolDAOImpl();
                            $rolDAO->addRolToUser($id, $nuevoUser["rol"]);
                            header("HTTP/1.1 201");
                            echo "Usuario creado";
                        } else {
                            header("HTTP/1.1 400");
                            echo "Fallo en la creacion del usuario";
                        }

                    } catch (Exception $e) {
                        header("HTTP/1.1 400");
                        echo $e->getMessage();
                    }



                } else {
                    header("HTTP/1.1 400");
                    echo json_encode(array('error' => 'El usuario no existe'));
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
            case 'jugador':

                break;


            case 'admin':
                $datosRecibidos = file_get_contents('php://input');
                $data = json_decode($datosRecibidos, true);
                $cantidadDatos = count($parametros);
                $usuario = esUsuario($data);
                if ($usuario === null) {
                    header('HTTP/1.1 400');
                    echo json_encode(array('error' => 'El usuario no existe'));
                    break;
                }

                $tipoUsuario = comprobarUsuario($usuario, "admin");


                if ($cantidadDatos == 2 && $tipoUsuario) { // actualiza usuario

                    $usuarioDAO = new UsuarioDAOImpl();
                    $usuarioActualizado = $data["usuarioActualizado"];
                    if (!is_numeric($parametros[2])) {
                        header("HTTP/1.1 400");
                        echo json_encode(array("error" => "Fallo en el segundo parametro del enlace"));
                        break;
                    }
                    try {

                        $user = Usuario::Builder()
                            ->setNombre($usuarioActualizado["nombre"])
                            ->setPassword(md5($usuarioActualizado["password"]))
                            ->setCorreo($usuarioActualizado["correo"])
                            ->build();

                        if ($usuarioDAO->update_Usuario_by_id($parametros[2], $user)) {

                            header("HTTP/1.1 201");
                            echo json_encode(array('exito' => 'El usuario ha sido actualizado'));
                        } else {
                            header("HTTP/1.1 400");
                            echo json_encode(array('fallo' => 'Fallo en la actualización del usuario'));

                        }

                    } catch (Exception $e) {
                        header("HTTP/1.1 400");
                        echo $e->getMessage();
                    }



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
            case 'jugador':

                break;


            case 'admin':
                $datosRecibidos = file_get_contents('php://input');
                $data = json_decode($datosRecibidos, true);
                $cantidadDatos = count($parametros);
                $usuario = esUsuario($data);
                if ($usuario === null) {
                    header('HTTP/1.1 400');
                    echo json_encode(array('error' => 'El usuario no existe'));
                    break;
                }

                $tipoUsuario = comprobarUsuario($usuario, "admin");


                if ($cantidadDatos == 2 && $tipoUsuario) { // crea usuaario

                    $usuarioDAO = new UsuarioDAOImpl();

                    if (!is_numeric($parametros[2])) {
                        header("HTTP/1.1 400");
                        echo json_encode(array("error" => "Fallo en el segundo parametro del enlace"));
                        break;
                    }
                    try {


                        if ($usuarioDAO->delete_Usuario_by_id($parametros[2])) {

                            header("HTTP/1.1 201");
                            echo json_encode(array('exito' => 'El usuario ha sido eliminado'));
                        } else {
                            header("HTTP/1.1 400");
                            echo json_encode(array('fallo' => 'Fallo en la eliminación del usuario'));

                        }

                    } catch (Exception $e) {
                        header("HTTP/1.1 400");
                        echo $e->getMessage();
                    }



                }
                break;

            default:
                header("HTTP/1.1 400");
                //echo "Entre en POST"; 
                break;
        }

        break;
    default:
        break;

}



function esUsuario($data)
{
    $usuarioDAO = new UsuarioDAOImpl();
    $dataFiltro = isset($data["nombre"]) && isset($data["password"]) ? $data : $dataFiltro = $data["usuario"];


    $usuarios = $usuarioDAO->get_Usuario_by_name($dataFiltro['nombre']);

    $usuario = comprobarPassword(md5($dataFiltro['password']), $usuarios);

    return $usuario;
}

function comprobarUsuario($data, $tipo)
{

    $rolDAO = new RolDAOImpl();
    $resultado = false;

    try {

        $rol = $rolDAO->getRolByIDUsuario($data["id"]);
        foreach ($rol as $value) {
            if (in_array($tipo, $value))
                $resultado = true;


        }

    } catch (Exception $e) {
        echo $e->getMessage();
    }

    return $resultado;
}

function comprobarPassword($contra1, $usuarios)
{
    $user = null;

    foreach ($usuarios as $usuario) {
        if ($usuario["password"] == $contra1) {
            $user = $usuario;
            break;
        }
    }

    return $user;
}