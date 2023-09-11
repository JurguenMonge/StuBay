<?php 

include '../data/costoEnvioData.php';

class CostoEnvioBusiness{

    private $costoEnvioData;
    
    function __construct(){
        $this->costoEnvioData = new CostoEnvioData();
    }

    public function insertarTBCostoEnvio($costoEnvio){
        return $this->costoEnvioData->insertarTBCostoEnvio($costoEnvio);
    }

    public function updateTBCostoEnvio($costoEnvio){
        return $this->costoEnvioData->updateTBCostoEnvio($costoEnvio);
    }

    public function deleteTBCostoEnvio($costoEnvio){
        return $this->costoEnvioData->deleteTBCostoEnvio($costoEnvio);
    }

    public function getAllTBCostoEnvio(){
        return $this->costoEnvioData->getAllTBCostoEnvio();
    }

    public function getTBCostoEnvioByIdCliente($idCliente){
        return $this->costoEnvioData->getTBCostoEnvioByCliente($idCliente);
    }

}