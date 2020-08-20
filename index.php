<?php

include_once './core/configURL.php';
include_once './controladores/vistasControlador.php';


$init = new vistasControlador();
$init->obtenerPlantillaControlador();
