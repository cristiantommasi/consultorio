<?php
   
    require_once("Consultorio.php");
    require_once("Menu.php");

    
    
    $consultorio = new Consultorio();
    $consultorio->leer('consultorio.json');

    $menu = Menu::getMenuConsultorio();

    do {
        
        $opcion = $menu->elegir();

        switch ($opcion) {
            case 1: $subMenu = Menu::getMenuPacientes();
            Menu::cls();
            $paciente = $subMenu->elegir();
                switch ($paciente) {
                    case '1':
                        //lograda
                        $consultorio->sacarTurno();
                        break;
                    case "2":
                        //revisar
                        $consultorio->anularTurno();
                        break;
                    case "3":
                        echo "ingrese fecha";
                        break;
                    case "4":
                        //lograda
                        $consultorio->listarMedicos();
                        break;
                } 
                Menu::pressEnter();
                Menu::cls(); break;
            
            case 2: $subMenu = Menu::getMenuMedicos();
            Menu::cls();
            $medico = $subMenu->elegir();
                switch ($medico) {
                    case '1':
                        //completar
                        $consultorio->getTurnos();
                        break;
                    case "2":
                        //lograda
                        $consultorio->mostrarHistorial();
                        break;
                    case "3":
                        //lograda
                        $consultorio->llenarHistorial();
                        break;
                }
                Menu::pressEnter();
                Menu::cls(); break;
            
            case 3: $subMenu = Menu::getMenuAdministrador();
            Menu::cls();
            $admin = $subMenu->elegir();
                switch ($admin) {
                    case '1':
                        //lograda
                        $consultorio->agregarPaciente();
                        break;
                    case "2":
                        //lograda
                        $consultorio->agregarMedico();
                        break;
                    case "3":
                        //lograda
                        $consultorio->sacarTurno();
                        break;
                    case "4":
                        $consultorio->anularTurno();
                        break;
                    case "5":
                        echo "Ver Turnos por Fecha";
                        break;
                }
                Menu::pressEnter();
                Menu::cls(); break;
        }    
    } while ($opcion != 0);

    $json_str = $consultorio->getJson();
    file_put_contents('consultorio.json', $json_str);


 

    echo ("Adios!\n");       