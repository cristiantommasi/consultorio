<?php

class Sala {
    private $nombre;
    private $turnos;

    public function __construct($nombre) {
        $this->nombre = $nombre;
        $this->turnos = [];
    }

    public function getNombre() {
        return $this->nombre;
    }


    public function getTurnos() {
        return $this->turnos;
    }

}