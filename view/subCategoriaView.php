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
    $categoriaBusiness = new CategoriaBusiness();
    $getCat = $categoriaBusiness->getAllTBCategoria();
    $categoriaIdSelected;
    session_start();
    ?>

    <style>/*
        #tablaSubcategorias {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        #tablaSubcategorias th,
        #tablaSubcategorias td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        #tablaSubcategorias th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        #tablaSubcategorias tr:hover {
            background-color: #e0e0e0;
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
                            name: "subcategoriaNombreView" // Agregar el nombre del campo
                        });
                        fila.append($("<td>").append(inputNombre));

                        // Crear campo de entrada de texto editable para Descripción
                        var inputDescripcion = $("<input>").attr({
                            type: "text",
                            value: item.descripcion,
                            readonly: false, // Hacerlo de solo lectura inicialmente
                            name: "subcategoriaDescripcionView" // Agregar el nombre del campo
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
                                        "&subcategoriaNombreView=" + item.nombre +
                                        "&subcategoriaDescripcionView=" + item.descripcion +
                                        "&subcategoriaActivoView=" + item.activo;
                                        
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


    <?php


    $subCategoriaBusiness = new SubCategoriaBusiness();
    $allSubCategorias = $subCategoriaBusiness->getAllTBSubCategoria();
    /*
        foreach ($allSubCategorias as $current) {

            echo '<form class="subcategoria" id="subcategoria-' . $current->getCategoriaId() . '" method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">';
            echo '<input type="hidden" name="subcategoriaIdView" value="' . $current->getId() . '">';
            echo '<tr>';
            echo '<input type="hidden" name="categoriaId" value="' . $current->getCategoriaId() . '">';
            echo '<td></td>';
            echo '<td><input type="text" name="subcategoriaSiglaView" id="subcategoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4"  value="' . $current->getSigla() . '"/></td>';
            echo '<td><input type="text" name="subcategoriaNombreView" id="subcategoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" value="' . $current->getNombre() . '"/></td>';
            echo '<td><input type="text" name="subcategoriaDescripcionView" id="subcategoriaDescripcionView" maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
            echo '<input type="hidden" name="subcategoriaActivoView" id="subcategoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/>';
            echo '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
            echo '<td><button type="button" class="btn btn-danger delete_categoria" tbsubcategoriaid="' . $current->getId() . '">Eliminar</button></td>';
            echo '</tr>';
            echo '</form>';
        }*/
    ?>
    </table>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        /*
        $(document).ready(function() {
            $(".delete_subcategoria").on("click", function() {
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
                        window.location.href = "../business/subCategoriaAction.php?delete=true&tbsubcategoriaid=" + subCategoriaId;
                    }
                });
            });
        });*/

        // Obtén una referencia a los campos de entrada
        //const subcategoriaSiglaView = document.getElementById('subcategoriaSiglaView');
        const subcategoriaNombreView = document.getElementById('subcategoriaNombreView');
        const subcategoriaDescripcionView = document.getElementById('subcategoriaDescripcionView');

        // Agrega un evento de escucha para cada campo de entrada
        //subcategoriaSiglaView.addEventListener('input', validateMaxLength);
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