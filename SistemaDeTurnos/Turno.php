<?php

class Turno {
    private $fecha;
    private $hora;
    private $medico;
    private $paciente;

    public function __construct($fecha, $hora, $medico, $paciente) {
        $this->fecha = $fecha;
        $this->hora = $hora;
        $this->medico = $medico;
        $this->paciente = $paciente;
    }

    public function getFecha() {
        return $this->fecha;
    }

    public function getHora() {
        return $this->hora;
    }

    public function getMedico() {
        return $this->medico;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function turnoExitoso(){
        return "Turno: {$this->fecha} {$this->hora}hs, Médico: {$this->getMedico()}";
    }

    public function mostrarInformacion() {
        return "Turno: {$this->fecha} {$this->hora}hs.\nMédico: {$this->getMedico()}\nPaciente: {$this->getPaciente()}\n\n";
    }

    public function getJson(){
        $output = [];
        $output['fecha'] = $this->fecha;
        $output['hora'] = $this->hora;
        $output['medico'] = $this->medico;
        $output['paciente'] = $this->paciente;

        return json_encode($output);
    }

    public static function seleccionarHorario(){
        echo "Ingrese una hora: ";
        $h = trim(fgets(STDIN));
        return $h;
    }

    public static function seleccionarFecha(){
        echo "Ingresa una fecha (dd-mm-YYYY): ";
        $f = trim(fgets(STDIN));
        return $f;
    }

    public static function validarFecha($fecha) {
        $patron = '/^(0[1-9]|[12][0-9]|3[01])-(0[1-9]|1[0-2])-(\d{4})$/';
        
        if (preg_match($patron, $fecha)) {
            list($dia, $mes, $anio) = explode('-', $fecha);
        
            if (checkdate($mes, $dia, $anio)) {
                return true;
            }
        }      
        return false;
    }

}