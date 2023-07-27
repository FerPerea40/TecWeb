<?php
    include("conexion.php");
    
    $pass = $_POST['pass'];
    $usuario = $_POST['username'];

    $consulta  = "UPDATE `usuarios` SET `password` = '". $pass ."' WHERE `usuarios`.`usuario` = '". $usuario ."';";

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
