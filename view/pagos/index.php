<?php require_once "../home/navbar.php";
require_once "../../model/conexion.php";
$conexion = conexion();
require_once "../../model/libraries/lib.php";

$sql = "SELECT fecha FROM gestion_cartera ORDER BY fecha DESC LIMIT 1 ";
$result = mysqli_query($conexion, $sql);
$fechahidden = mysqli_fetch_row($result);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagos</title>
</head>

<body style="overflow-x: hidden;">

    <div class="container-x d-flex">
        <input type="text" id="fecha" hidden value="<?php echo $fechahidden[0]; ?>">
        <div class="contenedor1 w-50 pl-1 mt-4">
            <h3 class="ml-3">Cartera Mensual</h3>
            <div class="panel_busqueda">
                <div class="row ml-1">
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="col-sm-12">Mes</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control form-control-sm" name="" id="mes">
                                    <option value="A">Meses...</option>
                                    <?php $sql = "SELECT fecha FROM gestion_cartera GROUP BY fecha DESC  LIMIT 10";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($ver = mysqli_fetch_row($result)) : ?>
                                        <option value=<?php echo $ver[0]; ?>><?php echo $ver[0]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="row">
                            <div class="col-sm-12">Grado</div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12">
                                <select class="form-control form-control-sm" name="" id="grado">
                                    <option value="A">Grados...</option>
                                    <?php $sql = "SELECT * FROM grados where estado = 1 order by id_grado asc";
                                    $result = mysqli_query($conexion, $sql);
                                    while ($ver = mysqli_fetch_row($result)) : ?>
                                        <option value=<?php echo $ver[0]; ?>><?php echo $ver[1]; ?></option>
                                    <?php endwhile; ?>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6 d-flex align-items-end justify-content-between">
                        <button class="px-3 btn btn-sm btn-info" onclick="buscar()">Buscar</button>
                        <button class="px-3 btn btn-sm btn-info" onclick="nuevoMes()">Nuevo Mes</button>
                        <button class="px-3 btn btn-sm btn-info" onclick="aplicarRecargo()">A. Recargos</button>
                    </div>
                    <div class="col-sm-2 d-flex align-items-end">
                        <div class="btn btn-info btn-sm" onclick="iniciarTodo()">
                            Iniciar
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div id="tabla_consulta" class="scrroll" style="height: 520px; overflow: auto; overflow-x: auto;"></div>
                    </div>
                </div>
            </div>
        </div>


        
        <div class="contenedor2 mt-2 w-50 pl-5 pr-2">
            <h3>Registrar Pago</h3>
            <div class="row">
                <div class="col-sm-4">
                    <div class="row">
                        <div class="col-sm-12">Nombre</div>
                    </div>
                    <div class="row">
                        <div class="col-sm-12">
                            <input type="text" id="buscador" name="buscador" class="form-control form-control-sm" placeholder="Nombres... Apellidos...">
                        </div>
                    </div>
                </div>
                <div class="col-sm-7">
                    <label for="resultados_estudiantes">Resultados</label>

                    <select name="resultados_estudiantes" id="resultados_estudiantes" class="form-control form-control-sm">
                        <option value="A" selected>Resultados...</option>

                    </select>
                </div>
                <div class="col-sm-1 d-flex align-items-end">
                    <div class="btn btn-info btn-sm" onclick="buscar_datos_totales()">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg>
                    </div>
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-sm-6">
                    <label for="responsable">Responsable Tutor</label>
                    <input disabled type="text" id="responsable" class="form-control form-control-sm" value="">
                </div>
                <div class="col-sm-3">
                    <label for="celular">Cedula</label>
                    <input disabled type="text" id="celular" class="form-control form-control-sm" value="">
                </div>
            </div>
            <div class="row mt-1">
                <div class="col-sm-4">
                    <label for="nombre_estudiante">Nombre Estudiante</label>
                    <input disabled class="form-control form-control-sm" value="" type="text" id="nombre_estudiante">
                </div>
                <div class="col-sm-2">
                    <label for="grado">Grado</label>
                    <input disabled class="form-control form-control-sm" value="" type="text" id="grado_estudiante">
                </div>
                <div class="col-sm-2">
                    <label for="cartera">Cartera</label>
                    <input disabled type="text" id="cartera" class="form-control form-control-sm" value="">
                </div>
                <div class="col-sm-2">
                    <label for="abonos">Abonos Mes</label>
                    <input disabled type="text" id="abonos" class="form-control form-control-sm" value="">
                </div>
                <div class="col-sm-2">
                    <label for="saldo_mes">Pensión</label>
                    <input disabled type="text" id="saldo_mes" class="form-control form-control-sm" value="">
                </div>
            </div>

                                        <hr class="mt-5">


            <div class="row mt-5">
                <div class="col-sm-3">
                    <label for="valor_pago">Valor a Pagar</label>
                    <input type="number" value="" class="form-control form-control-sm" id="valor_pago">
                </div>
                <div class="col-sm-4">
                    <label for="nombre_pagante">Nombre</label>
                    <input type="text" value="" class="form-control form-control-sm" id="nombre_pagante">
                </div>
                <div class="col-sm-3">
                    <label for="cedula_pagante">Cedula</label>
                    <input type="number" value="" class="form-control form-control-sm" id="cedula_pagante">
                </div>

            </div>
            <div class="row mt-1">
                <div class="col-sm-8">
                    <label for="Concepto">Concepto</label>
                    <input type="text" id="concepto" class="form-control form-control-sm">
                </div>
                <div class="col-sm-4">
                    <label for="medio_pago">Medio de pago</label>
                    <select name="medio_pago" class="form-control form-control-sm" id="medio_pago">
                        <option value="1" selected>Efectivo</option>
                        <option value="2">Transferencía</option>
                        <option value="3">Datafono</option>
                    </select>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-sm-12 d-flex justify-content-around">
                    <button class="px-4 btn btn-info btn-sm" onclick="crear_pago()">Pensíon</button>
                    <button class="px-4 btn btn-primary btn-sm" onclick="crear_pago_matricula()">Matrícula</button>

                    <button class="btn btn-warning ml-1" style="display:none;" id="print" onclick="print('A')">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                    </button>
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
    label {
        padding-bottom: 0px;
        margin-bottom: 0px;
    }

    table {
        font-size: 0.85rem !important;
    }
</style>

<script>
    function print(id) {
        window.open('../../controller/print.php?id=' + id, "TICKET", "width=1080, height=600")
        /* window.location.href = '../../controller/print.php?id='+id; */
    }

    function crear_pago_matricula() {
        if ($('#valor_pago').val() == '' || $('#resultados_estudiantes').val() == 'A' || $('#nombre_pagante').val() == '' || $('#cedula_pagante').val() == '' || $('#concepto').val() == '' || $('#medio_pago').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#valor_pago').val() +
                "&form2=" + $('#resultados_estudiantes').val() +
                "&form3=" + $('#nombre_pagante').val() +
                "&form4=" + $('#cedula_pagante').val() +
                "&form5=" + $('#concepto').val() +
                "&form6=" + $('#medio_pago').val();
            $.ajax({
                type: "POST",
                url: "../../controller/crear_pago_matricula.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        if ($('#mes').val() == 'A' || $('#grado').val() == 'A') {
                            document.getElementById("nombre_pagante").value = "";
                            document.getElementById("cedula_pagante").value = "";
                            document.getElementById('print').style.display = 'block';
                            alertify.message("Pago Exitoso");
                            return false;
                        } else {
                            buscar();
                            document.getElementById("nombre_pagante").value = "";
                            document.getElementById("cedula_pagante").value = "";
                            $('#tabla_consulta').load("temp_pagos.php");
                            document.getElementById('print').style.display = 'block';
                            alertify.message("Pago Exitoso");
                            return false;
                        }
                    }
                    if (r == 2) {
                        /* ojala no haya que usar esto */
                        alertify.error("El usuario tiene problemas con el ultimo mes");
                        return false;
                    }
                    if (r == 3) {
                        alertify.error("error pagando");
                        return false;
                    }
                    if (r == 4) {
                        alertify.error("error guardando registro, pago ok");
                        return false;
                    } else {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.error("Error no se encontro nada");
                        return false;
                    }
                }
            });
        }
    }

    function crear_pago() {
        if ($('#valor_pago').val() == '' || $('#resultados_estudiantes').val() == 'A' || $('#nombre_pagante').val() == '' || $('#cedula_pagante').val() == '' || $('#concepto').val() == '' || $('#medio_pago').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#valor_pago').val() +
                "&form2=" + $('#resultados_estudiantes').val() +
                "&form3=" + $('#nombre_pagante').val() +
                "&form4=" + $('#cedula_pagante').val() +
                "&form5=" + $('#concepto').val() +
                "&form6=" + $('#medio_pago').val();
            $.ajax({
                type: "POST",
                url: "../../controller/crear_pago.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        if ($('#mes').val() == 'A' || $('#grado').val() == 'A') {
                            document.getElementById("nombre_pagante").value = "";
                            document.getElementById("cedula_pagante").value = "";
                            document.getElementById('print').style.display = 'block';
                            alertify.message("Pago Exitoso");
                            return false;
                        } else {
                            buscar();
                            document.getElementById("nombre_pagante").value = "";
                            document.getElementById("cedula_pagante").value = "";
                            $('#tabla_consulta').load("temp_pagos.php");
                            document.getElementById('print').style.display = 'block';
                            alertify.message("Pago Exitoso");
                            return false;
                        }
                    }
                    if (r == 2) {
                        /* ojala no haya que usar esto */
                        alertify.error("El usuario tiene problemas con el ultimo mes");
                        return false;
                    }
                    if (r == 3) {
                        alertify.error("error pagando");
                        return false;
                    }
                    if (r == 4) {
                        alertify.error("error guardando registro, pago ok");
                        return false;
                    } else {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.error("Error no se encontro nada");
                        return false;
                    }
                }
            });
        }
    }

    function buscar_datos_totales() {
        cadena = "form1=" + $('#resultados_estudiantes').val();
        $.ajax({
            type: "POST",
            url: "../../controller/buscador_datos_totales.php", //validacion de datos de registro
            data: cadena,
            success: function(r) {
                if (r == 2) {
                    alertify.message("Este estudiante no tiene cartera");
                }
                dato = jQuery.parseJSON(r);
                $('#responsable').val(dato['0']);
                $('#celular').val(dato['2']);
                $('#nombre_estudiante').val(dato['3']);
                $('#grado_estudiante').val(dato['5']);
                $('#cartera').val(dato['6']);
                $('#abonos').val(dato['7']);
                $('#saldo_mes').val(dato['8']);
            }
        });
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


    function buscar() {
        if ($('#mes').val() == 'A' || $('#grado').val() == 'A') {
            alertify.message("Selecciona todos los campos");
        } else {
            cadena = "form1=" + $('#mes').val() +
                "&form2=" + $('#grado').val();

            $.ajax({
                type: "POST",
                url: "../../controller/buscar_cartera.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.message("Planilla actualizada");
                        return false;
                    } else {
                        $('#tabla_consulta').load("temp_pagos.php");
                        alertify.error("Error no se encontro nada");
                        return false;
                    }
                }
            });
        }
    }

    function nuevoMes() {
        if ($('#mes').val() == 'A') {
            alertify.message("Selecciona todos los campos");
        } else {
            alertify.confirm("Estas seguro de generar un nuevo mes? se cargarán los saldos pendientes a las carteras",
                function() {
                    cadena = "form1=" + $('#fecha').val();
                    $.ajax({
                        type: "POST",
                        url: "../../controller/crear_mes.php",
                        data: cadena,
                        success: function(r) {
                            if (r == 1) {
                                $('#tabla_consulta').load("temp_pagos.php");
                                alertify.message("Se genero un nuevo mes");
                                setInterval("location.reload()", 1500);
                                return false;
                            } else {
                                alertify.error("Error al generar el mes");
                                return false;
                            }
                        }
                    });
                },
                function() {
                    alertify.error('Cancelado');
                });
        }
    }

    function iniciarTodo() {
        alertify.confirm("Estas seguro de generar un nuevo mes? se cargarán los saldos pendientes a las carteras",
            function() {
                cadena = "form1=" + $('#fecha').val();
                $.ajax({
                    type: "POST",
                    url: "../../controller/crear_mes2.php",
                    data: cadena,
                    success: function(r) {
                        if (r == 1) {
                            $('#tabla_consulta').load("temp_pagos.php");
                            alertify.message("Se genero un nuevo mes");
                            setInterval("location.reload()", 1500);
                            return false;
                        } else {
                            alertify.error("Error al generar el mes");
                            return false;
                        }
                    }
                });
            },
            function() {
                alertify.error('Cancelado');
            });
    }

    function aplicarRecargo() {
        if ($('#mes').val() == 'A') {
            alertify.message("Selecciona todos los campos");
        } else {
            alertify.confirm("Estas seguro de que deseas aplicar el recargo? se aplicara a los grados pertinentes",
                function() {
                    cadena = "form1=" + $('#fecha').val();
                    $.ajax({
                        type: "POST",
                        url: "../../controller/aplicar_recargo.php",
                        data: cadena,
                        success: function(r) {
                            if (r == 1) {
                                alertify.message("Se aplico el recargo");
                                buscar();
                                return false;
                            }
                            if (r == 3) {
                                alertify.error("Recargo ya esta aplicado");
                                return false;
                            } else {
                                alertify.error("Error al aplicar");
                                return false;
                            }
                        }
                    });
                },
                function() {
                    alertify.error('Cancelado');
                });
        }
    }
</script>