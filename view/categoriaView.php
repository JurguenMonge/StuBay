<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Categorías</title>
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <?php
    error_reporting(0);
    include '../business/categoriaBusiness.php';


    ?>
</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Categorías</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>

    <section id="form">
        <table>
            <tr>
                <th>Sigla</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/categoriaAction.php">
                <tr>
                    <td><input required type="text" name="categoriaSiglaView" id="categoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4" /></td>
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
                echo '<td><input type="text" name="categoriaSiglaView" id="categoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4" readonly value="' . $current->getSigla() . '"/></td>';
                echo '<td><input type="text" name="categoriaNombreView" id="categoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="text" name="categoriaDescripcionView" id="categoriaDescripcionView" maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
                echo '<td><input type="checkbox" name="categoriaActivoView" id="categoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
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
        // Obtén una referencia a los campos de entrada
        const categoriaSiglaView = document.getElementById('categoriaSiglaView');
        const categoriaNombreView = document.getElementById('categoriaNombreView');
        const categoriaDescripcionView = document.getElementById('categoriaDescripcionView');

        // Agrega un evento de escucha para cada campo de entrada
        categoriaSiglaView.addEventListener('input', validateMaxLength);
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