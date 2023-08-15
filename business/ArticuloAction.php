<?php

include '../business/ArticuloBusiness.php';

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

        if(strlen($id) > 0 && )
    }
}

?>