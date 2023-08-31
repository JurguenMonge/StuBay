<?php

include '../data/pujaClienteData.php';

class PujaClienteBusiness
{

    private $pujaClienteData;

    public function __construct()
    {
        $this->pujaClienteData = new PujaClienteData();
    }

    public function insertarTBPujaCliente($pujaCliente)
    {
        return $this->pujaClienteData->insertarTBPujaCliente($pujaCliente);
    }

    public function actualizarTBPujaCliente($pujaCliente)
    {
        return $this->pujaClienteData->actualizarTBPujaCliente($pujaCliente);
    }

    public function eliminarTBPujaCliente($pujaCliente)
    {
        return $this->pujaClienteData->eliminarTBPujaCliente($pujaCliente);
    }

    public function getAllTBPujaCliente()
    {
        return $this->pujaClienteData->getAllTBPujaCliente();
    }
}
