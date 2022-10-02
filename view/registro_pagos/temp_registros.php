<?php
session_start();
 ?>
 <style>
    .table-sm td{padding: 0 0.3rem 0 0.3rem !important;}
 </style>
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
      if (isset($_SESSION['temp_registro_pagos'])): $i=0;
        foreach (@$_SESSION['temp_registro_pagos'] as $key) {
        $dat=explode("||", $key); $i=$i+1;
       ?>
       <tr>
                <td><?php echo $i; ?></td>
                <td><?php echo $dat[0]; ?></td>
                <td><?php echo $dat[1]." ".$dat[2]; ?></td>
                <td><?php echo $dat[3]; ?></td>
                <td><?php echo $dat[4]; ?></td>
                <td><?php echo $dat[5]; ?></td>
                <td><?php echo number_format($dat[6]); ?></td>
                <td><?php echo $dat[7]; ?></td>
                <td><?php echo $dat[8]; ?></td>
        </tr>

<?php }  endif;?>
</table>
    