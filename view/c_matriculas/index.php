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
    <title>Matriculas</title>
</head>

<body onload="consulta_tabla()">
    <div class="contenedor m-3 d-flex">
        <div class="parte1 w-50">
            <h3>Creación de Matriculas</h3>
            <div class="row">
                <div class="col-sm-3">
                    <div class="row">
                        <div class="col-sm-12"><label for="">Nombre</label></div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" id="buscador" name="buscador" class="form-control form-control-sm" placeholder="Nombres... Apellidos...">
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <label for="resultados_estudiantes">Resultados</label>

                    <select name="resultados_estudiantes" id="resultados_estudiantes" class="form-control form-control-sm">
                        <option value="A" selected>Resultados...</option>

                    </select>
                </div>
                <div class="col-sm-3 d-flex align-items-end">
                    <button class="btn btn-info btn-block" onclick="agregar_matricula()">Agregar</button>
                </div>

            </div>
            <div class="row">
                <div class="col-sm-3">
                    <label for="">Valor</label>
                    <input type="text" class="form-control" value="" id="valor" placeholder="$...">
                </div>
                <div class="col-sm-5">
                    <label for="">Concepto</label>
                    <input type="text" class="form-control" value="" id="concepto" placeholder="matricula...">
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
                <div class="col-sm-3">
                    <label for="">Saldo</label>
                    <input type="text" class="form-control" id="saldo" value="0">
                </div>
                <div class="col-sm-4">
                    <label for="">Pagante</label>
                    <input type="text" class="form-control" value="" id="pagante" placeholder="Nombre">
                </div>
                <div class="col-sm-5">
                    <label for="">Cedula</label>
                    <input type="text" class="form-control" value="" id="cedula" placeholder="111....">
                </div>
            </div>
        </div>
        <div class="parte2 p-3 w-50">
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
    function print(id) {
        window.open('../../controller/print.php?id=' + id, "TICKET", "width=1080, height=600")
        /* window.location.href = '../../controller/print.php?id='+id; */
    }

    function consulta_tabla() {
        $.ajax({
            type: "POST",
            url: "../../controller/buscar_tabla_matriculas.php", //validacion de datos de registro
            success: function(r) {
                if (r == 1) {
                    $('#tabla_consulta').load("temp_pagos.php");
                    return false;
                }
            }
        });
    }

    function agregar_matricula() {
        if ($('#valor').val() == '' || $('#resultados_estudiantes').val() == 'A' || $('#pagante').val() == '' || $('#cedula').val() == ''|| $('#concepto').val() == '' || $('#saldo').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#valor').val() +
                "&form2=" + $('#resultados_estudiantes').val() +
                "&form3=" + $('#pagante').val() +
                "&form4=" + $('#cedula').val()+
                "&form5=" + $('#saldo').val()+
                "&form6=" + $('#concepto').val()+
                "&form7=" + $('#medio_pago').val();
            $.ajax({
                type: "POST",
                url: "../../controller/crear_matricula.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("Matricula Exitosa");
                        document.getElementById("pagante").value = "";
                        document.getElementById("cedula").value = "";
                        consulta_tabla();
                        return false;
                    } else if (r == 3) {
                        alertify.error("error actualizando cartera");
                        return false;
                    } else if (r == 4) {
                        alertify.error("error creando registro");
                        return false;
                    } else if (r == 5) {
                        alertify.error("valor de matricula superado");
                        return false;
                    } else if (r == 2) {
                        alertify.error("este usuario ya tiene matricula este año");
                        return false;
                    } else {
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