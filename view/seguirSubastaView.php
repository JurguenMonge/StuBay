<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stubay</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(0);

    include '../business/seguirSubastaBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/pujaBusiness.php';
    include '../business/articuloBusiness.php';
    $articuloBusiness = new ArticuloBusiness();
    $getArticulos = $articuloBusiness->getAllTBArticulo();
    $clienteBusiness = new clienteBusiness();
    $getCliente = $clienteBusiness->getAllTBCliente();
    $subastaBusiness = new SubastaBusiness();
    $getSub = $subastaBusiness->getAllTBSubasta();
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
    <header>
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Seguir Subasta</h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>
    <section id="form">
        <table>
            <tr>
                <th>Cliente</th>
                <th>Subasta</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/seguirSubastaAction.php">
                <tr>
                    <td>
                        <select name="clienteidview" id="clienteidview">
                            <option value="">Seleccionar cliente</option>
                            <?php
                            if (count($getCliente) > 0) {
                                foreach ($getCliente as $cliente) {

                                    echo '<option value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . ' 
                                    ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ningun cliente registrado</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="subastaidview" id="subastaidview">
                            <option value="">Seleccionar subasta</option>
                            <?php
                            if (count($getSub) > 0) {
                                foreach ($getSub as $sub) {
                                    foreach ($getArticulos as $art){
                                        if($sub->getSubastaArticuloId() == $art->getArticuloId()){
                                            echo '<option value="' . $sub->getSubastaId() . '">' . $art->getArticuloNombre() . '</option>';
                                        }
                                    }
                                }
                            } else {
                                echo '<option value="">Ninguna subasta registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td><input required type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            error_reporting(0);
            $seguirSubastaBusiness = new SeguirSubastaBusiness();
            $allSeguirSubasta = $seguirSubastaBusiness->getAllTBSeguirSubasta();
            foreach ($allSeguirSubasta as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/seguirSubastaAction.php" onsubmit="return confirmarActualizacion();">';
                echo '<input type="hidden" name="subastaseguidoridview" id="subastaseguidoridview" value="' . $current->getSeguirSubastaId() . '"/>';
                echo '<tr>';
                echo '<td>
                <select name="clienteidview" id="clienteidview">';
                foreach ($getCliente as $cliente) {
                    if ($current->getClienteId() == $cliente->getClienteId()) {
                        echo '<option selected value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . '
                            ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido() . '</option>';
                    } else {
                        echo '<option value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . ' 
                           ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido() . '</option>';
                    }
                }
                echo '</select>
                </td>';
                echo '<td><select name="subastaidview" id="subastaidview">';
                foreach ($getSub as $sub) {
                    if ($current->getSubastaId() == $sub->getSubastaId()) {
                        echo '<option selected value="' . $sub->getSubastaId() . '">' . $sub->getSubastaArticuloId() . '</option>';
                    } else {
                        echo '<option value="' . $sub->getSubastaId() . '">' . $sub->getSubastaArticuloId() . '</option>';
                    }
                }
                echo '</select></td>';
                echo '<td><input type="hidden" name="subastaseguidoractivoview" id="subastaseguidoractivoview" ' . ($current->getSeguirSubastaActivo() == 1 ? 'checked' : '') . '></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><button type="button" class="btn btn-danger delete_seguirsubasta" tbsubastaseguidorid="' . $current->getSeguirSubastaId() . '">Eliminar</button></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>

        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".delete_seguirsubasta").on("click", function() {
                var seguirsubastaid = $(this).attr("tbpujaseguidorid");

                Swal.fire({
                    title: '¿Desea eliminar el cliente?',
                    text: "No se podrá revertir el cambio",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../business/seguirSubastaAction.php?delete1=true&tbpujaseguidorid=" + seguirsubastaid;
                    }
                });
            });
        });
    </script>
    <script>
        function confirmarActualizacion() {
            // Muestra una alerta de confirmación y captura la respuesta del usuario.
            var confirmacion = confirm("¿Desea confirmar la actualización de este cliente?");

            // Retorna true si el usuario acepta, lo que enviará el formulario.
            return confirmacion;
        }
    </script>
</body>

</html>