<?php
include("conexion.php");
$consulta  = "SELECT * FROM `tipomedicamento`";

$link=connect();
$respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
mysqli_close($link);

$rows = array();
while ($r = mysqli_fetch_assoc($respuesta)) {
    $rows[] = $r;
}
echo json_encode($rows);
