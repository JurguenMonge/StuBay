<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


include '../data/subCategoriaData.php';

class SubCategoriaBusiness
{

    private $subCategoriaData;

    public function __construct()
    {
        $this->subCategoriaData = new SubCategoriaData();
    }

    public function insertarTBSubCategoria($subCategoria)
    {
        return $this->subCategoriaData->insertarTBSubCategoria($subCategoria);
    }

    public function actualizarTBSubCategoria($subCategoria)
    {
        return $this->subCategoriaData->actualizarTBSubCategoria($subCategoria);
    }

    public function eliminarTBSubCategoria($subCategoriaId)
    {
        return $this->subCategoriaData->eliminarTBSubCategoria($subCategoriaId);
    }

    public function getTBSubCategoriaById($id){
        return $this->subCategoriaData->getTBSubCategoriaById($id);
    }

    public function getAllTBSubCategoria()
    {
        return $this->subCategoriaData->getAllTBSubCategorias();
    }

    public function getSubcategoriasByCategoriaId($categoriaId){
        return $this->subCategoriaData->getSubcategoriasByCategoriaId($categoriaId);
    }
}
