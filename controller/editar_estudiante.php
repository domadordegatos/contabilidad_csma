<?php
require_once "../model/conexion.php";
require_once "../model/gestion.php";
$conexion=conexion();

    $obj= new gestion();

    $idest=$_POST['idest'];
    echo json_encode($obj->editar_estudiante_datos($idest));
 ?>