<?php
    include("conexion.php");
    
    $password = $_POST['password'];
    $usuario = $_POST['usuario'];

    $consulta  = "SELECT * FROM `usuarios` WHERE `usuario` = '". $usuario ."'";

    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $registro=mysqli_fetch_array($result);

    $respuesta = array();
    if (isset($registro['tipo'])) {
        $respuesta['tipo']= $registro['tipo'];
    }

    if (!isset($registro['password'])) {
        $respuesta['resultado'] = "no";
    } elseif ($registro['password'] == $password) {
        $respuesta['resultado'] = "si";
        $token = bin2hex(random_bytes(24));
        $consulta = "UPDATE `usuarios` SET `token` = '". $token ."' WHERE `usuarios`.`usuario` = '".$usuario."'";
        $link=connect();
        $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
        mysqli_close($link);
        $respuesta['token'] = $token;
    } else {
        $respuesta['resultado'] = "no";
    }

    echo json_encode($respuesta);
