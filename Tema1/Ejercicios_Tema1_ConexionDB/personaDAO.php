<?php

require('./persona.php');

interface PersonaDAO {
    public function get_Persona_by_dni($dni);
    public function update_Persona_by_id($id,$persona);
    public function delete_Persona_by_id($id);
    public function insert_Persona($persona);
    public function get_all_personas();
}
