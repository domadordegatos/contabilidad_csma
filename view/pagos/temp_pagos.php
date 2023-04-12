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
                    <td>Suma Mes</td>
                    <td>Pagos Mes</td>
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
                <td><?php echo number_format($dat[13]); if($dat[12]>0){?><b><code>*</code></b><?php } ?></td><!-- cartera => cartera a fecha-->
                <td><?php echo number_format($dat[5]); ?></td>
                <td><?php echo number_format($dat[6]); ?></td>
                <td <?php ?>><?php if($dat[12]>0){echo number_format($dat[14]+$dat[12]);}else{
                    echo number_format($dat[14]);
                } ?></td>
        </tr>

<?php }  endif;?>
</table>
    