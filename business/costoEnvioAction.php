<?php

include '../business/costoEnvioBusiness.php';

if(isset($_POST['create'])){
    if(isset($_POST['clienteIdView']) && isset($_POST['costoEnvioKMView'])){
        $costoPorKM = $_POST['costoEnvioKMView'];
        $tbclienteid = $_POST['clienteIdView'];
        $costoEnvioEstado = 1;
        $precioSinFormato = str_replace('₡', '', $costoPorKM);
        $precioSinFormato = str_replace(',', '', $precioSinFormato); 
        $precioSinFormato = str_replace('.', '', $precioSinFormato); 
        $precioSinFormato = (int)$precioSinFormato; 
        if(strlen($precioSinFormato)>0 && strlen($tbclienteid)>0){

            $costoEnvio = new CostoEnvio(0,$precioSinFormato,$tbclienteid,$costoEnvioEstado);
            $costoEnvioBusiness = new CostoEnvioBusiness();
            $result = $costoEnvioBusiness->insertarTBCostoEnvio($costoEnvio);

            if($result == 1){
                header("location: ../view/costoEnvioView.php?success=create");
            } else {        
                header("location: ../view/costoEnvioView.php?error=dbError");
            }
        }else{
            header("location: ../view/costoEnvioView.php?error=emptyField");
        }
    }else{
        header("location: ../view/costoEnvioView.php?error=error");
    }
}else if(isset($_POST['update'])){

    if(isset($_POST['id']) && isset($_POST['clienteIdView']) && isset($_POST['costoEnvioKMView']) && isset($_POST['costoEnvioEstadoView'])){

        $costoEnvioId = $_POST['id'];
        $costoPorKM = $_POST['costoEnvioKMView'];
        $tbclienteid = $_POST['clienteIdView'];
        $precioSinFormato = str_replace('₡', '', $costoPorKM);
        $precioSinFormato = str_replace(',', '', $precioSinFormato); 
        $precioSinFormato = str_replace('.', '', $precioSinFormato); 
        $precioSinFormato = (int)$precioSinFormato; 
        $costoEnvioEstado = isset($_POST['costoEnvioEstadoView']) ? 1 : 0;

        if (strlen($precioSinFormato)>0 && strlen($tbclienteid)>0) {
            $costoEnvio = new CostoEnvio($costoEnvioId,$precioSinFormato,$tbclienteid,$costoEnvioEstado); 
            $costoEnvioBusiness = new CostoEnvioBusiness();
            $result = $costoEnvioBusiness->updateTBCostoEnvio($costoEnvio);

            if ($result == 1) {
                header("location: ../view/costoEnvioView.php?success=updated");
            } else {
                header("location: ../view/costoEnvioView.php?error=dbError");
            }

        } else {
            header("location: ../view/costoEnvioView.php?error=emptyField");
        }
    }
}else if(isset($_POST['delete'])){
    if(isset($_POST['id']) && isset($_POST['clienteIdView']) && isset($_POST['costoEnvioKMView']) && isset($_POST['costoEnvioEstadoView'])){

        $costoEnvioId = $_POST['id'];
        $costoPorKM = $_POST['costoEnvioKMView'];
        $tbclienteid = $_POST['clienteIdView'];
        $precioSinFormato = str_replace('₡', '', $costoPorKM);
        $precioSinFormato = str_replace(',', '', $precioSinFormato); 
        $precioSinFormato = str_replace('.', '', $precioSinFormato); 
        $precioSinFormato = (int)$precioSinFormato; 
        $costoEnvioEstado = 0;

        if (strlen($precioSinFormato)>0 && strlen($tbclienteid)>0) {

            $costoEnvio = new CostoEnvio($costoEnvioId,$precioSinFormato,$tbclienteid,$costoEnvioEstado); 
            $costoEnvioBusiness = new CostoEnvioBusiness();
            $result = $costoEnvioBusiness->deleteTBCostoEnvio($costoEnvio);

            if ($result == 1) {
                header("location: ../view/costoEnvioView.php?success=delete");
            } else {
                header("location: ../view/costoEnvioView.php?error=dbError");
            }
        }else {
            header("location: ../view/costoEnvioView.php?error=emptyField");
        }

    }
}
