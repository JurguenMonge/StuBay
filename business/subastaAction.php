<?php

include '../business/subastaBusiness.php';

if (isset($_POST['create'])) {
    //Validar que lleguen los datos
    if (
        isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView'])
        && isset($_POST['subastaPrecioInicialView'])
    ) {

        //Obtener datos
        $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
        $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
        $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
        $subastaEstadoArticulo = $_POST['subastaEstadoArticuloView'];
        $subastaDiasUsoArticulo = isset($_POST['mesesDeUso']) ? (int)$_POST['mesesDeUso'] : 0;
        $subastaActivo = 1;
        $subastaArticuloId = $_POST['subastaArticuloView'];
        $precioSinFormato = str_replace('₡', '', $subastaPrecioInicial); // Elimina el símbolo de colón
        $precioSinFormato = str_replace(',', '', $precioSinFormato); // Elimina las comas
        $precioSinFormato = str_replace('.', '', $precioSinFormato); // Elimina los puntos
        $precioSinFormato = (int)$precioSinFormato; // Convierte a un valor entero

        //Validar que contengan datos
        if (
            strlen($subastaFechaHoraInicio) > 0 && strlen($subastaFechaHoraFinal) > 0 && strlen($subastaPrecioInicial) > 0
            && strlen($subastaArticuloId) > 0
        ) {
            $subasta = new Subasta(
                0,
                $subastaFechaHoraInicio,
                $subastaFechaHoraFinal,
                $precioSinFormato,
                $subastaEstadoArticulo,
                $subastaDiasUsoArticulo,
                $subastaActivo,
                $subastaArticuloId
            );
            $subastaBusiness = new SubastaBusiness();
            $result = $subastaBusiness->insertarTBSubasta($subasta);
            if ($result == 1) {
                header("location: ../view/subastaView.php?success=insert");
            } else {
                header("location: ../view/subastaView.php?error=dbError");
            }
        } else {
            header("location: ../index.php?error=emptyField");
        }
    } else {
        header("location: ../index.php?error=error");
    }
} else if ($_POST['delete']) {
    if (
        isset($_POST['subastaIdView']) && isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView']) &&
        isset($_POST['subastaPrecioInicialView']) && isset($_POST['subastaActivoView'])
    ) {
        $subastaId = $_POST['subastaIdView'];
        $subastaArticuloId = $_POST['subastaArticuloView'];
        $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
        $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
        $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
        $subastaEstadoArticulo = $_POST['subastaEstadoArticuloView'];
        $subastaDiasUsoArticulo = isset($_POST['mesesDeUso']) ? (int)$_POST['mesesDeUso'] : 0;
        $subastaActivo = 0;
        $precioSinFormato = str_replace('₡', '', $subastaPrecioInicial);
        $precioSinFormato = str_replace(',', '', $precioSinFormato);
        $precioSinFormato = str_replace('.', '', $precioSinFormato);
        $precioSinFormato = (int)$precioSinFormato;
        if (
            strlen($subastaId) > 0 && strlen($subastaArticuloId) > 0 && strlen($subastaFechaHoraInicio) > 0 && strlen($subastaFechaHoraFinal) > 0
            && strlen($subastaPrecioInicial) > 0
        ) {
            $subasta = new Subasta(
                $subastaId,
                $subastaFechaHoraInicio,
                $subastaFechaHoraFinal,
                $precioSinFormato,
                $subastaEstadoArticulo,
                $subastaDiasUsoArticulo,
                $subastaActivo,
                $subastaArticuloId
            );
            $subastaBusiness = new SubastaBusiness();
            $result = $subastaBusiness->deleteTBSubasta($subasta);
            if ($result == 1) {
                header("location: ../view/subastaView.php?success=updated");
            } else {
                header("location: ../view/subastaView.php?error=dbError");
            }
        } else {
            header("location: ../view/subastaView.php?error=emptyField");
        }
    }
} else if ($_POST['update']) {
    if (
        isset($_POST['subastaIdView']) && isset($_POST['subastaArticuloView']) && isset($_POST['subastaFechaHoraInicioView']) && isset($_POST['subastaFechaHoraFinalView']) &&
        isset($_POST['subastaPrecioInicialView']) && isset($_POST['subastaActivoView'])
    ) {
        $subastaId = $_POST['subastaIdView'];
        $subastaArticuloId = $_POST['subastaArticuloView'];
        $subastaFechaHoraInicio = $_POST['subastaFechaHoraInicioView'];
        $subastaFechaHoraFinal = $_POST['subastaFechaHoraFinalView'];
        $subastaEstadoArticulo = $_POST['subastaEstadoArticuloView'];
        $subastaDiasUsoArticulo = 0;
        $subastaPrecioInicial = $_POST['subastaPrecioInicialView'];
        $precioSinFormato = str_replace('₡', '', $subastaPrecioInicial); // Elimina el símbolo de colón
        $precioSinFormato = str_replace(',', '', $precioSinFormato); // Elimina las comas
        $precioSinFormato = str_replace('.', '', $precioSinFormato); // Elimina los puntos
        $precioSinFormato = (int)$precioSinFormato; // Convierte a un valor entero
        $subastaActivo = 1;

        if (
            strlen($subastaId) > 0 && strlen($subastaArticuloId) > 0 && strlen($subastaFechaHoraInicio) > 0 && strlen($subastaFechaHoraFinal) > 0
            && strlen($subastaPrecioInicial) > 0
        ) {
            $subasta = new Subasta(
                $subastaId,
                $subastaFechaHoraInicio,
                $subastaFechaHoraFinal,
                $precioSinFormato,
                $subastaEstadoArticulo,
                $subastaDiasUsoArticulo,
                $subastaActivo,
                $subastaArticuloId
            );
            $subastaBusiness = new SubastaBusiness();
            $result = $subastaBusiness->updateTBSubasta($subasta);
            if ($result == 1) {
                header("location: ../view/subastaView.php?success=updated");
            } else {
                header("location: ../view/subastaView.php?error=dbError");
            }
        }
    }
} else if ($_POST['valor']) {
    $cadena = explode("-", $_POST['valor']);
    $subastaId = $cadena[0];
    $business = new SubastaBusiness();
    $subasta = $business->getTBSubastaById($subastaId);
    $precioInicialFormateado = '₡' . number_format($subasta->getSubastaPrecioInicial() , 2, '.', ',');
    $cadena = '<input required value="' . $precioInicialFormateado . '" type="text" name="subastaIdView" id="subastaIdView" maxlength="1000" readonly/>';

    echo $cadena;
}
