<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

include '../business/categoriaBusiness.php';

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
            } else {
                header("location: ../view/categoriaView.php?error=dbError");
            }
        } else {
            header("location: ../view/categoriaView.php?error=emptyField");
        }
    } else {
        header("location: ../view/categoriaView.php?error=error");
    }
} else if (isset($_POST['delete'])) { //if the user clicked on the delete button

    if (
        isset($_POST['categoriaIdView']) && isset($_POST['categoriaSiglaView']) && isset($_POST['categoriaNombreView'])
        && isset($_POST['categoriaDescripcionView'])
    ) { //check if the variables have values 
        $categoriaId = $_POST['categoriaIdView']; //get the id from the form
        $categoriaSigla = $_POST['categoriaSiglaView'];
        $categoriaNombre = $_POST['categoriaNombreView'];
        $categoriaDescripcion = $_POST['categoriaDescripcionView'];
        $categoriaActivo = 0;
        if (
            strlen($categoriaId) > 0 && strlen($categoriaSigla) > 0 && strlen($categoriaNombre) > 0
            && strlen($categoriaDescripcion) > 0
        ) { //check if the variables have values 

            $categoria = new Categoria(
                $categoriaId,
                $categoriaSigla,
                $categoriaNombre,
                $categoriaDescripcion,
                $categoriaActivo
            );

            $categoriaBusiness = new CategoriaBusiness();
            $result = $categoriaBusiness->eliminarTBCategoria($categoria);

            if ($result == 1) {
                header("location: ../view/categoriaView.php?success=delete"); //redirect to the index.php page with a success message
            } else {
                header("location: ../view/categoriaView.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../view/categoriaView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/categoriaView.php?error=error"); //redirect to the index.php page with an error message
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['categoriaSiglaView']) && isset($_POST['categoriaNombreView'])
        && isset($_POST['categoriaDescripcionView'])
    ) { //check if the variables have values

        $categoriaSigla = $_POST['categoriaSiglaView']; //get the name from the form
        $categoriaNombre = $_POST['categoriaNombreView'];
        $categoriaDescripcion = $_POST['categoriaDescripcionView'];
        $categoriaActivo = 1;
        if (
            strlen($categoriaSigla) > 0 && strlen($categoriaNombre) > 0
            && strlen($categoriaDescripcion) > 0
        ) { //check if the variables have values

            $categoria = new Categoria(
                0,
                $categoriaSigla,
                $categoriaNombre,
                $categoriaDescripcion,
                $categoriaActivo
            );

            $categoriaBusiness = new CategoriaBusiness();

            $result = $categoriaBusiness->insertarTBCategoria($categoria);
            if ($result == 1) {
                header("location: ../index.php?success=insert"); //redirect to the index.php page with a success message
            } else {
                header("location: ../index.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../index.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../index.php?error=error"); //redirect to the index.php page with an error message
    }
}
