<?php

include '../data/calificacionVendedorBusiness.php';
session_start();
if (isset($_POST['update'])) {

    if(
        isset($_POST['calificacionVendedorId']) &&
        isset($_POST['subastaId']) &&
        isset($_POST['clienteId']) &&
        isset($_POST['calificacionVendedorPuntos']) &&
        isset($_POST['calificacionVendedorComentarios'])
    ) {

        $calificacionVendedorId = $_POST['calificacionVendedorId'];
        $subastaId = $_POST['subastaId'];
        $clienteId = $_POST['clienteId'];
        $calificacionVendedorPuntos = $_POST['calificacionVendedorPuntos'];
        $calificacionVendedorComentarios = $_POST['calificacionVendedorComentarios'];
        $calificacionVendedorActivo = isset($_POST['calificacionVendedorActivo']) ? 1 : 0;//si esta activo le asigna 1 y si no 0

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
            
            $calificacionVendedorBusiness = new CalificacionVendedorBusiness();

            $result = $calificacionVendedorBusiness->updateTBCalificacionVendedor($calificacionVendedor);

            if ($result == 1 )
            {
                header("location: ../view/calificacionVendedorView.php?success=update");
                session_start();
                $_SESSION['msj'] = "Se ha actualizado correctamente";
            } else if ($result == 2){
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
} else if (isset($_GET['delete1'])){
    $calificacionVendedorId = $_GET['tbcalificacionvendedorid'];
    $calificacionVendedorBusiness = new CalificacionVendedorBusiness();
    $result = $calificacionVendedorBusiness->deleteTBCalificacionVendedor($calificacionVendedorId);
    if ($result == $id){
        if($calificacionVendedorId ==1){
            header("location: ../view/calificacionVendedorView.php?success=delete");
            session_start();
            $_SESSION['msj'] = "Se ha eliminado correctamente";
        } else {
            header("location: ../view/calificacionVendedorView.php?error=delete");
            session_start();
            $_SESSION['msj'] = "No se pudo eliminar";
        }
    } else if ($result == 2){
        header("location: ../view/calificacionVendedorView.php?error=delete");
        session_start();
        $_SESSION['msj'] = "No se pudo eliminar";
    } else {
        header("location: ../view/calificacionVendedorView.php?error=dbError");
        session_start();
        $_SESSION['msj'] = "Error desconocido";
    }
} else if (isset($_POST['create'])){

    if (
        isset($_POST['subastaId']) &&
        isset($_POST['clienteId']) &&
        isset($_POST['calificacionVendedorPuntos']) &&
        isset($_POST['calificacionVendedorComentarios'])
    ) {

        $subastaId = $_POST['subastaId'];
        $clienteId = $_POST['clienteId'];
        $calificacionVendedorPuntos = $_POST['calificacionVendedorPuntos'];
        $calificacionVendedorComentarios = $_POST['calificacionVendedorComentarios'];
        $calificacionVendedorActivo =  1;//si esta activo le asigna 1 y si no 0

        if (
            strlen($subastaId) > 0 &&
            strlen($clienteId) > 0 &&
            strlen($calificacionVendedorPuntos) > 0 &&
            strlen($calificacionVendedorComentarios) > 0
        ) {
            $calificacionVendedor = new CalificacionVendedor(
                0,
                $subastaId,
                $clienteId,
                $calificacionVendedorPuntos,
                $calificacionVendedorComentarios,
                $calificacionVendedorActivo
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
}