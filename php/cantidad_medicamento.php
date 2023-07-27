<?php
    include("conexion.php");
    $Id_Mat_Med = $_POST['select'];
    $Cantidad = $_POST['Cantidad'];
    $Fecha_caducidad = $_POST['Fecha_caducidad'];
    
    $consulta  = "INSERT INTO `bloquematerialmedico` (`Id_bloque`, `Cantidad`, `Fecha_caducidad`, `Id_Mat_Med`) VALUES (NULL,";
    $consulta  .= " '". $Cantidad."',";
    $consulta  .= " '". $Fecha_caducidad ."',";
    $consulta  .= " '". $Id_Mat_Med."')";
    
    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
