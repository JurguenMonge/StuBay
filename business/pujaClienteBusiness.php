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

    public function getTBPujaClienteById($id){
        return $this->pujaClienteData->getTBPujaClienteById($id);
    }

    public function getTBPujaClienteByArticulo($id){
        return $this->pujaClienteData->getTBPujaClienteByArticulo($id);
    }

    public function getTBPujaClienteGanador($id){
        return $this->pujaClienteData->getTBPujaClienteGanador($id);
    }

    public function getTBPujaClienteGanadorById($id){
        return $this->pujaClienteData->getTBPujaClienteGanadorById($id);
    }

    public function getPujaClienteGanador($articuloId){
        return $this->pujaClienteData->getPujaClienteGanador($articuloId);
    }

    public function obtenerInformacionCompras($clienteId){
        return $this->pujaClienteData->obtenerInformacionCompras($clienteId);
    }

    public function calcularDistanciaClienteVendedor($latCliente, $lonCliente, $latVendedor, $lonVendedor) {
        // Radio de la Tierra en kilómetros
        $radioTierra = 6371;
    
        // Convierte las coordenadas de grados a radianes
        $latCliente = deg2rad($latCliente);
        $lonCliente = deg2rad($lonCliente);
        $latVendedor = deg2rad($latVendedor);
        $lonVendedor = deg2rad($lonVendedor);
    
        // Diferencia de latitud y longitud
        $dLat = $latVendedor - $latCliente;
        $dLon = $lonVendedor - $lonCliente;
    
        // Fórmula de Haversine
        $a = sin($dLat / 2) * sin($dLat / 2) + cos($latCliente) * cos($latVendedor) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        
        // Calcula la distancia
        $distancia = $radioTierra * $c;
    
        return $distancia;
    }

    public function getPrecioMaximoByArticuloId($articuloId){
        return $this->pujaClienteData->getPrecioMaximoByArticuloId($articuloId);
    }

}
