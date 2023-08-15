<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro articulo</title>
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
            <form method="post" enctype="multipart/form-data" action="../business/articuloAction.php">
            <tr>
                    <td><input required type="text" name="nombre" id="nombre" /></td>
                    <td><input required type="text" name="categoria" id="categoria" /></td>
                    <td><input required type="text" name="subcategoria" id="subcategoria" /></td>
                    <td><input required type="text" name="marca" id="marca" /></td>
                    <td><input required type="text" name="modelo" id="modelo" /></td>
                    <td><input required type="text" name="serie" id="serie" /></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php 
            
            ?>
        </table>
    </section>
</body>
</html>