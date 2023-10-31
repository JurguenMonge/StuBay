<?php

include '../business/calificacionVendedorBusiness.php';
session_start();
if (isset($_POST['update'])) {
    if (
        isset($_POST['calificacionvendedoridview']) &&
        isset($_POST['subastaidview']) &&
        isset($_POST['clienteidview']) &&
        isset($_POST['vendedoridview']) &&
        isset($_POST['calificacionvendedorpuntosview']) &&
        isset($_POST['calificacionvendedorcomentariosview'])
    ) {
        // echo '<br> calificacionvendedorid' . $_POST['calificacionvendedoridview'];
        // echo '<br> subastaid' . $_POST['subastaidview'];
        // echo '<br> clienteid' . $_POST['clienteidview'];
        // echo '<br> vendedorid' . $_POST['vendedoridview'];
        // echo '<br> calificacionvendedorpuntos' . $_POST['calificacionvendedorpuntosview'];
        // echo '<br> calificacionvendedorcomentarios' . $_POST['calificacionvendedorcomentariosview'];
        // exit();
        $calificacionVendedorId = $_POST['calificacionvendedoridview'];
        $subastaId = $_POST['subastaidview'];
        $clienteId = $_POST['clienteidview'];
        $calificacionVendedorClienteId = $_POST['vendedoridview'];
        $calificacionVendedorPuntos = $_POST['calificacionvendedorpuntosview'];
        $calificacionVendedorComentarios = $_POST['calificacionvendedorcomentariosview'];


        if (
            strlen($calificacionVendedorId) > 0 &&
            strlen($subastaId) > 0 &&
            strlen($clienteId) > 0 &&
            strlen($calificacionVendedorClienteId) > 0 &&
            strlen($calificacionVendedorPuntos) > 0 &&
            strlen($calificacionVendedorComentarios) > 0

        ) {
            $calificacionVendedor = 
            new CalificacionVendedor(
                $calificacionVendedorId,
                $subastaId,
                $clienteId,
                $calificacionVendedorClienteId,
                $calificacionVendedorPuntos,
                $calificacionVendedorComentarios
            );

            $calificacionVendedorBusiness = new CalificacionVendedorBusiness();

            $result = $calificacionVendedorBusiness->updateTBCalificacionVendedor($calificacionVendedor);

            if ($result == 1) {
                header("location: ../view/calificacionVendedorView.php?success=update");
                session_start();
                $_SESSION['msj'] = "Se ha actualizado correctamente";
            } else if ($result == 2) {
                header("location: ../view/calificacionVendedorView.php?error=update");
                session_start();
                $_SESSION['msj'] = "No se pudo actualizar";
            } else {
                header("location: ../view/calificacionVendedorView.php?error=dbError");
                session_start();
                $_SESSION['msj'] = "Error desconocido";
            }
        } else {
            header("location: ../view/calificacionVendedorView.php?error=emptyField");
            session_start();
            $_SESSION['msj'] = "Existen campos vacíos";
        }
    } else {
        header("location: ../view/calificacionVendedorView.php?error=error");
        session_start();
        $_SESSION['msj'] = "Error desconocido";
    }
} else if (isset($_POST['delete'])) {
    if (isset($_POST['calificacionvendedoridview'])){
        $calificacionVendedorId = $_POST['calificacionvendedoridview'];

        if (strlen($calificacionVendedorId) > 0){
            $calificacionVendedorBusiness = new CalificacionVendedorBusiness();

            $result = $calificacionVendedorBusiness->deleteTBCalificacionVendedor($calificacionVendedorId);

            if ($result == 1) {
                header("location: ../view/calificacionVendedorView.php?success=delete");
                session_start();
                $_SESSION['msj'] = "Se ha eliminado correctamente";
            } else if ($result == 0) {
                header("location: ../view/calificacionVendedorView.php?error=delete");
                session_start();
                $_SESSION['msj'] = "No se pudo eliminar";
            } else {
                header("location: ../view/calificacionVendedorView.php?error=dbError");
                session_start();
                $_SESSION['msj'] = "Error desconocido";
            }
        }
    }
} else if (isset($_POST['create'])) {
    //   echo '<br> cliente id'. $_POST['clienteidview'];
    //   echo '<br> subastaid'.$_POST['subastaidview'];
    //   echo '<br> vendedoridview'.$_POST['vendedoridview'];
    //     echo '<br> calificacionvendedorpuntosview'.$_POST['calificacionvendedorpuntosview'];
    //     echo '<br> calificacionvendedorcomentariosview'.$_POST['calificacionvendedorcomentariosview'];
    //   exit();
    if (
        isset($_POST['subastaidview']) &&
        isset($_POST['clienteidview']) &&
        isset($_POST['vendedoridview']) &&
        isset($_POST['calificacionvendedorpuntosview']) &&
        isset($_POST['calificacionvendedorcomentariosview'])
    ) {

        $subastaId = $_POST['subastaidview'];
        $clienteId = $_POST['clienteidview'];
        $calificacionVendedorId = $_POST['vendedoridview'];
        $calificacionVendedorPuntos = $_POST['calificacionvendedorpuntosview'];
        $calificacionVendedorComentarios = $_POST['calificacionvendedorcomentariosview'];

        if (
            strlen($subastaId) > 0 &&
            strlen($clienteId) > 0 &&
            strlen($calificacionVendedorId) > 0 &&
            strlen($calificacionVendedorPuntos) > 0 &&
            strlen($calificacionVendedorComentarios) > 0
        ) {
            $calificacionVendedor =
                new CalificacionVendedor(
                    0,
                    $subastaId,
                    $clienteId,
                    $calificacionVendedorId,
                    $calificacionVendedorPuntos,
                    $calificacionVendedorComentarios
                );

            $calificacionVendedorBusiness = new CalificacionVendedorBusiness();

            $result = $calificacionVendedorBusiness->insertTBCalificacionVendedor($calificacionVendedor);

            if ($result == 1) {
                header("location: ../view/calificacionVendedorView.php?success=insert");
                session_start();
                $_SESSION['msj'] = "Se ha insertado correctamente";
            } else if ($result == 0) {
                header("location: ../view/calificacionVendedorView.php?error=insert");
                session_start();
                $_SESSION['msj'] = "No se pudo insertar";
            } else {
                header("location: ../view/calificacionVendedorView.php?error=dbError");
                session_start();
                $_SESSION['msj'] = "Error desconocido";
            }
        } else {
            header("location: ../view/calificacionVendedorView.php?error=emptyField");
            session_start();
            $_SESSION['msj'] = "Existen campos vacíos";
        }
    } else {
        header("location: ../view/calificacionVendedorView.php?error=error");
        session_start();
        $_SESSION['msj'] = "Error desconocido";
    }
}else if (isset($_POST['subastaidview'])) {
    //aca recibe el 3 del ajax de subastaidview y lo guarda en la variable subastaid, obtenido de la tbpujacliente
    $subastaId = $_POST['subastaidview'];
    include '../business/clienteBusiness.php';
    include '../business/pujaClienteBusiness.php';
    $pujaClienteBusiness = new PujaClienteBusiness();
    $clienteBusiness = new ClienteBusiness();
    $subastaBusiness = new SubastaBusiness();
    //$getPujaClienteById = $pujaClienteBusiness->getTBPujaClienteByArticulo($subastaId);//obtiene el id del cliente que gano la subasta
    //$getPujaganador = $pujaClienteBusiness->getPujaClienteGanador($subastaId); //obtiene el id del cliente que gano la subasta


    // $getClienteGanador = $clienteBusiness->getClientsByIdGanador($getPujaganador->getClienteId()); //obtiene el id del cliente que gano la subasta
    // $response = array( "vendedor" => $getClienteGanador->getClienteNombre());

    //aca necesito obtener el id del vendedor, para poder obtener el nombre del vendedor desde la tabla de subasta y mostrarlo en la tabla de calificacion vendedor
    $getSubasta = $subastaBusiness->getTBSubastaById($subastaId);
    $getVendedor = $clienteBusiness->getClientsByIdGanador($getSubasta->getSubastaVendedorId());
    $response = array("vendedorid" => $getVendedor->getClienteId(),"vendedor" => $getVendedor->getClienteNombre() . ' ' . $getVendedor->getClientePrimerApellido() . ' ' . $getVendedor->getClienteSegundoApellido());

    echo json_encode($response);

}