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
    <title>Creacion Estudiantes</title>
</head>

<body onload="tabla_estudiantes()">
    <div class="contenedor m-3 d-flex">
        <div class="seccion1 w-50">
            <h4>Gestión de Estudiantes</h4>
            <input type="number" hidden value="" id="id">
            <div class="form-group row">
                <label for="nombres" class="col-sm-2 col-form-label">Nombres</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nombres">
                </div>
            </div>
            <div class="form-group row">
                <label for="apellidos" class="col-sm-2 col-form-label">Apellidos</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="apellidos">
                </div>
            </div>
            <div class="form-group row">
                <label for="padre_buscador" class="col-sm-2 col-form-label">Buscar Padre</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control" id="padre_buscador" name="padre_buscador">
                </div>
                <div class="col-sm-5">
                    <select name="resultados_padres" id="resultados_padres" class="form-control">
                        <option value="A" selected>Resultados...</option>

                    </select>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-sm-4">
                    <select class="form-control" name="" id="descuento">
                        <option value="A">Descuentos...</option>
                        <?php $sql = "SELECT * FROM descuentos";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[1] . " " . $ver[2]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-sm-4">
                    <select class="form-control" name="" id="pension">
                        <option value="A">Pension...</option>
                        <?php $sql = "SELECT * FROM pensiones";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[1] . " " . $ver[2]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-sm-4">
                    <select class="form-control" name="" id="grado">
                        <option value="A">Grado...</option>
                        <?php $sql = "SELECT * FROM grados where estado = 1";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[1]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>


            </div>

            <div class="form-group row">

                <div class="col-sm-4">
                    <select class="form-control" name="" id="recargo">
                        <option value="A">Recargo...</option>
                        <?php $sql = "SELECT * FROM recargos";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[1]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-sm-4">
                    <select class="form-control" name="" id="estado">
                        <option value="A">Estado...</option>
                        <?php $sql = "SELECT * FROM estados";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[1]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>

                <div class="col-sm-4">
                    <input type="number" id="cartera" class="form-control" placeholder="Cartera....$" value="0">
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-sm-3"><button class="btn btn-info btn-sm btn-lg btn-block" onclick="agregar_estudiante()">Agregar</button></div>
                <div class="col-sm-3"><button class="btn btn-info btn-sm btn-lg btn-block" onclick="actualizar_estudiante()">Actualizar</button></div>
                <div class="col-sm-4"><button class="btn btn-primary btn-sm btn-lg btn-block" onclick="crear_estudiante_cartera()">Crear Estudiante + Cartera</button></div>
            </div>
            <div class="row mt-2">
                <button class="ml-3 btn btn-sm btn-warning px-4" onclick="crear_cartera_individual()">Activar cartera</button>
            </div>

        </div>



        <div class="seccion2 w-50 p-3">
            <div class="row col-sm-12 d-flex justify-content-end">
                <button class="btn-sm btn-info btn" onclick="nuevo_ano()">Crear Nuevo Año</button>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div id="tabla_consulta" class="scrroll" style="height: 520px; overflow: scroll; overflow-x: hidden;"></div>
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
<script>

function crear_cartera_individual() {
        if ($('#nombres').val() == '' || $('#apellidos').val() == '' || $('#resultados_padres').val() == 'A' ||
            $('#descuento').val() == 'A' || $('#pension').val() == 'A' ||
            $('#recargo').val() == 'A' || $('#estado').val() == 'A' || $('#cartera').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#nombres').val() +
                "&form2=" + $('#apellidos').val() +
                "&form3=" + $('#resultados_padres').val() +
                "&form4=" + $('#descuento').val() +
                "&form5=" + $('#pension').val() +
                "&form6=" + $('#recargo').val() +
                "&form7=" + $('#estado').val() +
                "&form8=" + $('#cartera').val() +
                "&form9=" + $('#grado').val();
            $.ajax({
                type: "POST",
                url: "../../controller/crear_cartera_individual.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("Cartera creada para este estudiante");
                        tabla_estudiantes();
                        $('#tabla_consulta').load("temp_estudiantes.php");
                        return false;
                    }else if (r == 2) {
                        alertify.error("el estudiante no aparece, verifica los nombres");
                        return false;
                    }else if (r == 4) {
                        alertify.error("El estudiante ya tiene cartera este mes");
                        return false;
                    }else if (r == 3) {
                        alertify.error("error al agregar");
                        return false;
                    } else {
                        alertify.error("Error al agregar");
                        return false;
                    }
                }
            });
        }
    }

function nuevo_ano(){
            alertify.confirm("Estas seguro de generar un nuevo año? las carteras se vaciaran",
            function(){
                $.ajax({
              type:"POST",
              url:"../../controller/crear_ano.php",
              success:function(r){
                if(r==1){
                    alertify.message("Feliz nuevo año");
                    return false;
                }else{
                    alertify.error("Error al generar el año");
                    return false;
                }
              }
            });
            },
            function(){
                alertify.error('Cancelado');
            });
          }

    function cargar_datos(id_estudiante){
			$.ajax({
				type:"POST",
				data:"idest=" + id_estudiante,
				url:"../../controller/editar_estudiante.php",
				success:function(r){
					dato=jQuery.parseJSON(r);
					$('#id').val(dato[0]);
					$('#nombres').val(dato[1]);
					$('#apellidos').val(dato[2]);
					$('#grado').val(dato[3]);
					$('#estado').val(dato[4]);
					$('#resultados_padres').val(dato[5]);
                    $('#descuento').val(dato[7]);
                    $('#cartera').val(dato[8]);
                    $('#pension').val(dato[9]);
                    $('#recargo').val(dato[10]);
                    $('#padre_buscador').val(dato[12]);
                    buscar_padre();
				}
			});
		}

    function tabla_estudiantes() {
        $.ajax({
            type: "POST",
            url: "../../controller/listado_estudiantes.php", //validacion de datos de registro
            success: function(r) {
                if (r == 1) {
                    console.log("deberia recargar");
                    $('#tabla_consulta').load("temp_estudiantes.php");
                    return false;
                }
            }
        });
    }

    $(document).ready(function() {
        $("input[name=padre_buscador]").change(function() {
            cadena = "form1=" + $('#padre_buscador').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscador_datos_padre.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        $('#resultados_padres').load("temp_buscador.php");
                        return false;
                    }
                }
            });
        });
    });

    function buscar_padre(){
            cadena = "form1=" + $('#padre_buscador').val();
            $.ajax({
                type: "POST",
                url: "../../controller/buscador_datos_padre.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        $('#resultados_padres').load("temp_buscador.php");
                        return false;
                    }
                }
            });
        }


        function crear_estudiante_cartera() {
        if ($('#nombres').val() == '' || $('#apellidos').val() == '' || $('#resultados_padres').val() == 'A' ||
            $('#descuento').val() == 'A' || $('#pension').val() == 'A' ||
            $('#recargo').val() == 'A' || $('#estado').val() == 'A' || $('#cartera').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#nombres').val() +
                "&form2=" + $('#apellidos').val() +
                "&form3=" + $('#resultados_padres').val() +
                "&form4=" + $('#descuento').val() +
                "&form5=" + $('#pension').val() +
                "&form6=" + $('#recargo').val() +
                "&form7=" + $('#estado').val() +
                "&form8=" + $('#cartera').val() +
                "&form9=" + $('#grado').val();
            $.ajax({
                type: "POST",
                url: "../../controller/crear_estudiante_cartera.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("Estudiante Agregado + cartera");
                        tabla_estudiantes();
                        $('#tabla_consulta').load("temp_estudiantes.php");
                        return false;
                    } else if (r == 2) {
                        alertify.error("Estudiante ya existe");
                        return false;
                    } else if (r == 3) {
                        alertify.error("Error creando estudiante");
                        return false;
                    } else if (r == 4) {
                        alertify.error("estudiante creado, error en cartera");
                        return false;
                    } else {
                        alertify.error("Error al agregar");
                        return false;
                    }
                }
            });
        }
    }


    function agregar_estudiante() {
        if ($('#nombres').val() == '' || $('#apellidos').val() == '' || $('#resultados_padres').val() == 'A' ||
            $('#descuento').val() == 'A' || $('#pension').val() == 'A' ||
            $('#recargo').val() == 'A' || $('#estado').val() == 'A' || $('#cartera').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#nombres').val() +
                "&form2=" + $('#apellidos').val() +
                "&form3=" + $('#resultados_padres').val() +
                "&form4=" + $('#descuento').val() +
                "&form5=" + $('#pension').val() +
                "&form6=" + $('#recargo').val() +
                "&form7=" + $('#estado').val() +
                "&form8=" + $('#cartera').val() +
                "&form9=" + $('#grado').val();
            $.ajax({
                type: "POST",
                url: "../../controller/agregar_estudiante.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("Estudiante Agregado");
                        tabla_estudiantes();
                        $('#tabla_consulta').load("temp_estudiantes.php");
                        return false;
                    } else if (r == 2) {
                        alertify.error("Estudiante ya existe");
                        return false;
                    } else if (r == 3) {
                        alertify.error("Error creando estudiante");
                        return false;
                    }else {
                        alertify.error("Error al agregar");
                        return false;
                    }
                }
            });
        }
    }

    function actualizar_estudiante() {
        if ($('#nombres').val() == '' || $('#apellidos').val() == '' || $('#resultados_padres').val() == 'A' ||
            $('#descuento').val() == 'A' || $('#pension').val() == 'A' ||
            $('#recargo').val() == 'A' || $('#estado').val() == 'A' || $('#cartera').val() == '') {
            alertify.message("debes llenar todos los campos");
        } else {
            cadena = "form1=" + $('#nombres').val() +
                "&form2=" + $('#apellidos').val() +
                "&form3=" + $('#resultados_padres').val() +
                "&form4=" + $('#descuento').val() +
                "&form5=" + $('#pension').val() +
                "&form6=" + $('#recargo').val() +
                "&form7=" + $('#estado').val() +
                "&form8=" + $('#cartera').val() +
                "&form9=" + $('#grado').val()+
                "&form10=" + $('#id').val();
            $.ajax({
                type: "POST",
                url: "../../controller/actualizar_estudiante.php", //validacion de datos de registro
                data: cadena,
                success: function(r) {
                    if (r == 1) {
                        alertify.message("Estudiante actualizado");
                        tabla_estudiantes();
                        $('#tabla_consulta').load("temp_estudiantes.php");
                        return false;
                    } else if (r == 3) {
                        alertify.error("Error actualizando estudiante");
                        return false;
                    } else {
                        alertify.error("Error al actualizar");
                        return false;
                    }
                }
            });
        }
    }
</script>