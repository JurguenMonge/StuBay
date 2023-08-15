<?php

include '../business/articuloBusiness.php';

if(isset($_POST['update'])){

    if (isset($_POST['id']) && isset($_POST['nombre']) && isset($_POST['categoria']) && isset($_POST['subcategoria']) && isset($_POST['marca'])
    && isset($_POST['modelo']) && isset($_POST['serie'])) {
       
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $subcategoria = $_POST['subcategoria'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $activo = isset($_POST['activo']) ? 1 : 0;

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
    if(isset($_POST['nombre']) && isset($_POST['categoria']) && isset($_POST['subcategoria']) 
        && isset($_POST['marca']) && isset($_POST['modelo']) && isset($_POST['serie'])){
        
        //Obtener los datos del formulario
        $nombre = $_POST['nombre'];
        $categoria = $_POST['categoria'];
        $subcategoria = $_POST['subcategoria'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $serie = $_POST['serie'];
        $activo = 1;

        //Validar variables
        if(strlen($nombre) > 0 && strlen($marca) > 0 && strlen($modelo) > 0 && strlen($serie) > 0)
        {
            $articulo = new Articulo(0,$nombre,$categoria,$subcategoria,$marca,$modelo,$serie,$activo);
            
            $articuloBusiness = new ArticuloBusiness();
            $result = $articuloBusiness->insertarTBArticulo($articulo);

            if ($result == 1) { //if the method insertTBStudent was executed succesfully it will return 1
                header("location: ../index.php?success=insert"); //redirect to the index.php page with a success message
            } else {
                header("location: ../index.php?error=dbError"); //redirect to the index.php page with an error message
            }
        } else {
            header("location: ../index.php?error=emptyField"); //redirect to the index.php page with an error message
        }
    }  else {
        header("location: ../index.php?error=error"); //redirect to the index.php page with an error message
    }
}

