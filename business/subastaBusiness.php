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

    public function getAllTBSubasta(){
        return $this->subastaData->getAllTBSubasta();
    }
}