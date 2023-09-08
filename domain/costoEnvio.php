<?php
class CostoEnvio{

    private $costoEnvioId;
    private $costoPorKM;
    private $tbclienteid;

    function __construct($costoEnvioId, $costoPorKM, $tbclienteid)
    {
        $this->costoEnvioId = $costoEnvioId;
        $this->costoPorKM = $costoPorKM;
        $this->tbclienteid = $tbclienteid;
    }

    /**
     * Get the value of costoEnvioId
     */ 
    public function getCostoEnvioId()
    {
        return $this->costoEnvioId;
    }

    /**
     * Set the value of costoEnvioId
     *
     * @return  self
     */ 
    public function setCostoEnvioId($costoEnvioId)
    {
        $this->costoEnvioId = $costoEnvioId;

        return $this;
    }

    /**
     * Get the value of costoPorKM
     */ 
    public function getCostoPorKM()
    {
        return $this->costoPorKM;
    }

    /**
     * Set the value of costoPorKM
     *
     * @return  self
     */ 
    public function setCostoPorKM($costoPorKM)
    {
        $this->costoPorKM = $costoPorKM;

        return $this;
    }

    /**
     * Get the value of tbclienteid
     */ 
    public function getTbclienteid()
    {
        return $this->tbclienteid;
    }

    /**
     * Set the value of tbclienteid
     *
     * @return  self
     */ 
    public function setTbclienteid($tbclienteid)
    {
        $this->tbclienteid = $tbclienteid;

        return $this;
    }
}

?>