<?php


require_once('./DataBases/usuarioDAOImpl.php');
/**
 * Ha quedado por terminar de implementar por motivos de salud
 */
class UsuarioController 
{

    private $usuarioDAO;
    public function __construct()
    {
        $this->usuarioDAO = new UsuarioDAOImpl();
    }



    public function getUsuarios()
    {
        $usuario = $this->usuarioDAO->get_all_Usuarios();
        header("HTTP/1.1 200");
        print json_encode($usuario);
    }
}

