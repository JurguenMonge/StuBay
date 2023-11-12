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


}