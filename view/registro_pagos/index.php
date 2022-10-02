<?php require_once "../home/navbar.php";
require_once "../../model/conexion.php";
$conexion = conexion();
require_once "../../model/libraries/lib.php";

?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro Pagos</title>
</head>

<body>
    <div class="contendor m-3">
        <h4>Registro de Pagos por Estudiante</h4>
        <div class="row">
            <div class="col-sm-2">
                <label for="nombre_estudiante">Nombre Estudiante</label>
                <input class="form-control form-control-sm" value="" type="text" name="nombre_estudiante" id="nombre_estudiante" placeholder="Name...">
            </div>
            <div class="col-sm-3">
                <label for="resultados_estudiantes">Resultados</label>

                <select name="resultados_estudiantes" id="resultados_estudiantes" class="form-control form-control-sm">
                    <option value="A" selected>Resultados...</option>

                </select>
            </div>
            <div class="col-sm-2">
                <label for="cantidad_registros">Cantidad Registros</label>
                <input class="form-control form-control-sm" value="" type="number" id="cantidad_registros">
            </div>

            <div class="col-sm-2 d-flex align-items-end">
                <button class="btn btn-sm btn-info" onclick="buscar_registros()">Buscar</button>
            </div>

        </div>
        <div class="row">
                <div class="col-sm-12">
                    <div id="tabla_consulta" style="height: 520px; overflow: scroll; overflow-x: hidden;"></div>
                </div>
            </div>

</body>

</html>

<script>

$(document).ready(function(){
                $("input[name=nombre_estudiante]").change(function(){
                cadena="form1=" + $('#nombre_estudiante').val();
                        $.ajax({
                        type:"POST",
                        url:"../../controller/buscador_datos_estudiante.php", //validacion de datos de registro
                        data:cadena,
                        success:function(r){
                            if(r==1){
                                $('#resultados_estudiantes').load("temp_buscador.php");
                                return false;
                            }
                        }
                        });
                });
            });

function buscar_registros(){
        if($('#resultados_estudiantes').val() == 'A'){
                alertify.message("debes llenar todos los campos");
            }else{
                cadena="form1=" + $('#resultados_estudiantes').val()+
                    "&form2=" + $('#cantidad_registros').val();
            $.ajax({
              type:"POST",
              url:"../../controller/buscar_registros_pagos.php", //validacion de datos de registro
              data:cadena,
              success:function(r){
                if(r==1){
                    $('#tabla_consulta').load("temp_registros.php");
                    alertify.message("Registros Encontrados");
                    return false;
                }if(r==2){/* ojala no haya que usar esto */
                    alertify.error("No existen registros de este usuario");
                    return false;
                }else{
                    $('#tabla_consulta').load("temp_registros.php");
                    alertify.error("Error no se encontro nada");
                    return false;
                }
              }
            });
        }
    }
</script>