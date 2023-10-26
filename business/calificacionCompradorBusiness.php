<?php

include '../data/calificacionCompradorData.php';

class CalificacionCompradorBusiness
{
    private $calificacionCompradorData;

    public function __construct()
    {
        $this->calificacionCompradorData = new CalificacionCompradorData();
    }

    public function insertTBCalificacionComprador($calificacionComprador)
    {
        return $this->calificacionCompradorData->insertTBCalificacionComprador($calificacionComprador);
    }

    public function updateTBCalificacionComprador($calificacionComprador)
    {
        return $this->calificacionCompradorData->updateTBCalificacionComprador($calificacionComprador);
    }

    public function deleteTBCalificacionComprador($calificacionCompradorId)
    {
        return $this->calificacionCompradorData->deleteTBCalificacionComprador($calificacionCompradorId);
    }

    public function getTBAllCalificacionComprador()
    {
        return $this->calificacionCompradorData->getTBAllCalificacionComprador();
    }

    public function getCalificacionCompradorByClienteId($calificacionCompradorId)
    {
        return $this->calificacionCompradorData->getCalificacionCompradorByClienteId($calificacionCompradorId);
    }
}