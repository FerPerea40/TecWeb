<?php
    include("conexion.php");
    //echo $_POST['boleta']. " " . $_POST['usuario'];
    $id_paciente;
    $Id_med;

    $consulta = "SELECT id_paciente FROM `paciente` WHERE `boleta` LIKE '". $_POST['boleta'] ."'";

    $link=connect();
    $respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);


    while ($r = mysqli_fetch_assoc($respuesta)) {
        $id_paciente = $r['id_paciente'];
    }
 
    $consulta = "SELECT * FROM `medico min` WHERE `user` LIKE '". $_POST['usuario'] ."'";

    $link=connect();
    $respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);


    while ($r = mysqli_fetch_assoc($respuesta)) {
        $Id_med = $r['Id_med'];
    }

    $res;
    $consulta = "UPDATE `paciente` SET `masa` = '". $_POST['masa'] ."', `altura` = '". $_POST['altura'] ."' WHERE `paciente`.`id_paciente` =". $id_paciente;
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $consulta="INSERT INTO `consulta` (`id_consulta`, `tension_arterial`, `frecuencia_cardiaca`, `frecuencia_respiratoria`, `temperatura_corp`, `oxigeno_sangre`, `glucosa`, `otros`, `padecimiento_actual`, `resumen_interrogatorio`, `resultados_servicios_aux`, `diagnostico`, `tratamiento`, `fecha`, `id_medico`, `id_paciente`) VALUES (NULL,";
        $consulta  .= "'".$_POST['tension_arterial']."',";
        $consulta  .= "'".$_POST['frecuencia_cardiaca']."',";
        $consulta  .= "'".$_POST['frecuencia_respiratoria']."',";
        $consulta  .= "'".$_POST['temperatura_corp']."',";
        $consulta  .= "'".$_POST['oxigeno_sangre']."',";
        $consulta  .= "'".$_POST['glucosa']."',";
        $consulta  .= "'".$_POST['otros']."',";
        $consulta  .= "'".$_POST['padecimiento_actual']."',";
        $consulta  .= "'".$_POST['resumen_interrogatorio']."',";
        $consulta  .= "'".$_POST['resultados_servicios_aux']."',";
        $consulta  .= "'".$_POST['diagnostico']."',";
        $consulta  .= "'".$_POST['tratamiento']."',";
        $consulta  .= "'".$_POST['fecha']."',";
        $consulta  .= "'".$Id_med."',";
        $consulta  .= "'".$id_paciente."')";
        if (mysqli_query($link, $consulta)) {
            $res['resultado'] = "si";
        } else {
            $res['resultado'] = "no";
        }
    } else {
        $res['resultado'] = "no";
    }
    mysqli_close($link);
    echo json_encode($res);
