<?php

require_once("../bo/AvionBo.php");
require_once("../domain/Avion.php");


/**
 * This class contain all services methods of the table Avion
 * @author ChGari
 * Date Last  modification: Fri Jul 24 11:28:43 CST 2020
 * Comment: It was created
 *
 */
//************************************************************
// Avion Controller 
//************************************************************

if (filter_input(INPUT_POST, 'action') != null) {
    $action = filter_input(INPUT_POST, 'action');

    try {
        $myAvionBo = new AvionBo();
        $myAvion = Avion::createNullAvion();

        //***********************************************************
        //choose the action
        //***********************************************************

        if ($action === "add_Avion" or $action === "update_Avion") {
            //se valida que los parametros hayan sido enviados por post
            if ((filter_input(INPUT_POST, 'idAvion') != null) && (filter_input(INPUT_POST, 'Fecha') != null) && (filter_input(INPUT_POST, 'Modelo') != null) && (filter_input(INPUT_POST, 'Marca') != null)&& (filter_input(INPUT_POST, 'Fila') != null)&& (filter_input(INPUT_POST, 'Asiento_Fila') != null)) {
                $myAvion->setidAvion(filter_input(INPUT_POST, 'idAvion'));
                $myAvion->setFecha(filter_input(INPUT_POST, 'Fecha'));
                $myAvion->setModelo(filter_input(INPUT_POST, 'Modelo'));
                $myAvion->setMarca(filter_input(INPUT_POST, 'Marca'));
                $myAvion->setFila(filter_input(INPUT_POST, 'Fila'));
                $myAvion->setAsiento_Fila(filter_input(INPUT_POST, 'Asiento_Fila'));
                
                if ($action == "add_Avion") {
                    $myAvionBo->add($myAvion);
                    echo('M~Registro Incluido Correctamente');
                }
                if ($action == "update_Avion") {
                    $myAvionBo->update($myAvion);
                    echo('M~Registro Modificado Correctamente');
                }
            }
        }

        //***********************************************************
        //***********************************************************

        if ($action === "showAll_Avion") {//accion de consultar todos los registros
            $resultDB   = $myAvionBo->getAll();
            $json       = json_encode($resultDB->GetArray());
            $resultado = '{"data": ' . $json . '}';
            if($resultDB->RecordCount() === 0){
                $resultado = '{"data": []}';
            }
            echo $resultado;
        }

        //***********************************************************
        //***********************************************************

        
        if ($action === "show_Avion") {//accion de mostrar cliente por ID
            //se valida que los parametros hayan sido enviados por post
            if (filter_input(INPUT_POST, 'idAvion') != null) {
                $myAvion->setidAvion(filter_input(INPUT_POST, 'idAvion'));
                $myAvion = $myAvionBo->searchById($myAvion);
                if ($myAvion != null) {
                    echo json_encode(($myAvion));
                } else {
                    echo('E~NO Existe un cliente con el ID especificado');
                }
            }
        }

        //***********************************************************
        //***********************************************************

        if ($action === "delete_Avion") {//accion de eliminar cliente por ID
            //se valida que los parametros hayan sido enviados por post
            if (filter_input(INPUT_POST, 'idAvion') != null) {
                $myAvion->setidAvion(filter_input(INPUT_POST, 'idAvion'));
                $myAvionBo->delete($myAvion);
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