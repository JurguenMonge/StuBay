<?php

include '../data/calificacionCompradorData.php';

class CalificacionCompradorBusiness{

    private $calificacionCompradorData;

    public function __construct(){
        $this->calificacionCompradorData = new CalificacionCompradorData();
    }
}