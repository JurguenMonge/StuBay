<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Cliente</title>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php
    error_reporting(0);
    include '../business/clienteBusiness.php';
    //include_once("../Session/session.php");

    session_start(); //Inicia una nueva sesión o reanuda la existente

    ?>
</head>

<body>
    <header>
        <h1>Registro Estudiante</h1>
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
                <th>Password</th>
                <th>Fecha Ingreso</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/clienteAction.php">
                <tr>
                    <td><input required type="text" name="clientenombre" id="clientenombre" pattern="^[A-Za-z]+$" /></td>
                    <td><input required type="text" name="clienteprimerapellido" id="clienteprimerapellido" pattern="^[A-Za-z]+$" /></td>
                    <td><input required type="text" name="clientesegundoapellido" id="clientesegundoapellido" pattern="^[A-Za-z]+$" /></td>
                    <td><input required type="email" name="clientecorreo" id="clientecorreo" /></td>
                    <td><input required type="password" name="clientepassword" id="clientepassword" /></td>
                    <td><input required type="date" name="clientefechaingreso" id="clientefechaingreso" /></td>
                    <td><input required type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            error_reporting(0);
            $clienteBusiness = new clienteBusiness();
            $allClientes = $clienteBusiness->getAllTBCliente();
            foreach ($allClientes as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/clienteAction.php">';
                echo '<input type="hidden" name="clienteid" value="' . $current->getClienteId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="clientenombre" id="clientenombre" value="' . $current->getClienteNombre() . '"/></td>';
                echo '<td><input type="text" name="clienteprimerapellido" id="clienteprimerapellido" value="' . $current->getClientePrimerApellido() . '"/></td>';
                echo '<td><input type="text" name="clientesegundoapellido" id="clientesegundoapellido" value="' . $current->getClienteSegundoApellido() . '"/></td>';
                echo '<td><input type="email" name="clientecorreo" id="clientecorreo" value="' . $current->getClienteCorreo() . '"/></td>';
                echo '<td><input type="password" name="clientepassword" id="clientepassword" value="' . $current->getClientePassword() . '"/></td>';
                echo '<td><input type="date" name="clientefechaingreso" id="clientefechaingreso" value="' . $current->getClienteFechaIngreso() . '"/></td>';
                echo '<td><input type="hidden" name="clienteactivo" id="clientactivo" ' . ($current->getClienteActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>

        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        $(document).ready(function() {
            $(".delete_cliente").on("click", function() {
                var id = $(this).attr("id");

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
                        window.location.href = "../business/clientAction.php?delete=true&clientid=" + id;
                    }
                });
            });
        });
    </script>

    <footer>
    </footer>
</body>

</html>