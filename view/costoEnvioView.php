<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Costo Envio</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(0);
    include '../business/clienteBusiness.php';
    include '../business/costoEnvioBusiness.php';
    $clienteBusiness = new ClienteBusiness();
    $costoEnvioBusiness = new CostoEnvioBusiness();
    $getAllClientes = $clienteBusiness->getAllTBCliente();
    $getAllCostoEnvio = $costoEnvioBusiness->getAllTBCostoEnvio();

    //aca esta lo de la sesion
    include_once("../session/startsession.php");
    session_start();
    if (isset($_SESSION['nombre'])) {
        $clienteId = $_SESSION['id'];
        $clienteNombre = $_SESSION['nombre'];
        $clientePrimerApellido = $_SESSION['apellido1'];
        $clienteSegundoApellido = $_SESSION['apellido2'];
        $clienteNombreCompleto = $clienteNombre . ' ' . $clientePrimerApellido . ' ' . $clienteSegundoApellido;
    } else {
        echo "No has iniciado sesión";
    }
    ?>
</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Costo Envio</h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>

    <section>
        <table>
            <tr>
                <th>Cliente</th>
                <th>Costo por KM</th>
                <th>Activo</th>
            </tr>
            <?php
            $precioInicial = 1000;
            $precioInicialFormateado = '₡' . number_format($precioInicial, 2, '.', ',');
            ?>
            <form method="post" enctype="multipart/form-data" action="../business/costoEnvioAction.php">
                <tr>
                    <td>
                        <input type="hidden" name="clienteIdView" id="clienteIdView" value="<?php echo $clienteId; ?>" readonly>
                        <span><?php echo $clienteNombreCompleto; ?></span>
                    </td>
                    <td>
                        <input required type="text" name="costoEnvioKMView" id="costoEnvioKMView" value="<?php echo $precioInicialFormateado; ?>" />
                    </td>
                    <td>
                        <input type="submit" value="Crear" name="create" id="create" />
                    </td>
                </tr>
            </form>
            <?php
            $clienteById = $costoEnvioBusiness->getTBCostoEnvioByCliente($clienteId);
            foreach ($clienteById as $current) {
                $precioInicial = $current->getCostoPorKM();
                $precioSinSimboloComas = str_replace(['₡', ','], '', $precioInicial);
                $precioComoFloat = (float)($precioSinSimboloComas / 100);
                $precioFormateado = '₡' . number_format($precioComoFloat, 2, ',', '.');
                echo '<form method="post" enctype="multipart/form-data" action="../business/costoEnvioAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getCostoEnvioId() . '">';
                echo '<tr>';
                echo '<td><input type="hidden" name="clienteIdView" id="clienteIdView" value="' . $current->getTbclienteid() . '" readonly>';
                echo '<span>' . $clienteNombreCompleto . '</span></td>';
                echo '<td><input type="text" name="costoEnvioKMView" id="costoEnvioKMView" value="' . $precioFormateado . '"/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>
        </table>
    </section>
</body>

</html>