<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificacion</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(0);
    include '../business/intercambioBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    $intercambioBusiness = new IntercambioBusiness();
    $clienteBusiness = new ClienteBusiness();
    $subastaBusiness = new SubastaBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $getArticulos = $articuloBusiness->getAllTBArticulo();
    $getSubastas = $subastaBusiness->getAllTBSubasta();
    $getClientes = $clienteBusiness->getAllTBCliente();
    include_once("../session/startsession.php");
    //session_start();
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
        <h1>Notificaciones</h1>
        <h1><?php echo "$clienteNombre" ?></h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>
    <?php
    if (isset($_SESSION['msj'])) { // Si existe la variable de sesión
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '<?php echo $_SESSION['msj']; ?>',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php unset($_SESSION['msj']); // Eliminar la variable de sesión
    } ?>

    <?php
    if (isset($_SESSION['error'])) { // Si existe la variable de sesión
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '<?php echo $_SESSION['error']; ?>',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php unset($_SESSION['error']); // Eliminar la variable de sesión
    } ?>

    <table border="1">
        <tr>
            <th>Articulo a cambio</th>
            <th>Cliente</th>
            <th>Subasta</th>
        </tr>

        <?php
        $getIntercambios = $intercambioBusiness->getIntercambiosByCliente($clienteId);
        foreach ($getIntercambios as $intercambio) {
            foreach ($getSubastas as $subasta) {
                foreach ($getArticulos as $articulo) {
                    foreach ($getClientes as $cliente) {
                        if ($intercambio->getArticulo() ==  $articulo->getArticuloId() && $subasta->getSubastaId() == $intercambio->getSubasta() && $intercambio->getComprador() == $cliente->getClienteId()) {
                            echo '<form method="post" enctype="multipart/form-data" action="../business/intercambioAction.php" ">';
                            echo '<input type="hidden" name="clienteidview" value="' . $clienteId . '">';
                            echo '<input type="hidden" name="intercambioid" id="intercambioid" value="' . $intercambio->getIntercambioId() . '">';
                            echo '<tr>';
                            echo '<td><span> ' .  $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '-' . $articulo->getArticuloSerie() . '</span></td>';
                            echo '<td><span> ' . $cliente->getClienteNombre() . '</span></td>';
                            foreach ($getArticulos as $articulo) {
                                if($articulo->getArticuloId() == $subasta->getSubastaArticuloId()){
                                    echo '<td><span> ' .  $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '-' . $articulo->getArticuloSerie() . '</span></td>';
                                }
                            }      
                            echo '<td><input type="submit" value="Aceptar" name="aceptar" id="aceptar"/></td>';
                            echo '<td><input type="submit" value="Rechazar" name="rechazar" id="rechazar"/></td>';
                            echo '</tr>';
                            echo '</form>';
                        }
                    }
                }
            }
        }
        ?>
    </table>
    <br><br><br>
    <section>
    <table border="1">
        <?php
            $getIntercambios = $intercambioBusiness->getIntercambiosRechazadosByCliente($clienteId);
            foreach ($getIntercambios as $intercambio) {
                foreach ($getSubastas as $subasta) {
                    foreach ($getArticulos as $articulo) {
                        if ($intercambio->getSubasta() ==  $subasta->getSubastaId() && $subasta->getSubastaArticuloId() == $articulo->getArticuloId()) {
                            echo '<tr>';
                            echo '<td><span> ¡Mala suerte! Te rechazaron el intercambio en la subasta = ' . $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '-' . $articulo->getArticuloSerie() . '</span></td>';
                            echo '</tr>';
                        }
                    }
                }
            }
            ?>
    </table>
    </section>
    <br><br><br>
    <section>
    <table border="1">
        <?php
            $getIntercambios = $intercambioBusiness->getIntercambiosAceptadosByCliente($clienteId);
            foreach ($getIntercambios as $intercambio) {
                foreach ($getSubastas as $subasta) {
                    foreach ($getArticulos as $articulo) {
                        if ($intercambio->getSubasta() ==  $subasta->getSubastaId() && $subasta->getSubastaArticuloId() == $articulo->getArticuloId()) {
                            echo '<tr>';
                            echo '<td><span> ¡Buena suerte! Te aceptaron el intercambio en la subasta = ' . $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '-' . $articulo->getArticuloSerie() . '</span></td>';
                            echo '</tr>';
                        }
                    }
                }
            }
            ?>
    </table>
    </section>
    

</body>

</html>