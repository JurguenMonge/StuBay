<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pujas del Cliente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <script>
        $(document).ready(function() {
            $('#articuloIdView').change(function() {
                recargarLista();
            });
        })

        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "../business/subastaAction.php",
                data: "valor=" + $('#articuloIdView').val(),
                success: function(r) {
                    $('#precioArticulo').html(r);
                }
            });
        }
    </script>

    <?php
    error_reporting(0);
    include '../business/pujaClienteBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    include '../business/subastaBusiness.php';
    $clienteBusiness = new ClienteBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $subastaBusiness = new SubastaBusiness();

    $getCli = $clienteBusiness->getAllTBCliente();
    $getArt = $articuloBusiness->getAllTBArticulo();
    $getSub = $subastaBusiness->getAllTBSubasta();
    date_default_timezone_set('America/Costa_Rica');
    ?>
</head>

<body>
    <header>
        <h1>Registro Pujas Cliente</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>

    <section id="form">
        <table>
            <tr>
                <th>Nombre del Cliente</th>
                <th>Nombre del artículo</th>
                <th>Precio Inicial</th>
                <th>Fecha</th>
                <th>Oferta</th>
                <th>Costo Envío</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" onsubmit="return validarPrecio()" action="../business/pujaClienteAction.php">
                <tr>
                    <td>
                        <select name="clienteIdView" id="clienteIdView">
                            <option value="">Seleccionar cliente</option>
                            <?php
                            if (count($getCli) > 0) {
                                foreach ($getCli as $cliente) {
                                    echo '<option value="' . $cliente->getClienteId() .  '" data-id="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="articuloIdView" id="articuloIdView">
                            <option value="">Seleccionar artículo</option>
                            <?php
                            $currentDate =  date("Y-m-d H:i:s");
                            var_dump($currentDate);
                            if (count($getArt) > 0 && count($getSub) > 0) {
                                foreach ($getSub as $subasta) {

                                    foreach ($getArt as $articulo) {
                                        
                                        if ($articulo->getArticuloId() == $subasta->getSubastaArticuloId() && $subasta->getSubastaActivo() == 1 && $subasta->getSubastaFechaHoraFinal() > $currentDate) {
                                            echo '<option value="' . $subasta->getSubastaId() . '-' . $articulo->getArticuloId() .  '">' . $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '</option>';
                                        }
                                    }
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td name="precioArticulo" id="precioArticulo"></td>
                    <td><input required type="text" name="pujaClienteFechaView" id="pujaClienteFechaView" readonly /></td>
                    <td><input required type="number" name="pujaClienteOfertaView" id="pujaClienteOfertaView" min="0" step="0.01" /></td>
                    <td><input required type="number" name="pujaClienteEnvioView" id="pujaClienteEnvioView" /></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $pujaClienteBusiness = new PujaClienteBusiness();
            $allPujasCliente = $pujaClienteBusiness->getAllTBPujaCliente();
            foreach ($allPujasCliente as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/pujaClienteAction.php">';
                echo '<input type="hidden" name="pujaClienteIdView" value="' . $current->getPujaClienteId() . '">';
                echo '<tr>';
                foreach ($getCli as $cliente) {
                    if ($cliente->getClienteId() == $current->getClienteId()) {
                        echo '<input type="hidden" name="clienteIdView" id="clienteIdView" value="' . $current->getPujaClienteId() . '">';
                        echo '<td><input type="text" pattern="\d+" title="Ingresa solo números" maxlength="4" readonly value="' . $cliente->getClienteNombre() . ' ' . $cliente->getClientePrimerApellido() . '"/></td>';
                    }
                }

                foreach ($getArt as $articulo) {
                    if ($articulo->getArticuloId() == $current->getArticuloId()) {
                        echo '<input type="hidden" name="articuloIdView" id="articuloIdView" value="' . $current->getArticuloId() . '">';
                        echo '<td><input type="text" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" readonly value="' .  $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo()  . '"/></td>';
                    }
                }
                echo '<td></td>';
                echo '<td><input type="datetime-local" name="pujaClienteFechaView" id="pujaClienteFechaView" value="' . $current->getPujaClienteFecha() . '"/></td>';
                echo '<td><input type="number" name="pujaClienteOfertaView" id="pujaClienteOfertaView" value="' . $current->getPujaClienteOferta() . '"/></td>';
                echo '<td><input type="number" name="pujaClienteEnvioView" id="pujaClienteEnvioView" value="' . $current->getPujaClienteEnvio() . '"/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete" /></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>

            <tr>
                <td></td>
                <td>
                    <?php
                    if (isset($_GET['error'])) {
                        if ($_GET['error'] == "emptyField") {
                            echo '<p style="color: red">Campo(s) vacio(s)</p>';
                        } else if ($_GET['error'] == "dbError") {
                            echo '<center><p style="color: red">Error al procesar la transacción</p></center>';
                        }
                    } else if (isset($_GET['success'])) {
                        echo '<p style="color: green">Transacción realizada</p>';
                    }
                    ?>
                </td>
            </tr>
        </table>
    </section>

    <script>

        function validarPrecio() {
            var precioInicial = parseFloat(document.getElementById("subastaIdView").value);
            var precioActual = parseFloat(document.getElementById("pujaClienteOfertaView").value);
            console.log(precioInicial);
            // Verifica si el precio actual es mayor que el precio inicial
            if (precioActual <= precioInicial) {
                alert("El precio a pujar debe ser mayor que el precio inicial del artículo.");
                return false;
            }
            return true;
        }

        /// Función para actualizar la fecha y hora
        function actualizarFechaHora() {
            // Obtener la fecha y hora actual en la zona horaria de Costa Rica
            var fechaActual = new Date().toLocaleString('es-ES', {
                timeZone: 'America/Costa_Rica'
            });

            // Actualizar el valor del campo de texto
            document.getElementById('pujaClienteFechaView').value = fechaActual;
        }

        // Actualizar la fecha y hora cada segundo
        setInterval(actualizarFechaHora, 1000);

        // Llamar a la función inicialmente para establecer la hora
        actualizarFechaHora();
    </script>

    <footer>
    </footer>

</body>

</html>