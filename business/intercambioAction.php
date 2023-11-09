<?php
include '../business/intercambioBusiness.php';

if(isset($_POST['intercambio'])){
    if( isset($_POST['articuloIdView']) && isset($_POST['articulointercambio']) && isset($_POST['clienteIdView']) ){
        $subasta = $_POST['articuloIdView'];
        $articulo = $_POST['articulointercambio'];
        $comprador = $_POST['clienteIdView'];
        $subastaBusiness = new SubastaBusiness();
        $getSubasta = $subastaBusiness->getTBSubastaById($subasta);
        $vendedor = $getSubasta->getSubastaVendedorId();
        $compradorActivo = 1;
        $vendedorActivo = 0;

        if(strlen($subasta) > 0 && strlen($articulo) > 0 && strlen($comprador) && strlen($vendedor)>0 && strlen($compradorActivo) > 0){
            $intercambio = new Intercambio(0,$articulo,$vendedor,$comprador,$subasta,$compradorActivo,$vendedorActivo);
            $intercambioBusiness = new IntercambioBusiness();
            $result = $intercambioBusiness->intsertarTBIntercambio($intercambio);
            if ($result == 1) {
                header("location: ../view/pujaClienteView.php?success=insert");
                session_start();
                $_SESSION['msj'] = "Intercambio enviado correctamente";
            } else {
                header("location: ../view/pujaClienteView.php?error=dbError");
                session_start();
                $_SESSION['error'] = "Error al enviar el intercambio";
            }
        }else {
            header("location: ../view/pujaClienteView.php?error=emptyField");
        }
    }else {
        header("location: ../view/pujaClienteView.php?error=error");
    }
}