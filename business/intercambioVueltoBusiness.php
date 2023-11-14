<?php
include '../data/intercambioVueltoData.php';

class IntercambioVueltoBusiness
{

    private $intercambioVueltoData;

    public function __construct()
    {
        $this->intercambioVueltoData = new IntercambioVueltoData();
    }

    public function insertarTBIntercambioVuelto($intercambioVuelto)
    {
        return $this->intercambioVueltoData->insertarTBIntercambioVuelto($intercambioVuelto);
    }

    public function getIntercambiosVueltoByCliente($clienteid)
    {
        return $this->intercambioVueltoData->getIntercambiosVueltoByCliente($clienteid);
    }

    public function getIntercambiosVueltoRechazadosByCliente($clienteid)
    {
        return $this->intercambioVueltoData->getIntercambiosVueltoRechazadosByCliente($clienteid);
    }

    public function getIntercambiosVueltoAceptadosByCliente($clienteid)
    {
        return $this->intercambioVueltoData->getIntercambiosVueltoAceptadosByCliente($clienteid);
    }

    public function aceptarIntercambioVuelto($intercambioVueltoId)
    {
        return $this->intercambioVueltoData->aceptarIntercambioVuelto($intercambioVueltoId);
    }

    public function rechazarIntercambioVuelto($intercambioVueltoId)
    {
        return $this->intercambioVueltoData->rechazarIntercambioVuelto($intercambioVueltoId);
    }
}