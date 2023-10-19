<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Subasta</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(E_ALL);
    error_reporting(0);
    ini_set('display_errors', 1);
    include '../business/articuloBusiness.php';
    include '../business/subastaBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/pujaClienteBusiness.php';
    $articuloBusiness = new ArticuloBusiness();
    $getAllArticulos = $articuloBusiness->getAllTBArticulo();
    $clienteBusiness = new ClienteBusiness();
    $getAllClientes = $clienteBusiness->getAllTBCliente();

    date_default_timezone_set('America/Costa_Rica');
    //Aca es para la sesion
    include_once("../session/startsession.php");
    session_start();
    if (isset($_SESSION['nombre'])) {
        $clienteId = $_SESSION['id'];
        $clienteNombre = $_SESSION['nombre'];
        $clientePrimerApellido = $_SESSION['apellido1'];
        $clienteSegundoApellido = $_SESSION['apellido2'];
        $clienteNombreCompleto = $clienteNombre . ' ' . $clientePrimerApellido . ' ' . $clienteSegundoApellido;
    } else {
        echo "No has iniciado sesión";
    }
    $id = $clienteBusiness->clienteById($clienteId);
    ?>

    <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            margin: 15% auto;
            max-height: 40vh;
            overflow-y: auto;
            display: flex;
            flex-direction: column;
        }

        .modal-content h2 {
            text-align: center;
            /* Centrar horizontalmente */
        }

        /* Estilo para el botón de cerrar */
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }



        .input-container {
            position: relative;
            width: 200px;
            /* Puedes ajustar el ancho según tus necesidades */
        }

        /* Estilos para el contenido del modal */
        .modal-content {
            background-color: #fff;
            margin: 15% auto;
            padding: 20px;
            border-radius: 5px;
            width: 80%;
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            position: relative;
        }

        .cell-column {
            width: 150px;
            /* Cambia el ancho según tus necesidades */
            text-align: center;
            /* Centra el contenido horizontalmente */
        }

        /* Estilos para el botón de cerrar */
        .close {
            color: #aaa;
            position: absolute;
            top: 10px;
            right: 20px;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
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
    </style>

</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Subasta</h1>
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
    <button type="button" id="verHistorialBtn">Ver Subastas Terminadas</button>
    <br><br>
    <section>
        <table>
            <tr>
                <th>Vendedor</th>
                <th>Articulo</th>
                <th>Fecha y Hora inicio</th>
                <th>Fecha y Hora final</th>
                <th>Precio inicial</th>
                <th>Estado del articulo</th>
                <th>Dias de uso</th>
            </tr>
            <?php
            // Obtén el valor del precio inicial desde PHP (esto es solo un ejemplo, asegúrate de tener el valor correcto)
            $precioInicial = 1000; // Aquí puedes reemplazarlo con tu valor real

            // Formatea el valor como moneda con el símbolo de colones
            $precioInicialFormateado = '₡' . number_format($precioInicial, 2, '.', ',');

            // Luego, en tu campo de entrada HTML, puedes mostrar el valor formateado
            ?>

            <form method="post" enctype="multipart/form-data" action="../business/subastaAction.php">
                <td>

                    <input type="hidden" name="vendedorIdView" id="vendedorIdView" value="<?php echo $clienteId; ?>" readonly>
                    <span><?php echo $clienteNombreCompleto; ?></span>


                </td>
                <td>
                    <select name="subastaArticuloView" id="subastaArticuloView">
                        <option value="">Seleccionar articulo</option>
                        <?php
                        if (count($getAllArticulos) > 0) {
                            foreach ($getAllArticulos as $articulo) {
                                if ($articulo->getClienteId() == $clienteId) {
                                    echo '<option value="' . $articulo->getArticuloId() . '">' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '</option>';
                                }
                            }
                        } else {
                            echo '<option value="">Ningun articulo registrado</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <input required type="datetime-local" name="subastaFechaHoraInicioView" id="subastaFechaHoraInicioView" />
                </td>
                <td>
                    <input required type="datetime-local" name="subastaFechaHoraFinalView" id="subastaFechaHoraFinalView" />
                </td>
                <td>
                    <input required type="text" name="subastaPrecioInicialView" id="subastaPrecioInicialView" value="<?php echo $precioInicialFormateado; ?>" />
                </td>
                <td>
                    <select name="subastaEstadoArticuloView" id="subastaEstadoArticuloView">
                        <option value="">Seleccionar estado</option>
                        <option value="Nuevo">Nuevo</option>
                        <option value="Usado">Usado</option>
                    </select>
                </td>
                <td id="estadoUsado" style="display: none;">
                    <input type="number" name="mesesDeUso" id="mesesDeUso">
                </td>
                <td>
                    <input type="submit" value="Crear" name="create" id="create" />
                </td>
            </form>
            <?php
            $subastaBusiness = new SubastaBusiness();
            $obtenerSubastas = $subastaBusiness->getAllTBSubasta();
            $obtenerClienteById = $subastaBusiness->getTBSubastaByClienteId($clienteId);
            foreach ($obtenerClienteById as $actualSubasta) {
                $precioInicial = $actualSubasta->getSubastaPrecioInicial();
                $precioSinSimboloComas = str_replace(['₡', ','], '', $precioInicial);
                $precioComoFloat = (float)($precioSinSimboloComas / 100);
                $precioFormateado = '₡' . number_format($precioComoFloat, 2, ',', '.');
                echo '<form method="post" enctype="multipart/form-data" action="../business/subastaAction.php">';
                echo '<input type="hidden" name="subastaIdView" value="' . $actualSubasta->getSubastaId() . '">';
                echo '<tr>';
                echo '<td><input type="hidden" name="vendedorIdView" id="vendedorIdView" value="' . $clienteId . '" readonly>
                        <span>' . $clienteNombreCompleto . '</span>
                        </td>';
                echo '<td>  <select name="subastaArticuloView" id="subastaArticuloView">';
                foreach ($getAllArticulos as $articulo) {
                    if ($articulo->getClienteId() == $clienteId) {
                        if ($actualSubasta->getSubastaArticuloId() == $articulo->getArticuloId()) {
                            echo "<option selected value='" . $articulo->getArticuloId() . "'>" . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . "</option>";
                        } else {
                            echo "<option value='" . $articulo->getArticuloId() . "'>" . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . "</option>";
                        }
                    }
                }
                echo ' </select></td>';
                echo '<td><input type="datetime-local" name="subastaFechaHoraInicioView" id="subastaFechaHoraInicioView" value="' . $actualSubasta->getSubastaFechaHoraInicio() . '"/></td>';
                echo '<td><input type="datetime-local" name="subastaFechaHoraFinalView" id="subastaFechaHoraFinalView" value="' . $actualSubasta->getSubastaFechaHoraFinal() . '"/></td>';
                echo '<td><input type="text" name="subastaPrecioInicialView" id="subastaPrecioInicialView" value="' . $precioFormateado . '"/></td>';
                echo '<td>  <select name="subastaEstadoArticuloView" id="subastaEstadoArticuloView">';
                if ($actualSubasta->getSubastaEstadoArticulo() == 'Nuevo') {
                    echo "<option value='Nuevo'>Nuevo</option>";
                    echo "<option value='Usado'>Usado</option>";
                } else {
                    echo "<option value='Usado'>Usado</option>";
                    echo "<option value='Nuevo'>Nuevo</option>";
                }
                echo '</select></td>';
                if ($actualSubasta->getSubastaEstadoArticulo() == 'Usado') {
                    echo '<td><input type="number" name="mesesDeUso" id="mesesDeUso" value="' . $actualSubasta->getSubastaDiasUsoArticulo() . '"/></td>';
                }
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>
        </table>
    </section>

    <div id="historialModal" class="modal">
        <div class="modal-content">
            <span class="close" id="cerrarModal">&times;</span>
            <h2>Historial de Subastas Terminadas</h2>
            <table class="tbHistorico">
                <thead>
                    <tr>
                        <th>Comprador</th>
                        <th>Artículo</th>
                        <th>Costo del Envío</th>
                        <th>Fecha</th>
                        <th>Oferta</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $pujaClienteBusiness = new PujaClienteBusiness();
                    $subastaBusiness = new SubastaBusiness();
                    
                    $currentDate =  date("Y-m-d H:i:s");
                    $subastasTerminadas = $subastaBusiness->getAllTBSubastasTerminadas($currentDate, $clienteId);
                                        
                    foreach ($subastasTerminadas as $subastas) {
                        $pujaClienteGanador = $pujaClienteBusiness->getPujaClienteGanador($subastas->getSubastaArticuloId());
                        echo '<input type="hidden" name="pujaClienteIdView" value="' . $pujaClienteGanador->getPujaClienteId() . '">';
                        echo '<tr>';
                        foreach ($getAllClientes as $cliente) {
                            if ($cliente->getClienteId() == $pujaClienteGanador->getClienteId()) {
                                echo '<input type="hidden" name="clienteIdView" id="clienteIdView" value="' . $pujaClienteGanador->getPujaClienteId() . '">';
                                echo '<td><input type="text" pattern="\d+" title="Ingresa solo números" maxlength="4" readonly value="' . $cliente->getClienteNombre() . ' ' . $cliente->getClientePrimerApellido() . '"/></td>';
                            }
                        }

                        foreach ($getAllArticulos as $articulo) {
                            if ($articulo->getArticuloId() == $pujaClienteGanador->getArticuloId()) {
                                echo '<input type="hidden" name="articuloIdView" id="articuloIdView" value="' . $pujaClienteGanador->getArticuloId() . '">';
                                echo '<td><input type="text" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" readonly value="' .  $articulo->getArticuloNombre() . '-' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo()  . '"/></td>';
                            }
                        }

                        echo '<td>
                                <div class="input-container">
                                    <span class="currency-symbol">₡</span>
                                    <input type="number" name="pujaClienteEnvioView" id="pujaClienteEnvioView" readonly value="' . $pujaClienteGanador->getPujaClienteEnvio() . '"/>
                                </div">
                            </td>';
                        echo '<td><input type="datetime-local" name="pujaClienteFechaView" id="pujaClienteFechaView" readonly value="' . $pujaClienteGanador->getPujaClienteFecha() . '"/></td>';
                        echo '<td>
                                <div class="input-container">
                                    <span class="currency-symbol">₡</span>
                                    <input type="number" name="pujaClienteOfertaView" id="pujaClienteOfertaView" readonly value="' . $pujaClienteGanador->getPujaClienteOferta() . '"/>
                                </div">
                            </td>';

                        echo '</tr>';
                    }

                    if ($subastasTerminadas == NULL) {
                        echo '<td><span>No posee Subastas terminadas</span></td>';
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        // JavaScript para mostrar el modal del historial de pujas
        var verHistorialBtn = document.getElementById("verHistorialBtn");
        var historialModal = document.getElementById("historialModal");
        var cerrarModal = document.getElementById("cerrarModal");

        verHistorialBtn.addEventListener("click", function() {
            historialModal.style.display = "block";
        });

        cerrarModal.addEventListener("click", function() {
            historialModal.style.display = "none";
        });

        // Cierra el modal si el usuario hace clic fuera de él
        window.addEventListener("click", function(event) {
            if (event.target == historialModal) {
                historialModal.style.display = "none";
            }
        });

        document.getElementById('subastaEstadoArticuloView').addEventListener('change', function() {
            var estadoSeleccionado = this.value;
            var estadoUsado = document.getElementById('estadoUsado');

            // Oculta ambos campos
            estadoUsado.style.display = 'none';

            // Muestra el campo correspondiente según la selección
            if (estadoSeleccionado === 'Usado') {
                estadoUsado.style.display = 'table-cell'; // Puedes ajustar el estilo según tu diseño
            }
        });
    </script>
</body>

</html>