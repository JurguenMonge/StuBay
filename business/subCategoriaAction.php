<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../business/subCategoriaBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['id']) && isset($_POST['sigla']) && isset($_POST['nombre'])
        && isset($_POST['descripcion'])
    ) {
        $id = $_POST['id'];
        $sigla = $_POST['sigla'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $activo = isset($_POST['activo']) ? 1 : 0;

        if (strlen($id) > 0 && strlen($sigla) > 0 && strlen($nombre) > 0 && strlen($categoria) && strlen($descripcion) > 0) {
            $subCategoria = new SubCategoria(
                $id,
                $sigla,
                $nombre,
                $categoria,
                $descripcion,
                $activo
            );

            $subCategoriaBusiness = new SubCategoriaBusiness();

            $result = $subCategoriaBusiness->actualizarTBSubCategoria($subCategoria);
            if ($result == 1) {
                header("location: ../view/subCategoriaView.php?success=updated");
            } else {
                header("location: ../view/subCategoriaView.php?error=dbError");
            }
        } else {
            header("location: ../view/subCategoriaView.php?error=emptyField");
        }
    } else {
        header("location: ../view/subCategoriaView.php?error=error");
    }
} else if (isset($_POST['delete'])) { //if the user clicked on the delete button

    if (
        isset($_POST['id']) && isset($_POST['sigla']) && isset($_POST['nombre'])
        && isset($_POST['descripcion'])
    ) { //check if the variables have values 
        $id = $_POST['id']; //get the id from the form
        $sigla = $_POST['sigla'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $activo = 0;
        if (
            strlen($id) > 0 && strlen($sigla) > 0 && strlen($nombre) > 0 && strlen($categoria)
            && strlen($descripcion) > 0
        ) { //check if the variables have values 

            $subCategoria = new SubCategoria(
                $id,
                $sigla,
                $nombre,
                $categoria,
                $descripcion,
                $activo
            );

            $subCategoriaBusiness = new SubCategoriaBusiness();
            $result = $subCategoriaBusiness->eliminarTBSubCategoria($subCategoria);

            if ($result == 1) {
                header("location: ../view/subCategoriaView.php?success=delete"); //redirect to the index.php page with a success message
            } else {
                header("location: ../view/subCategoriaView.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../view/subCategoriaView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/subCategoriaView.php?error=error"); //redirect to the index.php page with an error message
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['sigla']) && isset($_POST['nombre'])
        && isset($_POST['descripcion'])
    ) { //check if the variables have values

        $sigla = $_POST['sigla']; //get the name from the form
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $descripcion = $_POST['descripcion'];
        $activo = 1;

        if (
            strlen($sigla) > 0 &&
            strlen($categoria) &&
            strlen($nombre) > 0
            && strlen($descripcion) > 0
        ) { //check if the variables have values


            $subCategoria = new SubCategoria(
                0,
                $sigla,
                $nombre,
                $categoria,
                $descripcion,
                $activo
            );

            $subCategoriaBusiness = new SubCategoriaBusiness();

            $result = $subCategoriaBusiness->insertarTBSubCategoria($subCategoria);
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
