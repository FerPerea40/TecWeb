<?php
    include("conexion.php");
    $nss=$_POST['nss'];
    $respuesta = array();
    $link=connect();
    $respuesta['resultado'] = "si";
    $resultadoBD= mysqli_query($link, "SELECT * FROM `paciente`");
    while ($fila=mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['nss']== $nss) {
            $respuesta['resultado']= "no";
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
