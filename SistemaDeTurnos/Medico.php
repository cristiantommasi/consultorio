<?php

require_once("Consultorio.php");
require_once("Persona.php");

class Medico extends Persona {
    private $especialidad;
    private $matricula;

    public function __construct($nombre, $apellido, $dni, $especialidad,$matricula) {
        parent::__construct($nombre, $apellido, $dni);
        $this->especialidad = $especialidad;
        $this->matricula = $matricula;
    }

    public function getEspecialidad() {
        return $this->especialidad;
    }

    public function getMatricula() {
        return $this->matricula;
    }

    public function getJson(){
        $output = [];
        $output['nombre'] = $this->nombre;
        $output['apellido'] = $this->apellido;
        $output['dni'] = $this->dni;
        $output['especialidad'] = $this->especialidad;
        $output['matricula'] = $this->matricula;

        return json_encode($output);
    }
    
}