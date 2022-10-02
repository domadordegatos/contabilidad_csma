
<?php
session_start();
require_once "../model/conexion.php";
require_once "../model/gestion.php";
$conexion=conexion();

$obj= new gestion();

  $result=$obj->agregar_estudiante();
  echo $result;

 ?>