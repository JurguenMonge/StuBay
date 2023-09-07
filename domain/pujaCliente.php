<?php 

class PujaCliente{

    private $pujaClienteId;
    private $articuloId;
    private $clienteId;
    private $pujaClienteFecha;
    private $pujaClienteOferta;
    private $pujaClienteEnvio;

    function __construct($pujaClienteId, $clienteId, $articuloId, $pujaClienteFecha, $pujaClienteOferta, $pujaClienteEnvio) {
        $this->pujaClienteId = $pujaClienteId;
        $this->articuloId = $articuloId;
        $this->clienteId = $clienteId;
        $this->pujaClienteFecha = $pujaClienteFecha;
        $this->pujaClienteOferta = $pujaClienteOferta;
        $this->pujaClienteEnvio = $pujaClienteEnvio;
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

    function getPujaClienteFecha(){
        return $this->pujaClienteFecha;
    }

    function getPujaClienteOferta(){
        return $this->pujaClienteOferta;
    }

    function getPujaClienteEnvio(){
        return $this->pujaClienteEnvio;
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

    function setPujaClienteFecha($pujaClienteFecha){
        $this->pujaClienteFecha = $pujaClienteFecha;
    }

    function setPujaClienteOferta($pujaClienteOferta){
        $this->pujaClienteOferta = $pujaClienteOferta;
    }

    function setPujaClienteEnvio($pujaClienteEnvio){
        $this->pujaClienteEnvio = $pujaClienteEnvio;
    }

}

?>