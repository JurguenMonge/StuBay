<?php

include '../business/clienteDireccionBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['clientedireccionidview'])
        && isset($_POST['clienteidview'])
        && isset($_POST['clientedireccionbarrioview'])
        && isset($_POST['clientedireccioncoordenadagpsview'])
    ) {
        $clienteDireccionId = $_POST['clientedireccionidview'];
        $clienteId = $_POST['clienteidview'];
        $clienteDireccionBarrio = $_POST['clientedireccionbarrioview'];
        $clienteDireccionCoordenadaGps = $_POST['clientedireccioncoordenadagpsview'];
        $clienteDireccionActivo = isset($_POST['clientedireccionactivoview']) ? 1 : 0;

        if (
            strlen($clienteId) > 0 && strlen($clienteDireccionBarrio) > 0
            && strlen($clienteDireccionCoordenadaGps) > 0
        ) {
            $clienteDireccion = new ClienteDireccion(
                $clienteDireccionId,
                $clienteId,
                $clienteDireccionBarrio,
                $clienteDireccionCoordenadaGps,
                $clienteDireccionActivo
            ); //create a clientedireccion object

            $clienteDireccionBusiness = new ClienteDireccionBusiness();

            $result = $clienteDireccionBusiness->updateTBClienteDireccion($clienteDireccion);

            if ($result == 1) {
                header("location: ../view/clienteDireccionView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Cliente Direccion actualizado correctamente";
            } else if ($result == 2) {
                header("location: ../view/clienteDireccionView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "El correo ya existe";
            } else {
                header("location: ../view/clienteDireccionView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar el cliente";
            }
        } else {
            header("location: ../view/clienteDireccionView.php?error=emptyField");
        }
    } else {
        header("location: ../view/clienteDireccionView.php?error=error");
    }
} else if (isset($_GET['delete1'])) { //if the user clicked on the delete button
    $clienteDireccionId = $_GET['tbclientedireccionid'];
    $clienteDireccionBusiness = new ClienteDireccionBusiness();
    $result = $clienteDireccionBusiness->deleteTBClienteDireccion($clienteDireccionId);

    if ($result == 1) { // if the method deleteTBClient was executed successfully it will return 1
        header("Location: ../view/clienteDireccionView.php?success=delete1"); // redirect to the userview.php page with a success message
        session_start();
        $_SESSION['msj'] = "Cliente eliminado correctamente";
    } else {
        header("Location: ../view/clienteDireccionView.php?error=dbError"); // redirect to the userview.php page with an error message
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['clientedireccionbarrioview'])
        && isset($_POST['clientedireccioncoordenadagpsview'])
        && isset($_POST['clienteidview'])


    ) { //check if the variables have values

        $clienteDireccionBarrio = $_POST['clientedireccionbarrioview']; //get the name from the form
        $clienteDireccionCoordenadaGps = $_POST['clientedireccioncoordenadagpsview']; //get the first last name from the form
        $clienteId = $_POST['clienteidview']; //get the email from the form
        $clienteDireccionActivo = 1; //set the client to 1

        if (
            strlen($clienteDireccionBarrio) > 0
            && strlen($clienteDireccionCoordenadaGps) > 0
            && strlen($clienteId) > 0
        ) { //check if the variables have values

            $clienteDireccion = new ClienteDireccion(
                0,
                $clienteId,
                $clienteDireccionBarrio,
                $clienteDireccionCoordenadaGps,
                $clienteDireccionActivo
            ); //create a new client instance 

            $clienteDireccionBusiness = new ClienteDireccionBusiness(); //create a new instance of clientBusiness

            $result = $clienteDireccionBusiness->insertTBClienteDireccion($clienteDireccion); //call the method insertTBClient from clientBusiness

            if ($result == 1) { //if the method insertTBClient was executed succesfully it will return 1
                header("location: ../view/clienteDireccionView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Direccion de cliente registrado correctamente";
            } else if ($result == 2) {
                header("location: ../view/clienteDireccionView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "EL cliente ya tiene una direccion registrada";
                
            } else {
                header("location: ../view/clienteDireccionView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar la direccion del cliente";
            }
        } else {
            header("location: ../view/clienteDireccionView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/clienteDireccionView.php?error=error"); //redirect to the index.php page with an error message
    }
}