<?php

require('./Model/usuario.php');

interface UsuarioDAO {
    public function get_Usuario_by_id($id);
    public function get_Usuario_by_name($name);
    public function update_Usuario_by_id($id,$usuario);
    public function delete_Usuario_by_id($id);
    public function insert_Usuario($usuario);
    public function get_all_Usuarios();
}
