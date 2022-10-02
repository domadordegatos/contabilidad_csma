<?php
session_start();
 ?>
 <style>
    .table-sm td{padding: 0 0.3rem 0 0.3rem !important;}
 </style>
            <table class="table table-bordered table-sm mt-4">
                <tr class="table-info text-dark">
                    <td>Id</td>
                    <td>Nombre</td>
                    <td>Grado</td>
                    <td>Valor</td>
                    <td>Fecha</td>
                </tr>
            
      <?php
      if (isset($_SESSION['temp_matriculas'])):
        foreach (@$_SESSION['temp_matriculas'] as $key) {
        $dat=explode("||", $key);
       ?>
       <tr>
                <td><?php echo $dat[0]; ?></td>
                <td><?php echo $dat[1]." ".$dat[2]; ?></td>
                <td><?php echo $dat[3]; ?></td>
                <td><?php echo number_format($dat[4]); ?></td>
                <td><?php echo $dat[5]; ?></td>
        </tr>

<?php }  endif;?>
</table>
    