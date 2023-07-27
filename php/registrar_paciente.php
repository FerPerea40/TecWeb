<?php
    include("conexion.php");
    $carrera = "0";
    $academia = "0";

    $boleta = $_POST['boleta'];
    $nombres = $_POST['nombre'];
    $pa = $_POST['p_apellido'];
    $sa = $_POST['s_apellido'];
    $fecha = $_POST['fecha'];
    $sexo = $_POST['sexo'];
    $masa = $_POST['peso'];
    $altura = $_POST['altura'];
    $sangre = $_POST['sangre'];
    $seguro = $_POST['hospital'];
    $nss = $_POST['nss'];
    $curp = $_POST['CURP'];
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
    $ah = $_POST['ah'];
    $apnp = $_POST['apnp'];
    $app = $_POST['app'];
    $od = $_POST['od'];

    if ($tipo == "3") {
        $carrera = "0";
        $academia = "0";
    } elseif ($tipo == "2") {
        $carrera = "0";
    } elseif ($tipo == "1") {
        $academia = "0";
    }

    $consulta  = "INSERT INTO `paciente` (`id_paciente`, `boleta`, `nombres`, `pa`, `sa`, `fecha`, `sexo`, `masa`, `altura`, `sangre`, `seguro`, `nss`, `curp`, `tel`, `tel_e`, `contacto_e`, `tipo`, `carrera`, `academia`, `ah`, `apnp`, `app`, `od`)";
    $consulta  .= "VALUES (NULL, ";
    $consulta  .= "'".$boleta."',";
    $consulta  .= "'".$nombres."',";
    $consulta  .= "'". $pa ."',";
    $consulta  .= "'". $sa ."',";
    $consulta  .= "'". $fecha ."',";
    $consulta  .= "'". $sexo ."',";
    $consulta  .= "'". $masa ."',";
    $consulta  .= "'". $altura ."',";
    $consulta  .= "'". $sangre ."',";
    $consulta  .= "'". $seguro ."',";
    $consulta  .= "'". $nss ."',";
    $consulta  .= "'". $curp ."',";
    $consulta  .= "'". $tel ."',";
    $consulta  .= "'". $tel_e ."',";
    $consulta  .= "'". $contacto_e ."',";
    $consulta  .= "'". $tipo ."',";
    $consulta  .= "'". $carrera."',";
    $consulta  .= "'". $academia."',";
    $consulta  .= "'". $ah."',";
    $consulta  .= "'". $apnp."',";
    $consulta  .= "'". $app."',";
    $consulta  .= "'". $od."')";

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
