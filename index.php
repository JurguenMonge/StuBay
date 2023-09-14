<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./css/style.css">
    <title>StuBay</title>
    <?php
    error_reporting(0);
    include '../business/clienteBusiness.php';
    include_once("../Session/startsession.php");
    ?>
</head>

<body>

    <header>
        <h1>StuBay</h1>
    </header>

    <form class="login-form" method="POST" enctype="multipart/form-data" action="../StuBay/business/clienteAction.php"  >
        <div class="col-12">
            <input type="text" id="clientecorreoview" name="clientecorreoview" placeholder="Ingrese  correo" required="">
            <div class="invalid-feedback">Por favor ingresar su password
                correctamente!</div>
        </div>
        <input type="password" id="clientepasswordview" name="clientepasswordview" placeholder="Contraseña" required="">
        <div class="send-button">
            <input type="submit" id="login" name="login" value="Ingresar">
        </div>
        
    </form>
</body>

</html>