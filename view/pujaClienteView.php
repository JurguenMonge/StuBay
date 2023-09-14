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
            // Inicialmente, deshabilita la selección del artículo y las etiquetas HTML
            $('#articuloIdView').prop('disabled', true);

            // Escucha el evento change del campo de selección del cliente
            $('#clienteIdView').change(function() {
                // Verifica si se ha seleccionado un cliente válido
                if ($(this).val() !== '') {
                    // Habilita la selección del artículo
                    $('#articuloIdView').prop('disabled', false);
                } else {
                    // Si no se ha seleccionado un cliente válido, deshabilita la selección del artículo
                    $('#articuloIdView').prop('disabled', true);
                }
            });

            // Escucha el evento change del campo de selección del artículo
            $('#articuloIdView').change(function() {
                //var valor = "valor=" + $(this).val();
                //var valor2 = "valor2=" + $('#clienteIdView').val();

                $.ajax({
                    type: "POST",
                    url: "../business/subastaAction.php",
                    data: {
                        "valor": $(this).val(),
                        "valor2": $('#clienteIdView').val()
                    },
                    success: function(r) {

                        var data = JSON.parse(r);

                        $('#subastaIdView').val(data.precioInicial);
                        $('#pujaClienteEnvioView').val(data.costoEnvio);
                    }
                });
            });
        });
    </script>

    <style>
        .input-container {
            position: relative;
            width: 200px;
            /* Puedes ajustar el ancho según tus necesidades */
        }

        .currency-symbol {
            position: absolute;
            left: 5px;
            /* Ajusta la posición horizontal del símbolo */
            top: 40%;
            /* Centra verticalmente el símbolo */
            transform: translateY(-50%);
            font-size: 18px;
            /* Ajusta el tamaño del símbolo según tus necesidades */
            color: #333;
            /* Ajusta el color según tus necesidades */
            pointer-events: none;
            /* Evita que el usuario interactúe con el símbolo */
        }

        #pujaClienteOfertaView {
            padding-left: 25px;
            /* Añade un espacio a la izquierda del campo para el símbolo */
        }

        #pujaClienteEnvioView {
            padding-left: 25px;
            /* Añade un espacio a la izquierda del campo para el símbolo */
        }

        #subastaIdView {
            padding-left: 25px;
            /* Añade un espacio a la izquierda del campo para el símbolo */
        }
    </style>

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
    $precioOferta = 1000;
    $precioOfertaFormateado = '₡' . number_format($precioInicial, 2, '.', ',');
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
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Pujas Cliente</h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>

    <section id="form">
        <table>
            <tr>
                <th>Nombre del Cliente</th>
                <th>Nombre del artículo</th>
                <th>Precio Inicial</th>
                <th>Costo Envío</th>
                <th>Fecha</th>
                <th>Oferta</th>

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


                    <td>
                        <div class="input-container">
                            <span class="currency-symbol">₡</span>
                            <input required type="text" name="subastaIdView" id="subastaIdView" maxlength="1000" readonly />
                        </div>
                    </td>
                    <td>
                        <div class="input-container">
                            <span class="currency-symbol">₡</span>
                            <input required type="text" name="pujaClienteEnvioView" id="pujaClienteEnvioView" readonly />
                        </div>
                    </td>
                    <td><input required type="text" name="pujaClienteFechaView" id="pujaClienteFechaView" readonly /></td>

                    <td>
                        <div class="input-container">
                            <span class="currency-symbol">₡</span>
                            <input required type="text" name="pujaClienteOfertaView" id="pujaClienteOfertaView" min="0" step="0.01" />
                        </div>
                    </td>


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
                echo '<td>
                        <div class="input-container">
                            <span class="currency-symbol">₡</span>
                            <input type="number" name="pujaClienteEnvioView" id="pujaClienteEnvioView" readonly value="' . $current->getPujaClienteEnvio() . '"/>
                        </div">
                    </td>';
                echo '<td><input type="datetime-local" name="pujaClienteFechaView" id="pujaClienteFechaView" value="' . $current->getPujaClienteFecha() . '"/></td>';
                echo '<td>
                        <div class="input-container">
                            <span class="currency-symbol">₡</span>
                            <input type="number" name="pujaClienteOfertaView" id="pujaClienteOfertaView" value="' . $current->getPujaClienteOferta() . '"/>
                        </div">
                    </td>';

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
            var precioInicial = parseFloat(document.getElementById("subastaIdView").value.replace("₡", "").replace(",", ""));

            var precioActual = parseFloat(document.getElementById("pujaClienteOfertaView").value);
            console.log(precioInicial);
            // Verifica si el precio actual es mayor que el precio inicial
            if (precioActual <= precioInicial) {
                alert("La oferta debe ser mayor que el precio inicial del artículo.");
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