<?php
	session_start();
	if(isset($_SESSION['user'])){
    $user = $_SESSION['user'];
          require_once "../../model/conexion.php";
          $conexion=conexion();
    $sql="SELECT * FROM usuarios JOIN roles ON roles.id_rol = usuarios.rol  where usuarios.user = '$user'";
    $result=mysqli_query($conexion,$sql); $ver=mysqli_fetch_row($result);
 ?>

<nav class="navbar navbar-expand-lg navbar-light sticky-top" style="background-color: #e3f2fd; padding: 0.2rem 1rem;">
  <a class="navbar-brand" style="padding-bottom: 0px;" href="../home/index.php">
    <img src="../media/recursos/logo.png" width="40px" height="40px" alt=""></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
    aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <?php if($ver[3] == 2 || $ver[3] == 3){ ?>
        <li class="nav-item active">
        <a class="nav-link" href="../pagos/index.php">Pagos</a>
        </li>
      <?php } ?>
      <?php if($ver[3] == 3 || $ver[3] == 1){ ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_ventas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          Cartera
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown_ventas">
          <a class="dropdown-item" href="../pagos_generales/index.php">Cartera Mes</a>
          <a class="dropdown-item" href="../registro_pagos/index.php">Historial de Pagos</a>
        </div>
      </li>
      <?php } ?>
      <?php if($ver[3] == 2 || $ver[3] == 3){ ?>
      <li class="nav-item dropdown active">
        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown_ventas" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        Gestión
        </a>
        <div class="dropdown-menu" aria-labelledby="navbarDropdown_ventas">
          <a class="dropdown-item" href="../c_estudiantes/index.php">Estudiantes</a>
          <a class="dropdown-item" href="../c_responsables/index.php">Acudientes</a>
          <a class="dropdown-item" href="../c_matriculas/index.php">Matriculas</a>
        </div>
      </li>
      <?php } ?>
    </ul>
    <ul class="navbar-nav">
      <li class="d-flex align-items-center mr-3">
        <strong>
          <?php echo $user."--"; ?>
        </strong>
       <strong>
          <?php echo $ver[5]; ?>
        </strong>
      </li>
      <li><a href="../../controller/salir.php" class="btn btn-info">
          <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-door-closed"
            viewBox="0 0 16 16">
            <path d="M3 2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v13h1.5a.5.5 0 0 1 0 1h-13a.5.5 0 0 1 0-1H3V2zm1 13h8V2H4v13z" />
            <path d="M9 9a1 1 0 1 0 2 0 1 1 0 0 0-2 0z" />
          </svg>
          Salir</a></li>
    </ul>
  </div>
</nav>
<?php
} else {
 /*  echo "sin sesion"; */
	header("location:../login/index.html");
	}
?>