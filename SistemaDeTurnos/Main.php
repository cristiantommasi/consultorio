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
                        $consultorio->sacarTurno();break;//lograda. Faltaria comprobar que no hay turno en ese horario para TOMARLO
                    case "2":
                        $consultorio->anularTurno();break;//lograda
                    case "3":
                        $consultorio->turnosDisponibles();break;//lograda
                    case "4":
                        $consultorio->listarMedicos();break;//lograda
                    case "5":
                        $consultorio->listarMedicosXespecialidad();break;//lograda
                } 
                Menu::pressEnter();
                Menu::cls(); break;
            
            case 2: $subMenu = Menu::getMenuMedicos();
            Menu::cls();
            $medico = $subMenu->elegir();
                switch ($medico) {
                    case '1':
                        $consultorio->mostrarDia();break;//lograda
                    case "2":
                        $consultorio->mostrarHistorial();break;//lograda
                    case "3":
                        $consultorio->llenarHistorial();break;//lograda
                }
                Menu::pressEnter();
                Menu::cls(); break;
            
            case 3: $subMenu = Menu::getMenuAdministrador();
            Menu::cls();
            $admin = $subMenu->elegir();
                switch ($admin) {
                    case '1':
                        $consultorio->agregarPaciente();break;//lograda
                    case "2":
                        $consultorio->agregarMedico();break;//lograda
                    case "3":    
                        $consultorio->sacarTurno();break;//lograda
                    case "4":
                        $consultorio->anularTurno();break;//lograda
                    case "5":
                        $consultorio->turnosDisponibles();break;
                }
                Menu::pressEnter();
                Menu::cls(); break;
        }    
    } while ($opcion != 0);

    $json_str = $consultorio->getJson(); 
    file_put_contents('consultorio.json', $json_str);

    echo "Adios!\n";       