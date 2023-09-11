<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../business/pujaClienteBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['pujaClienteIdView']) && isset($_POST['clienteIdView']) && isset($_POST['articuloIdView']) && isset($_POST['pujaClienteFechaView'])
        && isset($_POST['pujaClienteOfertaView']) && isset($_POST['pujaClienteEnvioView'])
    ) {
        $cadena =
            $pujaClienteId = $_POST['pujaClienteIdView'];
        $clienteId = $_POST['clienteIdView'];
        $articuloId = $_POST['articuloIdView'];
        $pujaClienteFecha = $_POST['pujaClienteFechaView'];
        $pujaClienteOferta = $_POST['pujaClienteOfertaView'];
        $pujaClienteEnvio = $_POST['pujaClienteEnvioView'];

        if (
            strlen($pujaClienteId) > 0 && strlen($clienteId) > 0 && strlen($articuloId) > 0 && strlen($pujaClienteFecha) > 0
            && strlen($pujaClienteOferta) > 0 && strlen($pujaClienteEnvio) > 0
        ) {
            $pujaCliente = new PujaCliente(
                $pujaClienteId,
                $clienteId,
                $articuloId,
                $pujaClienteFecha,
                $pujaClienteOferta,
                $pujaClienteEnvio
            ); //create a student object

            $pujaClienteBusiness = new PujaClienteBusiness();

            $result = $pujaClienteBusiness->actualizarTBPujaCliente($pujaCliente);
            if ($result == 1) {
                header("location: ../view/pujaClienteView.php?success=updated");
            } else {
                header("location: ../view/pujaClienteView.php?error=dbError");
            }
        } else {
            header("location: ../view/pujaClienteView.php?error=emptyField");
        }
    } else {
        header("location: ../view/pujaClienteView.php?error=error");
    }
} else if (isset($_POST['delete'])) { //if the user clicked on the delete button

    if (
        isset($_POST['pujaClienteIdView']) && isset($_POST['clienteIdView']) && isset($_POST['articuloIdView']) && isset($_POST['pujaClienteFechaView'])
        && isset($_POST['pujaClienteOfertaView']) && isset($_POST['pujaClienteEnvioView'])
    ) { //check if the variables have values 
        $pujaClienteId = $_POST['pujaClienteIdView']; //get the id from the form
        $clienteId = $_POST['clienteIdView'];
        $articuloId = $_POST['articuloIdView'];
        $pujaClienteFecha = $_POST['pujaClienteFechaView'];
        $pujaClienteOferta = $_POST['pujaClienteOfertaView'];
        $pujaClienteEnvio = $_POST['pujaClienteEnvioView'];
        if (
            strlen($pujaClienteId) > 0 && strlen($clienteId) > 0 && strlen($articuloId) > 0 && strlen($pujaClienteFecha) > 0
            && strlen($pujaClienteOferta) > 0 && strlen($pujaClienteEnvio) > 0
        ) { //check if the variables have values 

            $pujaCliente = new PujaCliente(
                $pujaClienteId,
                $clienteId,
                $articuloId,
                $pujaClienteFecha,
                $pujaClienteOferta,
                $pujaClienteEnvio
            ); //create a student object

            $pujaClienteBusiness = new PujaClienteBusiness();
            $result = $pujaClienteBusiness->eliminarTBPujaCliente($pujaCliente);

            if ($result == 1) {
                header("location: ../view/pujaClienteView.php?success=delete"); //redirect to the index.php page with a success message
            } else {
                header("location: ../view/pujaClienteView.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../view/pujaClienteView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/pujaClienteView.php?error=error"); //redirect to the index.php page with an error message
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['clienteIdView']) && isset($_POST['articuloIdView']) && isset($_POST['pujaClienteFechaView'])
        && isset($_POST['pujaClienteOfertaView']) && isset($_POST['pujaClienteEnvioView'])
    ) { //check if the variables have values
        $cadena = explode("-", $_POST['articuloIdView']);

        $clienteId = $_POST['clienteIdView'];
        $articuloId = $cadena[1];
        // Formatear la fecha en el formato correcto 'YYYY-MM-DD HH:MM:SS'
        $pujaClienteFecha = date('Y-m-d H:i:s', strtotime($_POST['pujaClienteFechaView']));

        $pujaClienteOferta = $_POST['pujaClienteOfertaView'];
        $pujaClienteEnvio = $_POST['pujaClienteEnvioView'];

        if (
            strlen($clienteId) > 0 && strlen($articuloId) > 0 && strlen($pujaClienteFecha) > 0
            && strlen($pujaClienteOferta) > 0 && strlen($pujaClienteEnvio) > 0
        ) { //check if the variables have values

            $pujaCliente = new PujaCliente(
                0,
                $clienteId,
                $articuloId,
                $pujaClienteFecha,
                $pujaClienteOferta,
                $pujaClienteEnvio
            );

            $pujaClienteBusiness = new PujaClienteBusiness();

            $result = $pujaClienteBusiness->insertarTBPujaCliente($pujaCliente);
            if ($result == 1) {
                header("location: ../index.php?success=insert"); //redirect to the index.php page with a success message
            } else {
                header("location: ../index.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../index.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../index.php?error=error"); //redirect to the index.php page with an error message
    }
}
