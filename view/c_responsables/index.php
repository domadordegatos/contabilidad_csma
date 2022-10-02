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
    <title>Cr. Responsables</title>
</head>
<body onload="consulta_tabla()">

    <div class="contenedor p-3 d-flex">
        <div class="separador1 w-25">
            <div class="row col-sm-12">
                <h4>Creación de Respondables</h4>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="nombre">Nombres</label>
                    <input type="text" id="nombre" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="apellido">Apellidos</label>
                    <input type="text" id="apellido" class="form-control">
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <label for="celular">Celular</label>
                    <input type="number" id="celular" class="form-control">
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12">
                    <button class="btn btn-info btn-block btn-lg btn-sm" onclick="agregar_padre()">Agregar</button>
                </div>
            </div>
        </div>
        <div class="separador2 p-4 w-50">
        <div class="row">
                <div class="col-sm-12">
                    <div id="tabla_consulta" style="height: 520px; overflow: scroll; overflow-x: hidden;"></div>
                </div>
            </div>
        </div>
    </div>
    
</body>
</html>

<script>

function consulta_tabla(){
                        $.ajax({
                        type:"POST",
                        url:"../../controller/buscar_tabla_padres.php", //validacion de datos de registro
                        success:function(r){
                            if(r==1){
                                $('#tabla_consulta').load("temp_padres.php");
                                return false;
                            }
                        }
                        });
    }

    function agregar_padre(){
        if ($('#nombre').val() == '' || $('#apellido').val() == '' || $('#celular').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#nombre').val() +
                "&form2=" + $('#apellido').val() +
                "&form3=" + $('#celular').val();
            $.ajax({
                type: "POST",
                url: "../../controller/agregar_padre.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("Padre Agregado");
                        //tabla_estudiantes();
                        $('#tabla_consulta').load("temp_padres.php");
                        return false;
                    } else if (r == 2) {
                        alertify.error("padre ya existe");
                        return false;
                    } else if (r == 3) {
                        alertify.error("Error creando padre");
                        return false;
                    } else {
                        alertify.error("Error al agregar");
                        return false;
                    }
                }
            });
        }
    }
</script>