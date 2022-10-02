<?php
session_start();
 ?>
 <style>
    .table-sm td{padding: 0 0.3rem 0 0.3rem !important;}
 </style>
            <table class="table table-bordered table-sm mt-4">
                <tr class="table-info text-dark">
                    <td>Nombres</td>
                    <td>% Desc.</td>
                    <td>Recargo</td>
                    <td>Cartera</td>
                    <td>Suma del Mes</td>
                    <td>Pagos del Mes</td>
                    <td>Cartera Total</td>
                </tr>
            
      <?php
      if (isset($_SESSION['consulta_pagos'])):
        foreach (@$_SESSION['consulta_pagos'] as $key) {
        $dat=explode("||", $key);
       ?>
       <tr>
                <td><?php echo $dat[3]." ".$dat[2]; ?></td>
                <td><?php echo $dat[7]; ?></td>
                <td><?php if($dat[11] == 1){ echo "Aplicado";}?></td>
                <td><?php echo number_format($dat[4]); ?></td>
                <td><?php echo number_format($dat[5]); ?></td>
                <td><?php echo number_format($dat[6]); ?></td>
                <td <?php ?>><?php echo number_format(($dat[4]+($dat[5]-$dat[6]))); ?></td>
        </tr>

<?php }  endif;?>
</table>
    