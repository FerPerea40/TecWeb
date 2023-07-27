<?php
    include("conexion.php");
    $carrera = "0";
    $academia = "0";

    $boleta = $_POST['boleta2'];
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
    $id_paciente = $_POST['id_paciente'];

    if ($tipo == "3") {
        $carrera = "0";
        $academia = "0";
    } elseif ($tipo == "2") {
        $carrera = "0";
    } elseif ($tipo == "1") {
        $academia = "0";
    }

    $consulta  = "UPDATE `paciente` SET";
    $consulta  .="`boleta` = '". $boleta ."', ";
    $consulta  .="`nombres` = '".  $nombres ."', ";
    $consulta  .="`pa` = '". $pa ."', ";
    $consulta  .="`sa` = '". $sa ."', ";
    $consulta  .="`fecha` = '". $fecha ."', ";
    $consulta  .="`sexo` = '". $sexo ."', ";
    $consulta  .="`masa` = '". $masa ."', ";
    $consulta  .="`altura` = '". $altura ."', ";
    $consulta  .="`sangre` = '". $sangre ."', ";
    $consulta  .="`seguro` = '". $seguro ."', ";
    $consulta  .="`nss` = '". $nss ."', ";
    $consulta  .="`curp` = '". $curp ."', ";
    $consulta  .="`tel` = '". $tel ."', ";
    $consulta  .="`tel_e` = '". $tel_e ."', ";
    $consulta  .="`contacto_e` = '". $contacto_e ."', ";
    $consulta  .="`tipo` = '". $tipo ."', ";
    $consulta  .="`carrera` = '". $carrera ."', ";
    $consulta  .="`academia` = '". $academia ."', ";
    $consulta  .="`ah` = '". $ah ."', ";
    $consulta  .="`apnp` = '". $apnp ."', ";
    $consulta  .="`app` = '". $app ."', ";
    $consulta  .="`od` = '". $od ."', ";
    $consulta  .="`borrar` = '0' ";
    $consulta .= "WHERE `paciente`.`id_paciente` LIKE ". $id_paciente;

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
