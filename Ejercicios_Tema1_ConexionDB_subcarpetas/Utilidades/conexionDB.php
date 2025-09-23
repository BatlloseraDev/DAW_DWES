<?php

class ConexionDB{

    private $url= 'localhost';
    private $user = 'admin';
    private $password = 'admin';
    private $database = 'clasephp';

    private $connection;

    public function __construct(){
        
    }

    public function conectar(){
        try{
            $this->connection = mysqli_connect($this->url, $this->user, $this->password , $this->database);
            if(!$this->connection){
                throw new Exception('Fallo al conectar a MySQL'. mysqli_connect_error());
            }
        }
        catch(Exception $e){
            echo ''.$e->getMessage().'';
        }
    }
    
    public function desconectar(){
        mysqli_close($this->connection);
    }


    public function getPreparedStatement($sql){
        $stmt = mysqli_prepare($this->connection, $sql);
        //puede devolver falso lo dejo así por si quiero controlar el fallo aqui
        return $stmt;
    }

}