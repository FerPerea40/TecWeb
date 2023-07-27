<?php
    include('conexion.php');
    $valor= $_POST['select'];
    $link = connect();
    $respuesta = array();
    $respuesta['resultado']='';
    $sentencia="UPDATE `medico min` SET `borrado` = '1' WHERE `user` = '$valor'";
    $respuesta['ayuda']=$sentencia;
    
    if (mysqli_query($link, $sentencia)) {
        $sentencia="DELETE FROM `usuarios` WHERE `usuario` = '$valor'";
        if (mysqli_query($link, $sentencia)) {
            $respuesta['resultado']='Correcto';
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
