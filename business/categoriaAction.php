<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../business/categoriaBusiness.php';
include '../business/subCategoriaBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['categoriaIdView']) && isset($_POST['categoriaSiglaView']) && isset($_POST['categoriaNombreView'])
        && isset($_POST['categoriaDescripcionView'])
    ) {
        $categoriaId = $_POST['categoriaIdView'];
        $categoriaSigla = $_POST['categoriaSiglaView'];
        $categoriaNombre = $_POST['categoriaNombreView'];
        $categoriaDescripcion = $_POST['categoriaDescripcionView'];
        $categoriaActivo = isset($_POST['categoriaActivoView']) ? 1 : 0;

        if (strlen($categoriaId) > 0 && strlen($categoriaSigla) > 0 && strlen($categoriaNombre) > 0 && strlen($categoriaDescripcion) > 0) {
            $categoria = new Categoria(
                $categoriaId,
                $categoriaSigla,
                $categoriaNombre,
                $categoriaDescripcion,
                $categoriaActivo
            ); //create a student object

            $categoriaBusiness = new CategoriaBusiness();

            $result = $categoriaBusiness->actualizarTBCategoria($categoria);
            if ($result == 1) {
                header("location: ../view/categoriaView.php?success=updated");
                session_start();
                $_SESSION['msj'] = "Categoría actualizada correctamente";
            } else {
                header("location: ../view/categoriaView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar la categoría";
            }
        } else {
            header("location: ../view/categoriaView.php?error=emptyField");
        }
    } else {
        header("location: ../view/categoriaView.php?error=error");
    }
} else if (isset($_GET['delete'])) { //if the user clicked on the delete button

    $categoriaId = $_GET['tbcategoriaid'];
    $subCategoriaBusiness = new SubCategoriaBusiness();
    $subcategorias = $subCategoriaBusiness->getSubcategoriasByCategoriaId($categoriaId);

    if ($subcategorias == NULL) {
        $categoriaBusiness = new CategoriaBusiness();
        $result = $categoriaBusiness->eliminarTBCategoria($categoriaId);

        if ($result == 1) {
            header("location: ../view/categoriaView.php?success=delete"); //redirect to the index.php page with a success message
            session_start();
            $_SESSION['msj'] = "Categoría eliminada correctamente";
        } else {
            header("location: ../view/categoriaView.php?error=dbError"); //redirect to the index.php page with an error message
            session_start();
            $_SESSION['error'] = "Error al eliminar la categoría";
        }
    } else {
        header("location: ../view/categoriaView.php?error=error"); //redirect to the index.php page with an error message
        session_start();
        $_SESSION['error'] = "No puedes eliminar esta categoría porque posee subcategorías relacionadas";
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['categoriaNombreView'])
        && isset($_POST['categoriaDescripcionView'])
    ) { //check if the variables have values

        $categoriaNombre = $_POST['categoriaNombreView'];
        $categoriaDescripcion = $_POST['categoriaDescripcionView'];
        $categoriaActivo = 1;
        if (
            strlen($categoriaNombre) > 0
            && strlen($categoriaDescripcion) > 0
        ) { //check if the variables have values

            $categoria = new Categoria(
                0,
                '',
                $categoriaNombre,
                $categoriaDescripcion,
                $categoriaActivo
            );

            $categoriaBusiness = new CategoriaBusiness();

            $result = $categoriaBusiness->insertarTBCategoria($categoria);
            if ($result == 1) {
                header("location: ../view/categoriaView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Categoría registrada correctamente";
            } else {
                header("location: ../view/categoriaView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar la categoría";
            }
        } else {
            header("location: ../view/categoriaView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/categoriaView.php?error=error"); //redirect to the index.php page with an error message
    }
}
