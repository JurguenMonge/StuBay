<?php

include '../data/compradorPerfilData.php';

class CompradorPerfilBusiness
{

    private $compradorPerfilData;

    public function __construct()
    {
        $this->compradorPerfilData = new CompradorPerfilData();
    }

    public function insertarTBCompradorPerfil($compradorPerfil)
    {
        return $this->compradorPerfilData->insertarTBCompradorPerfil($compradorPerfil);
    }

    public function actualizarTBCompradorPerfil($compradorPerfil)
    {
        return $this->compradorPerfilData->actualizarTBCompradorPerfil($compradorPerfil);
    }

    public function eliminarTBCompradorPerfil($compradorPerfilId)
    {
        return $this->compradorPerfilData->eliminarTBCompradorPerfil($compradorPerfilId);
    }

    public function getAllTBCompradorPerfil()
    {
        return $this->compradorPerfilData->getAllTBCompradorPerfil();
    }
}
