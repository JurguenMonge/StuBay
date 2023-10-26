<?php

include '../business/articuloBusiness.php';

if (isset($_POST['update'])) {

    if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['subcategorias']) && isset($_FILES['articulofotoview'])) {

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $activo = 1;
        $subcategoria = $_POST['subcategorias'];
        $cliente = $_POST['clienteid'];
        $articuloFoto = $_FILES['articulofotoview'];

        // Verifica si se seleccionó una nueva imagen
        if (isset($_FILES['articulofotoview']) && $_FILES['articulofotoview']['error'] === UPLOAD_ERR_OK) {
            //$directory = "../articulosFotos/";
            //directory para almacenar las imagenes en la db en linux
            $directory = realpath("../fotos") . DIRECTORY_SEPARATOR;
            $fileExtension = pathinfo($_FILES['articulofotoview']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $filePath = $directory . $uniqueFileName;

            // Mueve la nueva imagen
            if (move_uploaded_file($_FILES['articulofotoview']['tmp_name'], $filePath)) {
                // Imagen cargada con éxito, actualiza el campo de la imagen
                $articuloFoto = $filePath;
            }
        } else {
            // No se seleccionó una nueva imagen, obtén la imagen actual del artículo
            $articuloBusiness = new ArticuloBusiness();
            $currentArticulo = $articuloBusiness->getArticuloById($id); // Obtener el artículo actual por su ID
            $articuloFoto = $currentArticulo->getArticuloFoto(); // Obtener la imagen actual del artículo actual
        }

        // Verifica si se seleccionó una nueva imagen
        if (isset($_FILES['articulofoto2view']) && $_FILES['articulofoto2view']['error'] === UPLOAD_ERR_OK) {
            //$directory = "../articulosFotos/";
            $directory = realpath("../fotos") . DIRECTORY_SEPARATOR;
            $fileExtension = pathinfo($_FILES['articulofoto2view']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $filePath = $directory . $uniqueFileName;

            // Mueve la nueva imagen
            if (move_uploaded_file($_FILES['articulofoto2view']['tmp_name'], $filePath)) {
                // Imagen cargada con éxito, actualiza el campo de la imagen
                $articuloFoto2 = $filePath;
            }
        } else {
            // No se seleccionó una nueva imagen, obtén la imagen actual del artículo
            $articuloBusiness = new ArticuloBusiness();
            $currentArticulo = $articuloBusiness->getArticuloById($id); // Obtener el artículo actual por su ID
            $articuloFoto2 = $currentArticulo->getArticuloFoto2(); // Obtener la imagen actual del artículo actual y asignarla a la variable $articuloFoto2 para que no se pierda al actualizar el artículo en la base de datos 
        }


        if (strlen($id) > 0 && strlen($nombre) > 0 && strlen($subcategoria) > 0) {
            $articulo = new Articulo(
                $id,
                $nombre,
                $marca,
                $modelo,
                $serie,
                $activo,
                $subcategoria,
                $cliente,
                $articuloFoto,
                $articuloFoto2
            );

            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->updateTBArticulo($articulo);

            if ($result == 1) {
                header("location: ../view/articuloView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Articulo actualizado correctamente";
            } else {
                header("location: ../view/articuloView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar el articulo";
            }
        } else {
            header("location: ../view/articuloView.php?error=emptyField");
        }
    } else {
        header("location: ../view/articuloView.php?error=error");
    }
} else if (isset($_POST['create'])) {
    // Validaciones
    if (
        isset($_POST['articulonombreview']) && isset($_POST['articulomarcaview'])
        && isset($_POST['articulomodeloview'])
        && isset($_POST['articuloserieview'])
        && isset($_POST['subcategorias'])
    ) {
        // Obtener los datos del formulario
        $articuloNombre = $_POST['articulonombreview'];
        $articuloMarca = $_POST['articulomarcaview'];
        $articuloModelo = $_POST['articulomodeloview'];
        $articuloSerie = $_POST['articuloserieview'];
        $articuloActivo = 1;
        $articuloSubCategoriaId = $_POST['subcategorias'];
        $cliente = $_POST['clienteid'];

        // Definir la ruta absoluta para el directorio de fotos
        $directory = "../fotos" . DIRECTORY_SEPARATOR;

        if (isset($_FILES['articulofotoview']) && $_FILES['articulofotoview']['error'] === UPLOAD_ERR_OK) {
            $fileExtension = pathinfo($_FILES['articulofotoview']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $filePath = $directory . $uniqueFileName;

            move_uploaded_file($_FILES['articulofotoview']['tmp_name'], $filePath);
            $articuloFoto = $filePath;
        } else {
            $articuloFoto = null;
        }

        if (isset($_FILES['articulofoto2view']) && $_FILES['articulofoto2view']['error'] === UPLOAD_ERR_OK) {
            $fileExtension = pathinfo($_FILES['articulofoto2view']['name'], PATHINFO_EXTENSION);
            $uniqueFileName = uniqid() . '_' . time() . '.' . $fileExtension;
            $filePath = $directory . $uniqueFileName;

            move_uploaded_file($_FILES['articulofoto2view']['tmp_name'], $filePath);
            $articuloFoto2 = $filePath;
        } else {
            $articuloFoto2 = null;
        }

        // Validar variables
        if (strlen($articuloNombre) > 0 && strlen($articuloSubCategoriaId) > 0) {
            $articulo = new Articulo(
                0,
                $articuloNombre,
                $articuloMarca,
                $articuloModelo,
                $articuloSerie,
                $articuloActivo,
                $articuloSubCategoriaId,
                $cliente,
                $articuloFoto,
                $articuloFoto2
            );
            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->insertarTBArticulo($articulo);
            if ($result == 1) {
                header("location: ../view/articuloView.php?success=insert");
                session_start();
                $_SESSION['msj'] = "Articulo registrado correctamente";
            } else {
                header("location: ../view/articuloView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al registrar el articulo";
            }
        } else {
            header("location: ../view/articuloView.php?error=emptyField");
        }
    } else {
        header("location: ../view/articuloView.php?error=error");
    }
}else if (isset($_POST['delete'])) {
    if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['subcategorias'])) {

        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $activo = 0;
        $subcategoria = $_POST['subcategorias'];
        $cliente = $_POST['clienteid'];

        if (strlen($id) > 0 && strlen($nombre) > 0 && strlen($subcategoria) > 0) {
            $articulo = new Articulo(
                $id,
                $nombre,
                $marca,
                $modelo,
                $serie,
                $activo,
                $subcategoria,
                $cliente,
                $articuloFoto,
                $articuloFoto2
            );

            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->deleteTBArticulo($articulo);

            if ($result == 1) {
                header("location: ../view/articuloView.php?success=delete");
                session_start();
                $_SESSION['msj'] = "Articulo eliminado correctamente";
            } else if ($result == 8) {
                header("location: ../view/articuloView.php?error=delete");
                session_start();
                $_SESSION['error'] = "Error al eliminar articulo, pertenece a una subasta activa";
            } else {
                header("location: ../view/articuloView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al eliminar el articulo";
            }
        } else {
            header("location: ../view/articuloView.php?error=emptyField");
        }
    } else {
        header("location: ../view/articuloView.php?error=error");
    }
} else if (isset($_GET['termino'])) {
    $termino = $_GET['termino'];
    $articuloBusiness = new ArticuloBusiness();
    $nombres = $articuloBusiness->getTBArticuloName($termino);

    if ($nombres) {
        echo json_encode($nombres);
    } else {
        echo json_encode(array("error" => "Error en la consulta"));
    }
}
