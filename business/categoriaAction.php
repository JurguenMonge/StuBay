<?php

include '../business/categoriaBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['id']) && isset($_POST['sigla']) && isset($_POST['nombre'])
        && isset($_POST['descripcion'])
    ) {
        $id = $_POST['id'];
        $sigla = $_POST['sigla'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $activo = isset($_POST['activo']) ? 1 : 0;

        if (strlen($id) > 0 && strlen($sigla) > 0 && strlen($nombre) > 0 && strlen($descripcion) > 0) {
            $categoria = new Categoria(
                $id,
                $sigla,
                $nombre,
                $descripcion,
                $activo
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
        isset($_POST['id']) && isset($_POST['sigla']) && isset($_POST['nombre'])
        && isset($_POST['descripcion'])
    ) { //check if the variables have values 
        $id = $_POST['id']; //get the id from the form
        $sigla = $_POST['sigla'];
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $activo = 0;
        if (
            strlen($id) > 0 && strlen($sigla) > 0 && strlen($nombre) > 0
            && strlen($descripcion) > 0
        ) { //check if the variables have values 

            $categoria = new Categoria(
                $id,
                $sigla,
                $nombre,
                $descripcion,
                $activo
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
        isset($_POST['sigla']) && isset($_POST['nombre'])
        && isset($_POST['descripcion'])
    ) { //check if the variables have values

        $sigla = $_POST['sigla']; //get the name from the form
        $nombre = $_POST['nombre'];
        $descripcion = $_POST['descripcion'];
        $activo = 1;
        if (
            strlen($sigla) > 0 && strlen($nombre) > 0
            && strlen($descripcion) > 0
        ) { //check if the variables have values

            $categoria = new Categoria(
                0,
                $sigla,
                $nombre,
                $descripcion,
                $activo
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
