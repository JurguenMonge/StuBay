<?php

include '../business/articuloBusiness.php';

if(isset($_POST['update'])){

    if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['subcategorias'])) {
       
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $activo = 1;
        $subcategoria = $_POST['subcategorias'];

        if(strlen($id) > 0 && strlen($nombre) > 0 && strlen($subcategoria) > 0){
            $articulo = new Articulo(
                $id,
                $nombre,
                $marca,
                $modelo,
                $serie,
                $activo,
                $subcategoria
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
    if(isset($_POST['articulonombreview']) && isset($_POST['articulomarcaview']) && isset($_POST['articulomodeloview'])
    && isset($_POST['articuloserieview']) && isset($_POST['subcategorias'])){
        
        //Obtener los datos del formulario
        $articuloNombre = $_POST['articulonombreview'];
        $articuloMarca = $_POST['articulomarcaview'];
        $articuloModelo = $_POST['articulomodeloview'];
        $articuloSerie = $_POST['articuloserieview'];
        $articuloActivo = 1;
        $articuloSubCategoriaId = $_POST['subcategorias'];
        //Validar variables
        if(strlen( $articuloNombre ) > 0 && strlen($articuloSubCategoriaId) > 0)
        {
            $articulo = new Articulo(0,$articuloNombre,$articuloMarca,$articuloModelo,$articuloSerie,$articuloActivo,$articuloSubCategoriaId);       
            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->insertarTBArticulo($articulo);

            if ($result == 1) { 
                header("location: ../view/articuloView.php?success=insert"); 
            } else {
                header("location: ../view/articuloView.php?error=dbError");
            }
        } else {
            header("location: ../view/articuloView.php?error=emptyField"); 
        }
    }  else {
        header("location: ../view/articuloView.php?error=error"); 
    }
}else if(isset($_POST['delete'])){
    if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['subcategorias'])) {
       
         $id = $_POST['id'];
         $nombre = $_POST['nombre'];
         $marca = $_POST['marca'];
         $modelo = $_POST['modelo'];
         $serie = $_POST['serie'];
         $activo = 0;
         $subcategoria = $_POST['subcategorias'];
        
        if(strlen($id) > 0 && strlen($nombre) > 0 && strlen($subcategoria) > 0){
            $articulo = new Articulo(
                $id,
                $nombre,
                $marca,
                $modelo,
                $serie,
                $activo,
                $subcategoria
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



