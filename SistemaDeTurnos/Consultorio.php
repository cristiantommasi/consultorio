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

    public function buscarFecha() { 
        
        $fecha = Turno::seleccionarFecha();

        if (Turno::validarFecha($fecha)) {
            foreach ($this->turnos as $key => $turno) {
                if ($turno->getFecha() == $fecha) {
                    return $fecha;
                }
            }
        }
        return false;
    }

    public function mostrarDia() {
        $dia = $this->turnosXdia();
        foreach ($dia as $d) {
            echo $d->mostrarInformacion();
        }
    }

    public function turnosXdia() {
        if (empty($this->turnos)) {
            echo "No hay turnos agendados.";
        }else{
            $fecha = $this->buscarFecha();
            $medico = Medico::seleccionarMedico();
            if (isset($fecha)) {
                foreach ($this->turnos as $turno) {
                    if ($turno->getFecha() == $fecha && $medico == $turno->getMedico()) {
                        $turnoDia[] = $turno;
                    }
                } 
                return $turnoDia;
            }else{
                echo "No hay turnos registrados en la fecha: $fecha";
            }
        }
    }

    public function turnosDisponibles() {
        $dia = $this->turnosXdia();
        echo "  Turnos del dia   \n";
        echo "===================\n";
        
            for ($i=10; $i <20 ; $i++) { 
                $condicion = true;
                $hora = $i;
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

    public function comprobarTurno($m,$f,$h){
        $comprobar = true;

        foreach($this->turnos as $turno){
            if($turno->getFecha() == $f && $turno->getHora() == $h && $turno->getMedico() == $m){
                $comprobar = false;
            }
        }
        return $comprobar;
    }

    public function sacarTurno(){
        $dni = $this->buscarDni();
        if (isset($dni)) {
            foreach ($this->pacientes as $paciente) {
                if ($paciente->getDni() == $dni) {
                    $fecha = Turno::seleccionarFecha();
                    if (Turno::validarFecha($fecha)) {
                        $this->listarMedicosXespecialidad();
                        $medico = Medico::seleccionarMedico();
                        $hora = Turno::seleccionarHorario();
                        if($this->comprobarTurno($medico, $fecha,$hora)){
                            $turno = new Turno($fecha, $hora, $medico,$paciente->getDni());
                            $this->turnos[] = $turno;
                            echo "Turno generado con exito.\n";
                            echo $turno->turnoExitoso();
                        }else{
                            echo "Ya hay un turno TOMADO en ese horario.";
                        }
                    }else{ 
                        echo "Ingreso de fecha invalido. recuerde!!! (dd-mm-YYYY)";
                    }
                }
            } 
        }else{ 
            echo "No se encontro el paciente.";
        }
    }

    public function anularTurno() {
        $dni = $this->buscarDni();
        $fecha = $this->buscarFecha();
        $medico = Medico::seleccionarMedico();
        if (isset($fecha)) {
            foreach ($this->turnos as $key => $turno) {
                if ($turno->getFecha() == $fecha && $turno->getPaciente() == $dni && $turno->getMedico() == $medico) {
                    unset($this->turnos[$key]);
                    echo "Turno cancelado.";
                }
            }
        }else{
            echo "No se encontró el turno para cancelar.";
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
        return false;
    }
    
    public function agregarPaciente(){
        $paciente = Paciente::tomarDatoPaciente();
        $this->pacientes[]= $paciente;
        echo "Paciente agregado: {$paciente->getNombreCompleto()}\n";
    }

    public function agregarMedico() {
        $medico = Medico::tomarDatoMedico();
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

    public function mostrarHistorial() {
        $dni = $this->buscarDni();
        foreach ($this->pacientes as $paciente) {
            if ($paciente->getDni() == $dni) {
                echo $paciente->gethistorialMedico();
                echo "\n";
            }     
        } 
    }  
    
    public function listarMedicos() {
        echo "Listado de Medicos\n";
        echo "==================\n";
        
        foreach ($this->medicos as $medico) {
            echo $medico->listar();
            echo "\n";
        }       
    }

    public function listarMedicosXespecialidad() {
        
        $especilidad = Medico::seleccionarEspecialidad();
        
        if($this->comprobarEspecialidad($especilidad)){
            echo "Listado de Medicos por Especialidad\n";
            echo "===================================\n";
            foreach ($this->medicos as $medico) {
                if($medico->getEspecialidad() == $especilidad)
                echo $medico->listar();
                echo "\n";
            }       
        }else{
            echo "No tenemos un Especialista para esa Especialidad";
        }
    }

    public function comprobarEspecialidad($especialidad){
        $comprobar = false;

        foreach( $this->medicos as $medico){
            if($medico->getEspecialidad() == $especialidad);
            $comprobar = true;
        }
        return $comprobar;
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