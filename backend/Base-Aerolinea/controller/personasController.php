<?php

require_once("../bo/PersonaBo.php");
require_once("../domain/Persona.php");


/**
 * This class contain all services methods of the table Persona
 * @author ChGari
 * Date Last  modification: Fri Jul 24 11:28:43 CST 2020
 * Comment: It was created
 *
 */
//************************************************************
// Persona Controller 
//************************************************************

if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    try {
        $myPersonaBo = new PersonaBo();
        $myPersona = Persona::createNullPersona();

        //***********************************************************
        //choose the action
        //***********************************************************

        if ($action === "add_Persona" or $action === "update_Persona") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'PK_cedula') != null) && (filter_input(INPUT_POST, 'nombre') != null) && (filter_input(INPUT_POST, 'apellido1') != null) && (filter_input(INPUT_POST, 'apellido2') != null) && (filter_input(INPUT_POST, 'fecNacimiento') != null) && (filter_input(INPUT_POST, 'sexo') != null)) {
                $myPersona->setPK_cedula(filter_input(INPUT_POST, 'PK_cedula'));
                $myPersona->setnombre(filter_input(INPUT_POST, 'nombre'));
                $myPersona->setapellido1(filter_input(INPUT_POST, 'apellido1'));
                $myPersona->setapellido2(filter_input(INPUT_POST, 'apellido2'));
                $myPersona->setfecNacimiento(filter_input(INPUT_POST, 'fecNacimiento'));
                $myPersona->setsexo(filter_input(INPUT_POST, 'sexo'));
                $myPersona->setlastUser('YO');
                if ($action == "add_Persona") {
                    $myPersonaBo->add($myPersona);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_Persona") {
                    $myPersonaBo->update($myPersona);
                    echo('M~Registro Modificado Correctamente');
                }
            }
        }

        //***********************************************************
        //***********************************************************

        if ($action === "showAll_Persona") {//accion de consultar todos los registros
            $resultDB   = $myPersonaBo->getAll();
            $json       = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if($resultDB->RecordCount() === 0){
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        //***********************************************************
        //***********************************************************

        
        if ($action === "show_Persona") {//accion de mostrar cliente por ID
            //se valida que los parametros hayan sido enviados por post
            if (filter_input(INPUT_POST, 'PK_cedula') != null) {
                $myPersona->setPK_cedula(filter_input(INPUT_POST, 'PK_cedula'));
                $myPersona = $myPersonaBo->searchById($myPersona);
                if ($myPersona != null) {
                    echo json_encode(($myPersona));
                } else {
                    echo('E~NO Existe un cliente con el ID especificado');
                }
            }
        }

        //***********************************************************
        //***********************************************************

        if ($action === "delete_Persona") {//accion de eliminar cliente por ID
            //se valida que los parametros hayan sido enviados por post
            if (filter_input(INPUT_POST, 'PK_cedula') != null) {
                $myPersona->setPK_cedula(filter_input(INPUT_POST, 'PK_cedula'));
                $myPersonaBo->delete($myPersona);
                echo('M~Registro Fue Eliminado Correctamente');
            }
        }

        //***********************************************************
        //se captura cualquier error generado
        //***********************************************************
    } catch (Exception $e) { //exception generated in the business object..
        echo("E~" . $e->getMessage());
    }
} else {
    echo('M~Parametros no enviados desde el formulario'); //se codifica un mensaje para enviar
}
?>
