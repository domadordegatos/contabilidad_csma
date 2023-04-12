<?php
    require_once "../model/conexion.php";
    $conexion = conexion();
	session_start();
    $user = $_SESSION['user'];
	if($user != ''){
    require_once "../model/libraries/lib.php";

    $id= $_GET["id"];
        $sql="SELECT pagos_generales.id_pago, pagos_generales.fecha, pagos_generales.valor, pagos_generales.concepto, pagos_generales.pagante, pagos_generales.cedula,
        pagos_generales.codigo, asuntos.codigo, asuntos.descripcion, estudiantes.nombres, estudiantes.apellidos, medio_pago.descripcion, grados.descripcion  
        FROM pagos_generales
        JOIN asuntos ON asuntos.id_asunto = pagos_generales.id_asunto
        JOIN estudiantes ON estudiantes.id_estudiante = pagos_generales.id_estudiante
        JOIN medio_pago ON medio_pago.id_medio = pagos_generales.id_medio
        JOIN grados ON grados.id_grado = pagos_generales.id_grado
        WHERE pagos_generales.id_pago = '$id' ORDER BY pagos_generales.id_pago desc";
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
                    <div class="col-sm-12 text-right"><label style="font-size: 2rem;"><b>Recibo No. <code><?php echo $data[7]."-".$data[6]; ?></code></b></label></div>
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
                    <div class="col-sm-3 text-uppercase"><b><?php echo $data[12]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Quien paga:</div>
                    <div class="col-sm-8 text-uppercase"><b><?php echo $data[4]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Nombre del estudiante:</div>
                    <div class="col-sm-8"><b><?php echo $data[10]." ".$data[9]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 border-bottom">
                <div class="row">
                    <div class="col-sm-3">Concepto:</div>
                    <div class="col-sm-9 text-uppercase"><b><?php echo $data[8]." - ".$data[3]; ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-6 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Medio de pago:</div>
                    <div class="col-sm-4 text-uppercase"><b><?php echo $data[11]; ?></b></div>
                </div>
            </div>
            <div class="col-sm-6 border-bottom">
                <div class="row">
                    <div class="col-sm-4">Total Cancelado:</div>
                    <div class="col-sm-4 text-uppercase"><b>$ <?php echo number_format($data[2]); ?></b></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-2 border-bottom">Saldo:</div>
            <div class="col-sm-10 border-bottom"><b>$</b></div>
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