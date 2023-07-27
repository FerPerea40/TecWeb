<?php
    include("conexion.php");
  
    $id_consulta = $_POST['id_consulta'];
     $tension_arterial = $_POST['tension_arterial'];
    $frecuencia_cardiaca = $_POST['frecuencia_cardiaca'];
    $frecuencia_respiratoria = $_POST['frecuencia_respiratoria'];
    $temperatura_corp = $_POST['temperatura_corp'];
    $oxigeno_sangre = $_POST['oxigeno_sangre'];
    $glucosa = $_POST['glucosa'];
    $otros = $_POST['otros'];
    $padecimiento_actual = $_POST['padecimiento_actual'];
    $resumen_interrogatorio = $_POST['resumen_interrogatorio'];
    $resultados_servicios_aux = $_POST['resultados_servicios_aux'];
    $diagnostico = $_POST['diagnostico'];
    $tratamiento = $_POST['tratamiento'];
   
    

    $consulta  = "UPDATE `consulta` SET";
    $consulta  .="`tension_arterial` = '". $tension_arterial ."', ";
    $consulta  .="`frecuencia_cardiaca` = '".  $frecuencia_cardiaca ."', ";
    $consulta  .="`frecuencia_respiratoria` = '". $frecuencia_respiratoria ."', ";
    $consulta  .="`temperatura_corp` = '". $temperatura_corp ."', ";
    $consulta  .="`oxigeno_sangre` = '". $oxigeno_sangre ."', ";
    $consulta  .="`glucosa` = '". $glucosa ."', ";
    $consulta  .="`otros` = '". $otros ."', ";
    $consulta  .="`padecimiento_actual` = '". $padecimiento_actual ."', ";
    $consulta  .="`resumen_interrogatorio` = '". $resumen_interrogatorio ."', ";
    $consulta  .="`resultados_servicios_aux` = '". $resultados_servicios_aux ."', ";
    $consulta  .="`diagnostico` = '". $diagnostico ."', ";
    $consulta  .="`tratamiento` = '$tratamiento' ";
    $consulta .= "WHERE `consulta`.`id_consulta` LIKE ". $id_consulta;

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
