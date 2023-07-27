<?php
    include('conexion.php');
    $user= $_POST['select'];
    $link = connect();
    $respuesta = array();
    $respuesta['resultado']='';
    $sentencia="SELECT * FROM `orientador`";
    $resultadoBD= mysqli_query($link, $sentencia);
    
    while ($fila=mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['user']==$user) {
            $respuesta['user']=$fila['user'];
            $respuesta['Nom_Orient']=$fila['Nom_Orient'];
            $respuesta['Ape_pat']=$fila['Ape_pat'];
            $respuesta['Ape_mat']=$fila['Ape_mat'];
            $respuesta['F_nacimiento']=$fila['F_nacimiento'];
            $respuesta['Sexo']=$fila['Sexo'];
            $respuesta['CURP']=$fila['CURP'];
            $respuesta['Tel_per']=$fila['Tel_per'];
            $respuesta['Tel_emer']=$fila['Tel_emer'];
            $respuesta['Ced_prof']=$fila['Ced_prof'];
            $respuesta['resultado']='Correcto';
        }
    }
    mysqli_close($link);
    echo json_encode($respuesta);
