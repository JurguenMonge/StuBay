<?php
class Devolucion{
    private $tbdevolucionid;
    private $tbdevolucionjustificacion;
    private $tbsubastaid;
    private $tbclienteid;

    function __construct($tbdevolucionid, $tbdevolucionjustificacion, $tbsubastaid, $tbclienteid)
    {
        $this->tbdevolucionid = $tbdevolucionid;
        $this->tbdevolucionjustificacion = $tbdevolucionjustificacion;
        $this->tbsubastaid = $tbsubastaid;
        $this->tbclienteid = $tbclienteid;
    }

    /**
     * Get the value of tbdevolucionid
     */ 
    public function getTbdevolucionid()
    {
        return $this->tbdevolucionid;
    }

    /**
     * Set the value of tbdevolucionid
     *
     * @return  self
     */ 
    public function setTbdevolucionid($tbdevolucionid)
    {
        $this->tbdevolucionid = $tbdevolucionid;

        return $this;
    }

    /**
     * Get the value of tbdevolucionjustificacion
     */ 
    public function getTbdevolucionjustificacion()
    {
        return $this->tbdevolucionjustificacion;
    }

    /**
     * Set the value of tbdevolucionjustificacion
     *
     * @return  self
     */ 
    public function setTbdevolucionjustificacion($tbdevolucionjustificacion)
    {
        $this->tbdevolucionjustificacion = $tbdevolucionjustificacion;

        return $this;
    }

    /**
     * Get the value of tbsubastaid
     */ 
    public function getTbsubastaid()
    {
        return $this->tbsubastaid;
    }

    /**
     * Set the value of tbsubastaid
     *
     * @return  self
     */ 
    public function setTbsubastaid($tbsubastaid)
    {
        $this->tbsubastaid = $tbsubastaid;

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