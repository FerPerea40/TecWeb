<?php
    include("conexion.php");
    $link= connect();
    $respuesta = array();
    
    $carrera = "0";
    $academia = "0";
    $boleta = $_POST['boleta'];
    $nombres = $_POST['nombre'];
    $pa = $_POST['p_apellido'];
    $sa = $_POST['s_apellido'];
    $fecha = $_POST['fecha'];
    $sexo = $_POST['sexo'];
    $tel = $_POST['TEL'];
    $tel_e = $_POST['TEL_EMERGENCIA'];
    $contacto_e = $_POST['NOM_TEL_EMERGENCIA'];
    $tipo = $_POST['tipo_paciente'];
    if (isset($_POST['CARRERA'])) {
        $carrera = $_POST['CARRERA'];
    }
    if (isset($_POST['Academia'])) {
        $academia = $_POST['Academia'];
    }
    $od = $_POST['Observaciones'];
    if ($tipo == "3") {
        $carrera = "0";
        $academia = "0";
    } elseif ($tipo == "2") {
        $carrera = "0";
    } elseif ($tipo == "1") {
        $academia = "0";
    }

    $consulta  = "INSERT INTO `paciente` (`id_paciente`, `boleta`, `nombres`, `pa`, `sa`, `fecha`, `sexo`, `tel`, `tel_e`, `contacto_e`, `tipo`, `carrera`, `academia`, `obs_ad_orientacion`)";
    $consulta  .= "VALUES (NULL, ";
    $consulta  .= "'".$boleta."',";
    $consulta  .= "'".$nombres."',";
    $consulta  .= "'". $pa ."',";
    $consulta  .= "'". $sa ."',";
    $consulta  .= "'". $fecha ."',";
    $consulta  .= "'". $sexo ."',";
    $consulta  .= "'". $tel ."',";
    $consulta  .= "'". $tel_e ."',";
    $consulta  .= "'". $contacto_e ."',";
    $consulta  .= "'". $tipo ."',";
    $consulta  .= "'". $carrera."',";
    $consulta  .= "'". $academia."',";
    $consulta  .= "'". $od."')";

    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);
    echo json_encode($respuesta);
?>