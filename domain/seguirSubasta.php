<?php

class SeguirSubasta{

    private $seguirSubastaId;
    private $clienteId;
    private $subastaId;
    private $seguirSubastaActivo;

    function __construct($seguirSubastaId, $clienteId, $subastaId, $seguirSubastaActivo)
    {
        $this->seguirSubastaId = $seguirSubastaId;
        $this->clienteId = $clienteId;
        $this->subastaId = $subastaId;
        $this->seguirSubastaActivo = $seguirSubastaActivo;
    }

    public function getSeguirSubastaId()
    {
        return $this->seguirSubastaId;
    }

    public function setSeguirSubastaId($seguirSubastaId)
    {
        $this->seguirSubastaId = $seguirSubastaId;

        return $this;
    }

    public function getClienteId()
    {
        return $this->clienteId;
    }
    
    public function setClienteId($clienteId)
    {
        $this->clienteId = $clienteId;

        return $this;
    }

    public function getSubastaId()
    {
        return $this->subastaId;
    }

    public function setSubastaId($subastaId)
    {
        $this->subastaId = $subastaId;

        return $this;
    }

    public function getSeguirSubastaActivo()
    {
        return $this->seguirSubastaActivo;
    }

    public function setSubastaSeguidorActivo($seguirSubastaActivo)
    {
        $this->seguirSubastaActivo = $seguirSubastaActivo;

        return $this;
    }
    
}