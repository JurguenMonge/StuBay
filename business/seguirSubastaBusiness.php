<?php

include '../data/seguirSubastaData.php';

class SeguirSubastaBusiness
{

    private $seguirSubastaData;

    public function __construct()
    {
        $this->seguirSubastaData = new SeguirSubastaData();
    }

    public function insertTBSeguirSubasta($seguirSubasta)
    {
        return $this->seguirSubastaData->insertTBSeguirSubasta($seguirSubasta);
    }

    public function updateTBSeguirSubasta($seguirSubasta)
    {
        return $this->seguirSubastaData->updateTBSeguirSubasta($seguirSubasta);
    }

    public function deleteTBSeguirSubasta($seguirSubasta)
    {
        return $this->seguirSubastaData->deleteTBSeguirSubasta($seguirSubasta);
    }

    public function getAllTBSeguirSubasta()
    {
        return $this->seguirSubastaData->getAllTBSeguirSubasta();
    }

    // public function getTBSeguirSubastaById($seguirSubastaId)
    // {
    //     return $this->seguirSubastaData->getTBSeguirSubastaById($seguirSubastaId);
    // }

    // public function getTBSeguirSubastaByClienteId($clienteId)
    // {
    //     return $this->seguirSubastaData->getTBSeguirSubastaByClienteId($clienteId);
    // }
}
