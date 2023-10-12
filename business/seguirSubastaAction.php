<?php

include '../business/seguirSubastaBusiness.php';

if (isset($_POST['valor'])) {
    $tbarticuloid = $_POST['valor'];
    include '../business/pujaClienteBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    $pujaClienteBusiness = new PujaClienteBusiness();
    $getPujas = $pujaClienteBusiness->getTBPujaClienteByArticulo($tbarticuloid);
    $clienteBusiness = new ClienteBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $getCli = $clienteBusiness->getAllTBCliente();
    $getArt = $articuloBusiness->getAllTBArticulo();
    echo '<table border="1">
            <tr>
                <th>Cliente</th>
                <th>Subasta</th>
                <th>Puja Fecha</th>
                <th>Puja Oferta</th>
                <th>Puja Envío</th>
            </tr>';

    foreach ($getPujas as $current) {
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
        echo '<td>' . $current->getPujaClienteFecha() . '</td>';
        echo '<td>₡' . $current->getPujaClienteOferta() . '</td>';
        echo '<td>₡' . $current->getPujaClienteEnvio() . '</td>';
        echo '</tr>';
    }

    echo '</table>';
}
    