<?php

class conexion {

    public $conn;

    public function __construct() {
        require_once dirname(__FILE__) . '/credenciales.php';
    }

    public function getConnection() {

        $this->conn = null;

        try {
            $this->conn = new PDO("pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
        } catch (Exception $exc) {
            echo $exc->getTraceAsString();
        }
        
        return $this->conn;
    }

}
