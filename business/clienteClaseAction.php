<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../business/clienteClaseBusiness.php';
include '../business/clienteCategoriaBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['clienteClaseIdView']) && isset($_POST['clienteClaseNombreView']) && isset($_POST['clienteClaseValorView'])
    ) {
        $clienteClaseId = $_POST['clienteClaseIdView'];
        $clienteClaseNombre = $_POST['clienteClaseNombreView'];
        $clienteClaseValor = $_POST['clienteClaseValorView'];
        $clienteClaseActivo = isset($_POST['clienteClaseActivoView']) ? 1 : 0;

        if (strlen($clienteClaseId) > 0 && strlen($clienteClaseNombre) > 0 && strlen($clienteClaseValor) > 0) {
            $clienteClase = new ClienteClase(
                $clienteClaseId,
                $clienteClaseValor,
                $clienteClaseNombre,
                $clienteClaseActivo
            ); 

            $clienteClaseBusiness = new ClienteClaseBusiness();

            $result = $clienteClaseBusiness->actualizarTBClienteClase($clienteClase);
            if ($result == 1) {
                header("location: ../view/clienteClaseView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Clase actualizada correctamente";
            } else {
                header("location: ../view/clienteClaseView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar la clase";
            }
        } else {
            header("location: ../view/clienteClaseView.php?error=emptyField");
        }
    } else {
        header("location: ../view/clienteClaseView.php?error=error");
    }
} else if (isset($_GET['delete'])) { //if the user clicked on the delete button

    $clienteClaseId = $_GET['tbclienteclaseid'];
    $clienteCategoriaBusiness = new ClienteCategoriaBusiness();

    if (!$clienteCategoriaBusiness->getClienteCategoriaByClaseId($clienteClaseId)) {
        $clienteClaseBusiness = new clienteClaseBusiness();
        $result = $clienteClaseBusiness->eliminarTBClienteClase($clienteClaseId);

        if ($result == 1) {
            header("location: ../view/clienteClaseView.php?success=delete"); //redirect to the index.php page with a success message
            session_start();
            $_SESSION['msj'] = "Clase eliminada correctamente";
        } else {
            header("location: ../view/clienteClaseView.php?error=dbError"); //redirect to the index.php page with an error message
            session_start();
            $_SESSION['error'] = "Error al eliminar la clase";
        }
    } else {
        header("location: ../view/clienteClaseView.php?error=error"); //redirect to the index.php page with an error message
        session_start();
        $_SESSION['error'] = "No puedes eliminar esta clase porque posee objetos relacionados";
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['clienteClaseNombreView'])
        && isset($_POST['clienteClaseValorView'])
    ) { //check if the variables have values

        $clienteClaseNombre = $_POST['clienteClaseNombreView'];
        $clienteClaseValor = $_POST['clienteClaseValorView'];
        $clienteClaseActivo = 1;
        if (
            strlen($clienteClaseNombre) > 0
            && strlen($clienteClaseValor) > 0
        ) { //check if the variables have values

            $clienteClase = new ClienteClase(
                0,
                $clienteClaseValor,
                $clienteClaseNombre,
                $clienteClaseActivo
            );

            $clienteClaseBusiness = new clienteClaseBusiness();

            $result = $clienteClaseBusiness->insertarTBClienteClase($clienteClase);
            if ($result == 1) {
                header("location: ../view/clienteClaseView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Categoría registrada correctamente";
            } else {
                header("location: ../view/clienteClaseView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar la categoría";
            }
        } else {
            header("location: ../view/clienteClaseView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/clienteClaseView.php?error=error"); //redirect to the index.php page with an error message
    }
}
