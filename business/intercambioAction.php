<?php
include '../business/intercambioBusiness.php';
session_start();

if(isset($_POST['create'])){
    if( true ){
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
}