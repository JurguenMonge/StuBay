<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Subasta</title>
    <?php
        error_reporting(0);
        include '../business/articuloBusiness.php';
        include '../business/subastaBusiness.php';
        $articuloBusiness = new ArticuloBusiness();
        $getAllArticulos = $articuloBusiness->getAllTBArticulo();
    ?>
</head>
<body>
    <header>
        <h1>Registro Subasta</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>
    <section>
        <table>
            <tr>
                <th>Articulo</th>
                <th>Fecha y Hora inicio</th>
                <th>Fecha y Hora final</th>
                <th>Precio inicial</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/subastaAction.php">
                <td>
                    <select name="subastaArticuloView" id="subastaArticuloView">
                        <option value="">Seleccionar articulo</option>
                        <?php 
                            if(count($getAllArticulos) > 0){
                                foreach($getAllArticulos as $articulo){
                                    echo '<option value="'.$articulo->getArticuloId().'">'.$articulo->getArticuloMarca().'-'.$articulo->getArticuloModelo().'</option>';
                                }
                            }else{ 
                                echo '<option value="">Ningun articulo registrado</option>'; 
                            } 
                        ?> 
                    </select>
                </td>
                <td>
                    <input required type="datetime-local" name="subastaFechaHoraInicioView" id="subastaFechaHoraInicioView"/>
                </td>
                <td>
                    <input required type="datetime-local" name="subastaFechaHoraFinalView" id="subastaFechaHoraFinalView"/>
                </td>
                <td>
                    <input required type="number" name="subastaPrecioInicialView" id="subastaPrecioInicialView"/>
                </td>
                <td>
                    <input type="submit" value="Crear" name="create" id="create" />
                </td>
            </form>
            <?php 
                $subastaBusiness = new SubastaBusiness();
                $obtenerSubastas = $subastaBusiness->getAllTBSubasta();
                foreach($obtenerSubastas as $actualSubasta){
                    echo '<form method="post" enctype="multipart/form-data" action="../business/subastaAction.php">';
                    echo '<input type="hidden" name="subastaIdView" value="' . $actualSubasta->getSubastaId() . '">';
                    echo '<tr>';
                    echo '<td>  <select name="subastaArticuloView" id="subastaArticuloView">';
                            foreach($getAllArticulos as $articulo){
                                if($actualSubasta->getSubastaArticuloId() == $articulo->getArticuloId()){
                                    echo "<option selected value='".$articulo->getArticuloId() ."'>".$articulo->getArticuloMarca().'-'.$articulo->getArticuloModelo()."</option>";
                                }else{
                                    echo "<option value='".$articulo->getArticuloId() ."'>".$articulo->getArticuloMarca().'-'.$articulo->getArticuloModelo()."</option>";
                                }
                            }
                    echo ' </select></td>';
                    echo '<td><input type="datetime-local" name="subastaFechaHoraInicioView" id="subastaFechaHoraInicioView" value="' . $actualSubasta->getSubastaFechaHoraInicio() . '"/></td>';
                    echo '<td><input type="datetime-local" name="subastaFechaHoraFinalView" id="subastaFechaHoraFinalView" value="' . $actualSubasta->getSubastaFechaHoraFinal() . '"/></td>';
                    echo '<td><input type="number" name="subastaPrecioInicialView" id="subastaPrecioInicialView" value="' . $actualSubasta->getSubastaPrecioInicial() . '"/></td>';
                    echo '<td><input type="checkbox" name="subastaActivoView" id="subastaActivoView" ' . ($actualSubasta->getSubastaActivo() == 1 ? "checked" : "") . '/></td>';
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