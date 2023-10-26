<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro articulo</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
    <?php
    error_reporting(0);
    include '../business/articuloBusiness.php';
    include '../business/categoriaBusiness.php';
    include '../business/subCategoriaBusiness.php';
    include '../business/clienteBusiness.php';
    $subcategoriaBusiness = new SubCategoriaBusiness();
    $articuloCategoriaBusiness = new CategoriaBusiness();
    $clienteBusiness = new ClienteBusiness();
    $getClientes = $clienteBusiness->getAllTBCliente();
    $getCat = $articuloCategoriaBusiness->getAllTBCategoria();
    $getSubCat = $subcategoriaBusiness->getAllTBSubCategoria();


    include_once("../session/startsession.php");
    //session_start();
    if (isset($_SESSION['nombre'])) {
        $clienteId = $_SESSION['id'];
        $clienteNombre = $_SESSION['nombre'];
        $clientePrimerApellido = $_SESSION['apellido1'];
        $clienteSegundoApellido = $_SESSION['apellido2'];
        $clienteNombreCompleto = $clienteNombre . ' ' . $clientePrimerApellido . ' ' . $clienteSegundoApellido;
    } else {
        echo "No has iniciado sesión";
    }
    ?>
    <script>
        $(document).ready(function() {
            $("#articulonombreview").on("input", function() {
                var termino = $(this).val();
                $.get("../business/articuloAction.php", {
                        termino: termino
                    })
                    .done(function(data) {
                        $("#resultados").empty();
                        console.log(data);

                        try {
                            var nombres = JSON.parse(data);
                            if (Array.isArray(nombres)) {
                                nombres.forEach(function(nombre) {
                                    var option = $("<option>").attr("value", nombre);
                                    $("#resultados").append(option);
                                });
                            } else if (nombres.error) {
                                console.error("Error en la consulta:", nombres.error);
                            }
                        } catch (error) {
                            console.error("Error al parsear la respuesta JSON:", error);
                        }
                    })
                    .fail(function(xhr, status, error) {
                        console.error("Error en la solicitud:", error);
                    });
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#articulocategoria').change(function() {
                recargarLista();
            });
        })

        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "../business/subCategoriaAction.php",
                data: "valor=" + $('#articulocategoria').val(),
                success: function(r) {
                    $('#subcategorias').html(r);
                }
            });
        }
    </script>
</head>

<body>
    <header>
        <h1>Registro Articulo</h1>
        <h1><?php echo "$clienteNombre" ?></h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>

    <?php
    if (isset($_SESSION['msj'])) { // Si existe la variable de sesión
    ?>
        <script>
            Swal.fire({
                icon: 'success',
                title: '<?php echo $_SESSION['msj']; ?>',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php unset($_SESSION['msj']); // Eliminar la variable de sesión
    } ?>

    <?php
    if (isset($_SESSION['error'])) { // Si existe la variable de sesión
    ?>
        <script>
            Swal.fire({
                icon: 'error',
                title: '<?php echo $_SESSION['error']; ?>',
                showConfirmButton: false,
                timer: 2500
            })
        </script>
    <?php unset($_SESSION['error']); // Eliminar la variable de sesión
    }
    ?>
    
    <section id="form">
        <table>
            <tr>
                <th>Nombre</th>
                <th>Cliente</th>
                <th>Categoria</th>
                <th>Subcategoria</th>
                <th>Marca</th>
                <th>Modelo</th>
                <th>Serie</th>
                <th>Foto Articulo</th>
                <th>Foto Articulo 2</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/articuloAction.php">
                <tr>
                    <td>
                        <textarea required name="articulonombreview" id="articulonombreview" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios" rows="3" cols="40"></textarea>
                        <datalist id="resultados"></datalist>
                    </td>
                    <td>
                        <input type="hidden" name="clienteid" id="clienteid" value="<?php echo $clienteId; ?>" readonly>
                        <span><?php echo $clienteNombreCompleto; ?></span>
                    </td>
                    <td>
                        <select name="articulocategoria" id="articulocategoria">
                            <option value="">--Seleccionar categoria--</option>
                            <?php
                            if (count($getCat) > 0) {
                                foreach ($getCat as $categoria) {
                                    echo '<option value="' . $categoria->getId() . '">' . $categoria->getSigla() . ' - ' . $categoria->getNombre() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="subcategorias" id="subcategorias">

                        </select>
                    </td>
                    <td><input type="text" name="articulomarcaview" id="articulomarcaview" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras y espacios" />
                    <td><input type="text" name="articulomodeloview" id="articulomodeloview" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios" />
                    <td><input type="text" name="articuloserieview" id="articuloserieview" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios" />
                    <td><input type="file" name="articulofotoview" id="articulofotoview" />
                    <td><input type="file" name="articulofoto2view" id="articulofoto2view" />
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>

            <?php
            $articuloBusiness = new ArticuloBusiness();
            $allArticulos = $articuloBusiness->getAllTBArticulo();
            $articulosByCliente = $articuloBusiness->getArticuloByClienteIdObject($clienteId);
            foreach ($articulosByCliente as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/articuloAction.php">';
                echo '<input type="hidden" name="id" value="' . $current->getArticuloId() . '">';
                echo '<tr>';
                echo '<td><textarea required name="nombre" id="nombre" pattern="^[A-Za-z0-9\s]+$" title="Solo se permiten letras, números y espacios" rows="3" cols="40">' . $current->getArticuloNombre() . '</textarea></td>';
                echo '<td>';
                echo '<input type="hidden" name="clienteid" id="clienteid" value="' . $current->getClienteId() . '" readonly>';
                echo '<span>' . $clienteNombreCompleto . '</span>';
                echo '</td>';
                echo '<td>  <select name="categoria" id="categoria">';
                foreach ($getSubCat as $subcategoria) {
                    if ($current->getArticuloSubCategoriaId() == $subcategoria->getSigla()) {
                        $categoriaId = $subcategoria->getCategoriaId();
                        foreach ($getCat as $categoria) {
                            if ($categoria->getId() ==  $categoriaId) {
                                echo "<option selected value='" . $categoria->getId() . "'>" . $categoria->getNombre() . "</option>";
                            } else {
                                echo "<option value='" . $categoria->getId() . "'>" . $categoria->getNombre() . "</option>";
                            }
                        }
                    }
                } //vendedorIdView
                echo ' </select></td>';
                echo '<td>  <select name="subcategorias" id="subcategorias">';
                foreach ($getSubCat as $subcategoria) {
                    if ($current->getArticuloSubCategoriaId() == $subcategoria->getSigla()) {
                        echo "<option selected value='" . $subcategoria->getSigla() . "'>" . $subcategoria->getSigla() . '-' . $subcategoria->getNombre() . "</option>";
                    } else {
                        echo "<option value='" . $subcategoria->getSigla() . "'>" . $subcategoria->getSigla() . '-' . $subcategoria->getNombre() . "</option>";
                    }
                }
                echo ' </select></td>';

                echo '<td><input type="text" name="marca" id="marca" value="' . $current->getArticuloMarca() . '"/></td>';
                echo '<td><input type="text" name="modelo" id="modelo" value="' . $current->getArticuloModelo() . '"/></td>';
                echo '<td><input type="text" name="serie" id="serie" value="' . $current->getArticuloSerie() . '"/></td>';
                echo '<td>';
                echo '<img src="' . $current->getArticuloFoto() . '" alt="Imagen actual" width="100" height="100" />';
                echo '<input type="file" name="articulofotoview" id="articulofotoview" />';
                echo '</td>';
                echo '<td>';
                echo '<img src="' . $current->getArticuloFoto2() . '" alt="Imagen actual" width="100" height="100" />';
                echo '<input type="file" name="articulofoto2view" id="articulofoto2view" />';
                echo '</td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update"/></td>';
                echo '<td><input type="submit" value="Eliminar" name="delete" id="delete"/></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>
        </table>
    </section>
</body>

</html>