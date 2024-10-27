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

    public function listar(){
        return $this->getNombreCompleto()."\nMatricula: ".$this->getMatricula()." Especialidad:".$this->getEspecialidad()."\n";
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

    public static function tomarDatoMedico(){
        echo "Nombre del médico: ";
        $nombre = trim(fgets(STDIN));
        echo "Apellido del médico: ";
        $apellido = trim(fgets(STDIN));
        echo "DNI del médico: ";
        $dni = trim(fgets(STDIN));
        echo "Especialidad del médico: ";
        $especialidad = trim(fgets(STDIN));
        echo "Matricula del médico: ";
        $matricula = trim(fgets(STDIN));

        $medico = new Medico($nombre, $apellido, $dni, $especialidad,$matricula);
        return $medico;
    }

    public static function seleccionarMedico(){
        echo "seleccione el medico: ";
        $m = trim(fgets(STDIN));
        return $m;
    }

    public static function seleccionarEspecialidad(){
        echo "seleccione una especialidad: ";
        $e = trim(fgets(STDIN));
        return $e;
    }
    
}