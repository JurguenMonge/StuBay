<?php

include '../business/calificacionCompradorBusiness.php';
session_start();
if (isset($_POST['update'])) {

    if (
        isset($_POST['calificacionvendedoridview']) &&
        isset($_POST['subastaidview']) &&
        isset($_POST['clienteidview']) &&
        isset($_POST['calificacionvendedorpuntosview']) &&
        isset($_POST['calificacionvendedorcomentariosview'])
    ) {

        $calificacionVendedorId = $_POST['calificacionvendedoridview'];
        $subastaId = $_POST['subastaidview'];
        $clienteId = $_POST['clienteidview'];
        $calificacionVendedorPuntos = $_POST['calificacionvendedorpuntosview'];
        $calificacionVendedorComentarios = $_POST['calificacionvendedorcomentariosview'];
        $calificacionVendedorActivo = isset($_POST['calificacionvendedorcctivoview']) ? 1 : 0; //si esta activo le asigna 1 y si no 0

        if (

            strlen($subastaId) > 0 &&
            strlen($clienteId) > 0 &&
            strlen($calificacionVendedorPuntos) > 0 &&
            strlen($calificacionVendedorComentarios) > 0

        ) {
            $calificacionVendedor = new CalificacionVendedor(
                $calificacionVendedorId,
                $subastaId,
                $clienteId,
                $calificacionVendedorPuntos,
                $calificacionVendedorComentarios,
                $calificacionVendedorActivo
            );

            $calificacionVendedorBusiness = new CalificacionCompradorBusiness();

            $result = $calificacionVendedorBusiness->updateTBCalificacionComprador($calificacionVendedor);

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
} else if (isset($_GET['delete1'])) {
    $calificacionCompradorId = $_GET['tbcalificacioncompradorid'];
    $calificacionCompradorBusiness = new CalificacionVendedorBusiness();
    $result = $calificacionVendedorBusiness->deleteTBCalificacionComprador($calificacionVendedorId);
    if ($result == $id) {
        if ($calificacionVendedorId == 1) {
            header("location: ../view/calificacionVendedorView.php?success=delete");
            session_start();
            $_SESSION['msj'] = "Se ha eliminado correctamente";
        } else {
            header("location: ../view/calificacionVendedorView.php?error=delete");
            session_start();
            $_SESSION['msj'] = "No se pudo eliminar";
        }
    } else if ($result == 2) {
        header("location: ../view/calificacionVendedorView.php?error=delete");
        session_start();
        $_SESSION['msj'] = "No se pudo eliminar";
    } else {
        header("location: ../view/calificacionVendedorView.php?error=dbError");
        session_start();
        $_SESSION['msj'] = "Error desconocido";
    }
} else if (isset($_POST['create'])) {

    if (
        isset($_POST['subastaidview']) &&
        isset($_POST['calificacionvendedorpuntosview']) &&
        isset($_POST['calificacionvendedorcomentariosview'])
    ) {

        $subastaId = $_POST['subastaidview'];
        //$clienteId = $_POST['clienteidview'];
        $calificacionVendedorPuntos = $_POST['calificacionvendedorpuntosview'];
        $calificacionVendedorComentarios = $_POST['calificacionvendedorcomentariosview'];
        include '../business/clienteBusiness.php';
        include '../business/pujaClienteBusiness.php';
        $pujaClienteBusiness = new PujaClienteBusiness();
        $clienteBusiness = new ClienteBusiness();
        $getPujaganador = $pujaClienteBusiness->getPujaClienteGanador($subastaId); //obtiene el id del cliente que gano la subasta
        $getClienteGanador = $clienteBusiness->getClientsByIdGanador($getPujaganador->getClienteId()); //obtiene el id del cliente que gano la subasta
        $calificacionVendedorActivo = 1; //si esta activo le asigna 1 y si no 0

        $idcomprador = $getClienteGanador->getClienteId();

        // echo 'Subasta' . $subastaId;
        // echo '\nPuntos' . $calificacionVendedorPuntos;
        // echo '\nComent' . $calificacionVendedorComentarios;
        // echo '\nID' . $idcomprador;
        // exit();
        if (
            strlen($subastaId) > 0 &&
            strlen($calificacionVendedorPuntos) > 0 &&
            strlen($calificacionVendedorComentarios) > 0
        ) {
            
            $calificacionComprador = new CalificacionVendedor(
                0,
                $subastaId,
                $idcomprador,
                $calificacionVendedorPuntos,
                $calificacionVendedorComentarios,
                $calificacionVendedorActivo
            );

            $calificacionCompradorBusiness = new CalificacionCompradorBusiness();

            $result = $calificacionCompradorBusiness->insertTBCalificacionComprador($calificacionComprador);

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
} else if (isset($_POST['subastaidview'])) {
    $subastaId = $_POST['subastaidview'];
    include '../business/clienteBusiness.php';
    include '../business/pujaClienteBusiness.php';
    $pujaClienteBusiness = new PujaClienteBusiness();
    $clienteBusiness = new ClienteBusiness();

    //$getPujaClienteById = $pujaClienteBusiness->getTBPujaClienteByArticulo($subastaId);//obtiene el id del cliente que gano la subasta
    $getPujaganador = $pujaClienteBusiness->getPujaClienteGanador($subastaId); //obtiene el id del cliente que gano la subasta


    $getClienteGanador = $clienteBusiness->getClientsByIdGanador($getPujaganador->getClienteId()); //obtiene el id del cliente que gano la subasta
    $response = array("ganador" => $getClienteGanador->getClienteNombre());
    echo json_encode($response);
    //$response = array("precioInicial" => $subasta->getSubastaPrecioInicial(), "costoEnvio" => $costoEnvio);
    //echo json_encode($response);
}
