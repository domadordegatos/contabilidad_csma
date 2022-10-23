<?php
class gestion{

  function buscar_tabla_padres(){
    unset($_SESSION['temp_padres']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT p.id_padre, p.apellidos, p.nombres, p.celular FROM padres as p ORDER BY id_padre DESC";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //id
                 $ver1[1] . "||" . //apellidos
                 $ver1[2] . "||" . //nombres
                 $ver1[3] . "||"; //celular
        $_SESSION['temp_padres'][] = $tabla;
      }
      echo 1;
    }
  }

  function agregar_padre(){
    $nombres = $_POST['form1'];
    $apellidos = $_POST['form2'];
    $celular = $_POST['form3'];
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT * FROM padres WHERE nombres = '$nombres' AND apellidos = '$apellidos'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      $sql = "INSERT INTO padres VALUES ('','$nombres','$apellidos','$celular')";
      $result = mysqli_query($conexion, $sql);
      if ($result) {
        return 1;
      }else{
        return 3;
      }
    } else {/*  ya existe este usuario */
      return 2;
    }
  }

  function buscar_tabla_matriculas(){
    unset($_SESSION['temp_matriculas']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT r.id_registro, e.apellidos, e.nombres, g.descripcion, r.valor_consignado, r.fecha_pago FROM registro_pagos AS r
    INNER JOIN estudiantes AS e ON e.id_estudiante = r.id_estudiante
    INNER JOIN grados AS g ON g.id_grado = r.grado WHERE id_movimiento = 3 ORDER BY r.id_registro desc";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //id
                 $ver1[1] . "||" . //apellidos
                 $ver1[2] . "||" . //nombres
                 $ver1[3] . "||". //grado
                 $ver1[4] . "||". //valor
                 $ver1[5] . "||"; //fecha
        $_SESSION['temp_matriculas'][] = $tabla;
      }
      echo 1;
    }
  }

  function buscar_mensualidad_general(){
    unset($_SESSION['temp_registro_mensualidad']);
    unset($_SESSION['fecha_busqueda']);
    $mes = $_POST['form1'];
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT id_grado FROM grados WHERE estado = 1";
        $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||"; //id grado
        $_SESSION['temp_registro_mensualidad'][] = $tabla;
        $_SESSION['fecha_busqueda'] = $mes;
      }
      echo 1;
    }
  }

  /* function crear_matricula(){
    date_default_timezone_set('America/Bogota');
    $valor = $_POST['form1']; $id = $_POST['form2']; $nombre = $_POST['form3']; $cedula = $_POST['form4']; $fecha = date('Y-m-d');
    $time = time();
    $hora = date("H:i:s", $time);
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT valor FROM valor_matricula";
    $result = mysqli_query($conexion, $sql);
    $v_matricula = mysqli_fetch_row($result);
    $user = $_SESSION['user'];

    $id_grado = self::id_grado($id);
    $id_admin = self::id_admin($user);
    $sql1 = "SELECT * FROM registro_pagos WHERE id_estudiante = '$id' AND id_movimiento = 3 AND grado = '$id_grado'";
    $result = mysqli_query($conexion, $sql1);

    $sql2 = "SELECT * FROM gestion_cartera WHERE id_estudiante = '$id' ORDER BY fecha DESC LIMIT 1";
    $result2 = mysqli_query($conexion, $sql2);
    $codigo = mysqli_fetch_row($result2);

      if ($valor < $v_matricula) {
        $sql = "INSERT INTO registro_pagos VALUES ('','$id_admin','$id',3,'$valor',2,'$fecha','$hora','$codigo[0]',0,'$valor','$nombre','$cedula','$id_grado')";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
          $sql3 = "SELECT cartera FROM estudiantes WHERE id_estudiante = '$id'"; $result3 = mysqli_query($conexion, $sql3); $cartera_previa = mysqli_fetch_row($result3); $suma_cartera = 0;

          $sql4 = "SELECT valor FROM valor_matricula"; $result4 = mysqli_query($conexion, $sql4); $val_matricula = mysqli_fetch_row($result4);

          $suma_cartera =$cartera_previa[0] + ($val_matricula[0]-$valor);

          $sql = "UPDATE estudiantes SET cartera = '$suma_cartera' where id_estudiante = '$id'";
          $result = mysqli_query($conexion, $sql);
          
          $saldo_nuevo = $suma_cartera + ($codigo[4] - $codigo[5]);//nueva cartera al ser creada

          $sql = "UPDATE gestion_cartera SET cartera = '$saldo_nuevo' where id_estudiante = '$id'";
          $result = mysqli_query($conexion, $sql);

          if($result){
            return 1;
          }else{
            return 3; //problema actualizando cartera 
          }
        } else {// eror creando registro 
          return 4;
        }
      } else {
        $sql = "INSERT INTO registro_pagos VALUES ('','$id_admin','$id',3,'$valor',2,'$fecha','$hora','$codigo[0]',0,'$valor','$nombre','$cedula','$id_grado')";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
          return 1;
        } else {
          return 4;
        }
      }
  } */

  function crear_matricula(){
    date_default_timezone_set('America/Bogota');
    $valor = $_POST['form1']; $id = $_POST['form2']; $nombre = $_POST['form3']; $cedula = $_POST['form4']; $fecha = date('Y-m-d');
    $time = time();
    $hora = date("H:i:s", $time);
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT valor FROM valor_matricula";
    $result = mysqli_query($conexion, $sql);
    $v_matricula = mysqli_fetch_row($result);
    $user = $_SESSION['user'];

    $id_grado = self::id_grado($id);
    $id_admin = self::id_admin($user);
    $sql1 = "SELECT * FROM registro_pagos WHERE id_estudiante = '$id' AND id_movimiento = 3 AND grado = '$id_grado'";
    $result = mysqli_query($conexion, $sql1);

    $sql2 = "SELECT * FROM gestion_cartera WHERE id_estudiante = '$id' ORDER BY fecha DESC LIMIT 1";
    $result2 = mysqli_query($conexion, $sql2);
    $codigo = mysqli_fetch_row($result2);

      if ($valor < $v_matricula) {
        $restante = $v_matricula[0] - $valor;

        $sql = "INSERT INTO registro_pagos VALUES ('','$id_admin','$id',3,'$valor',2,'$fecha','$hora','$codigo[0]',0,'$valor','$nombre','$cedula','$id_grado','Matrícula',1,'$restante')";

        $result = mysqli_query($conexion, $sql);
        if ($result) {

          $sql = "UPDATE estudiantes SET matricula = matricula + '$restante' where id_estudiante = '$id'";
          $result = mysqli_query($conexion, $sql);

          if($result){
            return 1;
          }else{
            return 3;/* problema actualizando cartera */
          }
        } else {/* eror creando registro */
          return 4;
        }
      } else {
        $sql = "INSERT INTO registro_pagos VALUES ('','$id_admin','$id',3,'$valor',2,'$fecha','$hora','$codigo[0]',0,'$valor','$nombre','$cedula','$id_grado','Matrícula',1,0)";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
          return 1;
        } else {
          return 4;
        }
      }
  }



  public function editar_estudiante_datos($idest){//////////////////////////////// ////  cuidadooooooooooooooooooooooo
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT * FROM estudiantes JOIN padres ON padres.id_padre = estudiantes.id_padre  WHERE id_estudiante= '$idest'";
    $result = mysqli_query($conexion, $sql);

    $ver = mysqli_fetch_row($result);
    $datos = array(
      "0" => $ver[0], //id
      "1" => $ver[1], //nombre
      "2" => $ver[2], //apellidos
      "3" => $ver[3], //grado
      "4" => $ver[4], //estado
      "5" => $ver[5], //idpadre
      "7" => $ver[7], //descuento
      "8" => $ver[8], //cartera
      "9" => $ver[9], //pension
      "10" => $ver[10], //recargo
      "12" => $ver[13], //nombre padre
    );
    return $datos;
  }

  function listado_estudiantes()
  {
    unset($_SESSION['temp_listado_estudiantes']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT id_estudiante, apellidos, nombres, grados.descripcion, estudiantes.estado FROM estudiantes
    JOIN grados ON grados.id_grado = estudiantes.grado
    ORDER BY estudiantes.grado ASC, estudiantes.estado ASC, estudiantes.apellidos ASC";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //id
          $ver1[1] . "||" . //apellidos
          $ver1[2] . "||" . //nombres
          $ver1[3] . "||". //grado
          $ver1[4] . "||"; //estado
        $_SESSION['temp_listado_estudiantes'][] = $tabla;
      }
      echo 1;
    }
  }

  function crear_cartera_individual(){
    date_default_timezone_set('America/Bogota');
    $nombres = $_POST['form1'];
    $apellidos = $_POST['form2'];
    $padre = $_POST['form3'];
    $descuento = $_POST['form4'];
    $pension = $_POST['form5'];
    $grado = $_POST['form9'];
    $recargo = $_POST['form6'];
    $estado = $_POST['form7'];
    $cartera = $_POST['form8'];
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT * FROM estudiantes WHERE nombres = '$nombres' AND apellidos = '$apellidos'";
    $result = mysqli_query($conexion, $sql);
    $id_estudiante = mysqli_fetch_row($result);
    if (mysqli_num_rows($result) <= 0) {
      return 2;
    } else {
      $sql1 = "SELECT id_mes_grado, fecha FROM gestion_cartera WHERE grado = '$grado' ORDER BY fecha DESC LIMIT 1 ";
      $result = mysqli_query($conexion, $sql1);
      $gestion_c = mysqli_fetch_row($result);

      $sql3 = "SELECT fecha FROM gestion_cartera ORDER BY fecha DESC LIMIT 1";
      $result3 = mysqli_query($conexion, $sql3);
      $fecha_g_c = mysqli_fetch_row($result3);

      $sql5="SELECT * FROM gestion_cartera WHERE id_estudiante = '$id_estudiante[0]' AND fecha = '$fecha_g_c[0]'";

      $result5 = mysqli_query($conexion, $sql5);
      if (mysqli_num_rows($result5) <= 0){

      $sql = "INSERT INTO gestion_cartera VALUES ('','$gestion_c[0]','$id_estudiante[0]','2','$cartera',0,1,'$fecha_g_c[0]','$grado',$cartera,0)";
      $result = mysqli_query($conexion, $sql);
      if ($result) {
        return 1; /* registro existoso */
      } else {
        return 3; /* no inserto el registro de cartera*/
      }
    }else{
      return 4;
    }
    }
  }

  function crear_estudiante_cartera(){
    date_default_timezone_set('America/Bogota');
    $nombres = $_POST['form1'];
    $apellidos = $_POST['form2'];
    $padre = $_POST['form3'];
    $descuento = $_POST['form4'];
    $pension = $_POST['form5'];
    $grado = $_POST['form9'];
    $recargo = $_POST['form6'];
    $estado = $_POST['form7'];
    $cartera = $_POST['form8'];
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT * FROM estudiantes WHERE nombres = '$nombres' AND apellidos = '$apellidos'";
    $result = mysqli_query($conexion, $sql);
    $last_fecha = mysqli_fetch_row($result);
    if (mysqli_num_rows($result) <= 0) {
      $sql = "INSERT INTO estudiantes VALUES ('','$nombres','$apellidos','$grado','$estado','$padre','$padre','$descuento',0,'$pension','$recargo',0)";
      $result = mysqli_query($conexion, $sql);
      if ($result) {
        $sql1 = "SELECT id_mes_grado, fecha FROM gestion_cartera WHERE grado = '$grado' ORDER BY fecha DESC LIMIT 1 ";
        $result = mysqli_query($conexion, $sql1);
        $gestion_c = mysqli_fetch_row($result);

        $sql3 = "SELECT fecha FROM gestion_cartera ORDER BY fecha DESC LIMIT 1";
        $result3 = mysqli_query($conexion, $sql3);
        $fecha_g_c = mysqli_fetch_row($result3);

        $sql2 = "SELECT id_estudiante FROM estudiantes ORDER BY id_estudiante DESC LIMIT 1 ";
        $result2 = mysqli_query($conexion, $sql2);
        $id_estudiante = mysqli_fetch_row($result2);

        $sql = "INSERT INTO gestion_cartera VALUES ('','$gestion_c[0]','$id_estudiante[0]','2','$cartera',0,1,'$fecha_g_c[0]','$grado',$cartera,0)";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
          return 1; /* registro existoso */
        } else {
          return 4; /* no inserto el registro de cartera*/
        }
      } else {
        echo 3;/* no se creo el estudiante*/
      }
    } else {/*  ya existe este usuario */
      return 2;
    }
  }

  function agregar_estudiante(){
    date_default_timezone_set('America/Bogota');
    $nombres = $_POST['form1'];
    $apellidos = $_POST['form2'];
    $padre = $_POST['form3'];
    $descuento = $_POST['form4'];
    $pension = $_POST['form5'];
    $grado = $_POST['form9'];
    $recargo = $_POST['form6'];
    $estado = $_POST['form7'];
    $cartera = $_POST['form8'];
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT * FROM estudiantes WHERE nombres = '$nombres' AND apellidos = '$apellidos'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      $sql = "INSERT INTO estudiantes VALUES ('','$nombres','$apellidos','$grado','$estado','$padre','$padre','$descuento',0,'$pension','$recargo',0)";
      $result = mysqli_query($conexion, $sql);
      if ($result) {
        $sql1 = "SELECT id_mes_grado, fecha FROM gestion_cartera WHERE grado = '$grado' ORDER BY fecha DESC LIMIT 1 ";
        $result = mysqli_query($conexion, $sql1);
        $gestion_c = mysqli_fetch_row($result);

        $sql3 = "SELECT fecha FROM gestion_cartera ORDER BY fecha DESC LIMIT 1";
        $result3 = mysqli_query($conexion, $sql3);
        $fecha_g_c = mysqli_fetch_row($result3);

        $sql2 = "SELECT id_estudiante FROM estudiantes ORDER BY id_estudiante DESC LIMIT 1 ";
        $result2 = mysqli_query($conexion, $sql2);
        $id_estudiante = mysqli_fetch_row($result2);

        $sql = "INSERT INTO gestion_cartera VALUES ('','$gestion_c[0]','$id_estudiante[0]','2',0,0,1,'$fecha_g_c[0]','$grado',0,0)";
        $result = mysqli_query($conexion, $sql);
        if ($result) {
          return 1; /* registro existoso */
        } else {
          return 4; /* no inserto el registro de cartera*/
        }
      } else {
        echo 3;/* no se creo el estudiante*/
      }
    } else {/*  ya existe este usuario */
      return 2;
    }
  }

  function actualizar_estudiante(){
    date_default_timezone_set('America/Bogota');
    $nombres = $_POST['form1'];
    $apellidos = $_POST['form2'];
    $padre = $_POST['form3'];
    $descuento = $_POST['form4'];
    $pension = $_POST['form5'];
    $grado = $_POST['form9'];
    $recargo = $_POST['form6'];
    $estado = $_POST['form7'];
    $cartera = $_POST['form8'];
    $id = $_POST['form10'];
    require_once "conexion.php";
    $conexion = conexion();
    $sql2 = "SELECT id_gestion, cartera FROM gestion_cartera WHERE id_estudiante = '$id' and estado_mes =1 order by fecha desc limit 1";
    $result2 = mysqli_query($conexion, $sql2);
    $cartera_previa = mysqli_fetch_row($result2);

    $sql3 = "SELECT cartera FROM estudiantes WHERE id_estudiante = '$id'";
    $result3 = mysqli_query($conexion, $sql3);
    $cartera_estudiante = mysqli_fetch_row($result3);


    $sql = "UPDATE estudiantes  SET nombres = '$nombres', apellidos ='$apellidos', grado = '$grado', estado ='$estado', id_padre ='$padre', descuento = '$descuento', cartera ='$cartera', pension ='$pension', recargo = '$recargo' WHERE id_estudiante= '$id' ";

    $result = mysqli_query($conexion, $sql);
    if ($result) {

      $primer_valor= $cartera_estudiante[0]-$cartera;
      $total = $cartera_previa[1] - $primer_valor;
      
      $sql = "UPDATE gestion_cartera  SET cartera = '$total' WHERE id_gestion= '$cartera_previa[0]'";
      $result = mysqli_query($conexion, $sql);
      if ($result) {
        return 1;
      } else {
        echo 3;/* no se actualizo el estudiante*/
      }
    }else{
      echo 4;
    }
  }

  function buscar_registros_pagos()
  {
    unset($_SESSION['temp_registro_pagos']);
    $id = $_POST['form1'];
    $cantidad = $_POST['form2'];
    require_once "conexion.php";
    $conexion = conexion();
    if ($cantidad == '') {
      $cantidad = 1000;
    }
    $sql = "SELECT registro_pagos.id_registro, estudiantes.apellidos, estudiantes.nombres, grados.descripcion, registro_pagos.nombre,
        registro_pagos.cedula, registro_pagos.valor_consignado, usuarios.nombre, registro_pagos.fecha_pago FROM registro_pagos
        JOIN usuarios ON usuarios.id_user = registro_pagos.id_admin
        JOIN estudiantes ON estudiantes.id_estudiante = registro_pagos.id_estudiante
        JOIN recargos ON recargos.id_recagos = registro_pagos.recargo
        JOIN grados ON grados.id_grado = registro_pagos.grado
        WHERE registro_pagos.id_estudiante= '$id' order by id_registro desc LIMIT $cantidad";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //id
          $ver1[1] . "||" . //apellidos
          $ver1[2] . "||" . //nombres
          $ver1[3] . "||" . //grado
          $ver1[4] . "||" . //pagante
          $ver1[5] . "||" . //cedula
          $ver1[6] . "||" . //valor
          $ver1[7] . "||" . //quien recibe
          $ver1[8] . "||"; //fecha
        $_SESSION['temp_registro_pagos'][] = $tabla;
      }
      echo 1;
    }
  }

  function crear_pago_matricula(){
    date_default_timezone_set('America/Bogota');
    $valor = $_POST['form1'];
    $id = $_POST['form2'];
    $nombre = $_POST['form3'];
    $cedula = $_POST['form4']; $concepto = $_POST['form5']; $medio_pago = $_POST['form6'];
    $fecha = date('Y-m-d');
    $nuevo_saldo = 0;
    $time = time();
    $hora = date("H:i:s", $time);
    require_once "conexion.php";
    $conexion = conexion();

    $sql1 = "SELECT * FROM gestion_cartera WHERE id_estudiante = '$id' AND estado_mes = 1 ORDER BY fecha DESC LIMIT 1";
    $result = mysqli_query($conexion, $sql1);

    $sql2 = "SELECT estudiantes.matricula FROM estudiantes WHERE id_estudiante = '$id'";
    $result2 = mysqli_query($conexion, $sql2);
    $matricula = mysqli_fetch_row($result2);

    if (mysqli_num_rows($result) <= 0) {
      return 2; // el usuario no tiene cartera o mes inactivo
    } else {
      $pagos_mes = mysqli_fetch_row($result);

      $sql = "UPDATE estudiantes SET matricula = matricula -'$valor' where id_estudiante = '$id'";
      $result = mysqli_query($conexion, $sql);
      if ($result) {

        $nuevo_saldo = $matricula[0] - $valor;

        $user = $_SESSION['user'];
        $id_admin = self::id_admin($user);
        $id_grado = self::id_grado($id);
        $sql = "INSERT INTO registro_pagos VALUES ('','$id_admin','$id',4,'$valor',2,'$fecha','$hora','$pagos_mes[0]','$matricula[0]','$nuevo_saldo','$nombre','$cedula','$id_grado','$concepto','$medio_pago','$nuevo_saldo')";
        $result = mysqli_query($conexion, $sql);

        if ($result) {
          echo 1;
        } else {
          return 4; /* no inserto el registro */
        }
      } else {
        echo 3;/* no se actualizo el abono */
      }
    }
  }

  function crear_pago(){
    date_default_timezone_set('America/Bogota');
    $valor = $_POST['form1'];
    $id = $_POST['form2'];
    $nombre = $_POST['form3'];
    $cedula = $_POST['form4']; $concepto = $_POST['form5']; $medio_pago = $_POST['form6'];
    $fecha = date('Y-m-d');
    $nuevo_saldo = 0;
    $time = time();
    $hora = date("H:i:s", $time);
    require_once "conexion.php";
    $conexion = conexion();

    $sql = "SELECT fecha FROM gestion_cartera ORDER BY fecha DESC LIMIT 1";
    $result = mysqli_query($conexion, $sql);
    $last_fecha = mysqli_fetch_row($result);

    $sql1 = "SELECT * FROM gestion_cartera WHERE id_estudiante = '$id' AND estado_mes = 1 ORDER BY fecha DESC LIMIT 1";
    $result = mysqli_query($conexion, $sql1);

    $sql2 = "SELECT cartera FROM estudiantes WHERE id_estudiante = '$id'";
    $result2 = mysqli_query($conexion, $sql2);
    $cartera_gestion = mysqli_fetch_row($result2);

    if (mysqli_num_rows($result) <= 0) {
      return 2; // el usuario no tiene cartera o mes inactivo
    } else {
      $pagos_mes = mysqli_fetch_row($result);
      $nuevo_saldo = $pagos_mes[5] + $valor;
      $duplicate_cartera = $cartera_gestion[0]+($pagos_mes[4]-$nuevo_saldo);
      $sql = "UPDATE gestion_cartera SET pagos_mes = '$nuevo_saldo', cartera = '$duplicate_cartera' where id_estudiante = '$id' and fecha = '$last_fecha[0]'";
      $result = mysqli_query($conexion, $sql);
      if ($result) {

        $user = $_SESSION['user'];
        $id_admin = self::id_admin($user);
        $id_grado = self::id_grado($id);
        $sql = "INSERT INTO registro_pagos VALUES ('','$id_admin','$id',2,'$valor','$pagos_mes[3]','$fecha','$hora','$pagos_mes[0]','$pagos_mes[5]','$nuevo_saldo','$nombre','$cedula','$id_grado','$concepto','$medio_pago','$duplicate_cartera')";
        $result = mysqli_query($conexion, $sql);

        if ($result) {
          echo 1;
        } else {
          return 4; /* no inserto el registro */
        }
      } else {
        echo 3;/* no se actualizo el abono */
      }
    }
  }


  function ob_datos_estudiante()
  {
    require_once "conexion.php";
    $conexion = conexion();
    $id = $_POST['form1'];

    $sql = "SELECT fecha FROM gestion_cartera ORDER BY fecha DESC LIMIT 1";
    $result = mysqli_query($conexion, $sql);
    $last_fecha = mysqli_fetch_row($result);

    $sql1 = "SELECT padres.apellidos, padres.nombres, padres.celular, estudiantes.apellidos,
        estudiantes.nombres, grados.descripcion, estudiantes.cartera, gestion_cartera.pagos_mes,
        gestion_cartera.saldo_mes FROM estudiantes
        JOIN grados ON grados.id_grado = estudiantes.grado
        JOIN padres ON padres.id_padre = estudiantes.id_padre OR padres.id_padre = estudiantes.id_madre
        JOIN gestion_cartera ON gestion_cartera.id_estudiante = estudiantes.id_estudiante
        WHERE gestion_cartera.fecha = '$last_fecha[0]' AND gestion_cartera.id_estudiante = '$id' and estudiantes.estado = 1";
    $result = mysqli_query($conexion, $sql1);
    if (mysqli_num_rows($result) <= 0) {
      return 2;
    }
    $ver = mysqli_fetch_row($result);
    $datos = array(
      "0" => $ver[0] . " " . $ver[1], //nombre y apellidos padre
      "2" => $ver[2], //celular
      "3" => $ver[3] . " " . $ver[4], //nombre est
      "5" => $ver[5], //grado
      "6" => $ver[6], //cartera
      "7" => $ver[7], //abonos
      "8" => $ver[8] //saldo mes
    );
    return $datos;
  }

  function buscador2()
  {

    unset($_SESSION['buscador']);
    $name = $_POST['form1'];
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT * FROM estudiantes WHERE apellidos LIKE ('%$name%' OR nombres LIKE '%$name%') and estado = 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[1] . "||" . //id
          $ver1[2] . "||" . //nombres
          $ver1[10] . "||" . //apellidos
          $ver1[11] . "||" . //grado
          $ver1[17] . "||" . //nombres padre
          $ver1[4] . "||" . //apellidos padre
          $ver1[5] . "||" . //nombres madre
          $ver1[21] . "||" . //apellidos madre
          $ver1[22] . "||" . //descuento
          $ver1[3] . "||" . //valor pension
          $ver1[6] . "||" . //cartera
          $ver1[3] . "||" . //saldo mes
          $ver1[3] . "||"; //pagos hechos mes
        $_SESSION['buscador'][] = $tabla;
      }
      echo 1;
    }
  }

  function buscador_datos_estudiante()
  {

    unset($_SESSION['buscador']);
    $name = $_POST['form1'];
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT id_estudiante, apellidos,  nombres FROM estudiantes WHERE (apellidos LIKE '%$name%' OR nombres LIKE '%$name%') and estado = 1";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //id
          $ver1[1] . "||" . //apellidos
          $ver1[2] . "||"; //nombres
        $_SESSION['buscador'][] = $tabla;
      }
      echo 1;
    }
  }

  function buscador_datos_padre()
  {

    unset($_SESSION['buscador']);
    $name = $_POST['form1'];
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT id_padre, apellidos,  nombres FROM padres WHERE apellidos LIKE '%$name%' OR nombres LIKE '%$name%'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //id
          $ver1[1] . "||" . //apellidos
          $ver1[2] . "||"; //nombres
        $_SESSION['buscador'][] = $tabla;
      }
      echo 1;
    }
  }

  function buscar_cartera()
  {

    unset($_SESSION['consulta_pagos']);
    $mes = $_POST['form1'];
    $grado = $_POST['form2'];
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT gestion_cartera.id_mes_grado, gestion_cartera.id_estudiante, estudiantes.nombres, estudiantes.apellidos, 
    estudiantes.cartera, gestion_cartera.saldo_mes, gestion_cartera.pagos_mes, descuentos.descripcion, descuentos.porcentaje, 
    gestion_cartera.estado_recargo, gestion_cartera.estado_mes, gestion_cartera.estado_recargo FROM gestion_cartera
            JOIN estudiantes ON estudiantes.id_estudiante = gestion_cartera.id_estudiante
            JOIN descuentos ON descuentos.id_descuento = estudiantes.descuento
            JOIN recargos ON recargos.id_recagos = gestion_cartera.estado_recargo
            WHERE gestion_cartera.grado = '$grado' AND gestion_cartera.fecha = '$mes' and not gestion_cartera.id_estudiante = 28 order by estudiantes.apellidos asc";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" .
          $ver1[1] . "||" .
          $ver1[2] . "||" .
          $ver1[3] . "||" .
          $ver1[4] . "||" .//cartera
          $ver1[5] . "||" .//
          $ver1[6] . "||" .
          $ver1[7] . "||" .
          $ver1[8] . "||" .
          $ver1[9] . "||" .
          $ver1[10] . "||" .
          $ver1[11] . "||";
        $_SESSION['consulta_pagos'][] = $tabla;
      }
      echo 1;
    }
  }


  function crear_ano(){//iniciar progrma
    date_default_timezone_set('America/Bogota');
    $fecha = date('Y-m-d');
    $anio = date("Y");
    $mes = date("m");
    unset($_SESSION['crear_mes']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT grados.descripcion, estudiantes.id_estudiante, pensiones.valor,
          descuentos.porcentaje, grados.id_grado, estudiantes.cartera
          FROM estudiantes
          JOIN grados ON grados.id_grado = estudiantes.grado
          JOIN descuentos ON descuentos.id_descuento = estudiantes.descuento
          JOIN pensiones ON pensiones.id_pension = estudiantes.pension
          WHERE estudiantes.estado = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //0 nombre grado
                 $ver1[1] . "||" . //1 id estudiante
                 $ver1[2] . "||" . //2 valor pension
                 $ver1[3] . "||" . //3 porcentaje descuento
                 $ver1[4] . "||" . //4 id grado
                 $ver1[5] . "||" ; //5 valor cartera
        $_SESSION['crear_mes'][] = $tabla;
      }
      $sql = "UPDATE gestion_cartera SET estado_mes = '0'";
      $result = mysqli_query($conexion, $sql);
      $sql = "UPDATE estudiantes SET cartera = '0'";
      $result = mysqli_query($conexion, $sql);

      if (isset($_SESSION['crear_mes'])) {
        foreach (@$_SESSION['crear_mes'] as $key) {
          $dat = explode("||", $key);
          $id_gestion = $mes . $dat[0] . $anio;
          $saldo_mes = $dat[2] - ($dat[2] * $dat[3]);//valor a pagar este mes

          $sql = "INSERT INTO gestion_cartera VALUES ('','$id_gestion','$dat[1]',2,'$saldo_mes',0,1,'$fecha','$dat[4]','$saldo_mes',0)";
          $result = mysqli_query($conexion, $sql);
        }
      }
      echo 1;
    }
  }


  function crear_mes(){
    date_default_timezone_set('America/Bogota');
    $ultima_fecha = $_POST['form1'];
    $fecha = date('Y-m-d');
    $anio = date("Y");
    $mes = date("m");
    unset($_SESSION['crear_mes']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT grados.descripcion, estudiantes.id_estudiante, pensiones.valor,
          descuentos.porcentaje, grados.id_grado, estudiantes.cartera,
          gestion_cartera.pagos_mes, gestion_cartera.saldo_mes, gestion_cartera.cartera FROM estudiantes
          JOIN grados ON grados.id_grado = estudiantes.grado
          JOIN descuentos ON descuentos.id_descuento = estudiantes.descuento
          JOIN pensiones ON pensiones.id_pension = estudiantes.pension
          JOIN gestion_cartera ON gestion_cartera.id_estudiante = estudiantes.id_estudiante
          WHERE estudiantes.estado = '1' AND gestion_cartera.fecha = '$ultima_fecha'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //0 nombre grado
                 $ver1[1] . "||" . //1 id estudiante
                 $ver1[2] . "||" . //2 valor pension
                 $ver1[3] . "||" . //3 porcentaje descuento
                 $ver1[4] . "||" . //4 id grado
                 $ver1[5] . "||" . //5 valor cartera
                 $ver1[6] . "||" . //6 pagos del mes
                 $ver1[7] . "||" . //7 SALDO MES
                 $ver1[8] . "||"; //8 cartera de final de mes
        $_SESSION['crear_mes'][] = $tabla;
      }
      $sql = "UPDATE gestion_cartera SET estado_mes = '0'";
      $result = mysqli_query($conexion, $sql);

      if (isset($_SESSION['crear_mes'])) {
        foreach (@$_SESSION['crear_mes'] as $key) {
          $dat = explode("||", $key);
          $id_gestion = $mes . $dat[0] . $anio;
          $saldo_mes = $dat[2] - ($dat[2] * $dat[3]);//valor a pagar este mes
          $saldo_nuevo = $dat[5] + ($dat[7] - $dat[6]);//nueva cartera al ser creada
          $cartera_duplicate = $saldo_nuevo + $saldo_mes;
          $sql = "UPDATE estudiantes SET cartera = '$saldo_nuevo' WHERE id_estudiante = '$dat[1]'";
          $result = mysqli_query($conexion, $sql);

          $sql = "INSERT INTO gestion_cartera VALUES ('','$id_gestion','$dat[1]',2,'$saldo_mes',0,1,'$fecha','$dat[4]','$cartera_duplicate','$dat[8]')";
          $result = mysqli_query($conexion, $sql);
        }
      }
      echo 1;
    }
  }

  function crear_mes2(){//iniciar progrma
    date_default_timezone_set('America/Bogota');
    $ultima_fecha = $_POST['form1'];
    $fecha = date('Y-m-d');
    $anio = date("Y");
    $mes = date("m");
    unset($_SESSION['crear_mes']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT grados.descripcion, estudiantes.id_estudiante, pensiones.valor,
          descuentos.porcentaje, grados.id_grado, estudiantes.cartera
          FROM estudiantes
          JOIN grados ON grados.id_grado = estudiantes.grado
          JOIN descuentos ON descuentos.id_descuento = estudiantes.descuento
          JOIN pensiones ON pensiones.id_pension = estudiantes.pension
          WHERE estudiantes.estado = '1'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" . //0 nombre grado
                 $ver1[1] . "||" . //1 id estudiante
                 $ver1[2] . "||" . //2 valor pension
                 $ver1[3] . "||" . //3 porcentaje descuento
                 $ver1[4] . "||" . //4 id grado
                 $ver1[5] . "||" ; //5 valor cartera
        $_SESSION['crear_mes'][] = $tabla;
      }
      $sql = "UPDATE gestion_cartera SET estado_mes = '0'";
      $result = mysqli_query($conexion, $sql);

      if (isset($_SESSION['crear_mes'])) {
        foreach (@$_SESSION['crear_mes'] as $key) {
          $dat = explode("||", $key);
          $id_gestion = $mes . $dat[0] . $anio;
          $saldo_mes = $dat[2] - ($dat[2] * $dat[3]);//valor a pagar este mes

          $sql = "INSERT INTO gestion_cartera VALUES ('','$id_gestion','$dat[1]',2,0,0,1,'$fecha','$dat[4]','$dat[5]','$dat[5]')";
          $result = mysqli_query($conexion, $sql);
        }
      }
      echo 1;
    }
  }

  function aplicar_recargo()
  {
    $ultima_fecha = $_POST['form1'];
    unset($_SESSION['aplicar_recargo']);
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT grados.id_grado, estudiantes.id_estudiante, grados.descripcion, 
        descuentos.descripcion, estudiantes.recargo, estudiantes.cartera,
        gestion_cartera.saldo_mes, gestion_cartera.estado_recargo, gestion_cartera.pagos_mes, 
        pensiones.valor FROM estudiantes
        JOIN grados ON grados.id_grado = estudiantes.grado
        JOIN descuentos ON descuentos.id_descuento = estudiantes.descuento
        JOIN pensiones ON pensiones.id_pension = estudiantes.pension
        JOIN gestion_cartera ON gestion_cartera.id_estudiante = estudiantes.id_estudiante
        WHERE estudiantes.estado = '1' and estudiantes.recargo = '1' AND gestion_cartera.fecha = '$ultima_fecha'";
    $result = mysqli_query($conexion, $sql);
    if (mysqli_num_rows($result) <= 0) {
      echo 2;
    } else {
      while ($ver1 = mysqli_fetch_row($result)) {
        $tabla = $ver1[0] . "||" .//id grado
                 $ver1[1] . "||" .//id estudiante
                 $ver1[2] . "||" .//descripcion grado
                 $ver1[3] . "||" .//descripcion
                 $ver1[4] . "||" .//recargo
                 $ver1[5] . "||" . //cartera
                 $ver1[6] . "||" . //saldo mes
                 $ver1[7] . "||" . //estado recargo
                 $ver1[8] . "||" . //abonos del mes
                 $ver1[9] . "||"; //valor de pension
        $_SESSION['aplicar_recargo'][] = $tabla;
      }
      $result = mysqli_query($conexion, $sql);

      if (isset($_SESSION['aplicar_recargo'])) {
        foreach (@$_SESSION['aplicar_recargo'] as $key) { //hace falta verificar si ya se aplico el recargo
          $dat = explode("||", $key);
          if ($dat[7] == 2) { //verificamos si ya se aplico el recargo
            $sql = "UPDATE gestion_cartera
                      INNER JOIN estudiantes ON estudiantes.id_estudiante = gestion_cartera.id_estudiante
                      SET gestion_cartera.estado_recargo = 1, gestion_cartera.saldo_mes = gestion_cartera.saldo_mes + 20000, gestion_cartera.cartera = gestion_cartera.cartera+20000
                      WHERE estudiantes.id_estudiante = '$dat[1]' AND gestion_cartera.fecha = '$ultima_fecha' AND 
		                  ((gestion_cartera.pagos_mes < gestion_cartera.saldo_mes * 0.7) OR gestion_cartera.cartera > 0)";
            $result = mysqli_query($conexion, $sql);
          }else{
            return 3;
          }
        }if($result){
          return 1;
        }
      }
    }
  }

  public function id_admin($id_admin)
  {
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT id_user from usuarios where user = '$id_admin'";
    $result = mysqli_query($conexion, $sql);
    $id = mysqli_fetch_row($result)[0];
    return $id;
    echo "id=>" . $id;
  }

  public function id_grado($id_estudiante)
  {
    require_once "conexion.php";
    $conexion = conexion();
    $sql = "SELECT grado from estudiantes where id_estudiante = '$id_estudiante'";
    $result = mysqli_query($conexion, $sql);
    $id = mysqli_fetch_row($result)[0];
    return $id;
    echo "id=>" . $id;
  }
}
