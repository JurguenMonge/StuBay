<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Subcategorías</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>


    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../business/subCategoriaBusiness.php';
    include '../business/categoriaBusiness.php';
    $categoriaBusiness = new CategoriaBusiness();
    $getCat = $categoriaBusiness->getAllTBCategoria();
    $categoriaIdSelected;
    ?>
</head>

<body>
    <header>
        <h1>Registro Subcategorías</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>

    <section id="form">
        <table>
            <tr>
                <th>Categoría</th>
                <th>Sigla</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">
                <tr>
                    <td>
                        <select name="categoria" id="categoria">
                            <option value="">Seleccionar categoria</option>
                            <?php
                            if (count($getCat) > 0) {
                                foreach ($getCat as $categoria) {
                                    echo '<option value="' . $categoria->getId() . "-" . $categoria->getSigla() . '" data-id="' . $categoria->getId() . '">' . $categoria->getNombre() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td><input required type="text" name="subcategoriaSiglaView" id="subcategoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4" /></td>
                    <td><input required type="text" name="subcategoriaNombreView" id="subcategoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" /></td>
                    <td><input required type="text" name="subcategoriaDescripcionView" id="subcategoriaDescripcionView" maxlength="1000" /></td>

                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <p>Seleccionaste la categoría con ID: <span name="categoriaId" id="categoriaId"></span></p>




            <?php


            $subCategoriaBusiness = new SubCategoriaBusiness();
            $allSubCategorias = $subCategoriaBusiness->getAllTBSubCategoria();
            foreach ($allSubCategorias as $current) {
                //if ($categoriaIdSelected == $current->getCategoriaId()) {
                echo '<form class="subcategoria" id="subcategoria-' . $current->getCategoriaId() . '" method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">';
                echo '<input type="hidden" name="subcategoriaIdView" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<input type="hidden" name="categoriaId" value="' . $current->getCategoriaId() . '">';
                echo '<td></td>';
                echo '<td><input type="text" name="subcategoriaSiglaView" id="subcategoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4" readonly value="' . $current->getSigla() . '"/></td>';
                echo '<td><input type="text" name="subcategoriaNombreView" id="subcategoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="text" name="subcategoriaDescripcionView" id="subcategoriaDescripcionView" maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
                echo '<td><input type="checkbox" name="subcategoriaActivoView" id="subcategoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete" /></td>';
                echo '</tr>';
                echo '</form>';
                //}
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
        const subcategoriaSiglaView = document.getElementById('subcategoriaSiglaView');
        const subcategoriaNombreView = document.getElementById('subcategoriaNombreView');
        const subcategoriaDescripcionView = document.getElementById('subcategoriaDescripcionView');

        // Agrega un evento de escucha para cada campo de entrada
        subcategoriaSiglaView.addEventListener('input', validateMaxLength);
        subcategoriaNombreView.addEventListener('input', validateMaxLength);
        subcategoriaDescripcionView.addEventListener('input', validateMaxLength);

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