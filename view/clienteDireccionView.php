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
    include '../business/clienteDireccionBusiness.php';
    include '../business/clienteBusiness.php';
    $clienteBusiness = new clienteBusiness();
    $getCliente = $clienteBusiness->getAllTBCliente();
    //include_once("../Session/session.php");

    session_start(); //Inicia una nueva sesión o reanuda la existente

    ?>
</head>

<body>
    <header>
        <h1>Registro Cliente Direccion</h1>
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
                <th>Direccion Barrio</th>
                <th>Coordenadas GPS</th>
                <th>Activo</th>
                <th></th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/clienteDireccionAction.php">
                <tr>
                    <td>
                        <select name="clienteidview" id="clienteidview">
                            <option value="">Seleccionar cliente</option>
                            <?php
                            if (count($getCliente) > 0) {
                                foreach ($getCliente as $cliente) {

                                    echo '<option value="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . ' 
                                    ' . $cliente->getClientePrimerApellido() . ' ' . $cliente->getClienteSegundoApellido() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ningun cliente registrado</option>';
                            }
                            ?>
                        </select>
                    <td><input required type="text" name="clientedireccionbarrioview" id="clientedireccionbarrioview" pattern="[A-Za-z0-9\s]+" oninput="validarCampo(this)" /></td>
                    <td><input required type="text" name="clientedireccioncoordenadagpsview" id="clientedireccioncoordenadagpsview" pattern="[A-Za-z0-9\s]+" oninput="validarCampo(this)" /></td>
                    <td></td>
                    <td><input required type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            error_reporting(0);
            $clienteDireccionBusiness = new clienteDireccionBusiness();
            $allClienteDirecciones = $clienteDireccionBusiness->getAllTBClienteDireccion();
            foreach ($allClienteDirecciones as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/clienteDireccionAction.php" onsubmit="return confirmarActualizacion();">';
                echo '<input type="hidden" name="clientedireccionidview" value="' . $current->getClienteDireccionId() . '">';
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
                echo '<td><input required  type="text" name="clientedireccionbarrioview" id="clientedireccionbarrioview" pattern="[A-Za-z0-9\s]+" value="' . $current->getClienteDireccionBarrio() . '" oninput="validateName(this)"/></td>';
                echo '<td><input required  type="text" name="clientedireccioncoordenadagpsview" id="clientedireccioncoordenadagpsview" pattern="[A-Za-z0-9\s]+" value="' . $current->getClienteDireccionCoordenadaGps() . '" oninput="validateName(this)"/></td>';
                echo '<td><input type="checkbox" name="clientedireccionactivoview" id="clientedireccionactivoview" ' . ($current->getClienteDireccionActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><button type="button" class="btn btn-danger delete_cliente" tbclientedireccionid="' . $current->getClienteDireccionId() . '">Eliminar</button></td>';
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
        function validateInput(input) {
            // Utiliza una expresión regular para validar que solo se permitan letras, números y espacios.
            const pattern = /^[A-Za-z0-9\s]+$/;
            if (!pattern.test(input.value)) {
                input.setCustomValidity("Solo se permiten letras, números y espacios.");
            } else {
                input.setCustomValidity("");
            }
        }
    </script>
    <script>
        function validateName(input) {
            const nameValue = input.value;

            // Comprueba si el campo está vacío o contiene caracteres no permitidos
            if (nameValue === '' || !/^[A-Za-z0-9\s]+$/.test(nameValue)) {
                input.setCustomValidity("Ingrese un valor válido (solo letras, números y espacios).");
            } else {
                input.setCustomValidity(""); // Restablece el mensaje de validación
            }
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