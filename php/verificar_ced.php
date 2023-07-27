<?php
    include("conexion.php");
    $ced=$_POST['CEDULA'];
    $respuesta = array();
    $link=connect();
    $respuesta['resultado'] = "si";
    $resultadoBD= mysqli_query($link, "SELECT * FROM `medico min`");
    while ($fila=mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['Ced_prof']== $ced) {
            $respuesta['resultado']= "no";
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
