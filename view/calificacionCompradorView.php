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
    include '../business/calificacionCompradorBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/pujaClienteBusiness.php';
    include '../business/articuloBusiness.php';
    include '../business/clienteCriterioBusiness.php';
    include '../business/criterioBusiness.php';

    $clienteCriterioBusiness = new ClienteCriterioBusiness();
    $criterioBusiness = new CriterioBusiness();
    $getClienteCriterio;
    $getCriterio = $criterioBusiness->getAllTBCriterio();

    $clienteBusiness = new ClienteBusiness();
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
                        var ganador = data.ganador; //aca se obtiene el nombre del ganador de la subasta y se muestra en el campo ganador de la tabla 
                        var clienteid = data.compradorid; //aca se obtiene el id del ganador de la subasta y se asigna al campo oculto
                        $('#ganador').html(ganador); //mostrar el nombre del ganador en el campo ganador de la tabla
                        // Asignar el valor del ganador al campo oculto
                        $('#ganadorInput').val(clienteid);
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

    <div style="position: absolute; top: 0; right: 0; padding: 10px;">
        <label>Puntaje:</label>
        <span style="font-weight: bold; color: black;">
            <?php
            $getClienteCriterio = $clienteCriterioBusiness->getClienteCriterioByIdCliente($clienteId);
            if ($getClienteCriterio != null) {
                foreach ($getCriterio as $current) {
                    if ($getClienteCriterio->getIdCriterio() == $current->getIdCriterio()) {
                        echo $current->getValor();
                    }
                }
            } else {
                echo 'Ninguno';
            }
            ?>
        </span>
    </div>

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
                    <input type="hidden" name="compradoridview" id="ganadorInput">
                    <td><input type="number" name="calificacionvendedorpuntosview" id="calificacionvendedorpuntosview" min="1" max="5"></td>
                    <td><textarea name="calificacionvendedorcomentariosview" id="calificacionvendedorcomentariosview" rows="3" cols="40"></textarea></td>
                    <td><input type="submit" name="create" id="create" value="crear"></td>
                </tr>
            </form>
            <?php
            error_reporting(0);
            $calificacionCompradorBusiness = new CalificacionCompradorBusiness();
            //$getCalifiacionesComprador = $calificacionCompradorBusiness->getTBAllCalificacionComprador();
            $getCalificacionComprador = $calificacionCompradorBusiness->getCalificacionCompradorByClienteId($clienteId);
            foreach ($getCalificacionComprador as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/calificacionCompradorAction.php">';
                echo '<input type="hidden" name="calificacioncompradoridview" id="calificacioncompradoridview" value="' . $current->getCalificacionCompradorId() . '" readonly>';
                echo '<tr>';
                echo '<td><input type="hidden" name="clienteidview" id="clienteidview" value="' . $current->getClienteId() . '" readonly>';
                echo  $clienteNombreCompleto;
                foreach ($getArticulos as $art) {
                    if ($current->getSubastaId() == $art->getArticuloId()) {
                        echo '<td><input type="hidden" name="subastaidview" id="subastaidview" value="' . $art->getArticuloId() . '" readonly>';
                        echo $art->getArticuloNombre();
                        echo '</td>';
                    }
                }
                foreach ($getCliente as $cliente) {
                    if ($current->getCalificacionCompradorClienteId() == $cliente->getClienteId()) {
                        $nombreCompleto = $cliente->getClienteNombre() . ' ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido();
                        echo '<td><input type="hidden" name="compradoridview" id="compradoridview" value="' . $cliente->getClienteId() . '" readonly>';
                        echo $nombreCompleto;
                        echo '</td>';
                    }
                }
                echo '<td><input type="number" name="calificacioncompradorpuntosview" id="calificacioncompradorpuntosview" value="' . $current->getCalificacionCompradorPuntos() . '" min="1" max="5"></td>';
                echo '<td><textarea name="calificacioncompradorcomentariosview" id="calificacioncompradorcomentariosview" >' . $current->getCalificacionCompradorComentarios() . '</textarea></td>';
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