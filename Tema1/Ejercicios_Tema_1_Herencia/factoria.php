<?php


require_once 'perro2.php';
require_once 'gato2.php';
require_once 'elefante.php';

class  Factoria {

    //CHAT GPT

    // // 1. Propiedad estática para guardar la única instancia.
    // private static $instance = null;

    // // 2. Constructor privado para evitar la instanciación directa.
    // private function __construct() {
    //     // Puedes poner aquí código de inicialización si es necesario.
    //     echo "Instancia de Factoria creada.<br>";
    // }

    // // 3. Método clone privado para evitar la clonación.
    // private function __clone() {}

    // // 4. Método wakeup privado para evitar la deserialización.
    // public function __wakeup() {
    //     throw new \Exception("No se puede deserializar un singleton.");
    // }

    // /**
    //  * 5. Método estático público para obtener la instancia.
    //  * Este es el único punto de acceso para obtener el objeto Factoria.
    //  */
    // public static function getInstance(): Factoria {
    //     if (self::$instance === null) {
    //         self::$instance = new self();
    //     }
    //     return self::$instance;
    // }

  
    private $nombres = ['Milú','Spot','Garfield','Jake','Tobi','Pequeño ayudante de santaclaus', 'Shiro'];
    private $razas = ['raza1','raza2','raza3','raza4','raza5','raza6','raza7','raza8'];
    private $pesos = [1,2,3,4,5,6,7,8,9,10];
    private $colores = ['color1','color2','color3','color4','color5','color6','color7','color8'];

    public function crearAnimalAleatorio() {
        $tiposDeAnimales = ['Perro', 'Gato', 'Elefante'];
        $tipoAleatorio = $tiposDeAnimales[array_rand($tiposDeAnimales)];

        $nombre = $this->nombres[array_rand($this->nombres)];
        $raza = $this->razas[array_rand($this->razas)];
        $peso = $this->pesos[array_rand($this->pesos)];
        $color = $this->colores[array_rand($this->colores)];

        switch ($tipoAleatorio) {
            case 'Perro':
                return new Perro2($nombre, $raza, $peso, $color);
            case 'Gato':
                return new Gato2($nombre, $raza, $peso, $color);
            case 'Elefante':
                return new Elefante($nombre, $raza, $peso, $color);
            default:
                return null; //
        }
    }
}