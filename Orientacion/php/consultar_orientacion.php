<?php
    include("conexion.php");
    //echo $_POST['boleta']. " " . $_POST['usuario'];
    $id_paciente;
    $Id_Orient;

    $consulta = "SELECT id_paciente FROM `paciente` WHERE `boleta` LIKE '". $_POST['boleta'] ."'";

    $link=connect();
    $respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);


    while ($r = mysqli_fetch_assoc($respuesta)) {
        $id_paciente = $r['id_paciente'];
    }
 
    $consulta = "SELECT * FROM `orientador` WHERE `user` LIKE '". $_POST['usuario'] ."'";

    $link=connect();
    $respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);


    while ($r = mysqli_fetch_assoc($respuesta)) {
        $Id_Orient = $r['Id_Orient'];
    }

    $res;
   
    $link=connect();

        $consulta="INSERT INTO `consulta_orient` (`id_consulta`, `tipo_atenc`, `Nom_asis1`, `Tel_asis1`, `Nom_asis2`, `Tel_asis2`, `Relac`, `Anota`, `Conclu`, `Id_Orient`, `id_paciente`, `fecha`) VALUES (NULL,";
        $consulta  .= "'".$_POST['Tipo_atencion']."',";
        $consulta  .= "'".$_POST['nombre_1']."',";
        $consulta  .= "'".$_POST['TEL_1']."',";
        $consulta  .= "'".$_POST['nombre_2']."',";
        $consulta  .= "'".$_POST['TEL_2']."',";
        $consulta  .= "'".$_POST['rela']."',";
        $consulta  .= "'".$_POST['anotaciones']."',";
        $consulta  .= "'".$_POST['conclusiones']."',";
        $consulta  .= "'".$Id_Orient."',";
        $consulta  .= "'".$id_paciente."',";
        $consulta  .= "'".$_POST['fecha']."')";
       
        if (mysqli_query($link, $consulta)) {
            $res['resultado'] = "si";
        } else {
            $res['resultado'] = "no";
        }   
    
  
    mysqli_close($link);
    echo json_encode($res);
