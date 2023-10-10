<?php

include '../business/seguirSubastaBusiness.php';

if (isset($_POST['update'])) {
    if (
        isset($_POST['subastaseguidoridview'])
        && isset($_POST['clienteidview'])
        && isset($_POST['subastaidview'])
    ) {
        $seguirSubastaId = $_POST['subastaseguidoridview'];
        $clienteId = $_POST['clienteidview'];
        $subastaId = $_POST['subastaidview'];
        $seguirSubastaActivo = isset($_POST['subastaseguidoractivoview']) ? 1 : 0;
        // echo 'id' . $seguirSubastaId;
        // echo 'cliente' . $clienteId;
        // echo 'subasta' . $subastaId;
        // echo 'activo' . $seguirSubastaActivo;
        // exit();
        if (strlen($clienteId) > 0 && strlen($subastaId) > 0) {
            $seguirSubasta = new SeguirSubasta(
                $seguirSubastaId,
                $clienteId,
                $subastaId,
                $seguirSubastaActivo
            ); //create a seguirSubasta object

            $seguirSubastaBusiness = new SeguirSubastaBusiness();

            $result = $seguirSubastaBusiness->updateTBSeguirSubasta($seguirSubasta);

            if ($result == 1) {
                header("location: ../view/seguirSubastaView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Seguir Subasta actualizado correctamente";
            } else if ($result == 2) {
                header("location: ../view/seguirSubastaView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "El correo ya existe";
            } else {
                header("location: ../view/seguirSubastaView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar el seguirSubasta";
            }
        } else {
            header("location: ../view/seguirSubastaView.php?error=emptyField");
        }
    } else {
        header("location: ../view/seguirSubastaView.php?error=error");
    }
} else if (isset($_GET['delete1'])) { //if the user clicked on the delete button
    $seguirSubastaId = $_GET['tbsubastaseguidorid'];
    $seguirSubastaBusiness = new SeguirSubastaBusiness();
    $result = $seguirSubastaBusiness->deleteTBSeguirSubasta($seguirSubastaId);

    if ($result == 1) {
        header("location: ../view/seguirSubastaView.php?success=deleted");
        session_start();
        $_SESSION['msj'] = "Seguir Subasta eliminado correctamente";
    } else {
        header("location: ../view/seguirSubastaView.php?error=dbError");
        session_start();
        $_SESSION['error'] = "Error al eliminar el seguirSubasta";
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['clienteidview'])
        && isset($_POST['subastaidview'])

    ) {
        $clienteId = $_POST['clienteidview'];
        $subastaId = $_POST['subastaidview'];
        $seguirSubastaActivo = 1;
        // echo 'cliente'. $clienteId;
        // echo 'subasta'. $subastaId;
        // echo 'activo'. $seguirSubastaActivo;
        // exit();
        if (
            strlen($clienteId) > 0
            && strlen($subastaId) > 0
        ) {
            $seguirSubasta = new SeguirSubasta(
                0,
                $clienteId,
                $subastaId,
                $seguirSubastaActivo
            ); //create a seguirSubasta object

            $seguirSubastaBusiness = new SeguirSubastaBusiness();

            $result = $seguirSubastaBusiness->insertTBSeguirSubasta($seguirSubasta);

            if ($result == 1) {
                header("location: ../view/seguirSubastaView.php?success=inserted");
                session_start();
                $_SESSION['msj'] = "Siguio correctamente la Subasta";
            } else if ($result == 2) {
                header("location: ../view/seguirSubastaView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Ya estas siguiendo esta subasta";
            } else {
                header("location: ../view/seguirSubastaView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al seguir la Subasta";
            }
        } else {
            header("location: ../view/seguirSubastaView.php?error=emptyField");
        }
    } else {
        header("location: ../view/seguirSubastaView.php?error=error");
    }
}
