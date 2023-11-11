<?php

include '../data/clienteClaseData.php';

class ClienteClaseBusiness
{

    private $clienteClaseData;

    public function __construct()
    {
        $this->clienteClaseData = new ClienteClaseData();
    }

    public function insertarTBClienteClase($clienteClase)
    {
        return $this->clienteClaseData->insertarTBClienteClase($clienteClase);
    }

    public function actualizarTBClienteClase($clienteClase)
    {
        return $this->clienteClaseData->actualizarTBClienteClase($clienteClase);
    }

    public function eliminarTBClienteClase($clienteClaseId)
    {
        return $this->clienteClaseData->eliminarTBClienteClase($clienteClaseId);
    }

    public function getAllTBClienteClase()
    {
        return $this->clienteClaseData->getAllTBClienteClase();
    }

    public function getClienteClaseIdByCriterio($criterio)
    {
        return $this->clienteClaseData->getClienteClaseIdByCriterio($criterio);
    }
}
