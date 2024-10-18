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
        return $this->turnos[] = $turno;
    }

    public function turnosXdia() {
        if (empty($this->turnos)) {
            echo "No hay turnos agendados.";
        }else{
            $fecha = $this->buscarFecha();
            if (isset($fecha)) {
                foreach ($this->turnos as $turno) {
                    if ($turno->getFecha() == $fecha) {
                        $turnoDia[] = $turno;
                    }
                } 
                return $turnoDia;
            }else{
                echo "No hay turnos registrados en la fecha: $fecha";
            }
        }
    }

    public function mostrarDia() {
        $dia = $this->turnosXdia();
        foreach ($dia as $d) {
            echo $d->mostrarInformacion();
        }
    }

    public function turnosDisponibles() {
        $dia = $this->turnosXdia();
        echo "  Turnos del dia   \n";
        echo "===================\n";
        
            for ($i=10; $i <20 ; $i++) { 
                $condicion = true;
                $hora = "{$i}hs";
                foreach ($dia as $d){
                    if($hora == $d->getHora()){
                        $condicion = false;
                    }
                }
                if ($condicion) {
                    echo "$i:00hs Disponible\n";
                } else {
                    echo "$i:00hs Tomado\n";
            }
        }
    }        
    
    public function tomarDatoPaciente(){
        echo "Nombre del paciente: ";
        $nombre = trim(fgets(STDIN));
        echo "Apellido del paciente: ";
        $apellido = trim(fgets(STDIN));
        echo "DNI del paciente: ";
        $dni = trim(fgets(STDIN));

        $paciente = new Paciente($nombre, $apellido, $dni);
        return $paciente;
    }

    public function agregarPaciente(){
        $paciente = $this->tomarDatoPaciente();
        $this->pacientes[]= $paciente;
        echo "Paciente agregado: {$paciente->getNombreCompleto()}\n";
    }

    public function tomarDatoMedico(){
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

    public function agregarMedico() {
        $medico = $this->tomarDatoMedico();
        $this->medicos[] = $medico;
        echo "Médico agregado: {$medico->getNombreCompleto()} - Especialidad: {$medico->getEspecialidad()}\n";
    }
    
    public function llenarHistorial() {
        $dni = $this->buscarDni();
        if ($dni) {
            foreach ($this->pacientes as $paciente) {
                if ($paciente->getDni() == $dni) {
                    echo "Agregar a Historia Clinica: ";
                    $entrada = trim(fgets(STDIN));
                    $paciente->setHistorialMedico($entrada);
                } 
            }
        }else{
            echo "Paciente no encontrado";
        }
    }

    public function buscarDni() {
        echo "Buscar Paciente por Dni: ";
        $dni = trim(fgets(STDIN));
        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni){
                return $dni;
            }
        }
    }

    public function obtenerHistorial() {
        $dni = $this->buscarDni();
        if ($dni) {
            foreach ($this->pacientes as $paciente) {
                if($paciente->getDni() == $dni) {
                    $paciente->gethistorialMedico();
                }
            } 
        }else{
            echo "Paciente no encontrado";
        }
    }

    public function mostrarHistorial() {
        $dni = $this->buscarDni();
        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni) {
                echo $paciente->gethistorialMedico();
                echo "\n";
            }     
        } 
    }       
    
    public function sacarTurno(){
        $dni = $this->buscarDni();
        if (isset($dni)) {
            foreach ($this->pacientes as $paciente) {
                if ($paciente->getDni() == $dni) {
                    echo "Ingresa una fecha (dd-mm-YYYY): ";
                    $fecha = trim(fgets(STDIN));
                    if ($this->validarFecha($fecha)) {
                        echo
                        $this->listarMedicos();
                        echo "seleccione el medico: ";
                        $medico = trim(fgets(STDIN));
                        echo "seleccione un horario: ";
                        $hora = trim(fgets(STDIN));
                        $turno = new Turno($fecha, $hora, $medico,$paciente->getDni());
                        $this->turnos[] = $turno;
                        echo "Turno generado con exito.\n";
                        echo $turno->turnoExitoso();
                    }else{
                        echo "Ingreso de fecha invalido. recuerde!!! (dd-mm-YYYY)";
                    }
                }
            } 
        }else{
            echo "No se encontro un paciente con el siguiente DNI: $dni";
        }
    }

    public function buscarFecha() {
        echo "Ingrese la fecha del turno (dd-mm-YYYY): ";
        $fecha = trim(fgets(STDIN));

        if ($this->validarFecha($fecha)) {
            foreach ($this->turnos as $key => $turno) {
                if ($turno->getFecha() == $fecha) {
                    return $fecha;
                }
            }
        }
        return false;
    }

    public function validarFecha($fecha) {
        $patron = '/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(\d{4})$/';
        
        if (preg_match($patron, $fecha)) {
            list($dia, $mes, $anio) = explode('-', $fecha);
        
            if (checkdate($mes, $dia, $anio)) {
                return true;
            }
        }      
        return false;
    }
        
    public function anularTurno() {
        $dni = $this->buscarDni();
        $fecha = $this->buscarFecha();
        if (isset($fecha)) {
            foreach ($this->turnos as $key => $turno) {
                if ($turno->getFecha() == $fecha && $turno->getPaciente() == $dni) {
                    unset($this->turnos[$key]);
                    echo "Turno cancelado.";
                }
            }
        }else{
            echo "No se encontró el turno para cancelar.";
        }
    }

    public function listarMedicos() {
        echo "Listado de Medicos\n";
        echo "===================\n";
        
        foreach ($this->medicos as $medico) {
            echo $medico->listar();
            echo "\n";
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

        if (file_exists($filename)) {
            
            $json = file_get_contents($filename);
            
            if (empty($filename)) {
                echo "El JSON está vacío.";
            }else{
                $datos = json_decode($json, true);

                $this->leerPacientes($datos);
                $this->leerMedicos($datos);
                $this->leerTurnos($datos); 
            }
        } else {
            echo "El archivo no existe.";
        }
    }

    public function leerPacientes($data){
        if (isset($data['pacientes']) && is_array($data['pacientes'])) {
            foreach ($data['pacientes'] as $pacienteString) {
                $paciente = json_decode($pacienteString, true);
                
                $p = new Paciente($paciente["nombre"],$paciente["apellido"],$paciente["dni"]);
                $p->setHistorialMedico($paciente['historialMedico']);
                $this->pacientes[] = $p;
            }
        }
    }

    public function leerMedicos($data){
        if (isset($data['medicos']) && is_array($data['medicos'])) {
            foreach ($data['medicos'] as $medicoString) {
                $medico = json_decode($medicoString, true);
                
                $m = new Medico($medico["nombre"],$medico["apellido"],$medico["dni"],$medico["especialidad"],$medico["matricula"]);
                $this->medicos[] = $m;
            }
        }
    }

    public function leerTurnos($data){
        if (isset($data['turnos']) && is_array($data['turnos'])) {
            foreach ($data['turnos'] as $turnoString) {
                $turno = json_decode($turnoString, true);
                
                $t = new Turno($turno["fecha"],$turno["hora"],$turno["medico"],$turno["paciente"]);
                $this->turnos[] = $t;
            }
        }
    }    
 
}