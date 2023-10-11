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
    $articuloBusiness = new ArticuloBusiness();
    $getAllArticulos = $articuloBusiness->getAllTBArticulo();
    $clienteBusiness = new ClienteBusiness();
    $getAllClientes = $clienteBusiness->getAllTBCliente();

    //Aca es para la sesion
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
                    <select name="vendedorIdView" id="vendedorIdView">
                        <option value="">Seleccionar vendedor</option>
                        <?php
                        if (count($getAllClientes) > 0) {
                            foreach ($getAllClientes as $cliente) {
                                if ($clienteNombre == $cliente->getClienteNombre()) {
                                    echo '<option value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . '</option>';
                                }
                            }
                        } else {
                            echo '<option value="">Ningun cliente registrado</option>';
                        }
                        ?>
                    </select>
                </td>
                <td>
                    <select name="subastaArticuloView" id="subastaArticuloView">
                        <option value="">Seleccionar articulo</option>
                        <?php
                        if (count($getAllArticulos) > 0) {
                            foreach ($getAllArticulos as $articulo) {
                                echo '<option value="' . $articulo->getArticuloId() . '">' . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . '</option>';
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
            foreach ($obtenerSubastas as $actualSubasta) {
                $precioInicial = $actualSubasta->getSubastaPrecioInicial();
                $precioSinSimboloComas = str_replace(['₡', ','], '', $precioInicial);
                $precioComoFloat = (float)($precioSinSimboloComas / 100);
                $precioFormateado = '₡' . number_format($precioComoFloat, 2, ',', '.');
                echo '<form method="post" enctype="multipart/form-data" action="../business/subastaAction.php">';
                echo '<input type="hidden" name="subastaIdView" value="' . $actualSubasta->getSubastaId() . '">';
                echo '<tr>';
                echo '<td>  <select name="vendedorIdView" id="vendedorIdView">';
                foreach ($getAllClientes as $cliente) {
                    if ($actualSubasta->getSubastaVendedorId() == $cliente->getClienteId()) {
                        echo "<option selected value='" . $cliente->getClienteId() . "'>" . $cliente->getClienteNombre() . "</option>";
                    } else {
                        echo "<option value='" . $cliente->getClienteId() . "'>" . $cliente->getClienteNombre() . "</option>";
                    }
                }
                echo ' </select></td>';
                echo '<td>  <select name="subastaArticuloView" id="subastaArticuloView">';
                foreach ($getAllArticulos as $articulo) {
                    if ($actualSubasta->getSubastaArticuloId() == $articulo->getArticuloId()) {
                        echo "<option selected value='" . $articulo->getArticuloId() . "'>" . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . "</option>";
                    } else {
                        echo "<option value='" . $articulo->getArticuloId() . "'>" . $articulo->getArticuloMarca() . '-' . $articulo->getArticuloModelo() . "</option>";
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
    <script>
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