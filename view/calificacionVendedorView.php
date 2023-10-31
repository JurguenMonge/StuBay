<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calificacion Vendedor</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    <?php
    
    include '../business/calificacionVendedorBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/pujaClienteBusiness.php';
    include '../business/articuloBusiness.php';

    $clienteBusiness = new clienteBusiness();
    $getCliente = $clienteBusiness->getAllTBCliente();
    $subastaBusiness = new SubastaBusiness();
    //$getSub = $subastaBusiness->getAllTBSubastaNoActivas();

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

    $pujaClienteBusiness = new PujaClienteBusiness();
    $getPujaCliente = $pujaClienteBusiness->getTBPujaClienteById($clienteId);
    ?>
    <script>
        $(document).ready(function() {
            $('#subastaidview').change(function() {
                var subastaidview = $(this).val();
                $.ajax({
                    url: '../business/calificacionVendedorAction.php',
                    method: 'POST',
                    data: {
                        subastaidview: subastaidview
                    },
                    success: function(response) {
                        var data = JSON.parse(response);
                        if (data.error) {
                            // Manejar error si lo hay
                            toastr.error(data.error);
                        } else {
                            var vendedor = data.vendedor; // Obtener el nombre del ganador de la subasta
                            var vendedorid = data.vendedorid; // Obtener el ID del ganador de la subasta
                            $('#vendedor').html(vendedor); // Mostrar el nombre del ganador en la tabla
                            // Asignar el valor del ganador al campo oculto
                            $('#vendedorInput').val(vendedorid);
                        }
                    },
                    error: function(xhr, status, error) {
                        // Manejar errores de la petición AJAX
                        toastr.error('Error en la petición AJAX: ' + error);
                    }
                });
            });
        });
    </script>
</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre " ?></h1>
        <h1>Registro Calificacion Vendedor</h1>
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
                            if (count($getPujaCliente) > 0) {
                                foreach ($getPujaCliente as $sub) {
                                    foreach ($getArticulos as $art) {
                                        if ($sub->getArticuloId() == $art->getArticuloId()) {
                                            echo '<option value="' . $art->getArticuloId() . '">' . $art->getArticuloNombre() . '</option>';
                                        }
                                    }
                                }
                            } else {
                                echo '<option value="">Ninguna subasta registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td id="vendedor"></td>
                    <input type="hidden" name="vendedoridview" id="vendedorInput">
                    <td><input type="number" name="calificacionvendedorpuntosview" id="calificacionvendedorpuntosview" min="1" max="5"></td>
                    <td><textarea name="calificacionvendedorcomentariosview" id="calificacionvendedorcomentariosview"></textarea></td>
                    <td><input type="submit" name="create" id="create" value="Crear"></td>
                </tr>
            </form>
            <?php
             error_reporting(0);
             $calificacionVendedorBusiness = new CalificacionVendedorBusiness();
             $getCalificacionVendedor = $calificacionVendedorBusiness->getCalificacionVendedorClienteById($clienteId);
             foreach($getCalificacionVendedor as $current){
                 echo '<form method="post" enctype="multipart/form-data" action="../business/calificacionVendedorAction.php">';
                 echo '<input type="hidden" name="calificacionvendedoridview" id="calificacionvendedoridview" value="' . $current->getCalificacionVendedorId() . '" readonly>';
                 echo '<tr>';
                 echo '<td><input type="hidden" name="clienteidview" id="clienteidview" value="' . $current->getClienteId() . '" readonly>';
                 echo $clienteNombreCompleto;
                 foreach($getArticulos as $art) {
                     if ($current->getSubastaId() == $art->getArticuloId()){
                        echo '<td><input type="hidden" name="subastaidview" id="subastaidview" value="' . $art->getArticuloId() . '" readonly>';
                         echo $art->getArticuloNombre();
                         echo '<td>';
                     }
                 }
                    foreach($getCliente as $cliente){
                        if($current->getCalificacionVendedorClienteId() == $cliente->getClienteId()){
                            echo '<td><input type="hidden" name="vendedoridview" id="vendedoridview" value="' . $cliente->getClienteId() . '" readonly>';
                            echo $cliente->getClienteNombre() . ' ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido();
                            echo '</td>';
                        }
                    }
                    echo '<td><input type="number" name="calificacionvendedorpuntosview" id="calificacionvendedorpuntosview" value="' . $current->getCalificacionVendedorPuntos() . '" min="1" max="5"></td>';
                    echo '<td><textarea name="calificacionvendedorcomentariosview" id="calificacionvendedorcomentariosview" rows="3" cols="40">' . $current->getCalificacionVendedorComentarios() . '</textarea></td>';
                    echo '<td><input type="submit" name="update" id="update" value="Actualizar"></td>';
                    echo '<td><input type="submit" name="delete" id="delete" value="Eliminar"></td>';
                    echo '</tr>';
                    echo '</form>';

             }
            ?>
        </table>
    </section>
</body>

</html>