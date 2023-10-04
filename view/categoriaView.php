<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Categorías</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
    include '../business/categoriaBusiness.php';
    include '../business/subCategoriaBusiness.php';
    $subCategoriaBusiness = new SubCategoriaBusiness();
    $getSubCat = $subCategoriaBusiness->getAllTBSubCategoria();
    $categoriaBusiness = new CategoriaBusiness();
    $getCat = $categoriaBusiness->getAllTBCategoria();

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
    </style>

</head>

<body>
    <header>
        <h1>Registro Categorías</h1>
        <h1><?php echo "$clienteNombre!" ?></h1>
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
                <th>Nombre</th>
                <th>Descripción</th>
            </tr>
            <form method="post" enctype="multipart/form-data" action="../business/categoriaAction.php">
                <tr>
                    <td><input required type="text" name="categoriaNombreView" id="categoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" /></td>
                    <td><input required type="text" name="categoriaDescripcionView" id="categoriaDescripcionView" maxlength="1000" /></td>
                    <td><input type="submit" value="Crear" name="create" id="create" /></td>
                </tr>
            </form>
            <?php
            $categoriaBusiness = new categoriaBusiness();
            $allCategorias = $categoriaBusiness->getAllTBCategoria();
            foreach ($allCategorias as $current) {
                echo '<form method="post" enctype="multipart/form-data" action="../business/categoriaAction.php">';
                echo '<input type="hidden" name="categoriaIdView" value="' . $current->getId() . '">';
                echo '<tr>';
                echo '<input type="hidden" name="categoriaSiglaView" id="categoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4"  value="' . $current->getSigla() . '"/>';
                echo '<td><input type="text" name="categoriaNombreView" id="categoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" maxlength="30" value="' . $current->getNombre() . '"/></td>';
                echo '<td><input type="text" name="categoriaDescripcionView" id="categoriaDescripcionView" maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
                echo '<td><input type="hidden" name="categoriaActivoView" id="categoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
                echo '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
                echo '<td><button type="button" class="btn btn-danger delete_categoria" tbcategoriaid="' . $current->getId() . '">Eliminar</button></td>';
                echo '</tr>';
                echo '</form>';
            }
            ?>


        </table>
    </section>

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

        $(document).ready(function() {
            $(".delete_categoria").on("click", function() {
                var categoriaId = $(this).attr("tbcategoriaid");

                Swal.fire({
                    title: '¿Desea eliminar la categoría?',
                    text: "No se podrá revertir el cambio",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: "Cancelar",
                    confirmButtonText: 'Eliminar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        window.location.href = "../business/categoriaAction.php?delete=true&tbcategoriaid=" + categoriaId;
                    }
                });
            });
        });
        // Obtén una referencia a los campos de entrada
        const categoriaNombreView = document.getElementById('categoriaNombreView');
        const categoriaDescripcionView = document.getElementById('categoriaDescripcionView');

        // Agrega un evento de escucha para cada campo de entrada
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