<?php
    include('conexion.php');
    $link=connect();
    $respuesta = array();
    $dato="";
    $id='';
    $respuesta['resultado']="";
    if (isset($_POST['dato'])) {
        $dato=$_POST['dato'];
    }
    $resultadoBD= mysqli_query($link, "SELECT * FROM paciente");
    while ($fila= mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['boleta']== $dato) {
            $id= $fila['id_paciente'];
            if ($fila['vigencia']==1) {
                $respuesta['eliminado']='si';
            }
        }
    }
    $directorio='vigencias/'.$id.'/';
    if (!file_exists($directorio)) {
        mkdir($directorio, 0777, true);
    }
    $dir=opendir($directorio);
    while ($elemento = readdir($dir)) {
        @unlink($directorio.$elemento);
    }
    if (move_uploaded_file($_FILES["file"]["tmp_name"], "$directorio".$_FILES["file"]["name"])) {
        $sentencia="UPDATE `paciente` SET `vigencia` = '1' WHERE `boleta` = '$dato'";
        if (mysqli_query($link, $sentencia)) {
            $respuesta['resultado']="Correcto";
        }
    }

    mysqli_close($link);
    echo json_encode($respuesta);
