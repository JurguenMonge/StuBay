<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Categorías</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include '../business/categoriaBusiness.php';
    session_start();

    ?>
</head>

<body>
    <header>
        <h1>Registro Categorías</h1>
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
                <th>Descripción</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/categoriaAction.php">
                <tr>
                    <td><input required type="text" name="categoriaNombreView" id="categoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" /></td>
                    <td><input required type="text" name="categoriaDescripcionView" id="categoriaDescripcionView" maxlength="1000" /></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $categoriaBusiness = new categoriaBusiness();
            $allCategorias = $categoriaBusiness->getAllTBCategoria();
            foreach ($allCategorias as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/categoriaAction.php">';
                echo '<input type="hidden" name="categoriaIdView" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<input type="hidden" name="categoriaSiglaView" id="categoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4"  value="' . $current->getSigla() . '"/>';
                echo '<td><input type="text" name="categoriaNombreView" id="categoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="text" name="categoriaDescripcionView" id="categoriaDescripcionView" maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
                echo '<td><input type="hidden" name="categoriaActivoView" id="categoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
                echo '<td><button type="button" class="btn btn-danger delete_categoria" tbcategoriaid="' . $current->getId() . '">Eliminar</button></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>

            
        </table>
    </section>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(".delete_categoria").on("click", function() {
                var categoriaId = $(this).attr("tbcategoriaid");

                Swal.fire({
                    title: '¿Desea eliminar la categoría?',
                    text: "No se podrá revertir el cambio",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../business/categoriaAction.php?delete=true&tbcategoriaid=" + categoriaId;
                    }
                });
            });
        });
        // Obtén una referencia a los campos de entrada
        //const categoriaSiglaView = document.getElementById('categoriaSiglaView');
        const categoriaNombreView = document.getElementById('categoriaNombreView');
        const categoriaDescripcionView = document.getElementById('categoriaDescripcionView');

        // Agrega un evento de escucha para cada campo de entrada
        //categoriaSiglaView.addEventListener('input', validateMaxLength);
        categoriaNombreView.addEventListener('input', validateMaxLength);
        categoriaDescripcionView.addEventListener('input', validateMaxLength);

        // Función para validar la longitud máxima del campo
        function validateMaxLength(event) {
            const input = event.target;
            const maxLength = input.getAttribute('maxlength');
            const currentValue = input.value;

            if (currentValue.length > maxLength) {
                input.setCustomValidity(`El campo no puede exceder ${maxLength} caracteres.`);
            } else {
                input.setCustomValidity('');
            }
        }
    </script>

    <footer>
    </footer>

</body>

</html>