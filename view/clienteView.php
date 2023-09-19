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
    include '../business/clienteBusiness.php';
    session_start();
    ?>
</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Cliente</h1>
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
                <th>Nombre</th>
                <th>Primer Apellido</th>
                <th>Segundo Apellido</th>
                <th>Correo</th>
                <th>Fecha Ingreso</th>
                <th>Password</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/clienteAction.php">
                <tr>
                    <td><input required type="text" name="clientenombreview" id="clientenombreview" pattern="^[A-Za-z]+$" oninput="validarCampo(this)" /></td>
                    <td><input required type="text" name="clienteprimerapellidoview" id="clienteprimerapellidoview" pattern="^[A-Za-z]+$" oninput="validarCampo(this)" /></td>
                    <td><input required type="text" name="clientesegundoapellidoview" id="clientesegundoapellidoview" pattern="^[A-Za-z]+$" oninput="validarCampo(this)" /></td>
                    <td><input required type="email" name="clientecorreoview" id="clientecorreoview" oninput="validarCampo(this)" /></td>
                    <td><input required type="date" name="clientefechaingresoview" id="clientefechaingresoview" /></td>
                    <td><input required type="password" name="clientepasswordview" id="clientepasswordview" /><button type="button" class="showPassword">Mostrar</button></td>
                    <td><input required type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            error_reporting(0);
            $clienteBusiness = new clienteBusiness();
            $allClientes = $clienteBusiness->getAllTBCliente();
            foreach ($allClientes as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/clienteAction.php" onsubmit="return confirmarActualizacion();">';
                echo '<input type="hidden" name="clienteidview" value="' . $current->getClienteId() . '">';
                echo '<tr>';
                echo '<td><input required  type="text" name="clientenombreview" id="clientenombreview" pattern="^[A-Za-z]+$" value="' . $current->getClienteNombre() . '" oninput="validateName(this)"/></td>';
                echo '<td><input required type="text" name="clienteprimerapellidoview" id="clienteprimerapellidoview" pattern="^[A-Za-z]+$" value="' . $current->getClientePrimerApellido() . '" oninput="validateName(this)"/></td>';
                echo '<td><input required type="text" name="clientesegundoapellidoview" id="clientesegundoapellidoview" pattern="^[A-Za-z]+$" value="' . $current->getClienteSegundoApellido() . '" oninput="validateName(this)"/></td>';
                echo '<td><input required type="email" name="clientecorreoview" id="clientecorreoview" value="' . $current->getClienteCorreo() . '" oninput="validateEmail(this)" /></td>';

                echo '<td><input required type="date" name="clientefechaingresoview" id="clientefechaingresoview" value="' . $current->getClienteFechaIngreso() . '"/></td>';
                echo '<td><input type="password" name="clientepasswordview" id="clientepasswordview" value="' . $current->getClientePassword() . '"/><button type="button" class="showPassword">Mostrar</button></td>';
                echo '<td><input type="hidden" name="clienteactivoview" id="clientactivoview" ' . ($current->getClienteActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><button type="button" class="btn btn-danger delete_cliente" tbclienteid="' . $current->getClienteId() . '">Eliminar</button></td>';
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
                var clienteid = $(this).attr("tbclienteid");

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
                        window.location.href = "../business/clienteAction.php?delete1=true&tbclienteid=" + clienteid;
                    }
                });
            });
        });

        const showPasswordButtons = document.querySelectorAll(".showPassword");
        showPasswordButtons.forEach(button => {
            button.addEventListener("click", () => {
                const passwordInput = button.previousElementSibling;
                if (passwordInput.type === "password") {
                    passwordInput.type = "text";
                } else {
                    passwordInput.type = "password";
                }
            });
        });
    </script>
    <script>
        function validarCampo(input) {
            const valor = input.value;
            const id = input.id;
            const errorSpan = document.getElementById(id + "-error");

            if (id === "clientecorreoview") {
                if (!isValidEmail(valor)) {
                    input.setCustomValidity("Ingrese una dirección de correo electrónico válida.");
                    errorSpan.textContent = "Correo inválido.";
                } else {
                    input.setCustomValidity("");
                    errorSpan.textContent = "";
                }
            } else if (id === "clientenombreview" || id === "clienteprimerapellidoview" || id === "clientesegundoapellidoview") {
                if (!isValidName(valor)) {
                    input.setCustomValidity("Ingrese un nombre válido (solo letras) y comience con mayúscula.");
                    errorSpan.textContent = "Nombre inválido.";
                } else {
                    input.setCustomValidity("");
                    errorSpan.textContent = "";
                }
            }

        }

        function isValidEmail(email) {
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            return emailPattern.test(email);
        }

        function isValidName(name) {
            const namePattern = /^[A-Z][a-z]+$/;
            return namePattern.test(name);
        }

        document.addEventListener("DOMContentLoaded", function() {
            const fechaIngresoInput = document.getElementById("clientefechaingresoview");
            const fechaActual = new Date();
            const yyyy = fechaActual.getFullYear();
            const mm = String(fechaActual.getMonth() + 1).padStart(2, '0'); // Sumar 1 porque en JavaScript los meses van de 0 a 11
            const dd = String(fechaActual.getDate()).padStart(2, '0');

            const fechaFormatted = `${yyyy}-${mm}-${dd}`;
            fechaIngresoInput.value = fechaFormatted;
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
        function validateEmail(input) { //del update
            const email = input.value;
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

            if (!emailPattern.test(email)) {
                input.setCustomValidity('Ingrese una dirección de correo electrónico válida con un dominio completo (por ejemplo, "correo@gmail.com").');
            } else {
                input.setCustomValidity('');
            }
        }

        function validateName(input) { //del update
            const nameValue = input.value;

            // Comprueba si el campo está vacío o no comienza con mayúscula
            if (nameValue === '' || !/^[A-Z][a-z]+$/.test(nameValue)) {
                input.setCustomValidity("Ingrese un nombre válido (solo letras y la primera letra en mayúscula).");
            } else {
                input.setCustomValidity(""); // Restablece el mensaje de validación
            }
        }
    </script>


    <footer>
    </footer>
</body>

</html>