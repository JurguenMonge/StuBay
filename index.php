<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>StuBay</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    error_reporting(0);

    include '../business/clienteBusiness.php';
    include_once("../session/startsession.php");
    session_start();
    ?>


</head>

<body>

    <header>
        <h1>StuBay</h1>
    </header>
    <!-- Verificar si $mensaje está definido y no es nulo -->
    <?php if (isset($mensaje) && !is_null($mensaje)): ?>
        <div class="alert alert-success">
            <?php echo $mensaje; ?>
        </div>
    <?php endif; ?>
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

    <form method="POST" enctype="multipart/form-data" action="../StuBay/business/clienteAction.php">
        <div class="col-12">
            <input type="text" id="clientecorreoview" name="clientecorreoview" placeholder="Ingrese  correo" required="">

        </div>
        <input type="password" id="clientepasswordview" name="clientepasswordview" placeholder="Contraseña" required="">
        <div class="send-button">
            <input type="submit" id="login" name="login" value="Ingresar">
        </div>
        <a href="view/registroClienteView.php" style="display: inline-block; margin-right: 10px;">Registrarse</a>
        <a href="view/reactivarCuenta.php" style="display: inline-block;">Reactivar cuenta</a>
    </form>
</body>

</html>