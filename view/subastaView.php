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
                <th>Estado del articulo</th>
                <th>Dias de uso</th>
            </tr>
            <?php
                // Obtén el valor del precio inicial desde PHP (esto es solo un ejemplo, asegúrate de tener el valor correcto)
                $precioInicial = 1000; // Aquí puedes reemplazarlo con tu valor real

                // Formatea el valor como moneda con el símbolo de colones
                $precioInicialFormateado = '₡' . number_format($precioInicial, 2, '.', ',');

                // Luego, en tu campo de entrada HTML, puedes mostrar el valor formateado
            ?>

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
                    <input required type="text" name="subastaPrecioInicialView" id="subastaPrecioInicialView" value="<?php echo $precioInicialFormateado; ?>" />
                </td>
                <td>
                    <select name="subastaEstadoArticuloView" id="subastaEstadoArticuloView">
                        <option value="">Seleccionar estado</option>
                        <option value="Nuevo">Nuevo</option>
                        <option value="Usado">Usado</option>
                    </select>
                </td>
                <td id="estadoUsado" style="display: none;">
                    <select name="mesesDeUso" id="mesesDeUso">
                        <option value="">Seleccione los meses de uso</option>
                        <option value="7">1 semana</option>
                        <option value="15">2 semanas</option>
                        <option value="30">3 semanas</option>
                        <option value="30">1 mes</option>
                        <option value="60">2 meses</option>
                        <option value="90">3 meses</option>
                        <option value="120">4 meses</option>
                        <option value="150">5 meses</option>
                        <option value="180">6 meses</option>
                        <option value="210">7 meses</option>
                        <option value="240">8 meses</option>
                        <option value="270">9 meses</option>
                        <option value="300">10 meses</option>
                        <option value="330">11 meses</option>
                        <option value="365">12 meses</option>
                    </select>
                </td>
                <td>
                    <input type="submit" value="Crear" name="create" id="create" />
                </td>
            </form>
            <?php 
                $subastaBusiness = new SubastaBusiness();
                $obtenerSubastas = $subastaBusiness->getAllTBSubasta();
                foreach($obtenerSubastas as $actualSubasta){
                    $precioInicial = $actualSubasta->getSubastaPrecioInicial();
                    $precioSinSimboloComas = str_replace(['₡', ','], '', $precioInicial);
                    $precioComoFloat = (float)($precioSinSimboloComas / 100);
                    $precioFormateado = '₡' . number_format($precioComoFloat, 2, ',', '.');
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
                    echo '<td><input type="text" name="subastaPrecioInicialView" id="subastaPrecioInicialView" value="' . $precioFormateado . '"/></td>';
                    echo '<td>  <select name="subastaEstadoArticuloView" id="subastaEstadoArticuloView">';
                        if ($actualSubasta->getSubastaEstadoArticulo() == 'Nuevo') {
                            echo "<option value='Nuevo'>Nuevo</option>";
                            echo "<option value='Usado'>Usado</option>";
                        } else {
                            echo "<option value='Usado'>Usado</option>";
                            echo "<option value='Nuevo'>Nuevo</option>";
                        }
                    echo '</select></td>';
                    if ($actualSubasta->getSubastaEstadoArticulo() == 'Usado') {
                        echo '<td id="estadoUsado">';
                        echo '<select name="mesesDeUso" id="mesesDeUso">';
                        if ($actualSubasta->getSubastaDiasUsoArticulo() != 0) {
                            echo "<option selected value='" . $actualSubasta->getSubastaDiasUsoArticulo() . "'>" . $actualSubasta->getSubastaDiasUsoArticulo() . ' Días' . "</option>";
                        }
                        echo '</select>';
                        echo '</td>';
                    }                    
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
    <script>
    document.getElementById('subastaEstadoArticuloView').addEventListener('change', function() {
        var estadoSeleccionado = this.value;
        var estadoUsado = document.getElementById('estadoUsado');

        // Oculta ambos campos
        estadoUsado.style.display = 'none';

        // Muestra el campo correspondiente según la selección
        if (estadoSeleccionado === 'Usado') {
            estadoUsado.style.display = 'table-cell'; // Puedes ajustar el estilo según tu diseño
        } 
    });
</script>
</body>
</html>