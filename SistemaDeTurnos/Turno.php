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

    public function getMedico() {
        return $this->medico;
    }

    public function getPaciente() {
        return $this->paciente;
    }

    public function mostrarInformacion() {
        return "Turno: {$this->fecha}, Médico: {$this->medico->getNombreCompleto()}, Paciente: {$this->paciente->getNombreCompleto()}";
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