<?php

include '../data/subastaData.php';

class SubastaBusiness {

    private $subastaData;

    function __construct()
    {
        $this->subastaData = new SubastaData();
    }

    public function insertarTBSubasta($subasta){
        return $this->subastaData->insertarTBSubasta($subasta);
    }

    public function deleteTBSubasta($subasta){
        return $this->subastaData->deleteTBSubasta($subasta);
    }

    public function updateTBSubasta($subasta){
        return $this->subastaData->updateTBSubasta($subasta);
    }

    public function getAllTBSubasta(){
        return $this->subastaData->getAllTBSubasta();
    }
}