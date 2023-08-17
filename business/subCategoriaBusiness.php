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

    public function eliminarTBSubCategoria($subCategoria)
    {
        return $this->subCategoriaData->eliminarTBSubCategoria($subCategoria);
    }

    public function getAllTBSubCategoria()
    {
        return $this->subCategoriaData->getAllTBSubCategorias();
    }
}
