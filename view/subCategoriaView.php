<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Subcategorías</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/alertaSocket.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css">
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


    //lo que hace es que si el usuario no ha iniciado sesion lo redirecciona al login
    include_once("../session/startsession.php");
    //session_start();
    if (isset($_SESSION['nombre'])) {

        $clienteNombre = $_SESSION['nombre'];
    } else {
        echo "No has iniciado sesión";
    }
    ?>

    <style>
        /* Estilos para el modal */
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }


        /* Estilo para las cajas de categoría en el mapa conceptual */
        .categoriaNode {
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            padding: 10px;
            margin: 10px;
            display: inline-block;
        }

        /* Estilo para las cajas de subcategoría en el mapa conceptual */
        .subcategoriaNode {
            border: 1px solid #ccc;
            background-color: #f2f2f2;
            padding: 10px;
            margin: 10px;
            display: inline-block;
        }

        /* Estilo para las líneas que conectan las cajas */
        .linea {
            border-left: 1px solid #ccc;
            height: 100%;
            display: inline-block;
            margin-left: 10px;
            margin-right: 10px;
            vertical-align: middle;
        }

        /* Estilo para el contenedor de subcategorías */
        .subcategoriaContainer {
            display: inline-block;
            vertical-align: top;
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
                            readonly: false,
                            name: "subcategoriaNombreView",
                            maxLength: 30
                        });
                        fila.append($("<td>").append(inputNombre));

                        // Crear campo de entrada de texto editable para Descripción
                        var inputDescripcion = $("<input>").attr({
                            type: "text",
                            value: item.descripcion,
                            readonly: false,
                            name: "subcategoriaDescripcionView",
                            maxLength: 1000
                        });
                        fila.append($("<td>").append(inputDescripcion));

                        // Crear campo oculto para el valor de Activo
                        var inputActivo = $("<input>").attr({
                            type: "hidden",
                            value: item.activo,
                            name: "subcategoriaActivoView"
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
    </script>

    <style>
        .subcategoria-list {
            padding-left: 159px;
        }
    </style>

</head>

<body>
    <header>
        <h1><?php echo "$clienteNombre!" ?></h1>
        <h1>Registro Subcategorías</h1>
        <h2><a href="inicioView.php">Home</a></h2>
    </header>

    <!-- Botón para mostrar el modal -->
    <button id="openMapModal">Mostrar Organigrama</button>


    <!-- Modal para el mapa conceptual -->
    <div id="mapModal" class="modal">
        <div class="modal-content">
            <span class="close" id="closeModal">&times;</span>
            <div id="mapaConceptual">

                <!-- Subcategorías y conexiones -->
                <?php
                if (count($getCat) > 0) {
                    foreach ($getCat as $categoria) {
                        echo '<div class="categoriaNode">';
                        echo '<span>' . $categoria->getNombre() . '</span>';
                        if (count($getSubCat) > 0) {
                            foreach ($getSubCat as $subcategoria) {
                                if ($categoria->getId() == $subcategoria->getCategoriaId()) {
                                    echo '<div class="linea"></div>';
                                    echo '<div class="subcategoriaContainer">';
                                    echo '<div class="subcategoriaNode">' . $subcategoria->getNombre() . '</div>';
                                    echo '</div>';
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
        </div>
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
        // Obtén una referencia al modal y al botón de cierre
        var mapModal = document.getElementById('mapModal');
        var openMapModalBtn = document.getElementById('openMapModal');
        var closeModalBtn = document.getElementById('closeModal');

        // Asigna un manejador de eventos al botón "Mostrar Mapa Conceptual"
        openMapModalBtn.addEventListener('click', function() {
            mapModal.style.display = 'block';
        });

        // Asigna un manejador de eventos al botón de cierre del modal
        closeModalBtn.addEventListener('click', function() {
            mapModal.style.display = 'none';
        });

        // Cierra el modal si el usuario hace clic fuera de él
        window.addEventListener('click', function(event) {
            if (event.target === mapModal) {
                mapModal.style.display = 'none';
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