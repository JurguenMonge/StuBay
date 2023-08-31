<?php 

class PujaCliente{

    private $pujaClienteId;
    private $articuloId;
    private $clienteId;
    private $pujaClientePrecioActual;

    function __construct($pujaClienteId, $clienteId, $articuloId, $pujaClientePrecioActual) {
        $this->pujaClienteId = $pujaClienteId;
        $this->articuloId = $articuloId;
        $this->clienteId = $clienteId;
        $this->pujaClientePrecioActual = $pujaClientePrecioActual;
    }

    //Getters
    function getPujaClienteId(){
        return $this->pujaClienteId;
    }

    function getClienteId(){
        return $this->clienteId;
    }

    function getArticuloId(){
        return $this->articuloId;
    }


    function getPujaClientePrecioActual(){
        return $this->pujaClientePrecioActual;
    }

    //Setters
    function setPujaClienteId($pujaClienteId){
        $this->pujaClienteId = $pujaClienteId;
    }

    function setClienteId($clienteId){
        $this->clienteId = $clienteId;
    }

    function setArticuloId($articuloId){
        $this->articuloId = $articuloId;
    }


    function setPujaClientePrecioActual($pujaClientePrecioActual){
        $this->pujaClientePrecioActual = $pujaClientePrecioActual;
    }

}

?>