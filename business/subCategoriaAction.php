<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../business/subCategoriaBusiness.php';

if (isset($_GET['update'])) {

    if (
        isset($_GET['subcategoriaIdView']) && isset($_GET['subcategoriaSiglaView']) && isset($_GET['subcategoriaNombreView'])
        && isset($_GET['subcategoriaDescripcionView'])
    ) {


        $subcategoriaId = $_GET['subcategoriaIdView'];
        $subcategoriaSigla = $cadena[1] . $_GET['subcategoriaSiglaView'];
        $subcategoriaNombre = $_GET['subcategoriaNombreView'];
        $categoria = $_GET['categoriaId'];
        $subcategoriaDescripcion = $_GET['subcategoriaDescripcionView'];
        $subcategoriaActivo = isset($_GET['subcategoriaActivoView']) ? 1 : 0;

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
                session_start();
                $_SESSION['msj'] = "Subcategoría actualizada correctamente";
            } else {
                header("location: ../view/subCategoriaView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al actualizar la subcategoría";
            }
        } else {
            header("location: ../view/subCategoriaView.php?error=emptyField");
        }
    } else {
        header("location: ../view/subCategoriaView.php?error=error");
    }
} else if (isset($_GET['delete'])) { //if the user clicked on the delete button

    $subcategoriaId = $_GET['tbsubcategoriaid'];
    $subCategoriaBusiness = new SubCategoriaBusiness();
    $result = $subCategoriaBusiness->eliminarTBSubCategoria($subcategoriaId);

    if ($result == 1) {
        header("location: ../view/subCategoriaView.php?success=delete"); //redirect to the index.php page with a success message
        session_start();
        $_SESSION['msj'] = "Subcategoría eliminada correctamente";
    } else {
        header("location: ../view/subCategoriaView.php?error=dbError"); //redirect to the index.php page with an error message
        session_start();
        $_SESSION['error'] = "Error al eliminar la subcategoría";
    }
} else if (isset($_POST['create'])) { //if the user clicked on the create button

    if (
        isset($_POST['subcategoriaNombreView'])
        && isset($_POST['subcategoriaDescripcionView'])
    ) { //check if the variables have values

        $cadena = explode("-", $_POST['categoria']);


        $subcategoriaNombre = $_POST['subcategoriaNombreView'];
        $categoria = $cadena[0];
        $subcategoriaDescripcion = $_POST['subcategoriaDescripcionView'];
        $subcategoriaActivo = 1;

        if (
            strlen($categoria) &&
            strlen($subcategoriaNombre) > 0
            && strlen($subcategoriaDescripcion) > 0
        ) { //check if the variables have values


            $subCategoria = new SubCategoria(
                0,
                $categoria,
                $subcategoriaNombre,
                $categoria,
                $subcategoriaDescripcion,
                $subcategoriaActivo
            );

            $subCategoriaBusiness = new SubCategoriaBusiness();

            $result = $subCategoriaBusiness->insertarTBSubCategoria($subCategoria);
            if ($result == 1) {
                header("location: ../view/subCategoriaView.php?success=insert"); //redirect to the index.php page with a success message
                session_start();
                $_SESSION['msj'] = "Subcategoría registrada correctamente";
            } else {
                header("location: ../view/subCategoriaView.php?error=dbError"); //redirect to the index.php page with an error message
                session_start();
                $_SESSION['error'] = "Error al registrar la subcategoría";
            }
        } else {
            header("location: ../view/subCategoriaView.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    } else {
        header("location: ../view/subCategoriaView.php?error=error"); //redirect to the index.php page with an error message
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
        $cadena .= '<option value="' . $parte2 . '">' . $sub->getSigla() . ' - ' . $sub->getNombre();
    }
    echo $cadena .= "</option>";
    
} else if (isset($_POST['numCategoria'])) {
    $cadena = explode("-", $_POST['numCategoria']);
    $categoriaId = $cadena[0];
    $subCategoriaBusiness = new SubCategoriaBusiness();
    $subcategorias = $subCategoriaBusiness->getSubcategoriasByCategoriaId($categoriaId);

    $datosArray = array();
    
    foreach ($subcategorias as $current) {
        $arrayActual = array("subcategoriaId"=> $current->getId(), "categoriaId" => $current->getCategoriaId(), "sigla" => $current->getSigla(),
                             "nombre" => $current->getNombre(), "descripcion" => $current->getDescripcion(), "activo" => $current->getActivo());
        $datosArray[] = $arrayActual;
    }
    //var_dump($datosArray);
    $response = json_encode($datosArray);
    echo $response;
/*
    $acumuladorCadenas = "";
    foreach ($subcategorias as $current) {
        $cadena = '<form class="subcategoria" id="subcategoria-' . $current->getCategoriaId() . '" method="post" enctype="multipart/form-data" action="../business/subCategoriaAction.php">';
        $cadena .= '<input type="hidden" name="subcategoriaIdView" value="' . $current->getId() . '">';
        $cadena .= '<tr>';
        $cadena .= '<input type="hidden" name="categoriaId" value="' . $current->getCategoriaId() . '">';
        $cadena .= '<td></td>';
        $cadena .= '<input type="hidden" name="subcategoriaSiglaView" id="subcategoriaSiglaView" pattern="\d+" title="Ingresa solo números" maxlength="4"  value="' . $current->getSigla() . '"/>';
        $cadena .= '<td><input type="text" name="subcategoriaNombreView" id="subcategoriaNombreView" pattern="^[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+$" title="Solo se permiten letras, espacios y tildes"  maxlength="30" value="' . $current->getNombre() . '"/></td>';
        $cadena .= '<td><input type="text" name="subcategoriaDescripcionView" id="subcategoriaDescripcionView" readonly maxlength="1000" value="' . $current->getDescripcion() . '"/></td>';
        $cadena .= '<input type="hidden" name="subcategoriaActivoView" readonly id="subcategoriaActivoView" ' . ($current->getActivo() == 1 ? "checked" : "") . '/>';
        $cadena .= '<td><input type="submit" value="Actualizar" name="update" id="update" /></td>';
        $cadena .= '<td><button type="button" class="btn btn-danger delete_subcategoria" tbsubcategoriaid="' . $current->getId() . '">Eliminar</button></td>';
        $cadena .= '</tr>';
        $cadena .= '</form>';
        $acumuladorCadenas .= $cadena; // Agregamos la cadena generada al acumulador
    }

    echo $acumuladorCadenas; // Imprimimos todas las cadenas generadas*/
}
