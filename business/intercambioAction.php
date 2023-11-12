<?php
include '../business/intercambioBusiness.php';
session_start();  
if(isset($_POST['create'])){
    if(true){
        include '../business/subastaBusiness.php';
        $subasta = $_POST['subastaid'];
        $articulo = $_POST['articulointercambio'];
        $comprador = $_POST['clienteid'];
        $subastaBusiness = new SubastaBusiness();
        $getSubasta = $subastaBusiness->getTBSubastaById($subasta);
        $vendedor = $getSubasta->getSubastaVendedorId();
        $compradorActivo = 1;
        $vendedorActivo = 0;
        if(true){
            $intercambio = new Intercambio(0,$articulo,$vendedor,$comprador,$subasta,$compradorActivo,$vendedorActivo);
            $intercambioBusiness = new IntercambioBusiness();
            $result = $intercambioBusiness->insertarTBIntercambio($intercambio);
            if ($result == 1) {
                header("location: ../view/pujaClienteView.php?success=insert");
                $_SESSION['msj'] = "Intercambio enviado correctamente";
                session_start();
                
            } else {
                header("location: ../view/pujaClienteView.php?error=dbError");
                $_SESSION['error'] = "Error al enviar el intercambio";
                session_start();  
            }
        }else {
            header("location: ../view/pujaClienteView.php?error=emptyField");
        }
    }else { 
        header("location: ../view/pujaClienteView.php?error=error");
    }
}else if(isset($_POST['aceptar'])){
    if(isset($_POST['intercambioid'])){
        $intercambioid = $_POST['intercambioid'];
        if(strlen($intercambioid) > 0){
            $intercambioBusiness = new IntercambioBusiness();
            $result = $intercambioBusiness->aceptarIntercambio($intercambioid);
            if ($result == 1) {
                header("location: ../view/notificacionView.php?success=insert");
                $_SESSION['msj'] = "Intercambio aceptado correctamente";
                session_start();
                
            } else {
                header("location: ../view/notificacionView.php?error=dbError");
                $_SESSION['error'] = "Error al aceptar el intercambio";
                session_start();  
            }
        }else {
            header("location: ../view/notificacionView.php?error=emptyField");
        }
    }else { 
        header("location: ../view/notificacionView.php?error=error");
    }
}else if(isset($_POST['rechazar'])){
    if(isset($_POST['intercambioid'])){
        $intercambioid = $_POST['intercambioid'];
        if(strlen($intercambioid) > 0){
            $intercambioBusiness = new IntercambioBusiness();
            $result = $intercambioBusiness->rechazarIntercambio($intercambioid);
            if ($result == 1) {
                header("location: ../view/notificacionView.php?success=insert");
                $_SESSION['msj'] = "Intercambio rechazado correctamente";
                session_start();
                
            } else {
                header("location: ../view/notificacionView.php?error=dbError");
                $_SESSION['error'] = "Error al rechazar el intercambio";
                session_start();  
            }
        }else {
            header("location: ../view/notificacionView.php?error=emptyField");
        }
    }else { 
        header("location: ../view/notificacionView.php?error=error");
    }
}