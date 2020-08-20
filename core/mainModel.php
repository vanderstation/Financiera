<?php

include_once dirname(__FILE__) . '/Credenciales.php';

class mainModel {

    private $conn;

    function __construct() {
        include_once dirname(__FILE__) . '/Credenciales.php';
    }

    public function getConnection() {
        
        try {
            $this->conn = new PDO("pgsql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
            return $this->conn;
        } catch (PDOException $exception) {
            return $exception->getMessage();
        }
    }

    protected function consultaSimple($query) {

        $stmt = self::getConnection()->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    protected function llamarDocumentoCliente() {

        $sql = ("SELECT tipo_persona_persona.id_tipo_persona,persona.nombre, persona_documento.documento FROM persona 
                INNER JOIN persona_documento ON persona.id = persona_documento.id_persona_documento
                INNER JOIN  tipo_persona_persona ON persona.id = tipo_persona_persona.id_persona
                INNER JOIN tipo_persona  on tipo_persona.id = tipo_persona_persona.id_tipo_persona
                WHERE tipo_persona_persona.id_tipo_persona='2'");

        $stmt = mainModel::consultaSimple($sql);
        return $stmt;
    }

    public function encryption($string) {

        $output = FALSE;
        $key = hash('sha256', SECRET_KEY);
        $iv = substr(hash('sha256', SECRET_IV), 0, 16);
        $output = openssl_encrypt($string, METHOD, $key, 0, $iv);
        $output = base64_encode($output);
        return $output;
    }

    protected function decryption($string) {

        $key = hash("sha256", SECRET_KEY);
        $iv = substr(hash("sha256", SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }
    
    public function decryptions($string) {

        $key = hash("sha256", SECRET_KEY);
        $iv = substr(hash("sha256", SECRET_IV), 0, 16);
        $output = openssl_decrypt(base64_decode($string), METHOD, $key, 0, $iv);
        return $output;
    }

    public function generarCodigoAleatorio($letra, $longitud, $numero) {

        for ($i = 1; $i <= $longitud; $i++) {
            $numRand = rand(0, 9);
            $letra .= $numRand;
        }
        return $letra . $numero;
    }

    protected function guardarBitacora($datos) {

        $query = self::getConnection()->prepare("INSERT INTO bitacora(id_bitacora, codigo_bitacora,
                fecha_entrada, hora_inicio, hora_salida, tipo_usuario, bitacora_year, codigo, id_usuarios)
                VALUES (:id_bitacora, :codigo_bitacora,:fecha_entrada, :hora_inicio, :hora_salida, 
                :tipo_usuario, :bitacora_year, :codigo, :id_usuarios);");

        $query->bindParam(":id_bitacora", $datos['id_bitacora']);
        $query->bindParam(":codigo_bitacora", $datos['codigo_bitacora']);
        $query->bindParam(":fecha_entrada", $datos['fecha_entrada']);
        $query->bindParam(":hora_inicio", $datos['hora_inicio']);
        $query->bindParam(":hora_salida", $datos['hora_salida']);
        $query->bindParam(":tipo_usuario", $datos['tipo_usuario']);
        $query->bindParam(":bitacora_year", $datos['bitacora_year']);
        $query->bindParam(":codigo", $datos['codigo']);
        $query->bindParam(":id_usuarios", $datos['id_usuarios']);

        $query->execute();

        return $query;
    }

    protected function limpiarCadena($cadena) {

        //trim — Elimina espacio en blanco (u otro tipo de caracteres) del inicio y el final de la cadena
        $cadena = trim($cadena);
        //stripslashes — Quita las barras invertidas de un string con comillas escapadas
        $cadena = stripslashes($cadena);
        $cadena = str_ireplace("<script>", "", $cadena);
        $cadena = str_ireplace("</script>", "", $cadena);
        $cadena = str_ireplace("<script src", "", $cadena);
        $cadena = str_ireplace("<script type=", "", $cadena);
        $cadena = str_ireplace("SELECT * FROM", "", $cadena);
        $cadena = str_ireplace("DELETE FORM", "", $cadena);
        $cadena = str_ireplace("INSERT INTO", "", $cadena);
        $cadena = str_ireplace("--", "", $cadena);
        $cadena = str_ireplace("^", "", $cadena);
        $cadena = str_ireplace("[", "", $cadena);
        $cadena = str_ireplace("]", "", $cadena);
        $cadena = str_ireplace("==", "", $cadena);
        $cadena = str_ireplace(";", "", $cadena);

        return $cadena;
    }

    public function llamarUrlUser($datos) {

        $sql = mainModel::getConnection()->prepare("SELECT usuarios_acceso_generales.id,
              usuarios.codigo, usuarios.usuario, usuarios_acceso_generales.id_acceso_generales,
              acceso_generales.descripcion_acceso, acceso_generales.url FROM usuarios  
              INNER JOIN usuarios_acceso_generales ON usuarios_acceso_generales.id_usuarios = usuarios.id
              INNER JOIN acceso_generales ON acceso_generales.id = usuarios_acceso_generales.id_acceso_generales
              WHERE usuarios.codigo=:codigo");

        $sql->bindParam(':codigo', $datos['codigo']);
        $sql->execute();
        return $sql;
    }

    protected function actualizarBitacora($codigo, $hora) {

        $query = self::getConnection()->prepare("UPDATE bitacora SET hora_salida=:hora WHERE codigo_bitacora=:codigo");
        $query->bindParam(":codigo", $codigo);
        $query->bindParam(":hora", $hora);
        $query->execute();

        return $query;
    }

    protected function sweetAlert($datos) {

        if ($datos['Alerta'] == "simple") {
            $alerta = " 
            <script>
            Swal.fire(
               '" . $datos['Titulo'] . "', 
               '" . $datos['Texto'] . "', 
               '" . $datos['Tipo'] . "'
            );
            </script>

                      ";
        } elseif ($datos['Alerta'] == "recargar") {
            $alerta = " 
            <script>
            Swal.fire({
               icon: 'question',
               title:'" . $datos['Titulo'] . "', 
               text:'" . $datos['Texto'] . "', 
               type:'" . $datos['Tipo'] . "',
               confirmButtonText: 'Aceptar!'
               }).then(function (){
               
                  location.reload();               
            });
            </script>
                      ";
        } elseif ($datos['Alerta'] == "limpiar") {
            $alerta = " 
            <script>
            Swal.fire({
               icon: 'success',   
               title:'" . $datos['Titulo'] . "', 
               text:'" . $datos['Texto'] . "', 
               type:'" . $datos['Tipo'] . "',
               confirmButtonText: 'Aceptar!'
               }).then(function (){
               
                  $('.FormularioAjax')[0].reset();
            });
            </script>
                      ";
        }

        return $alerta;
    }

}
