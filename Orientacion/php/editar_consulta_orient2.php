<?php
    include("conexion.php");
  
    $id_consulta = $_POST['id_consulta'];

    $tipo_atenc = $_POST['Tipo_atencion'];
    $Nom_asis1 = $_POST['nombre_1'];
    $Tel_asis1 = $_POST['TEL_1'];
    $Nom_asis2 = $_POST['nombre_2'];
    $Tel_asis2 = $_POST['TEL_2'];
    $Relac = $_POST['rela'];
    $Anota = $_POST['anotaciones'];
    $Conclu = $_POST['conclusiones'];

 
    $consulta  = "UPDATE `consulta_orient` SET";
    $consulta  .="`tipo_atenc` = '". $tipo_atenc ."', ";
    $consulta  .="`Nom_asis1` = '".  $Nom_asis1 ."', ";
    $consulta  .="`Tel_asis1` = '". $Tel_asis1 ."', ";
    $consulta  .="`Nom_asis2` = '". $Nom_asis2 ."', ";
    $consulta  .="`Tel_asis2` = '". $Tel_asis2 ."', ";
    $consulta  .="`Relac` = '". $Relac ."', ";
    $consulta  .="`Anota` = '". $Anota ."', ";
    $consulta  .="`Conclu` = '$Conclu' ";
    $consulta .= "WHERE `consulta_orient`.`id_consulta` LIKE ". $id_consulta;

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
