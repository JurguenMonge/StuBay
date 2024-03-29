<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> StuBay </title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    error_reporting(0);
    session_start();
    include '../business/clienteBusiness.php';
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
    <main>
        <h2><a href="../index.php">StuBay</a></h2>
        <h4>Reactivar cuenta</h4>

        <div class="card-body">

            <form method="post" enctype="multipart/form-data" action="../business/clienteAction.php">
                <div class="col-12">
                    <input type="text" name="clientecorreo" id="clientecorreo" placeholder="Correo electrónico" required="">
                </div>
                <div class="col-12">
                    <input type="password" name="clientepassword" id="clientepassword" placeholder="Contraseña" required="">
                </div>
                <div class="send-button">
                    <input type="submit" name="reactivar" id="reactivar" value="Reactivar cuenta">
                </div>
            </form>

        </div>


    </main>

</body>

</html>