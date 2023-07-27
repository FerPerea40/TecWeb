<?php
    function connect()
    {
        $servidor = "localhost";
        $usuario  = "u988867240_carlos";
        $clave    = "aq4&pb0cTHWWopwV5Hm*SVC%tqlQ";
        $base     = "u988867240_tecweb2020";
    
        $conexion = mysqli_connect($servidor, $usuario, $clave, $base);

        if (!$conexion) {
            echo "Error: No se pudo conectar a MySQL." . PHP_EOL; // IMPRIME MENSAJE DE ERROR PERSONALIZADO  Y SE TERMINA LA LÍNEA
            echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;// IDENTIFICA EL ERROR CON CÓDIGO O NOMBRE
            exit;
        }
    
        return $conexion;
    }
