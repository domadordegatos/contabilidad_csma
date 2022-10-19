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
    <title>Registro General</title>
</head>

<body>
    <div class="contenedor w-100">
        <div class="separador1 m-3">
            <h4>Cartera General del Mes</h4>
            <div class="row mb-2">
                <div class="col-sm-3">
                    <select class="form-control form-control-sm" name="" id="mes">
                        <option value="A">Meses...</option>
                        <?php $sql = "SELECT fecha FROM gestion_cartera GROUP BY fecha DESC  LIMIT 10";
                        $result = mysqli_query($conexion, $sql);
                        while ($ver = mysqli_fetch_row($result)) : ?>
                            <option value=<?php echo $ver[0]; ?>><?php echo $ver[0]; ?></option>
                        <?php endwhile; ?>
                    </select>
                </div>
                <div class="col-sm-2">
                    <button class="btn btn-info btn-sm" onclick="buscar_mensualidad()">Buscar</button>
                </div>
            </div>

        </div>
        <div class="separador2 p-3">
        <div class="row">
                <div class="col-sm-12">
                    <div id="tabla_consulta"></div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>

<script>
   function buscar_mensualidad(){
        if($('#mes').val() == 'A'){
                alertify.message("Selecciona todos los campos");
            }else{
            cadena="form1=" + $('#mes').val();
                   
            $.ajax({
              type:"POST",
              url:"../../controller/buscar_mensualidad_general.php", //validacion de datos de registro
              data:cadena,
              success:function(r){
                if(r==1){
                    $('#tabla_consulta').load("temp_pagos.php");
                    alertify.message("Planilla encontrada");
                    return false;
                }else{
                    $('#tabla_consulta').load("temp_pagos.php");
                    alertify.error("Error no se encontro nada");
                    return false;
                }
              }
            });
        }
        }
</script>