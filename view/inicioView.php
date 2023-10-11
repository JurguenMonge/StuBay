<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>StuBay</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">

    
    <?php
    error_reporting(0);
    include '../business/clienteBusiness.php';
    include_once("../session/startsession.php");
    session_start();
    if (isset($_SESSION['nombre'])) {

        $clienteNombre = $_SESSION['nombre'];
    } else {
        echo "No has iniciado sesión";
    }
    ?>
    <script>
    // ... Otro código ...

    function showToast(message) {
        toastr.options = {
            "positionClass": "toast-top-right",
            "showDuration": "300",
            "hideDuration": "1000",
            "timeOut": "5000",
            "extendedTimeOut": "1000",
            "showEasing": "swing",
            "hideEasing": "linear",
            "showMethod": "fadeIn",
            "hideMethod": "fadeOut"
        };
        toastr.info(message, "Nuevo mensaje");
    }

    // Resto de tu código ...
</script>
</head>

<body>

    <header>
        <h1>StuBay</h1>
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

    <a href="clienteView.php">Registro Cliente</a>
    <br><br>
    <a href="clienteDireccionView.php">Registro Dirección Cliente</a>
    <br><br>
    <a href="clienteTelefonoView.php">Registro Teléfono Cliente</a>
    <br><br>
    <a href="articuloView.php">Registro Articulo</a>
    <br><br>
    <a href="categoriaView.php">Registro Categorías</a>
    <br><br>
    <a href="subCategoriaView.php">Registro Subcategorías</a>
    <br><br>
    <a href="subastaView.php">Registrar Subasta</a>
    <br><br>
    <a href="pujaClienteView.php">Registrar Puja</a>
    <br><br>
    <a href="costoEnvioView.php">Registrar Costo envio</a>
    <br><br>
    <a href="seguirSubastaView.php">Seguir Subasta</a>
    <br><br>
    <a href="../session/closesession.php">Cerrar Sesión</a>
</body>

</html>