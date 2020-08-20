<?php

include_once './modelos/vistasModelo.php';

class vistasControlador extends vistasModelo {

    public function obtenerPlantillaControlador() {
        return include_once './vistas/plantilla.php';
    }

    public function obtenerVistaControlador() {
        if (isset($_GET["views"])) {
            $ruta = explode("/", $_GET["views"]);
            $respuesta = vistasModelo::obtenerVistasModelo($ruta[0]);
        } else {
            $respuesta = "login";
        }
        return $respuesta;
    }

}
