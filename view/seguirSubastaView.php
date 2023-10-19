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
    error_reporting(E_ALL);
    ini_set('display_errors', 1);    

    include '../business/seguirSubastaBusiness.php';
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
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/seguirSubastaAction.php">
                <tr>
                    <td>
                        <input type="hidden" name="clienteid" id="clienteid" value="<?php echo $clienteId; ?>" readonly>
                        <span><?php echo $clienteNombreCompleto; ?></span>
                    </td>
                    <td>
                        <select name="subastaidview" id="subastaidview">
                            <option value="">Seleccionar subasta</option>
                            <?php                         
                            if (count($getSub) > 0) {
                                foreach ($getSub as $sub) {
                                    foreach($getArticulos as $art){
                                        foreach($getCliente as $cliente){
                                            if($sub->getSubastaArticuloId() == $art->getArticuloId() && $sub->getSubastaVendedorId() == $cliente->getClienteId()){
                                                echo '<option value="' . $sub->getSubastaArticuloId() . '">' . $art->getArticuloNombre() . '-' . $cliente->getClienteNombre() .'</option>';
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
                </tr>
            </form>
        </table>
    </section>
    <br><br>
    <div id="resultado">

    </div>

    <script>
        $(document).ready(function() {
            $('#subastaidview').change(function() {
                recargarLista();
            });
        })

        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "../business/seguirSubastaAction.php",
                data: "valor=" + $('#subastaidview').val(),
                success: function(r) {
                    $('#resultado').html(r);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error en la solicitud AJAX: " + errorThrown);
                },
            });
        }
    </script>
</body>
</html>