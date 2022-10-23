<?php
session_start();
?>
<style>
    .table-sm td {
        padding: 0 0.3rem 0 0.3rem !important;
    }
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
        <td>Imp.</td>
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
                <td>
                    <button class="btn btn-sm btn-warning ml-1" id="print" onclick="print(<?php echo $dat[0]; ?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-printer" viewBox="0 0 16 16">
                            <path d="M2.5 8a.5.5 0 1 0 0-1 .5.5 0 0 0 0 1z" />
                            <path d="M5 1a2 2 0 0 0-2 2v2H2a2 2 0 0 0-2 2v3a2 2 0 0 0 2 2h1v1a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2v-1h1a2 2 0 0 0 2-2V7a2 2 0 0 0-2-2h-1V3a2 2 0 0 0-2-2H5zM4 3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1v2H4V3zm1 5a2 2 0 0 0-2 2v1H2a1 1 0 0 1-1-1V7a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v3a1 1 0 0 1-1 1h-1v-1a2 2 0 0 0-2-2H5zm7 2v3a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1v-3a1 1 0 0 1 1-1h6a1 1 0 0 1 1 1z" />
                        </svg>
                    </button>

                </td>
            </tr>

    <?php }
    endif; ?>
</table>