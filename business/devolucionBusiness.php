<?php
include '../data/devolucionData.php';

class DevolucionBusiness{

    private $devolucionData;

    public function __construct()
    {
        $this->devolucionData = new DevolucionData();
    }

    public function intsertarTBIntercambio($devolucion)
    {
        return $this->devolucionData->insertarTBDevolucion($devolucion);
    }

    public function getCantidadDevolucionesPorClienteYSubasta($idCliente, $subastaId)
    {
        return $this->devolucionData->getCantidadDevolucionesPorClienteYSubasta($idCliente, $subastaId);
    }

}