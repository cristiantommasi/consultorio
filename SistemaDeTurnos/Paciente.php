<?php

require_once("Consultorio.php");
require_once("Persona.php");

class Paciente extends Persona {
    private $historialMedico;

    public function __construct($nombre, $apellido, $dni) {
        parent::__construct($nombre, $apellido, $dni);
        
    }

    public function getHistorialMedico(){
        return $this->historialMedico;
    }

    public function setHistorialMedico($texto){
        $this->historialMedico =  "$texto\n";
    }

    public function getJson(){
        $output = [];
        $output['nombre'] = $this->nombre;
        $output['apellido'] = $this->apellido;
        $output['dni'] = $this->dni;
        $output['historialMedico'] = $this->historialMedico;

        return json_encode($output);
    }

    public static function tomarDatoPaciente(){
        echo "Nombre del paciente: ";
        $nombre = trim(fgets(STDIN));
        echo "Apellido del paciente: ";
        $apellido = trim(fgets(STDIN));
        echo "DNI del paciente: ";
        $dni = trim(fgets(STDIN));

        $paciente = new Paciente($nombre, $apellido, $dni);
        return $paciente;
    }
    
}