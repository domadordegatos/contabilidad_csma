
<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/gestion.php";
$conexion=conexion();

$obj= new gestion();

  $result=$obj->crear_pago_matricula();
  echo $result;

 ?>