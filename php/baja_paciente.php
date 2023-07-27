<?php
include("conexion.php");
$boleta = $_POST['boleta'];
//$boleta = "2019"; //Test
$consulta  = "UPDATE `paciente` SET `borrar` = '1' WHERE `paciente`.`boleta` LIKE'". $boleta ."'";

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
