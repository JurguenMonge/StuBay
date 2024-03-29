<?php 

include '../data/articuloData.php';

class ArticuloBusiness{

    private $articuloData;
    
    function __construct(){
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

    public function getArticulosBySubcategoriaId($subcategoriaId){
        return $this->articuloData->getArticulosBySubcategoriaId($subcategoriaId);
    }

    public function getArticuloByClienteId($clienteId){
        return $this->articuloData->getArticuloByClienteId($clienteId);
    }

    public function getArticuloByClienteIdObject($clienteId){
        return $this->articuloData->getArticuloByClienteIdObject($clienteId);
    }

    public function getTBArticuloName($nombre){
        return $this->articuloData->buscarNombres($nombre);
    }

    public function getArticuloById($id){
        return $this->articuloData->getArticuloById($id);
    }

    public function filtrar($articulo){
        return $this->articuloData->filtrar($articulo);
    }
}