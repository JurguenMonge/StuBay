<?php 

include '../data/articuloData.php';

class ArticuloBusiness{

    private $articuloData;
    
    function __construct()
    {
        $this->articuloData = new ArticuloData();
    }

    public function insertarTBArticulo($articulo){
        return $this->articuloData->insertarTBArticulo($articulo);
    }
}

?>
