<?php
    include('conexion.php');
    $link = connect();
    $resultado = array();
    $resultado['0']=0;
    $resultadoBD= mysqli_query($link, "SELECT * FROM `medico min`");
    
    while ($fila=mysqli_fetch_assoc($resultadoBD)) {
        if ($fila['borrado']==0) {
            $resultado['0']= $resultado['0']+1;
            $resultado[$resultado['0']]= $fila['user'];
        }
    }
    mysqli_close($link);
    echo json_encode($resultado);
