<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Categorías</title>

    <?php
    error_reporting(0);
    include '../business/categoriaBusiness.php';
    ?>
</head>

<body>
    <header>
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
                    <td><input required type="text" name="sigla" id="sigla" /></td>
                    <td><input required type="text" name="nombre" id="nombre" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios"/></td>
                    <td><input required type="text" name="descripcion" id="descripcion" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios"/></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $categoriaBusiness = new categoriaBusiness();
            $allCategorias = $categoriaBusiness->getAllTBCategoria();
            foreach ($allCategorias as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/categoriaAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="sigla" id="sigla" value="' . $current->getSigla() . '"/></td>';
                echo '<td><input type="text" name="nombre" id="nombre" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios" value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="text" name="descripcion" id="descripcion" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios" value="' . $current->getDescripcion() . '"/></td>';
                echo '<td><input type="checkbox" name="activo" id="activo" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
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

    <footer>
    </footer>
    
</body>

</html>