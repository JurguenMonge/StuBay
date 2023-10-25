<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificacion Comprador</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

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

        $fechaActual = date('Y-m-d H:i:s');
        $getSubasta = $subastaBusiness->getAllTBSubastasTerminadas($fechaActual, $clienteId);
    } else {
        echo "No has iniciado sesión";
    }
    ?>
    <script>
        $(document).ready(function() {
            $('#subastaidview').change(function() {
                var subastaidview = $(this).val();
                $.ajax({
                    url: '../business/calificacionCompradorAction.php',
                    method: 'POST',
                    data: {
                        subastaidview: subastaidview
                    },
                    success: function(response) {

                        var data = JSON.parse(response);
                        console.log(data);
                        var template = '';
                        // data.ganador.forEach(ganador => {
                        //     template += `
                        //     <span> Ganador = ${ganador.clienteNombre} ${ganador.clientePrimerApellido}</span>
                        // `;
                        // });
                        template += `
                            <span>${data.ganador}</span>
                        `;
                        $('#ganador').html(template);
                    }
                });
            });
        });
    </script>
</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre " ?></h1>
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
                <th>Vendedor</th>
                <th>Subasta</th>
                <th>Comprador</th>
                <th>Puntos</th>
                <th>Comentarios</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/calificacionCompradorAction.php">
                <tr>
                    <td>
                        <input type="hidden" name="clienteidview" id="clienteidview" value="<?php echo $clienteId; ?>" readonly>
                        <span><?php echo $clienteNombreCompleto; ?></span>
                    </td>
                    <td>
                        <select name="subastaidview" id="subastaidview">
                            <option value="">Seleccionar subasta</option>
                            <?php
                            if (count($getSubasta) > 0) {
                                foreach ($getSubasta as $sub) {
                                    foreach ($getArticulos as $art) {
                                        foreach ($getCliente as $cliente) {
                                            if ($sub->getSubastaArticuloId() == $art->getArticuloId() && $sub->getSubastaVendedorId() == $cliente->getClienteId()) {
                                                echo '<option value="' . $sub->getSubastaArticuloId() . '">' . $art->getArticuloNombre() . '</option>';
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
                    <td id="ganador"></td>
                    <td><input type="number" name="calificacionvendedorpuntosview" id="calificacionvendedorpuntosview" min="1" max="5"></td>
                    <td><textarea name="calificacionvendedorcomentariosview" id="calificacionvendedorcomentariosview"></textarea></td>
                    <td><input type="submit" name="create" id="create" value="crear"></td>
                </tr>

            </form>
        </table>
    </section>
</body>



</html>