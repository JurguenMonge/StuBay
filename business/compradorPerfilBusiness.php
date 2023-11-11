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

    public function actualizarTBCompradorPerfilById($compradorPerfil)
    {
        return $this->compradorPerfilData->actualizarTBCompradorPerfilById($compradorPerfil);
    }

    public function eliminarTBCompradorPerfil($compradorPerfilId)
    {
        return $this->compradorPerfilData->eliminarTBCompradorPerfil($compradorPerfilId);
    }

    public function getAllTBCompradorPerfil()
    {
        return $this->compradorPerfilData->getAllTBCompradorPerfil();
    }

    public function existeCompradorPerfil($idComprador)
    {
        return $this->compradorPerfilData->existeCompradorPerfil($idComprador);
    }
}
