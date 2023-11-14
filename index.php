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

<style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f5f5f5;
        }

        header {
            text-align: center;
            margin-bottom: 20px;
        }

        form {
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 20px;
            border-radius: 8px;
            width: 100%;
            max-width: 400px;
            box-sizing: border-box;
        }

        form input {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
        }

        .send-button {
            text-align: center;
        }

        .send-button input {
            background-color: #4caf50;
            color: #fff;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
            font-size: 16px;
        }

        .send-button a {
            display: block;
            margin-top: 10px;
            text-align: center;
            color: #333;
            text-decoration: none;
        }
    </style>

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
            <input type="text" id="clientecorreoview" name="clientecorreoview" placeholder="Ingrese correo" required="">
        </div>
        <input type="password" id="clientepasswordview" name="clientepasswordview" placeholder="Contraseña" required="">
        <div class="send-button">
            <input type="submit" id="login" name="login" value="Ingresar">
        </div>
        <a href="view/registroClienteView.php">Registrarse</a>
        <a href="view/reactivarCuenta.php">Reactivar cuenta</a>
    </form>
</body>

</html>