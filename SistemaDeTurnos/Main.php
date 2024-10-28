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
                        $consultorio->sacarTurno();break;
                    case "2":
                        $consultorio->anularTurno();break;
                    case "3":
                        $consultorio->turnosDisponibles();break;
                    case "4":
                        $consultorio->listarMedicos();break;
                    case "5":
                        $consultorio->listarMedicosXespecialidad();break;
                } 
                Menu::pressEnter();
                Menu::cls(); break;
            
            case 2: $subMenu = Menu::getMenuMedicos();
            Menu::cls();
            $medico = $subMenu->elegir();
                switch ($medico) {
                    case '1':
                        $consultorio->mostrarDia();break;
                    case "2":
                        $consultorio->mostrarHistorial();break;
                    case "3":
                        $consultorio->llenarHistorial();break;
                }
                Menu::pressEnter();
                Menu::cls(); break;
            
            case 3: $subMenu = Menu::getMenuAdministrador();
            Menu::cls();
            $admin = $subMenu->elegir();
                switch ($admin) {
                    case '1':
                        $consultorio->agregarPaciente();break;
                    case "2":
                        $consultorio->agregarMedico();break;
                    case "3":
                        $consultorio->bajaMedico();break;
                    case "4":    
                        $consultorio->sacarTurno();break;
                    case "5":
                        $consultorio->anularTurno();break;
                    case "6":
                        $consultorio->turnosDisponibles();break;
                }
                Menu::pressEnter();
                Menu::cls(); break;
        }    
    } while ($opcion != 0);

    $json_str = $consultorio->getJson(); 
    file_put_contents('consultorio.json', $json_str);

    echo "Adios!\n";       