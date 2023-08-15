<?php 

include '../data/ArticuloData.php';

class ArticuloBusiness{

    private $articuloData;
    
    function __construct()
    {
        $this->articuloData = new ArticuloData();
    }

    public function insertarTBArticulo($articulo){
        return $this->articuloData->insertarTBArticulo($articulo);
    }

    public function updateTBArticulo($articulo){
        return $this->articuloData->updateTBArticulo($articulo);
    }

    public function deleteTBArticulo($articulo){
        return $this->articuloData->deleteTBArticulo($articulo);
    }

    public function getAllTBArticulo(){
        return $this->articuloData->getAllTBArticulo();
    }

}

?>
