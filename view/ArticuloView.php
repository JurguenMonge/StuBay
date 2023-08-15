<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro articulo</title>
    <?php
        error_reporting(0);
        include '../business/ArticuloBusiness.php';
    ?>
</head>
<body>
    <header>
        <h1>Registro Articulo</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>

    <section id="form">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Categoria</th>
                <th>Subcategoria</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Activo</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/ArticuloAction.php">
            <tr>
                    <td><input required type="text" name="nombre" id="nombre" /></td>
                    <td><input required type="number" name="categoria" id="categoria" /></td>
                    <td><input required type="number" name="subcategoria" id="subcategoria" /></td>
                    <td><input required type="text" name="marca" id="marca" /></td>
                    <td><input required type="text" name="modelo" id="modelo" /></td>
                    <td><input required type="text" name="serie" id="serie" /></td>
                    <td>
                        <input type="checkbox" name="activo" id="activo" checked disabled />
                        <input type="hidden" name="activo" value="1" />
                    </td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php 
            $articuloBusiness = new ArticuloBusiness();
            $allArticulos = $articuloBusiness->getAllTBArticulo();
            foreach($allArticulos as $current){
                echo '<form method="post" enctype="multipart/form-data" action="../business/ArticuloAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="nombre" id="nombre" value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="number" name="categoria" id="categoria" value="' . $current->getCategoriaId() . '"/></td>';
                echo '<td><input type="number" name="subcategoria" id="subcategoria" value="' . $current->getSubCategoriaId() . '"/></td>';
                echo '<td><input type="text" name="marca" id="marca" value="' . $current->getMarca() . '"/></td>';
                echo '<td><input type="text" name="modelo" id="modelo" value="' . $current->getModelo() . '"/></td>';
                echo '<td><input type="text" name="serie" id="serie" value="' . $current->getSerie() . '"/></td>';
                echo '<td><input type="checkbox" name="activo" id="activo" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
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
</body>
</html>