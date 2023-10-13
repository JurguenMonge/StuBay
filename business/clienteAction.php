<?php

include '../business/clienteBusiness.php';
session_start();
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
    $id = $clienteBusiness->clienteByIdDelete($clienteId);
    if ($result == 1) { //este if es para verificar si se elimino correctamente el cliente

        if ($clienteId == $id) { //si el cliente que se elimino es el mismo que el que esta en sesion se cierra la sesion
            //echo "entro";
            //exit();
            header("location: ../index.php?success=delete1");
            $_SESSION['msj'] = "Cliente eliminado correctamente"; //ARREGLAR
            session_destroy();
        } else {
            header("location: ../view/clienteView.php?success=delete1");
            session_start();
            $_SESSION['msj'] = "Cliente eliminado correctamente";
        }
    } else if ($result == 2) {
        header("location: ../view/clienteView.php?error=delete1"); // redirect to the userview.php page with an error message
        session_start();
        $_SESSION['error'] = "Tiene subastas activas";
    } else {
        header("location: ../view/clienteView.php?error=dbError"); // redirect to the userview.php page with a success message
        session_start();
        $_SESSION['error'] = "Error al eliminar el cliente";
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
} else if (isset($_POST['login'])) { //if the user clicked on the login button

    if (isset($_POST['clientecorreoview']) && isset($_POST['clientepasswordview'])) { //check if the variables have values

        $passwordEncripted = $_POST['clientepasswordview']; //get the password from the form and encript it
        $clienteCorreo = $_POST['clientecorreoview']; //get the clienteCorreo from the form

        if (strlen($clienteCorreo) > 0 && strlen($passwordEncripted) > 0) { //check if the variables have values

            $clienteBusiness = new ClienteBusiness(); //create a new instance of clienteBusiness 

            $result = $clienteBusiness->clienteLogin($clienteCorreo, $passwordEncripted); //call the method clienteLogin from userBusiness 
            if ($result == 1) { //if the method returns 1 then the user was found in the database 
                $id = $clienteBusiness->clienteById($clienteCorreo);
                $nombre = $clienteBusiness->nombreClienteById($clienteCorreo);
                if ($id != null) {
                    $_SESSION["clientecorreoview"] = $clienteCorreo; //set the session variable to the tbclientecorreo that was entered in the form 
                    $_SESSION["id"] = $id;
                    //$_SESSION["nombre"] = $nombre->getClienteNombre();
                    header("location: ../view/inicioView.php?success=login"); //redirect the user to the clienteview.php
                    session_start();
                    $_SESSION['msj'] = "Bienvenido " . $nombre;
                } else {
                    header("location: ../index.php?error=login");
                }
            } else if ($result == 2) {
                header("location: ../index.php?error=login"); //if the method returns 0 then the user was not found in the database 
                session_start();
                $_SESSION['error'] = "Usuario o contraseña incorrecta";
            } else if ($result == 3) {
                header("location: ../index.php?error=login"); //if the method returns 0 then the user was not found in the database 
                session_start();
                $_SESSION['error'] = "Usuario desactivada";
            } else {
                header("location: ../index.php?error=error"); //if the method returns 0 then the user was not found in the database 
                session_start();
                $_SESSION['error'] = "Error al iniciar sesión";
            }
        } else {
            header("location: ../index.php?error=emptyField"); //if the variables don't have values then redirect the user to the index.php
        }
    } else {
        header("location: ../index.php?error=error"); //if the variables are not set then redirect the user to the index.php
    }
}
if (isset($_POST['reactivar'])) {
    if (isset($_POST['clientecorreo']) && isset($_POST['clientepassword'])) {
        $clienteBusiness = new ClienteBusiness();
        $result = $clienteBusiness->reactivarCuenta($_POST['clientecorreo'], $_POST['clientepassword']);

        if ($result == 1) {
            // La cuenta se reactivó con éxito, redirige a una página de éxito
            //header("location: ../view/inicioView.php?success=login"); //redirect the user to the clienteview.php
            header("location: ../index.php?reactived"); //redirect the user to the clienteview.php
            session_start();
            $_SESSION['msj'] = "Cuenta reactivada correctamente";
        } else if ($result == 2) {
            header("location: ../view/reactivarCuenta.php?error=login"); //if the method returns 0 then the user was not found in the database
            session_start();
            $_SESSION['error'] = "Usuario o contraseña incorrecta";
        } else if ($result == 3) {
            header("location: ../view/reactivarCuenta.php?error=login"); //if the method returns 0 then the user was not found in the database
            session_start();
            $_SESSION['error'] = "Usuario no encontrada";
        } else {
            header("location: ../view/reactivarCuenta.php?error=error"); //if the method returns 0 then the user was not found in the database
            session_start();
            $_SESSION['error'] = "Error al iniciar sesión";
        }
    }
}
if (isset($_POST['createC'])) { //if the user clicked on the create button

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
                header("location: ../index.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Cliente registrado correctamente";
            } else if ($result == 2) {
                header("location: ../index.php?error=exist"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "El correo ya esta en uso";
            } else {
                header("location: ../index.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar el cliente";
            }
        } else {
            header("location: ../index.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../index.php?error=error"); //redirect to the index.php page with an error message
    }
}
