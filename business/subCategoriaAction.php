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
        $subcategoriaSigla = $cadena[1] . $_POST['subcategoriaSiglaView'];
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

        $cadena = explode("-", $_POST['categoria']);

        $subcategoriaSigla = $cadena[1] . $_POST['subcategoriaSiglaView']; //get the name from the form
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
} else if (isset($_POST['valor'])) {
    $categoriaId = $_POST['valor'];
    $business = new SubCategoriaBusiness();
    $subcategorias = $business->getSubcategoriasByCategoriaId($categoriaId);
    //$cadena = "<select id='subcategoriaview' name='subcategoriaview'>";
    $cadena = '<option value="">Selecciona una subcategoria</option>';
    foreach ($subcategorias as $sub) {
         $subSigla = $sub->getSigla();
         $parte1 = substr($subSigla, 0, 2); 
         $parte2 = substr($subSigla, 2, 2); 
         $cadena .= '<option value="' . $parte2 . '">' . $sub->getSigla() . ' - ' . $sub->getNombre() ;
    }
        echo $cadena .= "</option>";
    //echo $cadena .= "</select>";
} else if (isset($_POST['numCategoria'])) {
    $cadena = explode("-", $_POST['numCategoria']);
    $categoriaId = $cadena[0];
    $subCategoriaBusiness = new SubCategoriaBusiness();
    $subcategorias = $subCategoriaBusiness->getSubcategoriasByCategoriaId($categoriaId);
    //var_dump($subcategorias);
    $acumuladorCadenas = "";
    foreach ($subcategorias as $current) {
        $cadena = '<form class="subcategoria" id="subcategoria-' . $current->getCategoriaId() . '" method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">';
        $cadena .= '<input type="hidden" name="subcategoriaIdView" value="' . $current->getId() . '">';
        $cadena .= '<tr>';
        $cadena .= '<input type="hidden" name="categoriaId" value="' . $current->getCategoriaId() . '">';
        $cadena .= '<td></td>';
        $cadena .= '<td><input type="text" name="subcategoriaSiglaView" id="subcategoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4" readonly value="' . $current->getSigla() . '"/></td>';
        $cadena .= '<td><input type="text" name="subcategoriaNombreView" id="subcategoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes" readonly maxlength="30" value="' . $current->getNombre() . '"/></td>';
        $cadena .= '<td><input type="text" name="subcategoriaDescripcionView" id="subcategoriaDescripcionView" readonly maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
        $cadena .= '<td><input type="checkbox" name="subcategoriaActivoView" readonly id="subcategoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/></td>';
        
        $cadena .= '</tr>';
        $cadena .= '</form>';
        $acumuladorCadenas .= $cadena; // Agregamos la cadena generada al acumulador
    }

    echo $acumuladorCadenas; // Imprimimos todas las cadenas generadas

}
