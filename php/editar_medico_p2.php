<?php
    include('conexion.php');
    $user= $_POST['select'];
    $link = connect();
    $respuesta = array();
    $valor=$_POST['select'];
    $Nom_med=$_POST['Nom_med'];
    $Ape_pat=$_POST['Ape_pat'];
    $Ape_mat=$_POST['Ape_mat'];
    $F_nacimiento=$_POST['F_nacimiento'];
    $Sexo=$_POST['Sexo'];
    $CURP=$_POST['CURP'];
    $Ced_prof=$_POST['Ced_prof'];
    $Tel_per=$_POST['Tel_per'];
    $Tel_emer=$_POST['Tel_emer'];
    $respuesta['resultado']='';
    
    $sentencia="UPDATE `medico min` SET `Nom_med` = '$Nom_med', `Ape_pat` = '$Ape_pat',`Ape_mat` = '$Ape_mat',`F_nacimiento` = '$F_nacimiento',`Sexo` = '$Sexo',`CURP` = '$CURP',`Ced_prof` = '$Ced_prof',`Tel_per` = '$Tel_per',`Tel_emer` = '$Tel_emer' WHERE `user` = '$valor'";
    if (mysqli_query($link, $sentencia)) {
        $respuesta['resultado']='Correcto';
    };
    mysqli_close($link);
    echo json_encode($respuesta);
