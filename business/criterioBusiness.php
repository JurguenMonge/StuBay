<?php

include '../data/criterioData.php';

class CriterioBusiness
{

    private $criterioData;

    public function __construct()
    {
        $this->criterioData = new CriterioData();
    }

    public function insertarTBCriterio($criterio)
    {
        return $this->criterioData->insertarTBCriterio($criterio);
    }

    public function actualizarTBCriterio($clienteClase)
    {
        return $this->criterioData->actualizarTBCriterio($clienteClase);
    }

    public function eliminarTBCriterio($criterioId)
    {
        return $this->criterioData->eliminarTBCriterio($criterioId);
    }

    public function getAllTBCriterio()
    {
        return $this->criterioData->getAllTBCriterio();
    }

    public function getCriterioIdByCriterio($criterio)
    {
        return $this->criterioData->getCriterioIdByCriterio($criterio);
    }
}
