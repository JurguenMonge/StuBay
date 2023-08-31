<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Pujas del Cliente</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" type="text/css" href="../css/style.css">

    <script>
       $(document).ready(function(){
        $('#articuloIdView').change(function(){
            recargarLista();
        });
       })
       function recargarLista(){
        $.ajax({
            type:"POST",
            url:"../business/subastaAction.php",
            data:"valor=" + $('#articuloIdView').val(),
            success:function(r){
                $('#precioArticulo').html(r);
            }
        });
       }
    </script>

    <?php
    error_reporting(0);
    include '../business/pujaClienteBusiness.php';
    include '../business/clienteBusiness.php';
    include '../business/articuloBusiness.php';
    include '../business/subastaBusiness.php';
    $clienteBusiness = new ClienteBusiness();
    $articuloBusiness = new ArticuloBusiness();
    $subastaBusiness = new SubastaBusiness();

    $getCli = $clienteBusiness->getAllTBCliente();
    $getArt = $articuloBusiness->getAllTBArticulo();
    $getSub = $subastaBusiness->getAllTBSubasta();
    ?>
</head>

<body>
    <header>
        <h1>Registro Pujas Cliente</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>

    <section id="form">
        <table>
            <tr>
                <th>Nombre del Cliente</th>
                <th>Nombre del artículo</th>
                <th>Precio Inicial</th>
                <th>Precio a Pujar</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/pujaClienteAction.php">
                <tr>
                <td>
                        <select name="clienteIdView" id="clienteIdView">
                            <option value="">Seleccionar cliente</option>
                            <?php
                            if (count($getCli) > 0) {
                                foreach ($getCli as $cliente) {
                                    echo '<option value="' . $cliente->getClienteId() .  '" data-id="' . $cliente->getClienteId() . '">' . $cliente->getClienteNombre() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="articuloIdView" id="articuloIdView">
                            <option value="">Seleccionar artículo</option>
                            <?php
                            if (count($getCli) > 0 && count($getSub) > 0) {
                                foreach ($getSub as $subasta) {
                                    foreach($getArt as $articulo){
                                        if($articulo->getArticuloId() == $subasta->getSubastaArticuloId() && $subasta->getSubastaActivo() == 1){
                                            echo '<option value="' .$subasta->getSubastaId().'-'. $articulo->getArticuloId() .  '">' .$articulo->getArticuloMarca().'-'.$articulo->getArticuloModelo(). '</option>';
                                        }
                                        
                                    }
                                    
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td name="precioArticulo" id="precioArticulo"></td>
                    <td><input required type="number" name="pujaClientePrecioActualView" id="pujaClientePrecioActualView" min=""/></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $pujaClienteBusiness = new PujaClienteBusiness();
            $allPujasCliente = $pujaClienteBusiness->getAllTBPujaCliente();
            foreach ($allPujasCliente as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/pujaClienteAction.php">';
                echo '<input type="hidden" name="pujaClienteIdView" value="' . $current->getPujaClienteId() . '">';
                echo '<tr>';
                echo '<td><input type="text" name="clienteIdView" id="clienteIdView" pattern="\d+" title="Ingresa solo números" maxlength="4" readonly value="' . $current->getClienteId() . '"/></td>';
                echo '<td><input type="text" name="articuloIdView" id="articuloIdView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" readonly value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="number" name="pujaClientePrecioActualView" id="pujaClientePrecioActualView" ' . $current->getPujaClientePrecioAtual(). '/></td>';
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