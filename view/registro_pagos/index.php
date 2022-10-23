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

                <button class="btn btn-warning ml-1" style="display:none;" id="print2" onclick="print2()">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                        <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                        <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                    </svg>
                </button>
            </div>

        </div>
        <div class="row">
            <div class="col-sm-12">
                <div id="tabla_consulta" class="scrroll" style="height: 520px; overflow: auto; overflow-x: hidden;"></div>
            </div>
        </div>

</body>

</html>
<style>
    .scrroll::-webkit-scrollbar {
  width: 16px;
}

.scrroll::-webkit-scrollbar-track {
  background-color: #e4e4e4;
  border-radius: 100px;
}

.scrroll::-webkit-scrollbar-thumb {
  background-color: #64AEF4;
  border-radius: 100px;
}
</style>

<script>
    function print(id) {
        window.open('../../controller/print.php?id=' + id, "TICKET", "width=1080, height=600")
        /* window.location.href = '../../controller/print.php?id='+id; */
    }

    function print2() {
        window.open('../../controller/print2.php', "TICKET", "width=1080, height=600")
        /* window.location.href = '../../controller/print.php?id='+id; */
    }

    $(document).ready(function() {
        $("input[name=nombre_estudiante]").change(function() {
            cadena = "form1=" + $('#nombre_estudiante').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscador_datos_estudiante.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        $('#resultados_estudiantes').load("temp_buscador.php");
                        return false;
                    }
                }
            });
        });
    });

    function buscar_registros() {
        if ($('#resultados_estudiantes').val() == 'A') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#resultados_estudiantes').val() +
                "&form2=" + $('#cantidad_registros').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscar_registros_pagos.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        document.getElementById('print2').style.display = 'block';
                        $('#tabla_consulta').load("temp_registros.php");
                        alertify.message("Registros Encontrados");
                        return false;
                    }
                    if (r == 2) {
                        /* ojala no haya que usar esto */
                        alertify.error("No existen registros de este usuario");
                        return false;
                    } else {
                        $('#tabla_consulta').load("temp_registros.php");
                        alertify.error("Error no se encontro nada");
                        return false;
                    }
                }
            });
        }
    }
</script>