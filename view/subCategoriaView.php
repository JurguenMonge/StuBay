<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Subcategorías</title>

    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../business/subCategoriaBusiness.php';
    include '../business/categoriaBusiness.php';
    $categoriaBusiness = new CategoriaBusiness();
    $getCat = $categoriaBusiness->getAllTBCategoria();
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
                <th>Sigla</th>
                <th>Nombre</th>
                <th>Categoría</th>
                <th>Descripción</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">
                <tr>
                    <td><input required type="text" name="sigla" id="sigla" /></td>
                    <td><input required type="text" name="nombre" id="nombre" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios" /></td>

                    <td>
                        <select name="categoria" id="categoria">
                            <option value="">Seleccionar categoria</option>
                            <?php 
                                if(count($getCat) > 0){
                                    foreach($getCat as $categoria){
                                        echo '<option value="'.$categoria->getId().'">'.$categoria->getNombre().'</option>';
                                    }
                                }else{ 
                                    echo '<option value="">Ninguna categoria registrada</option>'; 
                                } 
                            ?> 
                        </select>
                    </td>

                    <td><input required type="text" name="descripcion" id="descripcion" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios" /></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $subCategoriaBusiness = new SubCategoriaBusiness();
            $allSubCategorias = $subCategoriaBusiness->getAllTBSubCategoria();


            foreach ($allSubCategorias as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="sigla" id="sigla" value="' . $current->getSigla() . '"/></td>';
                echo '<td><input type="text" name="nombre" id="nombre" pattern="^[A-Za-z\s]+$" title="Solo se permiten letras y espacios" value="' . $current->getNombre() . '"/></td>';
                
                echo '<td>  <select name="categoria" id="categoria">';
                    foreach($getCat as $categoria){
                        if($current->getCategoriaId() == $categoria->getId()){
                            echo "<option selected value='".$categoria->getId()."'>".$categoria->getNombre()."</option>";
                        }else{
                            echo "<option value='".$categoria->getId()."'>".$categoria->getNombre()."</option>";
                        }
                    }
                echo ' </select></td>';
                
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