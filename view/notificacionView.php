<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notificacion</title>
    <?php
    error_reporting(0);
    include '../business/intercambioBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    $intercambioBusiness = new IntercambioBusiness();
    $clienteBusiness = new ClienteBusiness();
    $subastaBusiness = new SubastaBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $getArticulos = $articuloBusiness->getAllTBArticulo();
    $getSubastas = $subastaBusiness->getAllTBSubasta();
    $getClientes = $clienteBusiness->getAllTBCliente();
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
    <header>
        <h1>Notificaciones</h1>
        <h1><?php echo "$clienteNombre" ?></h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>
    
    <?php
        $getIntercambios = $intercambioBusiness->getIntercambiosByCliente($clienteId);
        foreach($getIntercambios as $intercambio){
            echo '<span> Numero de intercambio = ' . $intercambio->getIntercambioId() . '</span>';
        }
    ?>

    <?php
        $getIntercambios = $intercambioBusiness->getIntercambiosRechazadosByCliente($clienteId);
        foreach($getIntercambios as $intercambio){
            foreach($getSubastas as $subasta){
                foreach($getArticulos as $articulo){
                    if($intercambio->getSubasta() ==  $subasta->getSubastaId() && $subasta->getSubastaArticuloId() == $articulo->getArticuloId()){
                        echo '<span> Mala suerte! Te rechazaron el intercambio en la subasta = ' . $articulo->getArticuloNombre() . '</span>';
                    }
                }
            }
        }
    ?>

</body>
</html>