<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../business/subCategoriaBusiness.php';

if (isset($_POST['update'])) {

    if (
        isset($_POST['subcategoriaIdView']) && isset($_POST['subcategoriaSiglaView']) && isset($_POST['subcategoriaNombreView'])
        && isset($_POST['subcategoriaDescripcionView'])
    ) {
        

        $subcategoriaId = $_POST['subcategoriaIdView'];
        $subcategoriaSigla = $cadena[1].$_POST['subcategoriaSiglaView'];
        $subcategoriaNombre = $_POST['subcategoriaNombreView'];
        $categoria = $_POST['categoriaId'];
        $subcategoriaDescripcion = $_POST['subcategoriaDescripcionView'];
        $subcategoriaActivo = isset($_POST['subcategoriaActivoView']) ? 1 : 0;

        if (strlen($subcategoriaId) > 0 && strlen($subcategoriaSigla) > 0 && strlen($subcategoriaNombre) > 0 && strlen($categoria) && strlen($subcategoriaDescripcion) > 0) {
            $subCategoria = new SubCategoria(
                $subcategoriaId,
                $subcategoriaSigla,
                $subcategoriaNombre,
                $categoria,
                $subcategoriaDescripcion,
                $subcategoriaActivo
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
        isset($_POST['subcategoriaIdView']) && isset($_POST['subcategoriaSiglaView']) && isset($_POST['subcategoriaNombreView'])
        && isset($_POST['subcategoriaDescripcionView'])
    ) { //check if the variables have values 
        $subcategoriaId = $_POST['subcategoriaIdView']; //get the id from the form
        $subcategoriaSigla = $_POST['subcategoriaSiglaView'];
        $subcategoriaNombre = $_POST['subcategoriaNombreView'];
        $categoria = $_POST['categoriaId'];
        $subcategoriaDescripcion = $_POST['subcategoriaDescripcionView'];
        $subcategoriaActivo = 0;
        if (
            strlen($subcategoriaId) > 0 && strlen($subcategoriaSigla) > 0 && strlen($subcategoriaNombre) > 0 && strlen($categoria)
            && strlen($subcategoriaDescripcion) > 0
        ) { //check if the variables have values 

            $subCategoria = new SubCategoria(
                $subcategoriaId,
                $subcategoriaSigla,
                $subcategoriaNombre,
                $categoria,
                $subcategoriaDescripcion,
                $subcategoriaActivo
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
        isset($_POST['subcategoriaSiglaView']) && isset($_POST['subcategoriaNombreView'])
        && isset($_POST['subcategoriaDescripcionView'])
    ) { //check if the variables have values

        $cadena = explode("-",$_POST['categoria']);

        $subcategoriaSigla = $cadena[1].$_POST['subcategoriaSiglaView']; //get the name from the form
        $subcategoriaNombre = $_POST['subcategoriaNombreView'];
        $categoria = $cadena[0];
        $subcategoriaDescripcion = $_POST['subcategoriaDescripcionView'];
        $subcategoriaActivo = 1;

        if (
            strlen($subcategoriaSigla) > 0 &&
            strlen($categoria) &&
            strlen($subcategoriaNombre) > 0
            && strlen($subcategoriaDescripcion) > 0
        ) { //check if the variables have values


            $subCategoria = new SubCategoria(
                0,
                $subcategoriaSigla,
                $subcategoriaNombre,
                $categoria,
                $subcategoriaDescripcion,
                $subcategoriaActivo
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
}else if (isset($_POST['valor'])) {
    $categoriaId = $_POST['valor'];
    $business = new SubCategoriaBusiness();
    $subcategorias = $business->getSubcategoriasByCategoriaId($categoriaId);
    $cadena = "<select id='subcategoriaview' name='subcategoriaview'>";
    $cadena .= '<option value="">Selecciona una subcategoria</option>';
    foreach ($subcategorias as $sub) {
        $cadena .= '<option value="' . $sub->getId() . '">'. $sub->getSigla() .' - '. $sub->getNombre() . '</option>';
    }
    echo $cadena .= "</select>";
}





