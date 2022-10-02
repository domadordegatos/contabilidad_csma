<?php
session_start();

class gestion2
{
    function buscar_cartera($grado)
    {
        $fecha = $_SESSION['fecha_busqueda'];
        unset($_SESSION['consulta_pagos']);
        require_once "../../model/conexion.php";
        $conexion = conexion();
        $sql = "SELECT * FROM gestion_cartera
        JOIN estudiantes ON estudiantes.id_estudiante = gestion_cartera.id_estudiante
        JOIN descuentos ON descuentos.id_descuento = estudiantes.descuento
        JOIN recargos ON recargos.id_recagos = gestion_cartera.estado_recargo
        JOIN grados ON grados.id_grado = gestion_cartera.grado
        WHERE gestion_cartera.grado = '$grado' AND gestion_cartera.fecha = '$fecha' and not estudiantes.id_estudiante = 28 order by estudiantes.apellidos asc";
        $result = mysqli_query($conexion, $sql);
        if (mysqli_num_rows($result) <= 0) {
            
        } else {
            return $result;
        }
    }
}
?>
<style>
    .table-sm td {
        padding: 0 0.3rem 0 0.3rem !important;
    }
</style>
<table class="table table-sm table-bordered table-striped">
    <tr class="table-info text-dark">
        <th>Grado</th>
        <th>Nombres</th>
        <th>% Desc.</th>
        <th>Recargo</th>
        <th>Cartera</th>
        <th>Suma del Mes</th>
        <th>Pagos del Mes</th>
        <th>Cartera Total</th>
    </tr>

    <?php
    if (isset($_SESSION['temp_registro_mensualidad'])) :
        $t1 = 0; $t2 = 0; $t3 = 0; $t4 = 0;
        foreach (@$_SESSION['temp_registro_mensualidad'] as $key) {
            $dat = explode("||", $key);

            $result = gestion2::buscar_cartera($dat[0]);
            if($result){
            $g1 = 0; $g2 = 0; $g3 = 0; $g4 = 0; $total = 0;
            while ($ver = mysqli_fetch_row($result)) {  ?>
                <tr><?php $total = ($ver[18] + ($ver[4] - $ver[5])); ?>
                    <th><?php echo $ver[27]; ?></th>
                    <td><?php echo $ver[12] . " " . $ver[11]; ?></td>
                    <td><?php echo $ver[22]; ?></td>
                    <td><?php if ($ver[3] == 1) { echo "Aplicado"; } ?></td>
                    <td><?php echo number_format($ver[18]); ?></td>
                    <td><?php echo number_format($ver[4]); ?></td>
                    <td><?php echo number_format($ver[5]); ?></td>
                    <td><?php echo number_format($ver[9]); ?></td>
              <?php if ($ver[18] > 0) { $g1 = $g1 + $ver[18]; }
                    if ($ver[4] > 0) { $g2 = $g2 + $ver[4]; }
                    if ($ver[5] > 0) { $g3 = $g3 + $ver[5]; }
                    if ($total > 0) { $g4 = $g4 + $total; } ?>
                </tr> <?php } 
                $t1=$t1+$g1; $t2=$t2+$g2; $t3=$t3+$g3; $t4=$t4+$g4; 
                ?>
            <tr class="table-info">
                <td colspan="4"></td>
                <td><b><?php echo number_format($g1); ?></b></td>
                <td><b><?php echo number_format($g2); ?></b></td>
                <td><b><?php echo number_format($g3); ?></b></td>
                <td><b><?php echo number_format($g4); ?></b></td>
            </tr>

        <?php }} ?>

        <tr class="table-primary">
            <td colspan="4"></td>
            <td><b><?php echo number_format($t1); ?></b></td>
            <td><b><?php echo number_format($t2); ?></b></td>
            <td><b><?php echo number_format($t3); ?></b></td>
            <td><b><?php echo number_format($t4); ?></b></td>
        </tr>

    <?php endif; ?>
</table>