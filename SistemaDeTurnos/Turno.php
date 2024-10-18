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

    public function getTurno() {
        return $this;
    }

    public function getMedico() {
        return $this->medico;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function turnoExitoso(){
        return "Turno: {$this->fecha} {$this->hora}hs. , Médico: {$this->getMedico()}";
    }

    public function mostrarInformacion() {
        return "Turno: {$this->fecha} {$this->hora}.\nMédico: {$this->getMedico()}\nPaciente: {$this->getPaciente()}\n\n";
    }

    public function getJson(){
        $output = [];
        $output['fecha'] = $this->fecha;
        $output['hora'] = $this->hora;
        $output['medico'] = $this->medico;
        $output['paciente'] = $this->paciente;

        return json_encode($output);
    }

}