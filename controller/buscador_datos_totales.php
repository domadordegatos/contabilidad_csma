<?php
require_once "../model/conexion.php";
require_once "../model/gestion.php";
$conexion=conexion();

    $obj= new gestion();

    echo json_encode($obj->ob_datos_estudiante())
 ?>