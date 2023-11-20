<?php

include '../data/clienteCriterioData.php';

class ClienteCriterioBusiness
{

    private $clienteCriterioData;

    public function __construct()
    {
        $this->clienteCriterioData = new clienteCriterioData();
    }

    public function insertarTBClienteCriterio($clienteCriterio)
    {
        return $this->clienteCriterioData->insertarTBClienteCriterio($clienteCriterio);
    }

    public function getAllTBClienteCriterio()
    {
        return $this->clienteCriterioData->getAllTBClienteCriterios();
    }

    public function getClienteCriterioByCriterioId($criterioId)
    {
        return $this->clienteCriterioData->getClienteCriterioByCriterioId($criterioId);
    }

    public function getClienteCriterioByIdCliente($clienteId)
    {
        return $this->clienteCriterioData->getClienteCriterioByIdCliente($clienteId);
    }
}
