<?php
    require_once "../model/conexion.php";
    $conexion = conexion();
	session_start();
    $user = $_SESSION['user'];
	if($user != ''){
    require_once "../model/libraries/lib.php";

    $id= $_GET["id"];
    $sql="SELECT id_registro FROM registro_pagos ORDER BY id_registro DESC LIMIT 1";
    $result = mysqli_query($conexion, $sql);
    $last_id = mysqli_fetch_row($result);
        if($id == 'A'){ $id=$last_id[0]; }
        $sql="SELECT registro_pagos.id_registro, registro_pagos.fecha_pago, grados.descripcion, registro_pagos.nombre, estudiantes.apellidos, estudiantes.nombres,
            registro_pagos.concepto, medio_pago.descripcion, registro_pagos.valor_consignado, registro_pagos.cartera_a_dia
            FROM registro_pagos
            INNER JOIN grados ON grados.id_grado = registro_pagos.grado
            INNER JOIN estudiantes ON estudiantes.id_estudiante = registro_pagos.id_estudiante
            INNER JOIN medio_pago ON medio_pago.id_medio = registro_pagos.medio_pago
            WHERE registro_pagos.id_registro = '$id'";
            $result = mysqli_query($conexion, $sql);
            $data = mysqli_fetch_row($result);
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TICKET</title>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js" integrity="sha384-oBqDVmMz9ATKxIep9tiCxS/Z9fNfEXiDAYTujMAeBAsjFuCZSmKbSSUnQlmh/jp3" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.min.js" integrity="sha384-IDwe1+LCz02ROU9k972gdyvl+AESN10+x7tBKgc9I5HFtuNz0wWnPclzo6p9vxnk" crossorigin="anonymous"></script>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col-sm-12">Colegio San Mateo Apostol</div>
                </div>
                <div class="row">
                    <div class="col-sm-12">Nit: 900.221.419 - 5</div>
                </div>
                <div class="row">
                    <div class="col-sm-12">Resolucion Secretaria de Educación y Cultura Municipial 1090 de 2017</div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">Calle 19 # 5 - 142 barrio Bona Habitad Cel: 3112354190 - 3107814496 - Yopal Casanare</div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-center">www.csmayopal.edu.co</div>
                </div>
                <div class="row">
                    <div class="col-sm-12 text-right"><label style="font-size: 2rem;"><b>Recibo No. <code><?php echo $data[0]; ?></code></b></label></div>
                </div>
            </div>
            <div class="col-sm-3 text-center">
                <img width="90%" src="../view/media/recursos/logo-ticket.png" alt="">
            </div>
        </div>

        <div class="row">
            <div class="col-sm-5 border-bottom">
                <div class="row">
                    <div class="col-sm-3">Fecha:</div>
                    <div class="col-sm-9 text-center"><b><?php echo $data[1]; ?></b></div>
                </div>
            </div>
            <div class="col-sm-7 border-bottom">
                <div class="row">
                    <div class="col-sm-3">Grado:</div>
                    <div class="col-sm-3 text-uppercase"><b><?php echo $data[2]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Quien paga:</div>
                    <div class="col-sm-8 text-uppercase"><b><?php echo $data[3]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Nombre del estudiante:</div>
                    <div class="col-sm-8"><b><?php echo $data[4]." ".$data[5]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-bottom">
                <div class="row">
                    <div class="col-sm-3">Concepto:</div>
                    <div class="col-sm-9 text-uppercase"><b><?php echo $data[6]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Medio de pago:</div>
                    <div class="col-sm-4 text-uppercase"><b><?php echo $data[7]; ?></b></div>
                </div>
            </div>
            <div class="col-sm-6 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Total Cancelado:</div>
                    <div class="col-sm-4 text-uppercase"><b>$ <?php echo number_format($data[8]); ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 border-bottom">Saldo:</div>
            <div class="col-sm-10 border-bottom"><b>$ <?php echo number_format($data[9]); ?></b></div>
        </div>

        <div class="row pt-5 mt-2">
            <div class="col-sm-7"></div>
            <div class="col-sm-5 text-center">_______________________________________</div>
        </div>
        <div class="row">
            <div class="col-sm-7"></div>
            <div class="col-sm-5 text-center">FIRMA:</div>
        </div>

    </div>

</body>

</html>

<?php
} else {
 /*  echo "sin sesion"; */
	header("location:../view/login/index.html");
	}
?>