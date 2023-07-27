<?php
    include("conexion.php");
    
    $n_pacientes = 0;
    $n_pacientesH=0;
    $n_pacientesM=0;

    $n_carrera1=0;
    $n_carrera2=0;
    $n_carrera3=0;
    $n_carrera4=0;
    $n_carrera5=0;
    $n_academia1=0;
    $n_academia2=0;
    $n_academia3=0;
    $n_academia4=0;
    $n_academia5=0;
    $n_academia6=0;
    $n_academia7=0;

    $n_pacientesAlumnos=0;
    $n_pacientesDocentes=0;
    $n_pacientesPAAE=0;

    $n_SinNSS;
    $SinNSS;
    
    $n_SinCURP;
    $SinCURP;
    
    $n_SinVIGENCIA;
    $SinVIGENCIA;

    //saber cuentos pacientes hay sin borrado logico
    $consulta  = "SELECT count(borrar) FROM `paciente` WHERE borrar = '0'";
    // Sentencia correcta en sql es SELECT COUNT(borrar) FROM `paciente` WHERE sexo = 'H' AND borrar = 0
    //consulta2 y consulta3--> Son para saber cuantos pacientes SIN borrado logico hay, tanto en hombre como mujeres
    $consulta2  = "SELECT count(borrar) FROM `paciente` WHERE borrar = '0' AND sexo= 'H' " ;//hombres
    $consulta3  = "SELECT count(borrar) FROM `paciente` WHERE borrar = '0' AND sexo= 'M' " ;//mujeres

    //Sentencia correcta en sql es SELECT count(carrera) FROM `paciente` WHERE borrar = 0 AND carrera= 5
    $consultaCarrera1 =  "SELECT count(carrera) FROM `paciente` WHERE borrar = '0' AND carrera= '1' " ;//carrera1-->Metalurgica
    $consultaCarrera2 =  "SELECT count(carrera) FROM `paciente` WHERE borrar = '0' AND carrera= '2' " ;//carrera2-->Meca
    $consultaCarrera3 =  "SELECT count(carrera) FROM `paciente` WHERE borrar = '0' AND carrera= '3' " ;//carrera3-->Alimentos
    $consultaCarrera4 =  "SELECT count(carrera) FROM `paciente` WHERE borrar = '0' AND carrera= '4' " ;//carrera4-->Ambiental
    $consultaCarrera5 =  "SELECT count(carrera) FROM `paciente` WHERE borrar = '0' AND carrera= '5' " ;//carrera5-->Sistemas

    //Sentencia correcta en sql es SELECT count(academia) FROM `paciente` WHERE borrar = 0 AND academia= 1
    $consultaAcademia1 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '1' " ;//academia1-->Bioingenieria
    $consultaAcademia2 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '2' " ;//academia2-->Fisico-matematicas
    $consultaAcademia3 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '3' " ;//academia3-->meca
    $consultaAcademia4 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '4' " ;//academia4-->Qimico-biologicas
    $consultaAcademia5 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '5' " ;//academia5-->Sociales e ingles
    $consultaAcademia6 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '6' " ;//academia6-->Metalurgica
    $consultaAcademia7 =  "SELECT count(academia) FROM `paciente` WHERE borrar = '0' AND academia= '7' " ;//academia7-->Ciencias de la computacion

    $consultaTipo1 =  "SELECT count(tipo) FROM `paciente` WHERE borrar = '0' AND tipo= '1' ";
    $consultaTipo2 =  "SELECT count(tipo) FROM `paciente` WHERE borrar = '0' AND tipo= '2' ";
    $consultaTipo3 =  "SELECT count(tipo) FROM `paciente` WHERE borrar = '0' AND tipo= '3' ";

     /// consulta correcta en sql es SELECT count(boleta) FROM `paciente` WHERE borrar = 0 AND nss IS NULL
     $consulta_n_SinNSS =  "SELECT count(boleta) FROM `paciente` WHERE borrar = '0' AND nss = 0";
     $consulta_SinNSS = "SELECT * FROM `paciente` WHERE borrar = '0' AND nss = 0 ";
    
     /// consulta correcta en sql es SELECT count(boleta) FROM `paciente` WHERE borrar = 0 AND curp IS NULL
     $consulta_n_SinCURP =  "SELECT count(boleta) FROM `paciente` WHERE borrar = '0' AND curp = ''";
     $consulta_SinCURP = "SELECT * FROM `paciente` WHERE borrar = '0' AND curp = ''";
 
     /// consulta correcta en sql es SELECT count(boleta) FROM `paciente` WHERE borrar = 0 AND vigencia = 0
     $consulta_n_SinVIGENCIA =  "SELECT count(boleta) FROM `paciente` WHERE borrar = '0' AND vigencia = '0' ";
     $consulta_SinVIGENCIA = "SELECT * FROM `paciente` WHERE borrar = '0' AND vigencia = '0' ";

     $fecha_inicial = $_POST['fecha_inicial'];
     $fecha_final = $_POST['fecha_final'];
     $consultas_fecha = "SELECT count(id_consulta) FROM `consulta` WHERE `fecha` <= '". $fecha_final ."' AND `fecha` >= '". $fecha_inicial ."'";

    $link=connect();

    //saber cuentos pacientes hay sin borrado logico
    $n_pacientes = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta de cantidad de pacientes totales activos (sin borrado lógico)");
    $n_pacientesH = mysqli_query($link, $consulta2) or die("Error al ejecutar la consulta de cantidad de pacientes hombres activos (sin borrado lógico)");
    $n_pacientesM = mysqli_query($link, $consulta3) or die("Error al ejecutar la consulta de cantidad de pacientes mujeres activos (sin borrado lógico)");

    $n_carrera1= mysqli_query($link, $consultaCarrera1) or die("Error al ejecutar la consulta de cantidad de pacientes de la carrera 1");
    $n_carrera2= mysqli_query($link, $consultaCarrera2) or die("Error al ejecutar la consulta de cantidad de pacientes de la carrera 2 ");
    $n_carrera3= mysqli_query($link, $consultaCarrera3) or die("Error al ejecutar la consulta de cantidad de pacientes de la carrera 3");
    $n_carrera4= mysqli_query($link, $consultaCarrera4) or die("Error al ejecutar la consulta de cantidad de pacientes de la carrera 4");
    $n_carrera5= mysqli_query($link, $consultaCarrera5) or die("Error al ejecutar la consulta de cantidad de pacientes de la carrera 5");

    $n_academia1= mysqli_query($link, $consultaAcademia1) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 1");
    $n_academia2= mysqli_query($link, $consultaAcademia2) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 2 ");
    $n_academia3= mysqli_query($link, $consultaAcademia3) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 3");
    $n_academia4= mysqli_query($link, $consultaAcademia4) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 4");
    $n_academia5= mysqli_query($link, $consultaAcademia5) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 5");
    $n_academia6= mysqli_query($link, $consultaAcademia6) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 6");
    $n_academia7= mysqli_query($link, $consultaAcademia7) or die("Error al ejecutar la consulta de cantidad de pacientes de la Academia 7");
 
    $n_pacientesAlumnos= mysqli_query($link, $consultaTipo1) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 1");
    $n_pacientesDocentes= mysqli_query($link, $consultaTipo2) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 2 ");
    $n_pacientesPAAE= mysqli_query($link, $consultaTipo3) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 3");

    $n_SinNSS  = mysqli_query($link, $consulta_n_SinNSS) or die("Error al ejecutar la consulta de cantidad de pacientes sin NSS ");
    $SinNSS = mysqli_query($link, $consulta_SinNSS) or die("Error al ejecutar la consulta de pacientes sin NSS ");
    
    $n_SinCURP = mysqli_query($link, $consulta_n_SinCURP) or die("Error al ejecutar la consulta de cantidad de pacientes sin CURP ");
    $SinCURP = mysqli_query($link, $consulta_SinCURP) or die("Error al ejecutar la consulta de pacientes sin CURP ");
    
    $n_SinVIGENCIA = mysqli_query($link, $consulta_n_SinVIGENCIA) or die("Error al ejecutar la consulta de cantidad de pacientes sin vigencia de derechos ");
    $SinVIGENCIA = mysqli_query($link, $consulta_SinVIGENCIA) or die("Error al ejecutar la consulta de pacientes sin vigencia de derechos ");
    
    $n_consultas_fechas = mysqli_query($link, $consultas_fecha) or die("Error al ejecutar la consulta de pacientes sin vigencia de derechos ");
    
    
    mysqli_close($link);

    $rows_n_pacientes= array();
    $rows_n_pacientesH= array();
    $rows_n_pacientesM= array();
    $rows_n_carrera1= array();
    $rows_n_carrera2= array();
    $rows_n_carrera3= array();
    $rows_n_carrera4= array();
    $rows_n_carrera5= array();
    $rows_n_academia1= array();
    $rows_n_academia2= array();
    $rows_n_academia3= array();
    $rows_n_academia4= array();
    $rows_n_academia5= array();
    $rows_n_academia6= array();
    $rows_n_academia7= array();
    $rows_n_pacientesAlumnos= array();
    $rows_n_pacientesDocentes= array();
    $rows_n_pacientesPAAE= array();
    $rows_n_SinNSS= array();
    $rows_SinNSS= array();
    $rows_n_SinCURP= array();
    $rows_SinCURP= array();
    $rows_n_SinVIGENCIA= array();
    $rows_SinVIGENCIA= array();
    $row_n_consultas_fechas = array();

    while ($r = mysqli_fetch_assoc($n_pacientes)) {
        $rows_n_pacientes[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_pacientesH)) {
        $rows_n_pacientesH[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_pacientesM)) {
        $rows_n_pacientesM[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_carrera1)) {
        $rows_n_carrera1[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_carrera2)) {
        $rows_n_carrera2[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_carrera3)) {
        $rows_n_carrera3[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_carrera4)) {
        $rows_n_carrera4[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_carrera5)) {
        $rows_n_carrera5[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia1)) {
        $rows_n_academia1[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia2)) {
        $rows_n_academia2[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia3)) {
        $rows_n_academia3[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia4)) {
        $rows_n_academia4[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia5)) {
        $rows_n_academia5[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia6)) {
        $rows_n_academia6[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_academia7)) {
        $rows_n_academia7[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_pacientesAlumnos)) {
        $rows_n_pacientesAlumnos[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_pacientesDocentes)) {
        $rows_n_pacientesDocentes[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_pacientesPAAE)) {
        $rows_n_pacientesPAAE[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_SinNSS)) {
        $rows_n_SinNSS[] = $r;
    }

    while ($r = mysqli_fetch_assoc($SinNSS)) {
        $rows_SinNSS[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_SinCURP)) {
        $rows_n_SinCURP[] = $r;
    }

    while ($r = mysqli_fetch_assoc($SinCURP)) {
        $rows_SinCURP[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_SinVIGENCIA)) {
        $rows_n_SinVIGENCIA[] = $r;
    }

    while ($r = mysqli_fetch_assoc($SinVIGENCIA)) {
        $rows_SinVIGENCIA[] = $r;
    }

    while ($r = mysqli_fetch_assoc($n_consultas_fechas)) {
        $rows_n_consultas_fechas[] = $r;
    }

    $arr = array('n_pacientes' => $rows_n_pacientes,
    'n_pacientesH' => $rows_n_pacientesH ,
    'n_pacientesM' => $rows_n_pacientesM,
    'n_carrera1' => $rows_n_carrera1,
    'n_carrera2' => $rows_n_carrera2,
    'n_carrera3' => $rows_n_carrera3,
    'n_carrera4' => $rows_n_carrera4,
    'n_carrera5' => $rows_n_carrera5,
    'n_academia1' => $rows_n_academia1,
    'n_academia2' => $rows_n_academia2,
    'n_academia3' => $rows_n_academia3,
    'n_academia4' => $rows_n_academia4,
    'n_academia5' => $rows_n_academia5,
    'n_academia6' => $rows_n_academia6,
    'n_academia7' => $rows_n_academia7,
    'n_pacientesAlumnos' => $rows_n_pacientesAlumnos,
    'n_pacientesDocentes' => $rows_n_pacientesDocentes,
    'n_pacientesPAAE' => $rows_n_pacientesPAAE,
    'n_SinNSS' => $rows_n_SinNSS,
    'SinNSS' => $rows_SinNSS,
    'n_SinCURP' => $rows_n_SinCURP,
    'SinCURP' => $rows_SinCURP,
    'n_SinVIGENCIA' => $rows_n_SinVIGENCIA,
    'SinVIGENCIA' => $rows_SinVIGENCIA,
    'n_consultas_fechas' => $rows_n_consultas_fechas
                                    );

    echo json_encode($arr);
