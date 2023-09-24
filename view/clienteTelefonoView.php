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
    session_start();
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
                    <td><select name="clienteidview" id="clienteidview">
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
                        </select></td>
                        <td>
    <input required type="text" name="clientetelefononumeroview" id="clientetelefononumeroview" placeholder="+506 Número" oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0, 8);" />
</td>

                    <td><input required type="text" name="clientetelefonodescripcionview" id="clientetelefonodescripcionview" pattern="^[0-9,\s-]+$" placeholder="Descripción" /></td>
                    <td><input required type="submit" value="Crear" name="create" id="create" /></td>
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
                var clientetelefonoid = $(this).attr("tbclientetelefonoid");

                Swal.fire({
                    title: '¿Desea eliminar el dato del cliente?',
                    text: "No se podrá revertir el cambio",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../business/clienteTelefonoAction.php?delete1=true&tbclientetelefonoid=" + clientetelefonoid;
                    }
                });
            });
        });
    </script>

    <script>
        function confirmarActualizacion() {
            // Muestra una alerta de confirmación y captura la respuesta del usuario.
            var confirmacion = confirm("¿Desea confirmar la actualización de este cliente?");

            // Retorna true si el usuario acepta, lo que enviará el formulario.
            return confirmacion;
        }
    </script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        const numeroInput = document.getElementById("clientetelefononumeroview");

        numeroInput.addEventListener("input", function() {
            // Elimina cualquier carácter que no sea un número
            this.value = this.value.replace(/[^0-9]/g, '');

            // Limita la longitud máxima a 8 dígitos
            if (this.value.length > 8) {
                this.value = this.value.slice(0, 8);
            }

            
        });
    });
</script>


    <footer>
    </footer>
</body>

</html>