<?php
    include("conexion.php");
    $user=$_POST['Usuario'];
    $respuesta = array();
    $link=connect();
    $respuesta['resultado'] = "si";
    $resultadoBD= mysqli_query($link, "SELECT * FROM usuarios");
    while ($fila=mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['usuario']== $user) {
            $respuesta['resultado']= "no";
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
