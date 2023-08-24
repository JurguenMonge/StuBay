<?php

include '../business/articuloBusiness.php';

if(isset($_POST['update'])){

    if (isset($_POST['articuloidview']) && isset($_POST['articulonombreview']) && isset($_POST['articulosubcategoriaview']) && isset($_POST['articulomarcaview'])
    && isset($_POST['articulomodeloview']) && isset($_POST['articuloserieview'])) {
       
        $articuloId = $_POST['articuloidview'];
        $articuloNombre = $_POST['articulonombreview'];
        $articuloMarca = $_POST['articulomarcaview'];
        $articuloModelo = $_POST['articulomodeloview'];
        $articuloSerie = $_POST['articuloserieview'];
        $articuloActivo = isset($_POST['articuloactivoview']) ? 1 : 0;
        $articuloSubCategoria = $_POST['articulosubcategoriaview'];

        if(strlen($id) > 0 && strlen($nombre) > 0 && strlen($categoria) > 0 && strlen($subcategoria) > 0 && strlen($marca) > 0 &&
            strlen($modelo) > 0 && strlen($serie) > 0
        ){
            $articulo = new Articulo(
                $id,
                $nombre,
                $categoria,
                $subcategoria,
                $marca,
                $modelo,
                $serie,
                $activo
            );

            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->updateTBArticulo($articulo);

            if($result == 1){
                header("location: ../view/articuloView.php?success=updated");
            } else {        
                header("location: ../view/articuloView.php?error=dbError");
            }
        }else{
            header("location: ../view/articuloView.php?error=emptyField");
        }
    }else {
        header("location: ../view/articuloView.php?error=error");
    }
} else if(isset($_POST['create'])){
    //Validaciones
    if(isset($_POST['articulonombreview']) && isset($_POST['articulosubcategoriaview']) 
        && isset($_POST['articulomarcaview']) && isset($_POST['articulomodeloview']) && isset($_POST['articuloserieview'])){
        
        //Obtener los datos del formulario
        $articuloNombre = $_POST['articulonombreview'];
        $articuloMarca = $_POST['articulomarcaview'];
        $articuloModelo = $_POST['articulomodeloview'];
        $articuloSerie = $_POST['articuloserieview'];
        $articuloSubCategoriaId = $_POST['articulosubcategoriaview'];
        $articuloActivo = 1;

        //Validar variables
        if(strlen($articuloNombre) > 0 && strlen($articuloMarca) > 0 && strlen($articuloModelo) > 0 && strlen($articuloSerie) > 0)
        {
            $articulo = new Articulo(0,$articuloNombre,$articuloMarca,$articuloModelo,$articuloSerie,$articuloActivo,$articuloSubCategoriaId);
            
            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->insertarTBArticulo($articulo);

            if ($result == 1) { 
                header("location: ../index.php?success=insert"); 
            } else {
                header("location: ../index.php?error=dbError"); 
            }
        } else {
            header("location: ../index.php?error=emptyField"); 
        }
    }  else {
        header("location: ../index.php?error=error"); 
    }
}else if(isset($_POST['delete'])){

    if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['articulocategoria']) && isset($_POST['subcategoria']) && isset($_POST['marca'])
    && isset($_POST['modelo']) && isset($_POST['serie'])) {
       
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['articulocategoria'];
        $subcategoria = $_POST['subcategoria'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $activo = 0;

        if(strlen($id) > 0 && strlen($nombre) > 0 && strlen($categoria) > 0 && strlen($subcategoria) > 0 && strlen($marca) > 0 &&
            strlen($modelo) > 0 && strlen($serie) > 0
        ){
            $articulo = new Articulo(
                $id,
                $nombre,
                $categoria,
                $subcategoria,
                $marca,
                $modelo,
                $serie,
                $activo
            );

            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->deleteTBArticulo($articulo);

            if($result == 1){
                header("location: ../view/articuloView.php?success=delete");
            } else {        
                header("location: ../view/articuloView.php?error=dbError");
            }
        }else{
            header("location: ../view/articuloView.php?error=emptyField");
        }
    }else {
        header("location: ../view/articuloView.php?error=error");
    }
}  else if(isset($_GET['termino'])){
    $termino = $_GET['termino'];
    $articuloBusiness = new ArticuloBusiness();
    $nombres = $articuloBusiness->getTBArticuloName($termino); 
    
    if ($nombres) { 
        echo json_encode($nombres);
    } else {
        echo json_encode(array("error" => "Error en la consulta"));
    }
}



