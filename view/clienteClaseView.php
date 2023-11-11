<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Clases</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include '../business/clienteClaseBusiness.php';
    $clienteClaseBusiness = new ClienteClaseBusiness();
    $getClienteClases = $clienteClaseBusiness->getAllTBClienteClase();

    include_once("../session/startsession.php");
    //session_start();
    if (isset($_SESSION['nombre'])) {

        $clienteNombre = $_SESSION['nombre'];
    } else {
        echo "No has iniciado sesión";
    }

    ?>

</head>

<body>
    <header>
        <h1>Registro Clases</h1>
        <h1><?php echo "$clienteNombre!" ?></h1>
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
    } ?>

    <section id="form">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Valor</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/clienteClaseAction.php">
                <tr>
                    <td>
                        <select required name="clienteClaseNombreView" id="clienteClaseNombreView">
                            <option value="" selected>Seleccionar nombre</option>
                            <option value="Bueno">Bueno</option>
                            <option value="Regular">Regular</option>
                            <option value="Esporádico">Esporádico</option>
                        </select>
                    </td>
                    <td>
                        <select required name="clienteClaseValorView" id="clienteClaseValorView">
                            <option value="" selected>Seleccionar valor</option>
                            <?php
                            // Genera las opciones para el campo Valor
                            for ($i = 1; $i <= 10; $i++) {
                                echo '<option value="' . $i . '">' . $i . '</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php

            foreach ($getClienteClases as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/clienteClaseAction.php">';
                echo '<input type="hidden" name="clienteClaseIdView" value="' . $current->getIdClase() . '">';
                echo '<tr>';
                echo '<td>
                        <select name="clienteClaseNombreView" id="clienteClaseNombreView">
                            <option value="Bueno" ' . ($current->getNombre() == "Bueno" ? "selected" : "") . '>Bueno</option>
                            <option value="Regular" ' . ($current->getNombre() == "Regular" ? "selected" : "") . '>Regular</option>
                            <option value="Esporádico" ' . ($current->getNombre() == "Esporádico" ? "selected" : "") . '>Esporádico</option>
                        </select>
                    </td>';
                echo '<td>';
                echo '<select name="clienteClaseValorView" id="clienteClaseValorView">';
                foreach (range(1, 10) as $i) {
                    echo '<option value="' . $i . '" ' . ($current->getValor() == $i ? "selected" : "") . '>' . $i . '</option>';
                }
                echo '</select>';
                echo '</td>';
                echo '<td><input type="hidden" name="clienteClaseActivoView" id="clienteClaseActivoView" ' . ($current->getEstado() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
                echo '<td><button type="button" class="btn btn-danger delete_cliente_clase" tbclienteclaseid="' . $current->getIdClase() . '">Eliminar</button></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>


        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".delete_cliente_clase").on("click", function() {
                var clienteClaseId = $(this).attr("tbclienteclaseid");

                Swal.fire({
                    title: '¿Desea eliminar la clase?',
                    text: "No se podrá revertir el cambio",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../business/clienteClaseAction.php?delete=true&tbclienteclaseid=" + clienteClaseId;
                    }
                });
            });
        });
    </script>

    <footer>
    </footer>

</body>

</html>