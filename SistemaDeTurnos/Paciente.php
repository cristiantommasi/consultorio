<?php

require_once("Consultorio.php");
require_once("Persona.php");

class Paciente extends Persona {
    private $historialMedico;

    public function __construct($nombre, $apellido, $dni) {
        parent::__construct($nombre, $apellido, $dni);
        $this->historialMedico = null;
    }

    public function getHistorialMedico(){
        return $this->historialMedico;
    }

    public function setHistorialMedico($texto){
        $this->historialMedico = $this->getHistorialMedico(). "\n" .$texto ."\n";
    }

    public function getJson(){
        $output = [];
        $output['nombre'] = $this->getNombre();
        $output['apellido'] = $this->getApellido();
        $output['dni'] = $this->getDni();
        $output['historialMedico'] = $this->getHistorialMedico();

        return json_encode($output);
    }
    
}