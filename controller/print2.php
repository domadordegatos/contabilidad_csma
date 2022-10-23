<?php
require_once "../model/conexion.php";
$conexion = conexion();
session_start();
$user = $_SESSION['user'];
if ($user != '') {
    require_once "../model/libraries/lib.php";
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
                </div>
                <div class="col-sm-3 text-center">
                    <img width="90%" src="../view/media/recursos/logo-ticket.png" alt="">
                </div>
            </div>
        </div>

        <div class="contendor">
            <table class="table table-bordered table-sm mt-4">
                <tr class="table-info text-dark">
                    <td>#</td>
                    <td>Id R.</td>
                    <td>Estudiante</td>
                    <td>Grado</td>
                    <td>Pagante</td>
                    <td>Cedula</td>
                    <td>Valor</td>
                    <td>Facturador</td>
                    <td>Fecha</td>
                </tr>
    
                <?php
                if (isset($_SESSION['temp_registro_pagos'])) : $i = 0;
                    foreach (@$_SESSION['temp_registro_pagos'] as $key) {
                        $dat = explode("||", $key);
                        $i = $i + 1;
                ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo $dat[0]; ?></td>
                            <td class="text-uppercase"><?php echo $dat[1] . " " . $dat[2]; ?></td>
                            <td><?php echo $dat[3]; ?></td>
                            <td class="text-uppercase"><?php echo $dat[4]; ?></td>
                            <td><?php echo $dat[5]; ?></td>
                            <td>$ <?php echo number_format($dat[6]); ?></td>
                            <td><?php echo $dat[7]; ?></td>
                            <td><?php echo $dat[8]; ?></td>
                        </tr>
    
                <?php }
                endif; ?>
            </table>
        </div>


    </body>

    </html>

<?php
} else {
    /*  echo "sin sesion"; */
    header("location:../view/login/index.html");
}
?>