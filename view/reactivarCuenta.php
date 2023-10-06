<!DOCTYPE html>
<html>

<head>
    
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> StuBay </title>
    <?php
    error_reporting(0);
    session_start();
    include '../business/clienteBusiness.php';
    ?>
</head>

<body>

    <main>

        <h4>Reactivar cuenta</h4>

        <div class="card-body">

            <form method="post" enctype="multipart/form-data" action="../business/clienteAction.php" >
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