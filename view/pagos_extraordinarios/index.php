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
    <title>General</title>
</head>

<body onload="consulta_tabla()">
    <div class="contenedor m-3 d-flex">
        <div class="parte1 w-50">
            <h3>Pagos Generales</h3>
            <div class="row">
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12"><label for="">Nombre Estudiante</label></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" id="buscador" name="buscador" class="form-control" placeholder="Nombres... Apellidos...">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="resultados_estudiantes">Resultados</label>

                    <select name="resultados_estudiantes" id="resultados_estudiantes" class="form-control">
                        <option value="A" selected>Resultados...</option>

                    </select>
                </div>
                <div class="col-sm-3 d-flex align-items-end">
                    <button class="btn btn-info btn-block" onclick="crear_pago_general()">Agregar</button>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Valor</label>
                    <input type="text" class="form-control" value="" id="valor" placeholder="$...">
                </div>
                <div class="col-sm-5">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" value="" id="concepto" placeholder="asunto.....">
                </div>
                <div class="col-sm-4">
                    <label for="medio_pago">Medio de pago</label>
                    <select name="medio_pago" class="form-control" id="medio_pago">
                        <option value="1" selected>Efectivo</option>
                        <option value="2">Transferencía</option>
                        <option value="3">Datafono</option>
                    </select>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-4">
                    <label for="asunto">Asunto</label>
                    <select class="form-control" name="asunto" id="asunto">
                        <option value="A">Asuntos...</option>
                        <?php $sql = "SELECT * FROM asuntos where estado = 1 order by id_asunto asc";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[1]."-".$ver[2]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-sm-5">
                    <label for="">Pagante</label>
                    <input type="text" class="form-control" value="" id="pagante" placeholder="Nombre">
                </div>
                <div class="col-sm-3">
                    <label for="">Cedula</label>
                    <input type="text" class="form-control" value="" id="cedula" placeholder="111....">
                </div>
            </div>
        </div>
        <div class="parte2 p-3 w-50">
        <div class="row">
            <div class="col-sm-4">
                <label for="nombre_estudiante">Nombre Estudiante</label>
                <input class="form-control form-control-sm" value="" type="text" name="nombre_estudiante" id="nombre_estudiante" placeholder="Name...">
            </div>
            <div class="col-sm-4">
                <label for="resultados_estudiantes2">Resultados</label>

                <select name="resultados_estudiantes2" id="resultados_estudiantes2" class="form-control form-control-sm">
                    <option value="A" selected>Resultados...</option>

                </select>
            </div>
            <div class="col-sm-2">
                <label for="cantidad_registros">Cant Reg.</label>
                <input class="form-control form-control-sm" value="" type="number" id="cantidad_registros">
            </div>

            <div class="col-sm-2 d-flex align-items-end">
                <button class="btn btn-sm btn-info" onclick="buscar_registros()">Buscar</button>
            </div>

        </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="tabla_consulta" class="scrroll" style="height: 520px; overflow: auto; overflow-x: hidden;"></div>
                </div>
            </div>
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

<style>
    table {
        font-size: 0.9rem !important;
    }
</style>
<script>

$(document).ready(function() {
        $("input[name=nombre_estudiante]").change(function() {
            cadena = "form1=" + $('#nombre_estudiante').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscador_datos_estudiante2.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        $('#resultados_estudiantes2').load("temp_buscador2.php");
                        return false;
                    }
                }
            });
        });
    });

    function buscar_registros() {
            cadena = "form1=" + $('#resultados_estudiantes2').val() +
                     "&form2=" + $('#cantidad_registros').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscar_registros_pagos_generales.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.message("Registros Encontrados");
                        return false;
                    }
                    if (r == 2) {
                        /* ojala no haya que usar esto */
                        alertify.error("No existen registros de este usuario");
                        return false;
                    } else {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.error("Error no se encontro nada");
                        return false;
                    }
                }
            });
    }

    function print(id) {
        window.open('../../controller/print3.php?id=' + id, "TICKET", "width=1080, height=600")
        /* window.location.href = '../../controller/print.php?id='+id; */
    }

    function consulta_tabla() {
        cadena = "form1=" + $('#resultados_estudiantes2').val() +
                 "&form2=" + $('#cantidad_registros').val();
        $.ajax({
            type: "POST",
            url: "../../controller/buscar_tabla_pagos_generales.php", //validacion de datos de registro
            data: cadena,
            success: function(r) {
                if (r == 1) {
                    $('#tabla_consulta').load("temp_pagos.php");
                    return false;
                }
            }
        });
    }

    function crear_pago_general() {
        if ($('#valor').val() == '' || $('#resultados_estudiantes').val() == 'A' || $('#pagante').val() == '' || $('#cedula').val() == '' || $('#concepto').val() == '' || $('#asunto').val() == 'A') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#valor').val() +
                "&form2=" + $('#resultados_estudiantes').val() +
                "&form3=" + $('#pagante').val() +
                "&form4=" + $('#cedula').val() +
                "&form5=" + $('#asunto').val() +
                "&form6=" + $('#concepto').val() +
                "&form7=" + $('#medio_pago').val();
            $.ajax({
                type: "POST",
                url: "../../controller/crear_pago_general.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("pago exitoso");
                        document.getElementById("pagante").value = "";
                        document.getElementById("cedula").value = "";
                        consulta_tabla();
                        return false;
                    }else if (r == 4) {
                        alertify.error("error creando registro");
                        return false;
                    }else {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.error("Error desconocido");
                        return false;
                    }
                }
            });
        }
    }

    $(document).ready(function() {
        $("input[name=buscador]").change(function() {
            cadena = "form1=" + $('#buscador').val();
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
</script>