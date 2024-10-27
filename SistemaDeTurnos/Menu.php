<?php

    class Menu {
        private $titulo;
        private $opciones;

        public function __construct($titulo) {
            $this->titulo = $titulo;
        }

        public function addOpcion($valor, $descripcion) {

            $this->opciones[] = [$valor, $descripcion];
            
        }

        public function elegir() {
            echo $this->titulo."\n";
            echo ("============\n");

            foreach ($this->opciones as $opcion) {
                echo "\033[31m";
                echo $opcion[0];
                echo "\033[0m";
                
                echo '-';
                echo $opcion[1];
                echo "\n";
            }

            echo ("Ingrese opcion: ");
            $opcion = fgets(STDIN);    
            echo ("\n");            

            return $opcion;
        }

        static function getMenuConsultorio() {
            $menu = new Menu("Sistema de Turnos");
            
            $menu->addOpcion(0, 'Salir');
            $menu->addOpcion(1, 'Paciente');
            $menu->addOpcion(2, 'Medico');
            $menu->addOpcion(3, 'Administrador');
            
            return $menu;
        }

        static function getMenuPacientes() {
            $menu = new Menu('Pacientes');

            $menu->addOpcion(0, 'Volver'); 
            $menu->addOpcion(1, 'Tomar Turno'); 
            $menu->addOpcion(2, 'Cancelar Turno'); 
            $menu->addOpcion(3, 'Consultar Turnos Disponibles'); 
            $menu->addOpcion(4, 'Ver todos los Medicos'); 
            $menu->addOpcion(5, 'Ver Medicos por Especialidad'); 

            return $menu;
        }

        static function getMenuMedicos() {
            $menu = new Menu('Medicos');

            $menu->addOpcion(0, 'Volver'); 
            $menu->addOpcion(1, 'Ver Turnos tomados por Fecha'); 
            $menu->addOpcion(2, 'Ver Historia Clinica de Paciente'); 
            $menu->addOpcion(3, 'Cargar Historia Clinica de Paciente'); 

            return $menu;
        }

        static function getMenuAdministrador() {
            $menu = new Menu('Administrador');

            $menu->addOpcion(0, 'Volver'); 
            $menu->addOpcion(1, 'Agregar Paciente'); 
            $menu->addOpcion(2, 'Agregar Medico'); 
            $menu->addOpcion(3, 'Agregar Turno'); 
            $menu->addOpcion(4, 'Anular Turno'); 
            $menu->addOpcion(5, 'Ver Turnos por Fecha'); 

            return $menu;
        }

        public static function pressEnter() {
            echo "\n\nPresiona Enter para continuar...";
            fgets(STDIN);
        }
        
        public static function cls(){
            if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
                popen('cls', 'w');//system("cls");
            } else {
                system("clear");
            }
        }


    }