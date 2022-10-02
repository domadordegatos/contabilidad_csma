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
        <td>Id</td>
        <td>Nombres</td>
        <td>Grado</td>
        <td>Edición</td>
    </tr>

    <?php
    if (isset($_SESSION['temp_listado_estudiantes'])) :
        foreach (@$_SESSION['temp_listado_estudiantes'] as $key) {
            $dat = explode("||", $key);
    ?>
            <tr>
                <td><?php echo $dat[0]; ?></td>
                <td><?php echo $dat[1] . " " . $dat[2]; ?></td>
                <td><?php echo $dat[3]; ?></td>
                <td> <button class="btn btn-info btn-sm" onclick="cargar_datos(<?php echo $dat[0]; ?>)">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                        </svg>
                    </button> </td>
            </tr>

    <?php }
    endif; ?>
</table>