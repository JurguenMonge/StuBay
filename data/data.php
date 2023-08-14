<?php

class Data {

    public $server;
    public $user;
    public $password;
    public $db;
    public $connection;
    public $isActive;

    public function __construct() {
        $hostName = "DESKTOP-ON48ISV";
        
        switch ($hostName) {
            case "DESKTOP-ON48ISV"://mi pc
                
                $this->isActive = false;
                $this->server = "127.0.0.1";
                $this->user = "root";
                $this->password = "";
                $this->db = "dbstubay";
                break;
            case "hostName": //laptop's PC
                $this->isActive = false;
                $this->server = "127.0.0.1";
                $this->user = "root";
                $this->password = "";
                $this->db = "dbstubay";
                break;
            default: //Hosting
                 $this->isActive = false;
      			 $this->server = "x.x.x.x";
      			 $this->user = "xxxxxxx";
      			 $this->password = "xxxxxxx";
      			 $this->db = "xxxxxxxxxx"; 
                break;
        }
    }

}


