<?php
    include('conexion.php');
    $link=connect();
    $respuesta = array();
    $dato="";
    $id='';
    $respuesta['directorio']="";
    $respuesta['vigencia']='';
    if (isset($_POST['dato'])) {
        $dato=$_POST['dato'];
    }
    $resultadoBD= mysqli_query($link, "SELECT * FROM paciente");
    while ($fila= mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['boleta']== $dato) {
            if ($fila['vigencia']==1) {
                $id= $fila['id_paciente'];
            } else {
                $respuesta['vigencia']='no';
            }
        }
    }
    if (!$respuesta['vigencia']=='no') {
        $directorio='vigencias/'.$id.'/';
        if (file_exists($directorio)) {
            $dir=opendir($directorio);
            $nom="";
            while ($elemento = readdir($dir)) {
                $nom=$elemento;
            }
            $directorio=$directorio.$nom;
            $respuesta['directorio']=$directorio;
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
