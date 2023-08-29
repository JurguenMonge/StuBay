<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">
    <?php
    error_reporting(0);
    include '../business/clienteTelefonoBusiness.php';
    include '../business/clienteBusiness.php';
    $clienteBusiness = new clienteBusiness();
    $getCliente = $clienteBusiness->getAllTBCliente();
    //include_once("../Session/session.php");

    session_start(); //Inicia una nueva sesión o reanuda la existente

    ?>
</head>

<body>
    <header>
        <h1>Registro Teléfono Cliente</h1>
        <h2><a href="../index.php">Home</a></h2>
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
    } ?>

    <section id="form">
        <table>
            <tr>
                <th>Cliente</th>
                <th></th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/clienteTelefonoAction.php">
                <tr>
                    <td colspan="3">
                        <input required type="text" name="clientetelefono_datos" id="clientetelefono_datos" pattern="^[0-9,\s-]+$" style="width: 40%;" />
                    </td>
                    <td><input required type="submit" value="Crear" name="create" id="create" onclick="separarYEnviarDatos()" />
                    </td>
                </tr>
            </form>
            <?php
            error_reporting(0);
            $clienteTelefonoBusiness = new clienteTelefonoBusiness();
            $allClienteTelefonos = $clienteTelefonoBusiness->getAllTBClienteTelefono();
            foreach ($allClienteTelefonos as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/clienteTelefonoAction.php" onsubmit="return confirmarActualizacion();">';
                echo '<input type="hidden" name="clientetelefonoidview" value="' . $current->getClienteTelefonoId() . '">';
                echo '<tr>';
                echo '<td><select name="clienteidview" id="clienteidview">';
                foreach ($getCliente as $cliente) {
                    if ($current->getClienteId() == $cliente->getClienteId()) {
                        echo '<option selected value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . '
                            ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido() . '</option>';
                    } else {
                        echo '<option value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . ' 
                           ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido() . '</option>';
                    }
                }
                echo '</select></td>';
                echo '<td><input required  type="text" name="clientetelefononumeroview" id="clientetelefononumeroview" pattern="^[0-9,\s-]+$" value="' . $current->getClienteTelefonoNumero() . '" oninput="validateInput(this)"/></td>';
                echo '<td><input required  type="text" name="clientetelefonodescripcionview" id="clientetelefonodescripcionview" pattern="^[0-9,\s-]+$" value="' . $current->getClienteTelefonoDescripcion() . '" oninput="validateName(this)"/></td>';
                echo '<td><input type="checkbox" name="clientetelefonoactivoview" id="clientetelefonoactivoview" ' . ($current->getClienteTelefonoActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><button type="button" class="btn btn-danger delete_cliente" tbclientetelefonoid="' . $current->getClienteTelefonoId() . '">Eliminar</button></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>

        </table>
    </section>

    <!-- Scripts JavaScript -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".delete_cliente").on("click", function() {
                var clientedireccionid = $(this).attr("tbclientedireccionid");

                Swal.fire({
                    title: '¿Desea eliminar el cliente?',
                    text: "No se podrá revertir el cambio",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../business/clienteDireccionAction.php?delete1=true&tbclientedireccionid=" + clientedireccionid;
                    }
                });
            });
        });
    </script>

    <script>
        function separarYEnviarDatos() {
            // Obtén el valor del campo de entrada
            const datosInput = document.getElementById("clientetelefono_datos");
            const datosValue = datosInput.value;

            // Divide los datos por comas (",")
            const datosDivididos = datosValue.split(",");

            // Asegúrate de que el clienteid tenga al menos 2 caracteres
            const clienteid = datosDivididos[0].trim();
            const clienteidFormatted = clienteid.length === 1 ? "0" + clienteid : clienteid;

            // Asigna los datos divididos a campos ocultos en el formulario
            const clienteidInput = document.createElement("input");
            clienteidInput.type = "hidden";
            clienteidInput.name = "clienteidview";
            clienteidInput.value = clienteidFormatted;

            const telefononumeroviewInput = document.createElement("input");
            telefononumeroviewInput.type = "hidden";
            telefononumeroviewInput.name = "clientetelefononumeroview";
            telefononumeroviewInput.value = datosDivididos[1].trim();

            const telefonodescripcionInput = document.createElement("input");
            telefonodescripcionInput.type = "hidden";
            telefonodescripcionInput.name = "clientetelefonodescripcionview";
            telefonodescripcionInput.value = datosDivididos[2].trim();

            // Agrega los campos ocultos al formulario
            const form = document.querySelector("form");
            form.appendChild(clienteidInput);
            form.appendChild(telefononumeroviewInput);
            form.appendChild(telefonodescripcionInput);

            // Envía el formulario
            form.submit();
        }
    </script>


    <script>
        function confirmarActualizacion() {
            // Muestra una alerta de confirmación y captura la respuesta del usuario.
            var confirmacion = confirm("¿Desea confirmar la actualización de este cliente?");

            // Retorna true si el usuario acepta, lo que enviará el formulario.
            return confirmacion;
        }
    </script>



    <footer>
    </footer>
</body>

</html>