<?php
    include('conexion.php');
    $boleta = $_POST['boleta'];
    //$boleta = "2019670113";
    $consulta  = "SELECT * FROM paciente INNER JOIN consulta  ON paciente.id_paciente = consulta.id_paciente WHERE paciente.boleta LIKE '".$boleta."'";

    $link=connect();
    $respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $rows = array();
    while ($r = mysqli_fetch_assoc($respuesta)) {
        $rows[] = $r;
    }
    echo json_encode($rows);
