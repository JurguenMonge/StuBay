<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificacion Comprador</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>

    <?php
    include '../business/clienteBusiness.php';
    include '../business/pujaClienteBusiness.php';
    include '../business/articuloBusiness.php';
    $clienteBusiness = new clienteBusiness();
    $getCliente = $clienteBusiness->getAllTBCliente();
    $subastaBusiness = new SubastaBusiness();
    $getSub = $subastaBusiness->getAllTBSubastaNoActivas();
    $articuloBusiness = new ArticuloBusiness();
    $getArticulos = $articuloBusiness->getAllTBArticulo();
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
        <h1><?php echo "$clienteNombre "?></h1>
        <h1>Registro Calificacion Comprador</h1>
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

    <section id="form">
        <table>
            <tr>
                <th>Comprador</th>
                <th>Subasta</th>
                <th>Vendedor</th>
                <th>Puntos</th>
                <th>Comentarios</th>
            </tr>
            <form method="post" action="../business/calificacionVendedorAction.php">
                <tr>
                    <td>
                        <input type="hidden" name="clienteidview" id="clienteidview" value="<?php echo $clienteId; ?>" readonly>
                        <span><?php echo $clienteNombreCompleto; ?></span>
                    </td>
                    <td>
                        <select name="subastaidview" id="subastaidview">
                            <option value="">Seleccionar subasta</option>
                            <?php
                            if (count($getSub) > 0) {
                                foreach ($getSub as $sub) {
                                    foreach ($getArticulos as $art) {
                                        foreach ($getCliente as $cliente) {
                                            if ($sub->getSubastaArticuloId() == $art->getArticuloId() && $sub->getSubastaVendedorId() == $cliente->getClienteId()) {
                                                echo '<option value="' . $sub->getSubastaArticuloId() . '">' . $art->getArticuloNombre() . '-' . $cliente->getClienteNombre() . '</option>';
                                            }
                                        }
                                    }
                                }
                            } else {
                                echo '<option value="">Ninguna subasta registrada</option>';
                            }
                            ?>
                        </select>
                    </td>

                    <td><input type="number" name="calificacionVendedorPuntos" id="calificacionVendedorPuntos" min="1" max="5"></td>
                    <td><textarea name="calificacionVendedorComentarios" id="calificacionVendedorComentarios"></textarea></td>
                    <td><input type="submit" name="create" id="create" value="Registrar"></td>
                </tr>

            </form>
        </table>
    </section>
</body>

</html>