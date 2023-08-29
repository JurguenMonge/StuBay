<?php

include '../business/clienteBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['clienteidview'])
        && isset($_POST['clientenombreview'])
        && isset($_POST['clienteprimerapellidoview'])
        && isset($_POST['clientesegundoapellidoview'])
        && isset($_POST['clientecorreoview'])
        && isset($_POST['clientepasswordview'])
        && isset($_POST['clientefechaingresoview'])
    ) {

        $clienteId = $_POST['clienteidview'];
        $clienteNombre = $_POST['clientenombreview'];
        $clientePrimerApellido = $_POST['clienteprimerapellidoview'];
        $clienteSegundoApellido = $_POST['clientesegundoapellidoview'];
        $clienteCorreo = $_POST['clientecorreoview'];
        $clientePassword = $_POST['clientepasswordview'];
        $clienteFechaIngreso = $_POST['clientefechaingresoview'];
        $clienteActivo = isset($_POST['clienteactivoview']) ? 1 : 0;

        if (
            strlen($clienteNombre) > 0 && strlen($clientePrimerApellido) > 0
            && strlen($clienteSegundoApellido) > 0 && strlen($clienteCorreo) > 0
            && strlen($clientePassword) > 0 && strlen($clienteFechaIngreso) > 0
        ) {
            $cliente = new Cliente(
                $clienteId,
                $clienteNombre,
                $clientePrimerApellido,
                $clienteSegundoApellido,
                $clienteCorreo,
                $clientePassword,
                $clienteFechaIngreso,
                $clienteActivo
            ); //create a client object

            $clienteBusiness = new ClienteBusiness();

            $result = $clienteBusiness->updateTBCliente($cliente);

            if ($result == 1) {
                header("location: ../view/clienteView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Cliente actualizado correctamente";
            } else if ($result == 2) {
                header("location: ../view/clienteView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "El correo ya existe";
            } else {
                header("location: ../view/clienteView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar el cliente";
            }
        } else {
            header("location: ../view/clienteView.php?error=emptyField");
        }
    } else {
        header("location: ../view/clienteView.php?error=error");
    }
} else if (isset($_GET['delete1'])) { //if the user clicked on the delete button
    $clienteId = $_GET['tbclienteid'];
    $clienteBusiness = new ClienteBusiness();
    $result = $clienteBusiness->deleteTBCliente($clienteId);

    if ($result == 1) { // if the method deleteTBClient was executed successfully it will return 1
        header("Location: ../view/clienteView.php?success=delete1"); // redirect to the userview.php page with a success message
        session_start();
        $_SESSION['msj'] = "Cliente eliminado correctamente";
    } else {
        header("Location: ../view/clienteView.php?error=dbError"); // redirect to the userview.php page with an error message
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['clientenombreview'])
        && isset($_POST['clienteprimerapellidoview'])
        && isset($_POST['clientesegundoapellidoview'])
        && isset($_POST['clientecorreoview'])
        && isset($_POST['clientepasswordview'])
        && isset($_POST['clientefechaingresoview'])

    ) { //check if the variables have values

        $clienteNombre = $_POST['clientenombreview']; //get the name from the form
        $clientePrimerApellido = $_POST['clienteprimerapellidoview']; //get the first last name from the form
        $clienteSegundoApellido = $_POST['clientesegundoapellidoview']; //get the second last name from the form
        $clienteCorreo = $_POST['clientecorreoview']; //get the identification from the form
        $clientePassword = password_hash($_POST['clientepasswordview'], PASSWORD_DEFAULT); //get the password from the form and encript it
        $clienteFechaIngreso = $_POST['clientefechaingresoview']; //get the email from the form
        $clienteActivo = 1; //set the client to 1

        if (
            strlen($clienteNombre) > 0
            && strlen($clientePrimerApellido) > 0
            && strlen($clienteSegundoApellido) > 0
            && strlen($clienteCorreo) > 0
            && strlen($clientePassword) > 0
            && strlen($clienteFechaIngreso) > 0
        ) { //check if the variables have values

            $cliente = new Cliente(
                0,
                $clienteNombre,
                $clientePrimerApellido,
                $clienteSegundoApellido,
                $clienteCorreo,
                $clientePassword,
                $clienteFechaIngreso,
                $clienteActivo
            ); //create a new client instance 

            $clienteBusiness = new ClienteBusiness(); //create a new instance of clientBusiness

            $result = $clienteBusiness->insertTBCliente($cliente); //call the method insertTBClient from clientBusiness

            if ($result == 1) { //if the method insertTBClient was executed succesfully it will return 1
                header("location: ../view/clienteView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Cliente registrado correctamente";
            } else if ($result == 2) {
                header("location: ../view/clienteView.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "El correo ya esta en uso";
                
            } else {
                header("location: ../view/clienteView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar el cliente";
            }
        } else {
            header("location: ../view/clienteView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/clienteView.php?error=error"); //redirect to the index.php page with an error message
    }
} /*else if (isset($_POST['delete'])) { //if the user clicked on the delete button

    if (
        isset($_POST['clienteid']) 
        && isset($_POST['clientenombre'])
        && isset($_POST['clienteprimerapellido']) 
        && isset($_POST['clientesegundoapellido'])
        && isset($_POST['clientecorreo']) 
        && isset($_POST['clientepassword'])
        && isset($_POST['clientefechaingreso'])
    ) { //check if the variables have values 
        $clienteId = $_POST['clienteid']; //get the user_id from the form
        $clienteNombre = $_POST['clientenombre']; //get the name from the form
        $clientePrimerApellido = $_POST['clienteprimerapellido']; //get the first last name from the form
        $clienteSegundoApellido = $_POST['clientesegundoapellido']; //get the second last name from the form
        $clienteCorreo = $_POST['clientecorreo']; //get the identification from the form
        $clientePassword = $_POST['clientepassword']; //get the birth date from the form
        $clienteFechaIngreso = $_POST['clientefechaingreso']; //get the email from the form
        $clienteActivo = 0; //set the client to 0

        if (
            strlen($clienteId) > 0 
            && strlen($clienteNombre) > 0
            && strlen($clientePrimerApellido) > 0 
            && strlen($clienteSegundoApellido) > 0
            && strlen($clienteCorreo) > 0 
            && strlen($clientePassword) > 0
            && strlen($clienteFechaIngreso) > 0
        ) { //check if the variables have values 
            $cliente = new Cliente(
                $clienteId,
                $clienteNombre,
                $clientePrimerApellido,
                $clienteSegundoApellido,
                $clienteCorreo,
                $clientePassword,
                $clienteFechaIngreso,
                $clienteActivo
            ); //create a new client instance

            $clienteBusiness = new ClienteBusiness(); //create a new instance of clientBusiness

            $result = $clienteBusiness->deleteTBCliente($cliente); //call the method deleteTBUser from userBusiness 

            if ($result == 1) { //if the method deleteTBUser was executed succesfully it will return 1
                header("location: ../view/clienteView.php?success=delete"); //redirect to the index.php page with a success message
            } else {
                header("location: ../view/clienteView.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../view/clienteView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/clienteView.php?error=error"); //redirect to the index.php page with an error message
    }
}*/
