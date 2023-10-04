<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <title>StuBay</title>
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
</head>

<body>

    <header>
        <h1>StuBay</h1>
        <h1><?php echo "Bienvenido, $clienteNombre!" ?></h1>
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
    <a href="../session/closesession.php">Cerrar Sesión</a>
</body>

</html>