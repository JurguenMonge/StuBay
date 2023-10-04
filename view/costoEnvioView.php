<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Costo Envio</title>
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

        $clienteNombre = $_SESSION['nombre'];
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
                        <select name="clienteIdView" id="clienteIdView">
                            <option value="">Seleccionar cliente</option>
                            <?php
                            if (count($getAllClientes) > 0) {
                                foreach ($getAllClientes as $cliente) {
                                    echo '<option value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ningun cliente registrado</option>';
                            }
                            ?>
                        </select>
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
            foreach ($getAllCostoEnvio as $current) {
                $precioInicial = $current->getCostoPorKM();
                $precioSinSimboloComas = str_replace(['₡', ','], '', $precioInicial);
                $precioComoFloat = (float)($precioSinSimboloComas / 100);
                $precioFormateado = '₡' . number_format($precioComoFloat, 2, ',', '.');
                echo '<form method="post" enctype="multipart/form-data" action="../business/costoEnvioAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getCostoEnvioId() . '">';
                echo '<tr>';
                echo '<td>  <select name="clienteIdView" id="clienteIdView">';
                foreach ($getAllClientes as $cliente) {
                    if ($current->getTbclienteid() == $cliente->getClienteId()) {
                        echo "<option selected value='" . $cliente->getClienteId() . "'>" . $cliente->getClienteNombre() . "</option>";
                    } else {
                        echo "<option value='" . $cliente->getClienteId() . "'>" . $cliente->getClienteNombre() . "</option>";
                    }
                }
                echo ' </select></td>';
                echo '<td><input type="text" name="costoEnvioKMView" id="costoEnvioKMView" value="' . $precioFormateado . '"/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>
            <tr>
                <td></td>
                <td>
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyField") {
                            echo '<p style="color: red">Campo(s) vacio(s)</p>';
                        } else if ($_GET['error'] == "dbError") {
                            echo '<center><p style="color: red">Error al procesar la transacción</p></center>';
                        }
                    } else if (isset($_GET['success'])) {
                        echo '<p style="color: green">Transacción realizada</p>';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </section>
</body>

</html>