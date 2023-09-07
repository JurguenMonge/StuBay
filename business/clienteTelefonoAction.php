<?php

include '../business/clienteTelefonoBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['clienteidview'])
        && isset($_POST['clientetelefononumeroview'])
        && isset($_POST['clientetelefonodescripcionview'])
    ) {
        $clienteTelefonoId = $_POST['clientetelefonoidview'];
        $clienteId = $_POST['clienteidview'];
        $clienteTelefonoNumero = $_POST['clientetelefononumeroview'];
        $clienteTelefonoDescripcion = $_POST['clientetelefonodescripcionview'];
        $clienteTelefonoActivo = isset($_POST['clientetelefonoactivoview']) ? 1 : 0;
        if (
            strlen($clienteId) > 0 
            && strlen($clienteTelefonoNumero) > 0
            && strlen($clienteTelefonoDescripcion) > 0
        ) {
            $clienteTelefono = new ClienteTelefono(
                $clienteTelefonoId,
                $clienteId,
                $clienteTelefonoNumero,
                $clienteTelefonoDescripcion,
                $clienteTelefonoActivo
            ); //create a clientetelefono object

            $clienteTelefonoBusiness = new ClienteTelefonoBusiness();

            $result = $clienteTelefonoBusiness->updateTBClienteTelefono($clienteTelefono);

            if ($result == 1) {
                header("location: ../view/clienteTelefonoView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Dato del cliente actualizado correctamente";
            } else if ($result == 2) {
                header("location: ../view/clienteTelefonoView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "El dato del cliente ya existe";
            } else {
                header("location: ../view/clienteTelefonoView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar el cliente";
            }
        } else {
            header("location: ../view/clienteTelefonoView.php?error=emptyField");
        }
    } else {
        header("location: ../view/clienteTelefonoView.php?error=error");
    }
}else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['clienteidview'])
        && isset($_POST['clientetelefononumeroview'])
        && isset($_POST['clientetelefonodescripcionview'])


    ) { //check if the variables have values
        $clienteId = $_POST['clienteidview']; //get the email from the form
        $clienteTelefonoNumero = $_POST['clientetelefononumeroview']; //get the name from the form
        $clienteTelefonoDescripcion = $_POST['clientetelefonodescripcionview']; //get the first last name from the form
        $clienteTelefonoActivo = 1; //set the client to 1

        if (
            strlen($clienteId) > 0
            && strlen($clienteTelefonoNumero) > 0
            && strlen($clienteTelefonoDescripcion) > 0
        ) { //check if the variables have values

            $clienteTelefono = new ClienteTelefono(
                0,
                $clienteId,
                $clienteTelefonoNumero,
                $clienteTelefonoDescripcion,
                $clienteTelefonoActivo
            ); //create a new client instance 
            // Verifiquemos los valores antes de la inserción
            // Muestra los datos del objeto ClienteTelefono
            // echo "Cliente ID: " . $clienteTelefono->getClienteId() . "<br>";
            // echo "Número de Teléfono: " . $clienteTelefono->getClienteTelefonoNumero() . "<br>";
            // echo "Descripción: " . $clienteTelefono->getClienteTelefonoDescripcion() . "<br>";
            // echo "Activo: " . $clienteTelefono->getClienteTelefonoActivo() . "<br>";
            // exit();
            $clienteTelefonoBusiness = new ClienteTelefonoBusiness(); //create a new instance of clientBusiness

            $result = $clienteTelefonoBusiness->insertTBClienteTelefono($clienteTelefono); //call the method insertTBClient from clientBusiness

            if ($result == 1) { //if the method insertTBClient was executed succesfully it will return 1
                header("location: ../view/clienteTelefonoView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Direccion de cliente registrado correctamente";
            } else if ($result == 2) {
                header("location: ../view/clienteTelefonoView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "EL cliente ya tiene una direccion registrada";
            } else {
                header("location: ../view/clienteTelefonoView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar la direccion del cliente";
            }
        } else {
            header("location: ../view/clienteTelefonoView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/clienteTelefonoView.php?error=error"); //redirect to the index.php page with an error message
    }
}else if (isset($_GET['delete1'])) { //if the user clicked on the delete button
    $clienteTelefonoId = $_GET['tbclientetelefonoid'];
    $clienteTelefonoBusiness = new ClienteTelefonoBusiness();
    $result = $clienteTelefonoBusiness->deleteTBClienteTelefono($clienteTelefonoId);

    if ($result == 1) { // if the method deleteTBClient was executed successfully it will return 1
        header("Location: ../view/clienteTelefonoView.php?success=delete1"); // redirect to the userview.php page with a success message
        session_start();
        $_SESSION['msj'] = "Datos del cliente eliminado correctamente";
    } else {
        header("Location: ../view/clienteTelefonoView.php?error=dbError"); // redirect to the userview.php page with an error message
    }
}
