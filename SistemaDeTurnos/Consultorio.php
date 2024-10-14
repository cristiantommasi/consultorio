<?php

require_once("Turno.php");
require_once("Paciente.php");
require_once("Persona.php");
require_once("Medico.php");
 

class Consultorio {
    protected $turnos; // Array para almacenar todos los turnos
    protected $medicos; // Array para almacenar todos los medicos
    protected $pacientes; // Array para almacenar todos los pacientes

    public function __construct() {
        
        $this->turnos = [];
        $this->medicos = [];
        $this->pacientes = [];
    }


    public function agregarTurno(Turno $turno) {
        $this->turnos[] = $turno;
    }

    public function obtenerTurnos() {
        return $this->turnos;
    }

    public function mostrarTurnos() {
        if (empty($this->turnos)) {
            echo "No hay turnos agendados.";
        }

        $informacion = "Turnos en el Consultorio:\n";
        foreach ($this->turnos as $turno) {
            $informacion .= $turno->mostrarInformacion() . "\n";
        }
        return $informacion;
    }


    public function agregarPaciente(){
        echo "Nombre del paciente: ";
        $nombre = trim(fgets(STDIN));
        echo "Apellido del paciente: ";
        $apellido = trim(fgets(STDIN));
        echo "DNI del paciente: ";
        $dni = trim(fgets(STDIN));

        $paciente = new Paciente($nombre, $apellido, $dni);
        echo "Paciente agregado: {$paciente->getNombreCompleto()}\n";

        $this->pacientes[]= $paciente;
    }

    public function agregarMedico() {
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
        echo "Médico agregado: {$medico->getNombreCompleto()} - Especialidad: {$medico->getEspecialidad()}\n";

        $this->medicos[] = $medico;
    }
    
    public function llenarHistorial() {
        echo "Buscar Paciente por Dni: ";
        $dni = trim(fgets(STDIN));
        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni) {
                echo "Agregar a Historia Clinica: ";
                $entrada = trim(fgets(STDIN));
                $paciente->setHistorialMedico($entrada);
            } 
        }  
    }

    public function obtenerHistorial() {
        echo "Buscar Paciente por Dni: ";
        $dni = trim(fgets(STDIN));
        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni) {
                $paciente->gethistorialMedico();
            } else {
                echo "{No se encontro el Historial Medico del paciente $dni }";
            }
        }       
    }

    public function mostrarHistorial() {
        echo "Buscar Paciente por Dni: ";
        $dni = trim(fgets(STDIN));
        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni) {
                echo $paciente->gethistorialMedico();
                echo "\n";
            }     
        } 
    }       
    

    public function sacarTurno(){
        echo "DNI del paciente: ";
        $dni = trim(fgets(STDIN));

        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni) {
                echo "Ingresa una fecha (dd-mm-YYYY): ";
                $fecha = trim(fgets(STDIN));
                echo "ingresa el nombre del medico: ";
                $medico = trim(fgets(STDIN));
                echo "seleccione un horario: ";
                $hora = trim(fgets(STDIN));
                $turno = new Turno($fecha, $hora, $medico,$paciente->getNombreCompleto());
                $this->turnos[] = $turno;
                echo "Turno generado con exito.";
            }
        }
    }

    public function anularTurno() {
        echo "Ingrese su DNI: ";
        $dni = trim(fgets(STDIN));
        echo "Ingrese la fecha del turno: ";
        $fecha = trim(fgets(STDIN));
        foreach ($this->turnos as $key => $turno) {
            if ($turno->getFecha() === $fecha && $turno->getPaciente()->dni === $dni) {
                unset($this->turnos[$key]);
                echo "Turno cancelado.";
            }
        }
        //return "No se encontró el turno para cancelar.";
    }

    public function listarMedicos() {
        echo "Listado de Medicos\n";
        echo "===================\n";
        
        foreach ($this->medicos as $medico) {
            echo $medico->getNombreCompleto()."\nEspecialidad:".$medico->getEspecialidad()."\nMatricula: ".$medico->getMatricula();
            echo "\n\n";
        }       
    }

    public function getTurnos() {
        
        echo "Ingrese la fecha del turno: ";
        $fecha = trim(fgets(STDIN));

        echo "Listado de Turnos del dia $fecha\n";
        echo "===================\n";
        
        foreach ($this->turnos as $turno) {
            if ($turno->getFecha() === $fecha) {
                echo $turno->getFecha();
            }     
        }
    }

    public function listarPacientes() {
        
        
        foreach ($this->pacientes as $paciente) {
            echo $paciente->getNombreCompleto();
            echo "\n";

        }       
    }

    public function getJson(){
        $output = [];
        $output['pacientes'] = [];
        $output['medicos'] = [];
        $output['turnos'] = [];

        foreach($this->pacientes as $paciente){
            $output['pacientes'][]=$paciente->getJson();
        }

        foreach($this->medicos as $medico){
            $output['medicos'][]=$medico->getJson();
        }

        foreach($this->turnos as $turno){
            $output['turnos'][]=$turno->getJson();
        }

        return json_encode($output);
    }

    public function leer($filename){

        $json = file_get_contents($filename);
        $texto = json_decode($json);

        foreach($texto->pacientes as $paciente){
            
            $p = new Paciente($paciente->nombre,$paciente->apellido,$paciente->dni);
            $p->$paciente->historialMedico;
            $this->pacientes[] = $p;
        }      
    }
   
}