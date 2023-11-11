<?php

include '../data/clienteCategoriaData.php';

class ClienteCategoriaBusiness
{

    private $clienteCategoriaData;

    public function __construct()
    {
        $this->clienteCategoriaData = new ClienteCategoriaData();
    }

    public function insertarTBClienteCategoria($clienteCategoria)
    {
        return $this->clienteCategoriaData->insertarTBClienteCategoria($clienteCategoria);
    }

    public function getAllTBClienteCategoria()
    {
        return $this->clienteCategoriaData->getAllTBClienteCategorias();
    }

    public function getClienteCategoriaByClaseId($claseId)
    {
        return $this->clienteCategoriaData->getClienteCategoriaByClaseId($claseId);
    }

    public function getClienteCategoriaByIdCliente($clienteId)
    {
        return $this->clienteCategoriaData->getClienteCategoriaByIdCliente($clienteId);
    }
}
