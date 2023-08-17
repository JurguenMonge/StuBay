<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro articulo</title>
    <?php
        error_reporting(0);
        include '../business/articuloBusiness.php';
        include '../business/categoriaBusiness.php';
        include '../business/subCategoriaBusiness.php';
        $subcategoriaBusiness = new SubCategoriaBusiness();
        $articuloCategoriaBusiness = new CategoriaBusiness();
        $getCat = $articuloCategoriaBusiness->getAllTBCategoria();
        $getSubCat = $subcategoriaBusiness->getAllTBSubCategoria();
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
            <form method="post" enctype="multipart/form-data" action="../business/articuloAction.php">
                <tr>
                    <td><input required type="text" name="nombre" id="nombre" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios"/>
                    <td>
                        <select name="articulocategoria" id="articulocategoria">
                            <option value="">Seleccionar categoria</option>
                            <?php 
                                if(count($getCat) > 0){
                                    foreach($getCat as $categoria){
                                        echo '<option value="'.$categoria->getSigla().'">'.$categoria->getSigla().' - '.$categoria->getNombre().'</option>';
                                    }
                                }else{ 
                                    echo '<option value="">Ninguna categoria registrada</option>'; 
                                } 
                            ?> 
                        </select>
                    </td>
                    <td>
                        <select name="subcategoria" id="subcategoria">
                                <option value="">Seleccionar subcategoria</option>
                                <?php 
                                    if(count($getSubCat) > 0){
                                        foreach($getSubCat as $subcategoria){
                                            echo '<option value="'.$subcategoria->getSigla().'">'.$subcategoria->getSigla().' - '.$subcategoria->getNombre().'</option>';
                                        }
                                    }
                                ?>
                        </select>                     
                    </td>
                    <td><input required type="text" name="marca" id="marca" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios"/>
                    <td><input required type="text" name="modelo" id="modelo" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios"/>
                    <td><input required type="text" name="serie" id="serie" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios"/>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            
            <?php 
            $articuloBusiness = new ArticuloBusiness();
            $allArticulos = $articuloBusiness->getAllTBArticulo();
            foreach($allArticulos as $current){
                echo '<form method="post" enctype="multipart/form-data" action="../business/articuloAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="nombre" id="nombre" value="' . $current->getNombre() . '"/></td>';


                echo '<td>  <select name="articulocategoria" id="articulocategoria">';
                    foreach($getCat as $categoria){
                        if($current->getCategoriaId() == $categoria->getId()){
                            echo "<option selected value='".$categoria->getSigla()."'>".$categoria->getSigla().' - '.$categoria->getNombre()."</option>";
                        }else{
                            echo "<option value='".$categoria->getSigla()."'>".$categoria->getSigla().' - '.$categoria->getNombre()."</option>";
                        }
                    }
                echo ' </select></td>';

                echo '<td>  <select name="subcategoria" id="subcategoria">';
                    foreach($getSubCat as $subcategoria){
                        if($current->getSubCategoriaId() == $subcategoria->getId()){
                            echo "<option selected value='".$subcategoria->getSigla()."'>".$subcategoria->getSigla().' - '.$subcategoria->getNombre()."</option>";
                        }else{
                            echo "<option value='".$subcategoria->getSigla()."'>".$subcategoria->getSigla().' - '.$subcategoria->getNombre()."</option>";
                        }
                    }
                echo ' </select></td>';

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