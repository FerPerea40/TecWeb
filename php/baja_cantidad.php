<?php
    include("conexion.php");
    $Id_bloque = $_POST['Id_bloque'];

    //echo $Cantidad ." ".$Id_bloque;
    $consulta  = "DELETE FROM `bloquematerialmedico` WHERE `Id_bloque` = '$Id_bloque'";
    
    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
?>