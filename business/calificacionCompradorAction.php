<?php

include '../business/calificacionCompradorBusiness.php';
session_start();
if (isset($_POST['update'])) {
    // echo 'calificacioncompradorid' . $_POST['calificacioncompradoridview'];
    // echo '<br>comprador' . $_POST['compradoridview'];
    // echo '<br>subastaid' . $_POST['subastaidview'];
    // echo '<br>clienteid' . $_POST['clienteidview'];
    // echo '<br>puntos' . $_POST['calificacioncompradorpuntosview'];
    // echo '<br>comentarios' . $_POST['calificacioncompradorcomentariosview'];

    // exit();
    if (
        isset($_POST['calificacioncompradoridview']) &&
        isset($_POST['subastaidview']) &&
        isset($_POST['clienteidview']) &&
        isset($_POST['compradoridview']) &&
        isset($_POST['calificacioncompradorpuntosview']) &&
        isset($_POST['calificacioncompradorcomentariosview'])
    ) {

        $calificacionCompradorId = $_POST['calificacioncompradoridview'];
        $subastaId = $_POST['subastaidview'];
        $clienteId = $_POST['clienteidview'];
        $compradorId = $_POST['compradoridview'];
        $calificacionCompradorPuntos = $_POST['calificacioncompradorpuntosview'];
        $calificacionCompradorComentarios = $_POST['calificacioncompradorcomentariosview'];

        if (

            strlen($subastaId) > 0 &&
            strlen($clienteId) > 0 &&
            strlen($compradorId) > 0 && //comprueba que no esten vacios los campos
            strlen($calificacionCompradorPuntos) > 0 &&
            strlen($calificacionCompradorComentarios) > 0

        ) {
            $calificacionComprador = new CalificacionComprador(
                $calificacionCompradorId,
                $subastaId,
                $clienteId,
                $compradorId,
                $calificacionCompradorPuntos,
                $calificacionCompradorComentarios,
            );

            $calificacionCompradorBusiness = new CalificacionCompradorBusiness();

            $result = $calificacionCompradorBusiness->updateTBCalificacionComprador($calificacionComprador);

            if ($result == 1) {
                header("location: ../view/calificacionCompradorView.php?success=update");
                session_start();
                $_SESSION['msj'] = "Se ha actualizado correctamente";
            } else if ($result == 2) {
                header("location: ../view/calificacionCompradorView.php?error=update");
                session_start();
                $_SESSION['msj'] = "No se pudo actualizar";
            } else {
                header("location: ../view/calificacionCompradorView.php?error=dbError");
                session_start();
                $_SESSION['msj'] = "Error desconocido";
            }
        } else {
            header("location: ../view/calificacionCompradorView.php?error=emptyField");
            session_start();
            $_SESSION['msj'] = "Existen campos vacíos";
        }
    } else {
        header("location: ../view/calificacionCompradorView.php?error=error");
        session_start();
        $_SESSION['msj'] = "Error desconocido";
    }
} else if (isset($_POST['delete'])) {
    // echo $_POST['calificacioncompradoridview'];
    // exit();
    if (isset($_POST['calificacioncompradoridview'])) {

        $calificacionCompradorId = $_POST['calificacioncompradoridview'];

        if (strlen($calificacionCompradorId) > 0) {

            $calificacionCompradorBusiness = new CalificacionCompradorBusiness();

            $result = $calificacionCompradorBusiness->deleteTBCalificacionComprador($calificacionCompradorId);

            if ($result == 1) {
                header("location: ../view/calificacionCompradorView.php?success=delete");
                session_start();
                $_SESSION['msj'] = "Se ha eliminado correctamente";
            } else if ($result == 0) {
                header("location: ../view/calificacionCompradorView.php?error=delete");
                session_start();
                $_SESSION['msj'] = "No se pudo eliminar";
            } else {
                header("location: ../view/calificacionCompradorView.php?error=dbError");
                session_start();
                $_SESSION['msj'] = "Error desconocido";
            }
        } else {
            header("location: ../view/calificacionCompradorView.php?error=emptyField");
            session_start();
            $_SESSION['msj'] = "Existen campos vacíos";
        }
    } else {
        header("location: ../view/calificacionCompradorView.php?error=error");
        session_start();
        $_SESSION['msj'] = "Error desconocido";
    }
} else if (isset($_POST['create'])) {
    // echo $_POST['compradoridview'];
    // exit();
    if (
        isset($_POST['subastaidview']) &&
        isset($_POST['clienteidview']) &&
        isset($_POST['compradoridview']) &&
        isset($_POST['calificacionvendedorpuntosview']) &&
        isset($_POST['calificacionvendedorcomentariosview'])
    ) {

        $subastaId = $_POST['subastaidview'];
        $clienteId = $_POST['clienteidview'];
        $compradorId = $_POST['compradoridview'];
        $calificacionVendedorPuntos = $_POST['calificacionvendedorpuntosview'];
        $calificacionVendedorComentarios = $_POST['calificacionvendedorcomentariosview'];

        if (
            strlen($subastaId) > 0 &&
            strlen($clienteId) > 0 &&
            strlen($compradorId) > 0 && //comprueba que no esten vacios los campos
            strlen($calificacionVendedorPuntos) > 0 &&
            strlen($calificacionVendedorComentarios) > 0
        ) {

            $calificacionComprador = new CalificacionComprador(
                0,
                $subastaId,
                $clienteId,
                $compradorId,
                $calificacionVendedorPuntos,
                $calificacionVendedorComentarios
            );

            $calificacionCompradorBusiness = new CalificacionCompradorBusiness();

            $result = $calificacionCompradorBusiness->insertTBCalificacionComprador($calificacionComprador);

            if ($result == 1) {
                header("location: ../view/calificacionCompradorView.php?success=insert");
                session_start();
                $_SESSION['msj'] = "Se ha insertado correctamente";
            } else if ($result == 0) {
                header("location: ../view/calificacionCompradorView.php?error=insert");
                session_start();
                $_SESSION['msj'] = "No se pudo insertar";
            } else {
                header("location: ../view/calificacionCompradorView.php?error=dbError");
                session_start();
                $_SESSION['msj'] = "Error desconocido";
            }
        } else {
            header("location: ../view/calificacionCompradorView.php?error=emptyField");
            session_start();
            $_SESSION['msj'] = "Existen campos vacíos";
        }
    } else {
        header("location: ../view/calificacionCompradorView.php?error=error");
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
    //$response = array("ganador" => $getClienteGanador->getClienteNombre());
    $response = array("compradorid" => $getClienteGanador->getClienteId(), "ganador" => $getClienteGanador->getClienteNombre() . ' ' . $getClienteGanador->getClientePrimerApellido() . ' ' . $getClienteGanador->getClienteSegundoApellido());
    // Establecer las cabeceras para que el cliente entienda que está recibiendo JSON
    //header('Content-Type: application/json');//ejemplo de json {"ganador":"Jorge"}


    echo json_encode($response);
    //$response = array("precioInicial" => $subasta->getSubastaPrecioInicial(), "costoEnvio" => $costoEnvio);
    //echo json_encode($response);
}
