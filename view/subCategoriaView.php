<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Subcategorías</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);

    include '../business/subCategoriaBusiness.php';
    include '../business/categoriaBusiness.php';
    $subCategoriaBusiness = new SubCategoriaBusiness();
    $getSubCat = $subCategoriaBusiness->getAllTBSubCategoria();
    $categoriaBusiness = new CategoriaBusiness();
    $getCat = $categoriaBusiness->getAllTBCategoria();
    $categoriaIdSelected;
    session_start();
    ?>

    <style>
        /* Estilo para las cajas de subcategoría en el mapa conceptual */
        .subcategoriaBox {
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            padding: 10px;
            margin: 10px;
            display: inline-block;
            position: relative;
        }

        /* Estilo para las líneas que conectan las cajas */
        .linea {
            border: 1px solid #ccc;
            width: 0;
            height: 40px;
            display: inline-block;
            vertical-align: middle;
            position: absolute;
            top: 50%;
        }

        /* Estilo para las cajas de categoría */
        .categoriaBox {
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            padding: 10px;
            margin: 10px;
            display: inline-block;
        }

        /* Oculta los campos de categoría, sigla y activo */
        #tablaSubcategorias td:nth-child(1),
        #tablaSubcategorias td:nth-child(2),
        #tablaSubcategorias td:nth-child(3),
        #tablaSubcategorias td:nth-child(6) {
            display: none;
        }
    </style>

    <script>
        $(document).ready(function() {
            $('#categoria').change(function() {
                recargarLista();
            });
        });

        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "../business/subCategoriaAction.php",
                data: "numCategoria=" + $('#categoria').val(),
                success: function(response) {
                    var data = JSON.parse(response);
                    //console.log(data);
                    var tabla = $("#tablaSubcategorias");

                    // Limpia la tabla antes de añadir nuevos datos
                    tabla.empty();

                    // Recorre los datos y crea una fila para cada elemento
                    data.forEach(function(item) {
                        var fila = $("<tr>");
                        // Añadir las columnas con los datos
                        fila.append($("<td>").text(item.subcategoriaId));
                        fila.append($("<td>").text(item.categoriaId));
                        fila.append($("<td>").text(item.sigla));

                        // Crear campo de entrada de texto editable para Nombre
                        var inputNombre = $("<input>").attr({
                            type: "text",
                            value: item.nombre,
                            readonly: false, // Hacerlo de solo lectura inicialmente
                            name: "subcategoriaNombreView", // Agregar el nombre del campo
                            maxLength: 30
                        });
                        fila.append($("<td>").append(inputNombre));

                        // Crear campo de entrada de texto editable para Descripción
                        var inputDescripcion = $("<input>").attr({
                            type: "text",
                            value: item.descripcion,
                            readonly: false, // Hacerlo de solo lectura inicialmente
                            name: "subcategoriaDescripcionView", // Agregar el nombre del campo
                            maxLength: 1000
                        });
                        fila.append($("<td>").append(inputDescripcion));

                        // Crear campo oculto para el valor de Activo
                        var inputActivo = $("<input>").attr({
                            type: "hidden",
                            value: item.activo,
                            name: "subcategoriaActivoView" // Agregar el nombre del campo
                        });
                        fila.append($("<td>").append(inputActivo));


                        // Agrega un botón de "Actualizar" a la fila
                        var botonEditar = $("<button>").text("Actualizar");
                        botonEditar.attr("tbsubcategoriaid", item.subcategoriaId);
                        botonEditar.click(function() {
                            var subCategoriaId = $(this).attr("tbsubcategoriaid");

                            Swal.fire({
                                title: '¿Desea actualizar la subcategoría?',
                                text: "No se podrá revertir el cambio",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: "Cancelar",
                                confirmButtonText: 'Actualizar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Redirecciona a la página de actualización con los datos de la subcategoría como parámetros de consulta
                                    window.location.href = "../business/subCategoriaAction.php?update=true&subcategoriaIdView=" + subCategoriaId +
                                        "&categoriaId=" + item.categoriaId +
                                        "&subcategoriaSiglaView=" + item.sigla +
                                        "&subcategoriaNombreView=" + inputNombre.val() +
                                        "&subcategoriaDescripcionView=" + inputDescripcion.val() +
                                        "&subcategoriaActivoView=" + item.activo;
                                    console.log(inputNombre.val());
                                }
                            });
                            return false;
                        });
                        fila.append($("<td>").append(botonEditar));

                        // Agrega un botón de "Eliminar" a la fila
                        var botonEliminar = $("<button>").text("Eliminar");
                        botonEliminar.attr("tbsubcategoriaid", item.subcategoriaId);
                        botonEliminar.click(function() {
                            var subCategoriaId = $(this).attr("tbsubcategoriaid");

                            Swal.fire({
                                title: '¿Desea eliminar la subcategoría?',
                                text: "No se podrá revertir el cambio",
                                icon: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: "Cancelar",
                                confirmButtonText: 'Eliminar'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    // Realiza la redirección después de la confirmación
                                    window.location.href = "../business/subCategoriaAction.php?delete=true&tbsubcategoriaid=" + subCategoriaId;
                                }
                            });
                            return false;
                        });
                        fila.append($("<td>").append(botonEliminar));

                        tabla.append(fila);
                    });

                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud:", error);
                }
            });
        }

        /*
        $(document).ready(function() {
            $("#obtenerDatos").click(function() {
                $.ajax({
                    url: 'ejemplo.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        // Limpiar la tabla antes de agregar nuevos datos
                        $("#cuerpoTabla").empty();

                        // Recorrer la lista de datos y construir la tabla
                        $.each(data, function(index, item) {
                            var fila = "<tr><td>" + item.nombre + "</td><td>" + item.edad + "</td></tr>";
                            $("#cuerpoTabla").append(fila);
                        });
                    },
                    error: function() {
                        alert('Error al obtener los datos');
                    }
                });
            });
        });
        
        $(document).ready(function() {
            $('#categoria').change(function() {
                recargarLista();
            });
        });

        function recargarLista() {
            $.ajax({
                type: "POST",
                url: "../business/subCategoriaAction.php",
                data: "numCategoria=" + $('#categoria').val(),
                success: function(response) {
                    // Inserta la respuesta generada por el bucle PHP en la tabla
                    $("#tablaSubcategorias").empty(); // Limpia la tabla antes de añadir nuevos datos
                    $("#tablaSubcategorias").html(response);
                },
                error: function(xhr, status, error) {
                    console.error("Error en la solicitud:", error);
                }
            });
        }*/
    </script>

    <style>
        .subcategoria-list {
            padding-left: 159px;
        }
    </style>

</head>

<body>
    <header>
        <h1>Registro Subcategorías</h1>
        <h2><a href="../index.php">Home</a></h2>
    </header>

    <!-- Agrega un botón para mostrar/ocultar el mapa conceptual -->
    <button id="toggleMap">Mostrar Mapa Conceptual</button>

    <!-- Contenedor del mapa conceptual (inicialmente oculto) -->
    <div id="mapaConceptual" style="display: none;">
        <!-- Categoría raíz -->
        <div class="categoriaBox">
            <span>Categoría Raíz</span>
        </div>

        <!-- Subcategorías y conexiones -->
        <?php
        if (count($getCat) > 0) {
            foreach ($getCat as $categoria) {
                echo '<div class="subcategoriaBox">';
                echo '<span>' . $categoria->getNombre() . '</span>';
                if (count($getSubCat) > 0) {
                    foreach ($getSubCat as $subcategoria) {
                        if ($categoria->getId() == $subcategoria->getCategoriaId()) {
                            echo '<div class="linea"></div>';
                            echo '<span>' . $subcategoria->getNombre() . '</span>';
                        }
                    }
                } else {
                    echo '<span>Ninguna subcategoría registrada en esta categoría</span>';
                }
                echo '</div>';
            }
        } else {
            echo '<span>Ninguna categoría registrada</span>';
        }
        ?>
    </div>

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
    } ?>

    <section id="form">
        <table>
            <tr>
                <th>Categoría</th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th></th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">
                <tr>
                    <td>
                        <select name="categoria" id="categoria">
                            <option value="">Seleccionar categoria</option>
                            <?php
                            if (count($getCat) > 0) {
                                foreach ($getCat as $categoria) {
                                    echo '<option value="' . $categoria->getId() . "-" . $categoria->getSigla() . '" data-id="' . $categoria->getId() . '">' . $categoria->getNombre() . '</option>';
                                }
                            } else {
                                echo '<option value="">Ninguna categoria registrada</option>';
                            }
                            ?>
                        </select>
                    </td>


                    <td><input required type="text" name="subcategoriaNombreView" id="subcategoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" /></td>
                    <td><input required type="text" name="subcategoriaDescripcionView" id="subcategoriaDescripcionView" maxlength="1000" /></td>

                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>


        </table>
    </section>

    <form class="subcategoria" id="miForm" method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">
        <table id="tablaSubcategorias" class="subcategoria-list">
        </table>
    </form>
    <br><br>


    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        document.getElementById('toggleMap').addEventListener('click', function() {
            var mapaConceptual = document.getElementById('mapaConceptual');
            if (mapaConceptual.style.display === 'none') {
                mapaConceptual.style.display = 'block';
            } else {
                mapaConceptual.style.display = 'none';
            }
        });

        // Obtén una referencia a los campos de entrada
        const subcategoriaNombreView = document.getElementById('subcategoriaNombreView');
        const subcategoriaDescripcionView = document.getElementById('subcategoriaDescripcionView');

        // Agrega un evento de escucha para cada campo de entrada
        subcategoriaNombreView.addEventListener('input', validateMaxLength);
        subcategoriaDescripcionView.addEventListener('input', validateMaxLength);

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