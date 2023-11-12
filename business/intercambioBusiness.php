<?php
include '../data/intercambioData.php';

class IntercambioBusiness{

    private $intercambioData;

    public function __construct()
    {
        $this->intercambioData = new IntercambioData();
    }

    public function insertarTBIntercambio($intercambio)
    {
        return $this->intercambioData->insertarTBIntercambio($intercambio);
    }

    public function getIntercambiosByCliente($clienteid)
    {
        return $this->intercambioData->getIntercambiosByCliente($clienteid);
    }

    public function getIntercambiosRechazadosByCliente($clienteid)
    {
        return $this->intercambioData->getIntercambiosRechazadosByCliente($clienteid);
    }

    public function getIntercambiosAceptadosByCliente($clienteid)
    {
        return $this->intercambioData->getIntercambiosAceptadosByCliente($clienteid);
    }

    public function aceptarIntercambio($intercambioid)
    {
        return $this->intercambioData->aceptarIntercambio($intercambioid);
    }

    public function rechazarIntercambio($intercambioid)
    {
        return $this->intercambioData->rechazarIntercambio($intercambioid);
    }


}