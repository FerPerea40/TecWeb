<?php
    include("conexion.php");
    $Lab_Empresa = $_POST['Lab_Empresa'];
    $componente_quimico = $_POST['componente_quimico'];
    $concentracion = $_POST['concentracion'];
    $nombre = $_POST['nombre'];
    $presentacion = $_POST['presentacion'];
    
    $consulta  = "INSERT INTO `tipomedicamento` (`Id_Mat_Med`, `Lab_Empresa`, `componente_quimico`, `concentracion`, `presentacion`, `nombre`) VALUES (NULL,";
    $consulta  .= " '". $Lab_Empresa."',";
    $consulta  .= " '". $componente_quimico ."',";
    $consulta  .= " '". $concentracion."',";
    $consulta  .= " '". $presentacion."',";
    $consulta  .= " '". $nombre."')";
    
    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
