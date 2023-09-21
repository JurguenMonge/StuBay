<?php

include '../data/categoriaData.php';

class CategoriaBusiness
{

    private $categoriaData;

    public function __construct()
    {
        $this->categoriaData = new CategoriaData();
    }

    public function insertarTBCategoria($categoria)
    {
        return $this->categoriaData->insertarTBCategoria($categoria);
    }

    public function actualizarTBCategoria($categoria)
    {
        return $this->categoriaData->actualizarTBCategoria($categoria);
    }

    public function eliminarTBCategoria($categoriaId)
    {
        return $this->categoriaData->eliminarTBCategoria($categoriaId);
    }

    public function getAllTBCategoria()
    {
        return $this->categoriaData->getAllTBCategorias();
    }
}
