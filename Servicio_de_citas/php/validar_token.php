<?php
    include("conexion.php");
    
    $consulta  = "SELECT COUNT(`token`) FROM `usuarios` WHERE `token` LIKE '". $_POST['token'] ."'";

    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $registro=mysqli_fetch_array($result);
    
    echo json_encode($registro);