<?php
include("conexion.php");
$id_consulta = $_POST['id_consulta'];

//$boleta = "2019"; //Test
$consulta  = "SELECT * FROM `consulta_orient` WHERE `id_consulta` LIKE '". $id_consulta ."'";

$link=connect();
$respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
mysqli_close($link);

$rows = array();
while ($r = mysqli_fetch_assoc($respuesta)) {
    $rows[] = $r;
}
echo json_encode($rows);
?>