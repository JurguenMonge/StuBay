<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../business/criterioBusiness.php';
include '../business/clienteCategoriaBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['criterioIdView']) && isset($_POST['criterioNombreView']) && isset($_POST['criterioValorView'])
    ) {
        $criterioId = $_POST['criterioIdView'];
        $criterioNombre = $_POST['criterioNombreView'];
        $criterioValor = $_POST['criterioValorView'];
        $criterioActivo = isset($_POST['criterioActivoView']) ? 1 : 0;

        if (strlen($criterioId) > 0 && strlen($criterioNombre) > 0 && strlen($criterioValor) > 0) {
            $criterio = new Criterio(
                $criterioId,
                $criterioValor,
                $criterioNombre,
                $criterioActivo
            ); 

            $criterioBusiness = new CriterioBusiness();

            $result = $criterioBusiness->actualizarTBcriterio($criterio);
            if ($result == 1) {
                header("location: ../view/criterioView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Criterio actualizado correctamente";
            } else {
                header("location: ../view/criterioView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar el criterio";
            }
        } else {
            header("location: ../view/criterioView.php?error=emptyField");
        }
    } else {
        header("location: ../view/criterioView.php?error=error");
    }
} else if (isset($_GET['delete'])) { //if the user clicked on the delete button

    $criterioId = $_GET['tbclienteclaseid'];
    $clienteCategoriaBusiness = new ClienteCategoriaBusiness();

    if (!$clienteCategoriaBusiness->getClienteCategoriaByClaseId($criterioId)) {
        $criterioBusiness = new criterioBusiness();
        $result = $criterioBusiness->eliminarTBcriterio($criterioId);

        if ($result == 1) {
            header("location: ../view/criterioView.php?success=delete"); //redirect to the index.php page with a success message
            session_start();
            $_SESSION['msj'] = "Clase eliminada correctamente";
        } else {
            header("location: ../view/criterioView.php?error=dbError"); //redirect to the index.php page with an error message
            session_start();
            $_SESSION['error'] = "Error al eliminar la clase";
        }
    } else {
        header("location: ../view/criterioView.php?error=error"); //redirect to the index.php page with an error message
        session_start();
        $_SESSION['error'] = "No puedes eliminar esta clase porque posee objetos relacionados";
    }
} else if (isset($_POST['create'])) {

    if (
        isset($_POST['criterioNombreView'])
        && isset($_POST['criterioValorView'])
    ) { //check if the variables have values

        $criterioNombre = $_POST['criterioNombreView'];
        $criterioValor = $_POST['criterioValorView'];
        $criterioActivo = 1;
        if (
            strlen($criterioNombre) > 0
            && strlen($criterioValor) > 0
        ) { //check if the variables have values

            $criterio = new criterio(
                0,
                $criterioValor,
                $criterioNombre,
                $criterioActivo
            );

            $criterioBusiness = new CriterioBusiness();

            $result = $criterioBusiness->insertarTBcriterio($criterio);
            if ($result == 1) {
                header("location: ../view/criterioView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Criterio registrado correctamente";
            } else {
                header("location: ../view/criterioView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar el Criterio";
            }
        } else {
            header("location: ../view/criterioView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/criterioView.php?error=error"); //redirect to the index.php page with an error message
    }
}
