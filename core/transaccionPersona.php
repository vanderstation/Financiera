<?php

class transaccionPersona {

    private $conn;
    private $connection;

    function __construct() {

        require_once dirname(__FILE__) . '/mainModel.php';
        $this->conn = new mainModel();
        $this->connection = $this->conn->getConnection();
    }

    public function tipoDocumento() {

        $query = "SELECT id,cedula FROM documento  ORDER BY cedula";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }
    
    public function tipoPersona() {

        $query = "SELECT id,descripcion_tipo_persona FROM tipo_persona  ORDER BY id";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }

    public function tipoNumero() {
        $query = "SELECT id, descripcion FROM tipo_telefono  ORDER BY descripcion";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }

    public function tipoDireccion() {
        $query = "SELECT id, descripcion_direccion FROM tipo_direccion  ORDER BY descripcion_direccion";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }

    public function tipoPuesto() {
        $query = "SELECT id, tipo_puesto FROM puesto  ORDER BY tipo_puesto";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }

    public function tipoEmpleado() {
        $query = "SELECT id, tipo_empleado FROM tipo_empleado  ORDER BY tipo_empleado";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }

    public function tipoPrivilegio() {
        $query = "SELECT id, privilegio FROM permiso_usuarios  ORDER BY privilegio";
        $stmt = $this->connection->query($query);
        $stmt->execute();
        return $stmt;
    }

}
