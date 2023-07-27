<?php
    include("conexion.php");
    $boleta =$_POST['boleta'];
    //$boleta = "444";
    $respuesta = array();
    $link=connect();
    $respuesta['resultado'] = "si";
    $resultadoBD= mysqli_query($link, "SELECT * FROM paciente");
    while ($fila=mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['boleta']== $boleta) {
            $respuesta['resultado']= "no";
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
