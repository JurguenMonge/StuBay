<?php
/*
error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
include '../business/pujaClienteBusiness.php';
include '../business/compradorPerfilBusiness.php';
include '../business/clienteCategoriaBusiness.php';
include '../business/clienteClaseBusiness.php';
include '../business/devolucionBusiness.php';

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
                session_start();
                $_SESSION['msj'] = "Puja actualizada correctamente";
            } else {
                header("location: ../view/pujaClienteView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar la puja";
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
                session_start();
                $_SESSION['msj'] = "Puja eliminada correctamente";
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
        $pujaClienteFechaView = $_POST['pujaClienteFechaView'];

        $timestamp = strtotime(str_replace('/', '-', $pujaClienteFechaView));

        $pujaClienteFecha = date('Y-m-d H:i:s', $timestamp);

        $pujaClienteOferta = $_POST['pujaClienteOfertaView'];
        $pujaClienteEnvio = $_POST['pujaClienteEnvioView'];
        $pujaClienteBusiness = new PujaClienteBusiness();
        $compradorPerfilBusiness = new CompradorPerfilBusiness();
        $precioMaximoPujaActual = $pujaClienteBusiness->getPrecioMaximoByArticuloId($articuloId);

        if ($pujaClienteOferta <= $precioMaximoPujaActual) {
            header("location: ../view/pujaClienteView.php?error=fechaError");
            session_start();
            $_SESSION['error'] = "El valor de la oferta debe ser mayor al precio máximo actual ($precioMaximoPujaActual)";
        } else {

            if (
                strlen($clienteId) > 0 && strlen($articuloId) > 0 && strlen($pujaClienteFecha) > 0
                && strlen($pujaClienteOferta) > 0 && strlen($pujaClienteEnvio) > 0
            ) {

                $pujaCliente = new PujaCliente(
                    0,
                    $clienteId,
                    $articuloId,
                    $pujaClienteFecha,
                    $pujaClienteOferta,
                    $pujaClienteEnvio
                );

                $compradorPerfil = null;
                $devolucionBusiness = new DevolucionBusiness();
                $cantidadDevoluciones = $devolucionBusiness->getCantidadDevolucionesPorClienteYSubasta($clienteId, $articuloId);
                
                $cantidadCompra = 0;
                if ($compradorPerfilBusiness->existeCompradorPerfil($clienteId)) {
                    $infoCompra = $pujaClienteBusiness->obtenerInformacionCompras($clienteId, $articuloId);
                    $cantidadCompra = $infoCompra['cantidadCompras'];
                    $montoCompra = $infoCompra['montoCompras']+$pujaClienteOferta;
                    $frecuenciaCompra = $infoCompra['frecuenciaCompra'];

                    $compradorPerfil = new CompradorPerfil(0, $cantidadCompra, $montoCompra, $frecuenciaCompra, $cantidadDevoluciones, $clienteId);
                    

                    $compradorPerfilBusiness->actualizarTBCompradorPerfilById($compradorPerfil);
                } else {
                    $compradorPerfil = new CompradorPerfil(0, 1, $pujaClienteOferta, 0, $cantidadDevoluciones, $clienteId);
                    $compradorPerfilBusiness->insertarTBCompradorPerfil($compradorPerfil);
                }

                if ($compradorPerfil != null) {
                    $clienteCategoriaBusiness = new ClienteCategoriaBusiness();
                    $clienteClaseBusiness = new ClienteClaseBusiness();
                    $criterio = '';

                    if ($cantidadCompra < 5) {
                        $criterio = 'Esporádico';
                    } elseif ($cantidadCompra >= 5 && $cantidadCompra < 10) {
                        $criterio = 'Regular';
                    } elseif ($cantidadCompra >= 10) {
                        $criterio = 'Bueno';
                    }
                    $clienteClaseId = $clienteClaseBusiness->getClienteClaseIdByCriterio($criterio);

                    $clienteCategoria = new ClienteCategoria($clienteId, $clienteClaseId);
                    $clienteCategoriaBusiness->insertarTBClienteCategoria($clienteCategoria);
                }

                $result = $pujaClienteBusiness->insertarTBPujaCliente($pujaCliente);
                if ($result == 1) {
                    header("location: ../view/pujaClienteView.php?success=insert"); //redirect to the index.php page with a success message
                    session_start();
                    $_SESSION['msj'] = "Puja registrada correctamente";
                } else {
                    header("location: ../view/pujaClienteView.php?error=dbError"); //redirect to the index.php page with an error message
                    session_start();
                    $_SESSION['error'] = "Error al registrar la puja";
                }
            } else {
                header("location: ../view/pujaClienteView.php?error=emptyField"); //redirect to the index.php page with an error message
            }
        }
    } else {
        header("location: ../view/pujaClienteView.php?error=error"); //redirect to the index.php page with an error message
    }
} else if (isset($_POST['valor'])) {
    $clienteId = $_POST['valor'];
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    $pujaClienteBusiness = new PujaClienteBusiness();
    $allPujasCliente = $pujaClienteBusiness->getTBPujaClienteById($clienteId);
    $clienteBusiness = new ClienteBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $getCli = $clienteBusiness->getAllTBCliente();
    $getArt = $articuloBusiness->getAllTBArticulo();

    echo '<table border="1">
            <tr>
                <th>Cliente</th>
                <th>Subasta</th>
                <th>Puja Envío</th>
                <th>Puja Fecha</th>
                <th>Puja Oferta</th>
            </tr>';

    foreach ($allPujasCliente as $current) {
        echo '<tr>';
        foreach ($getCli as $cliente) {
            if ($cliente->getClienteId() == $current->getClienteId()) {
                echo '<td>' . $cliente->getClienteNombre() . ' ' . $cliente->getClientePrimerApellido() . '</td>';
            }
        }
        foreach ($getArt as $articulo) {
            if ($articulo->getArticuloId() == $current->getArticuloId()) {
                echo '<td>' .  $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo()  . '</td>';
            }
        }
        echo '<td>₡' . $current->getPujaClienteEnvio() . '</td>';
        echo '<td>' . $current->getPujaClienteFecha() . '</td>';
        echo '<td>₡' . $current->getPujaClienteOferta() . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
