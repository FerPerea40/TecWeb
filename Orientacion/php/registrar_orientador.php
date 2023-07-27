<?php
    include("conexion.php");
    $ape_mat = "";
    $curp= "";
    $tel_emer= "";


    $nom_med = $_POST['NOMBRES'];
    $ape_pat = $_POST['P_APELLIDO'];
    if (isset($_POST['S_APELLIDO'])) {
        $ape_mat = $_POST['S_APELLIDO'];
    }
    $f_nacimiento = $_POST['FECHA_NACIMIENTO'];
    $sexo = $_POST['SEXO'];
    if (isset($_POST['CURP'])) {
        $curp = $_POST['CURP'];
    }
    $ced_prof= $_POST['CEDULA'];
    $tel_per = $_POST['TEL'];
    if (isset($_POST['TEL_EMERGENCIA'])) {
        $tel_emer = $_POST['TEL_EMERGENCIA'];
    }
    $user = $_POST['Usuario'];
    $passw = $_POST['pass1'];

    $consulta  = "INSERT INTO `orientador` (`Id_Orient`, `user`, `passw`, `Nom_Orient`, `Ape_pat`, `Ape_mat`, `F_nacimiento`, `Sexo`, `CURP`, `Tel_per`, `Tel_emer`, `Ced_prof`, `borrado`)";
    $consulta  .= "VALUES (NULL, ";
    $consulta  .= "'".$user."',";
    $consulta  .= "'". $passw."',";
    $consulta  .= "'". $nom_med."',";
    $consulta  .= "'". $ape_pat."',";
    $consulta  .= "'". $ape_mat."',";
    $consulta  .= "'". $f_nacimiento."',";
    $consulta  .= "'". $sexo."',";
    $consulta  .= "'". $curp."',";
    $consulta  .= "'". $tel_per."',";
    $consulta  .= "'". $tel_emer."',";
    $consulta  .= "'". $ced_prof."',";
    $consulta  .= "'". false."')";
    

    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $consulta = "INSERT INTO `usuarios` (`usuario`, `password`, `tipo`)";
        $consulta .= "VALUES (";
        $consulta .="'". $user."',";
        $consulta .="'". $passw."',";
        $consulta .="'2')";
        if (mysqli_query($link, $consulta)) {
            $respuesta['resultado'] = "si";
        } else {
            $respuesta['resultado'] = "no";
        }
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
