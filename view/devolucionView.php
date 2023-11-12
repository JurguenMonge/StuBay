<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Devolucion</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../business/pujaClienteBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    $pujaClienteBusiness = new PujaClienteBusiness();
    //include '../business/subastaBusiness.php';
    $clienteBusiness = new ClienteBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $subastaBusiness = new SubastaBusiness();

    $getCli = $clienteBusiness->getAllTBCliente();
    $getArt = $articuloBusiness->getAllTBArticulo();
    $getSub = $subastaBusiness->getAllTBSubastaOrdenadas();

    date_default_timezone_set('America/Costa_Rica');


    //aca esta lo de la sesion
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
        <h1><?php echo "$clienteNombre" ?></h1>
        <h1>Devolucion</h1>
        <h2><a href="inicioView.php">Home</a></h2>
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
    }
    ?>
    <table>
        <tr>
            <th>Cliente</th>
            <th>Justificacion</th>
            <th>Subasta</th>
        </tr>
        <form method="post" enctype="multipart/form-data" action="../business/devolucionAction.php">
                <td>
                    <input type="hidden" name="clienteid" id="clienteid" value="<?php echo $clienteId; ?>" readonly>
                    <span><?php echo $clienteNombreCompleto; ?></span>
                </td>
                <td>
                    <textarea required name="justificacion" id="justificacion" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios" rows="3" cols="40"></textarea>
                </td>
                <td>
                    <select name="subastaidview" id="subastaidview">
                    <option value="">Seleccionar subasta</option>
                    <?php
                    $pujaGanada = $pujaClienteBusiness->getTBPujaClienteGanadorById($clienteId);
                    $currentDate = date("Y-m-d H:i:s");
                    foreach($pujaGanada as $puja){
                        foreach ($getSub as $sub) {
                            foreach($getArt as $art){
                                if($sub->getSubastaArticuloId() == $art->getArticuloId() && $sub->getSubastaId() == $puja->getArticuloId()){
                                    echo '<option value="' . $sub->getSubastaId() . '">' . $art->getArticuloNombre() .'</option>';
                                } 
                            }
                            
                        }
                    }   
                    ?>
                    </select>   
                </td>
                <td>
                    <input type="submit" value="Crear" name="create" id="create" />
                </td>
        </form>
    </table>
   


</body>
</html>