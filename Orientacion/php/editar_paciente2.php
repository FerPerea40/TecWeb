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
    $obs_ad_orientacion = $_POST['Observaciones'];
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
    $consulta  .="`tel` = '". $tel ."', ";
    $consulta  .="`tel_e` = '". $tel_e ."', ";
    $consulta  .="`contacto_e` = '". $contacto_e ."', ";
    $consulta  .="`tipo` = '". $tipo ."', ";
    $consulta  .="`carrera` = '". $carrera ."', ";
    $consulta  .="`academia` = '". $academia ."', ";
    $consulta  .="`obs_ad_orientacion` = '". $obs_ad_orientacion ."', ";
    $consulta  .="`borrar_orientacion` = '0' ";
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
