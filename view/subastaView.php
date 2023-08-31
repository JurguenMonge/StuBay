<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Subasta</title>
    <?php
        error_reporting(0);
        include '../business/articuloBusiness.php';
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
        </table>
    </section>
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
</body>
</html>