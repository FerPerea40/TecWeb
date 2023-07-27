<?php
include("conexion.php");
$link=connect();
$respuesta=array();
$dato="";
$respuesta['resultado']='no';
$respuesta['nombre']='';
$respuesta['id']='';
if (isset($_POST['boleta'])) {
    $dato=$_POST['boleta'];
}
$resultadoBD= mysqli_query($link, "SELECT * FROM paciente");
while ($fila= mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['boleta']== $dato) {
            $respuesta['resultado']='si';
            $respuesta['nombre']="".$fila['nombres']." ".$fila['pa']." ".$fila['sa'];
            $respuesta['id']= $fila['id_paciente'];
            $respuesta['borrar']=$fila['borrar'];
    }
}
mysqli_close($link);
echo json_encode($respuesta);
