<?php
    include("conexion.php");

    $Lab_Empresa = $_POST['Lab_Empresa'];
    $componente_quimico = $_POST['componente_quimico'];
    $concentracion = $_POST['concentracion'];
    $nombre = $_POST['nombre'];
    $presentacion = $_POST['presentacion'];
    $Id_Mat_Med = $_POST['Id_Mat_Med'];
     
    $consulta  = "UPDATE `tipomedicamento` SET";
    $consulta  .="`Lab_Empresa` = '". $Lab_Empresa  ."', ";
    $consulta  .="`componente_quimico` = '". $componente_quimico  ."', ";
    $consulta  .="`concentracion` = '". $concentracion  ."', ";
    $consulta  .="`nombre` = '". $nombre  ."', ";
    $consulta  .="`presentacion` = '". $presentacion  ."' ";
    $consulta  .="WHERE `tipomedicamento`.`Id_Mat_Med` = ".$Id_Mat_Med;

    //echo $consulta;

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
