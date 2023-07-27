<?php

function connect()
{
    $servidor = "localhost";
    $usuario  = "u452640354_carlos";
    $clave    = "H9qA.Z7tpkvFNcH";
    $base     = "u452640354_tecweb2020";

    $conexion = mysqli_connect($servidor, $usuario, $clave, $base);

    if (!$conexion) {
        echo "Error: No se pudo conectar a MySQL." . PHP_EOL; // IMPRIME MENSAJE DE ERROR PERSONALIZADO  Y SE TERMINA LA LÍNEA
        echo "error de depuración: " . mysqli_connect_errno() . PHP_EOL;// IDENTIFICA EL ERROR CON CÓDIGO O NOMBRE
        exit;
    }

    return $conexion;
}

require('fpdf.php');

class PDF extends FPDF
{
    //Cabeza
    public function Header()
    {
        //(nombre, coordenadas x, coordenadas y, tamaño)
        $this->Image('logoIPN.jpg', 0, 5, 30);

        $this->SetFont('Arial', 'B', 25);

        //Movernos a la derecha
        $this->Cell(80);

        //titulo (ancho de celda, alto de celda, texto, borde o no )
        $this->Cell(30, 18, utf8_decode('Reporte de consultas'), 0, 0, 'C');
     
        //Salto de línea
        $this->Ln(20);
    }
    
    //Pie pag
    public function Footer()
    {
        //posicion final
        $this->SetY(-15);
        //Arial
        $this->SetFont('Arial', 'I', 8);
        //Num pag
        $this->Cell(0, 10, utf8_decode('Página ').$this->PageNo().'/{nb}', 0, 0, 'C');
    }
}

$link=connect();

$PDF = new PDF();
$PDF -> AliasNbPages();
$PDF ->Addpage();

$fecha_inicial = $_GET['fecha1'];
$fecha_final = $_GET['fecha2'];

//saber cuentos pacientes hay sin borrado logico
$consulta  = "SELECT count(borrar_orientacion) FROM `paciente` WHERE borrar_orientacion = '0'";
// Sentencia correcta en sql es SELECT COUNT(borrar) FROM `paciente` WHERE sexo = 'H' AND borrar = 0
//consulta2 y consulta3--> Son para saber cuantos pacientes SIN borrado logico hay, tanto en hombre como mujeres
$consulta2  = "SELECT count(borrar_orientacion) FROM `paciente` WHERE borrar_orientacion = '0' AND sexo= 'H' " ;//hombres
$consulta3  = "SELECT count(borrar_orientacion) FROM `paciente` WHERE borrar_orientacion = '0' AND sexo= 'M' " ;//mujeres

//Sentencia correcta en sql es SELECT count(carrera) FROM `paciente` WHERE borrar = 0 AND carrera= 5
// $consultaCarrera1 =  "SELECT count(`PA`.`carrera`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`carrera`= '1' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//carrera1-->Metalurgica
// $consultaCarrera2 =  "SELECT count(`PA`.`carrera`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`carrera`= '2' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//carrera2-->Meca
// $consultaCarrera3 =  "SELECT count(`PA`.`carrera`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`carrera`= '3' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//carrera3-->Alimentos
// $consultaCarrera4 =  "SELECT count(`PA`.`carrera`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`carrera`= '4' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//carrera4-->Ambiental
// $consultaCarrera5 =  "SELECT count(`PA`.`carrera`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`carrera`= '5' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//carrera5-->Sistemas
$consultaCarrera1 =  "SELECT count(carrera) FROM `paciente` WHERE borrar_orientacion = '0' AND carrera= '1' " ;//carrera1-->Metalurgica
$consultaCarrera2 =  "SELECT count(carrera) FROM `paciente` WHERE borrar_orientacion = '0' AND carrera= '2' " ;//carrera2-->Meca
$consultaCarrera3 =  "SELECT count(carrera) FROM `paciente` WHERE borrar_orientacion = '0' AND carrera= '3' " ;//carrera3-->Alimentos
$consultaCarrera4 =  "SELECT count(carrera) FROM `paciente` WHERE borrar_orientacion = '0' AND carrera= '4' " ;//carrera4-->Ambiental
$consultaCarrera5 =  "SELECT count(carrera) FROM `paciente` WHERE borrar_orientacion = '0' AND carrera= '5' " ;//carrera5-->Sistemas

//Sentencia correcta en sql es SELECT count(academia) FROM `paciente` WHERE borrar = 0 AND academia= 1
$consultaAcademia1 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '1' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia1-->Bioingenieria
$consultaAcademia2 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '2' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia2-->Fisico-matematicas
$consultaAcademia3 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '3' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia3-->meca
$consultaAcademia4 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '4' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia4-->Qimico-biologicas
$consultaAcademia5 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '5' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia5-->Sociales e ingles
$consultaAcademia6 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '6' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia6-->Metalurgica
$consultaAcademia7 =  "SELECT count(`PA`.`academia`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `PA`.`borrar_orientacion` = '0' AND `PA`.`academia`= '7' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'" ;//academia7-->Ciencias de la computacion

//Sentencia correcta en sql SELECT count(tipo) FROM `paciente` WHERE borrar_orientacion = '0' AND tipo= '1'
$consultaTipo1 =  "SELECT count(tipo) FROM `paciente` WHERE borrar_orientacion = '0' AND tipo= '1' ";//tipo1-->Alumno
$consultaTipo2 =  "SELECT count(tipo) FROM `paciente` WHERE borrar_orientacion = '0' AND tipo= '2' ";//tipo2-->Docente 
$consultaTipo3 =  "SELECT count(tipo) FROM `paciente` WHERE borrar_orientacion = '0' AND tipo= '3' ";//tipo3-->PAAE
$consultaTipo4 =  "SELECT count(tipo) FROM `paciente` WHERE borrar_orientacion = '0' AND tipo= '4' ";//tipo4-->Externo

$consultaTipoN =  "SELECT `tipo` FROM `paciente` WHERE borrar_orientacion = '0' ";

//Agruge lo de que tipo de consulta es de orientacion JDDD
//Sentencia correcta en sql es "SELECT count(CO.tipo_atenc) FROM consulta_orient AS CO INNER JOIN paciente AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = 1 AND PA.borrar_orientacion = 0
$tipoAtencion1= "SELECT count(`CO`.`tipo_atenc`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '1' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";//tipo1-->Consulta individual orientacion psicologica
$tipoAtencion2= "SELECT count(`CO`.`tipo_atenc`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '2' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";//tipo2-->Consulta individual orientacion educativa
$tipoAtencion3= "SELECT count(`CO`.`tipo_atenc`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '3' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";//tipo3-->Aplicacion de pruebas psicologicas 
$tipoAtencion4= "SELECT count(`CO`.`tipo_atenc`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '4' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";//tipo4-->Canalizacion
$tipoAtencion5= "SELECT count(`CO`.`tipo_atenc`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '5' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";//tipo5-->Atencion Familiar
$tipoAtencion6= "SELECT count(`CO`.`tipo_atenc`) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente` = `PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '6' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";//tipo6-->COSECOVI/Denuncias de red de genero

//Agruge Para saber cuantos son de cada tipo de consulta JDDD
/// consulta correcta en sql es SELECT count(PA.boleta) FROM `consulta_orient` AS CO INNER JOIN `paciente` AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = '1' AND PA.borrar_orientacion = '0' 
$consulta_n_tipoAtencion1 =  "SELECT count(PA.boleta) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '1' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."' ";
$consulta_tipoAtencion1 =  "SELECT * FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '1' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";

/// consulta correcta en sql es SELECT count(PA.boleta) FROM `consulta_orient` AS CO INNER JOIN `paciente` AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = '2' AND PA.borrar_orientacion = '0' 
$consulta_n_tipoAtencion2 =  "SELECT count(PA.boleta) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '2' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";
$consulta_tipoAtencion2 =  "SELECT * FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '2' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";

/// consulta correcta en sql es SELECT count(PA.boleta) FROM `consulta_orient` AS CO INNER JOIN `paciente` AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = '3' AND PA.borrar_orientacion = '0' 
$consulta_n_tipoAtencion3 =  "SELECT count(PA.boleta) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '3' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";
$consulta_tipoAtencion3 =  "SELECT * FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '3' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";

/// consulta correcta en sql es SELECT count(PA.boleta) FROM `consulta_orient` AS CO INNER JOIN `paciente` AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = '4' AND PA.borrar_orientacion = '0' 
$consulta_n_tipoAtencion4 =  "SELECT count(PA.boleta) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '4' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";
$consulta_tipoAtencion4 =  "SELECT * FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '4' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";

/// consulta correcta en sql es SELECT count(PA.boleta) FROM `consulta_orient` AS CO INNER JOIN `paciente` AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = '5' AND PA.borrar_orientacion = '0' 
$consulta_n_tipoAtencion5 =  "SELECT count(PA.boleta) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '5' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";
$consulta_tipoAtencion5 =  "SELECT * FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '5' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";

/// consulta correcta en sql es SELECT count(PA.boleta) FROM `consulta_orient` AS CO INNER JOIN `paciente` AS PA ON CO.id_paciente=PA.id_paciente WHERE CO.tipo_atenc = '6' AND PA.borrar_orientacion = '0' 
$consulta_n_tipoAtencion6 =  "SELECT count(PA.boleta) FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '6' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";
$consulta_tipoAtencion6 =  "SELECT * FROM `consulta_orient` AS `CO` INNER JOIN `paciente` AS `PA` ON `CO`.`id_paciente`=`PA`.`id_paciente` WHERE `CO`.`tipo_atenc` = '6' AND `PA`.`borrar_orientacion` = '0' AND `CO`.`fecha` <= '". $fecha_final ."' AND `CO`.`fecha` >= '". $fecha_inicial ."'";

//saber cuantos pacientes hay sin borrado logico
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

///JDDD
$n_tipoAtencion1= mysqli_query($link, $tipoAtencion1) or die("Error al ejecutar la consulta de cantidad de tipo de antencion Tipo 1");
$n_tipoAtencion2= mysqli_query($link, $tipoAtencion2) or die("Error al ejecutar la consulta de cantidad de tipo de antencion Tipo 2");
$n_tipoAtencion3= mysqli_query($link, $tipoAtencion3) or die("Error al ejecutar la consulta de cantidad de tipo de antencion Tipo 3");
$n_tipoAtencion4= mysqli_query($link, $tipoAtencion4) or die("Error al ejecutar la consulta de cantidad de tipo de antencion Tipo 4");
$n_tipoAtencion5= mysqli_query($link, $tipoAtencion5) or die("Error al ejecutar la consulta de cantidad de tipo de antencion Tipo 5");
$n_tipoAtencion6= mysqli_query($link, $tipoAtencion6) or die("Error al ejecutar la consulta de cantidad de tipo de antencion Tipo 6");

///JDDD
$n_tipoA1= mysqli_query($link, $consulta_n_tipoAtencion1) or die("Error al ejecutar la consulta de cantidad de pacientes tipo de antencion Tipo 1");
$tipoA1=  mysqli_query($link, $consulta_tipoAtencion1) or die("Error al ejecutar la consulta de cantidad de pacientes de tipo de antencion Tipo 1");

$n_tipoA2= mysqli_query($link, $consulta_n_tipoAtencion2) or die("Error al ejecutar la consulta de cantidad de pacientes tipo de antencion Tipo 2");
$tipoA2=  mysqli_query($link, $consulta_tipoAtencion2) or die("Error al ejecutar la consulta de cantidad de pacientes de tipo de antencion Tipo 2");

$n_tipoA3= mysqli_query($link, $consulta_n_tipoAtencion3) or die("Error al ejecutar la consulta de cantidad de pacientes tipo de antencion Tipo 3");
$tipoA3=  mysqli_query($link, $consulta_tipoAtencion3) or die("Error al ejecutar la consulta de cantidad de pacientes de tipo de antencion Tipo 3");

$n_tipoA4= mysqli_query($link, $consulta_n_tipoAtencion4) or die("Error al ejecutar la consulta de cantidad de pacientes tipo de antencion Tipo 4");
$tipoA4=  mysqli_query($link, $consulta_tipoAtencion4) or die("Error al ejecutar la consulta de cantidad de pacientes de tipo de antencion Tipo 4");

$n_tipoA5= mysqli_query($link, $consulta_n_tipoAtencion5) or die("Error al ejecutar la consulta de cantidad de pacientes tipo de antencion Tipo 5");
$tipoA5=  mysqli_query($link, $consulta_tipoAtencion5) or die("Error al ejecutar la consulta de cantidad de pacientes de tipo de antencion Tipo 5");

$n_tipoA6= mysqli_query($link, $consulta_n_tipoAtencion6) or die("Error al ejecutar la consulta de cantidad de pacientes tipo de antencion Tipo 6");
$tipoA6=  mysqli_query($link, $consulta_tipoAtencion6) or die("Error al ejecutar la consulta de cantidad de pacientes de tipo de antencion Tipo 6");


$n_pacientesAlumnos= mysqli_query($link, $consultaTipo1) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 1");
$n_pacientesDocentes= mysqli_query($link, $consultaTipo2) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 2 ");
$n_pacientesPAAE= mysqli_query($link, $consultaTipo3) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 3");
$n_pacientesExterno= mysqli_query($link, $consultaTipo4) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 4");
$tipoN = mysqli_query($link, $consultaTipoN) or die("Error al ejecutar la consulta del tipo de paciente");


 //$fecha_inicial ="20200907"; // $_GET['fecha1'];
 //$fecha_final = "20200907"; //$_GET['fecha2'];
 
 
 ///JDDD
 $consultas_fecha = "SELECT count(id_consulta) FROM `consulta_orient` WHERE `fecha` <= '". $fecha_final ."' AND `fecha` >= '". $fecha_inicial ."'";
 $n_consultas_fechas = mysqli_query($link, $consultas_fecha) or die("Error al ejecutar la consulta de pacientes sin vigencia de derechos ");



while ($r = mysqli_fetch_assoc($n_consultas_fechas)) {
    $rows_n_consultas_fechas[] = $r;
}

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
///JDDD////////////////////////////
while ($r = mysqli_fetch_assoc($n_tipoAtencion1)) {
    $rows_n_tipoAtencion1[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoAtencion2)) {
    $rows_n_tipoAtencion2[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoAtencion3)) {
    $rows_n_tipoAtencion3[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoAtencion4)) {
    $rows_n_tipoAtencion4[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoAtencion5)) {
    $rows_n_tipoAtencion5[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoAtencion6)) {
    $rows_n_tipoAtencion6[] = $r;
}
///JDDD////////////////////////////
while ($r = mysqli_fetch_assoc($n_tipoA1)) {
    $rows_n_tipoA1[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoA1)) {
    $rows_tipoA1[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoA2)) {
    $rows_n_tipoA2[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoA2)) {
    $rows_tipoA2[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoA3)) {
    $rows_n_tipoA3[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoA3)) {
    $rows_tipoA3[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoA4)) {
    $rows_n_tipoA4[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoA4)) {
    $rows_tipoA4[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoA5)) {
    $rows_n_tipoA5[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoA5)) {
    $rows_tipoA5[] = $r;
}

while ($r = mysqli_fetch_assoc($n_tipoA6)) {
    $rows_n_tipoA6[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoA6)) {
    $rows_tipoA6[] = $r;
}
////////////////////////////////

while ($r = mysqli_fetch_assoc($n_pacientesAlumnos)) {
    $rows_n_pacientesAlumnos[] = $r;
}

while ($r = mysqli_fetch_assoc($n_pacientesDocentes)) {
    $rows_n_pacientesDocentes[] = $r;
}

while ($r = mysqli_fetch_assoc($n_pacientesPAAE)) {
    $rows_n_pacientesPAAE[] = $r;
}
while ($r = mysqli_fetch_assoc($n_pacientesExterno)) {
    $rows_n_pacientesExterno[] = $r;
}

while ($r = mysqli_fetch_assoc($tipoN)) {
    $rows_tipoN[] = $r;
}

//COLUMNAS QUE SE MUESTRAN

$n30= strval(implode($rows_n_consultas_fechas[0]));//valor en int para el ciclo

$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(182, 10, 'Cantidad de consultas en el periodo de tiempo seleccionado', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(60, 8, 'Desde', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Hasta', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Total de consultas realizadas', 1, 1, 'C', 0);// el ultimo crea un salto de linea
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(60, 8, $fecha_inicial, 1, 0, 'C', 0);
$PDF->Cell(60, 8, $fecha_final, 1, 0, 'C', 0);
$PDF->Cell(60, 8, $n30, 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->Ln(6);//Salto de línea

//COLUMNAS QUE SE MUESTRAN
$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(89, 8, 'Cantidad de pacientes activos', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(60, 8, 'Hombres', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Mujeres', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Total', 1, 1, 'C', 0);// el ultimo crea un salto de linea
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(60, 8, implode($rows_n_pacientesH[0]), 1, 0, 'C', 0);
$PDF->Cell(60, 8, implode($rows_n_pacientesM[0]), 1, 0, 'C', 0);
$PDF->Cell(60, 8, ''.implode($rows_n_pacientes[0]).'', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->Ln(6);//Salto de línea


//COLUMNAS por carrera ///////////////////REVISAR NUMEROS
$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(102, 10, 'Cantidad de pacientes por carrera', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(38, 8, utf8_decode('Metalúrgica'), 1, 0, 'C', 0);
$PDF->Cell(38, 8, utf8_decode('Mecatrónica'), 1, 0, 'C', 0);
$PDF->Cell(38, 8, 'Alimentos', 1, 0, 'C', 0);
$PDF->Cell(38, 8, 'Ambiental', 1, 0, 'C', 0);
$PDF->SetFont('Arial', 'B', 8);
$PDF->Cell(38, 8, 'Sistemas computacionales', 1, 1, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(38, 8, implode($rows_n_carrera1[0]), 1, 0, 'C', 0);
$PDF->Cell(38, 8, implode($rows_n_carrera2[0]), 1, 0, 'C', 0);
$PDF->Cell(38, 8, implode($rows_n_carrera3[0]), 1, 0, 'C', 0);
$PDF->Cell(38, 8, implode($rows_n_carrera4[0]), 1, 0, 'C', 0);
$PDF->Cell(38, 8, implode($rows_n_carrera5[0]), 1, 1, 'C', 0);

$PDF->Ln(6);//Salto de línea

//COLUMNAS por academia
$PDF->SetFont('Arial', 'B', 20);
$PDF->Cell(120, 10, 'Cantidad de pacientes por academia', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Bioingeniería'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia1[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Físico - Matemáticas'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia2[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Mecatrónica'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia3[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Químico - Biológicas'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia4[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Sociales e Ingles'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia5[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Metalúrgica'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia6[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(70, 10, utf8_decode('Ciencias de la computación'), 1, 0, 'C', 0);
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(25, 10, implode($rows_n_academia7[0]), 1, 1, 'C', 0);

$PDF->Ln(6);//Salto de línea

//COLUMNAS QUE SE MUESTRAN
$PDF->SetFont('Arial', 'B', 20);
$PDF->Cell(120, 8, utf8_decode('Cantidad de pacientes por categoría'), 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(48, 8, 'Alumno', 1, 0, 'C', 0);
$PDF->Cell(48, 8, 'Docente', 1, 0, 'C', 0);
$PDF->Cell(48, 8, 'PAAE', 1, 0, 'C', 0);
$PDF->Cell(48, 8, 'Externo', 1, 1, 'C', 0);// el ultimo crea un salto de linea
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(48, 8, implode($rows_n_pacientesAlumnos[0]), 1, 0, 'C', 0);
$PDF->Cell(48, 8, implode($rows_n_pacientesDocentes[0]), 1, 0, 'C', 0);
$PDF->Cell(48, 8, ''.implode($rows_n_pacientesPAAE[0]).'', 1, 0, 'C', 0);// el ultimo crea un salto de linea
$PDF->Cell(48, 8, ''.implode($rows_n_pacientesExterno[0]).'', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->Ln(6);//Salto de línea

//COLUMNAS por academia
$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(128, 10, 'Cantidad de pacientes por tipo de consulta', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Consulta individual orientación psicológica'), 1, 0, 'C', 0);//tipo1
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_tipoAtencion1[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Consulta individual orientación educativa'), 1, 0, 'C', 0);//tipo2
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_tipoAtencion2[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Aplicación de pruebas psicológicas '), 1, 0, 'C', 0);//tipo3
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_tipoAtencion3[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Canalización'), 1, 0, 'C', 0);//tipo4 
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_tipoAtencion4[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Atención Familiar'), 1, 0, 'C', 0);//tipo5
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_tipoAtencion5[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('COSECOVI/Denuncias de red de genero'), 1, 0, 'C', 0);//tipo6
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_tipoAtencion6[0]), 1, 1, 'C', 0);

$PDF->Ln(6);//Salto de línea

// //Ahora tenemos que utilizar la variable del total de alumnos consultados por cada tipo de consulta
// $n1= strval(implode($rows_n_tipoAtencion1[0]));//valor en int para el ciclo
// $n2= strval(implode($rows_n_tipoAtencion2[0]));//valor en int para el ciclo
// $n3= strval(implode($rows_n_tipoAtencion3[0]));//valor en int para el ciclo
// $n4= strval(implode($rows_n_tipoAtencion4[0]));//valor en int para el ciclo
// $n5= strval(implode($rows_n_tipoAtencion5[0]));//valor en int para el ciclo
// $n6= strval(implode($rows_n_tipoAtencion6[0]));//valor en int para el ciclo

// ///LISTA DE LOS QUE fueron consultados por tipo 1
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(190, 10, utf8_decode('Lista de Consulta individual orientación psicológica '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
// $PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);


// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n1; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_tipoA1[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA1[$i]['nombres']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA1[$i]['pa']), 1, 0, 'C', 0);

//     //para saber la categoria
//     $temporal = strval($rows_tipoA1[$i]['tipo']);

//     if ($temporal == 1) {
//         $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
//     } elseif ($temporal == 2) {
//         $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
//     } elseif ($temporal == 3) {
//         $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
//     } elseif ($temporal == 4) {
//         $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
//     } else {
//         $PDF->SetFont('Arial', '', 8);
//         $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
//     }
// }

// $PDF->Ln(6);//Salto de línea

// ///LISTA DE LOS QUE fueron consultados por tipo 2
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(190, 10, utf8_decode('Lista de Consulta individual orientación educativa '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
// $PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);


// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n2; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_tipoA2[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA2[$i]['nombres']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA2[$i]['pa']), 1, 0, 'C', 0);

//     //para saber la categoria
//     $temporal = strval($rows_tipoA2[$i]['tipo']);

//     if ($temporal == 1) {
//         $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
//     } elseif ($temporal == 2) {
//         $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
//     } elseif ($temporal == 3) {
//         $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
//     } elseif ($temporal == 4) {
//         $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
//     } else {
//         $PDF->SetFont('Arial', '', 8);
//         $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
//     }
// }

// $PDF->Ln(6);//Salto de línea

// ///LISTA DE LOS QUE fueron consultados por tipo 3
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(190, 10, utf8_decode('Aplicación de pruebas psicológicas '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
// $PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);


// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n3; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_tipoA3[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA3[$i]['nombres']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA3[$i]['pa']), 1, 0, 'C', 0);

//     //para saber la categoria
//     $temporal = strval($rows_tipoA3[$i]['tipo']);

//     if ($temporal == 1) {
//         $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
//     } elseif ($temporal == 2) {
//         $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
//     } elseif ($temporal == 3) {
//         $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
//     } elseif ($temporal == 4) {
//         $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
//     } else {
//         $PDF->SetFont('Arial', '', 8);
//         $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
//     }
// }

// $PDF->Ln(6);//Salto de línea

// ///LISTA DE LOS QUE fueron consultados por tipo 4
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(190, 10, utf8_decode('Canalización '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
// $PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);


// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n4; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_tipoA4[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA4[$i]['nombres']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA4[$i]['pa']), 1, 0, 'C', 0);

//     //para saber la categoria
//     $temporal = strval($rows_tipoA4[$i]['tipo']);

//     if ($temporal == 1) {
//         $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
//     } elseif ($temporal == 2) {
//         $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
//     } elseif ($temporal == 3) {
//         $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
//     } elseif ($temporal == 4) {
//         $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
//     } else {
//         $PDF->SetFont('Arial', '', 8);
//         $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
//     }
// }

// $PDF->Ln(6);//Salto de línea

// ///LISTA DE LOS QUE fueron consultados por tipo 5
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(190, 10, utf8_decode('Atención Familiar '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
// $PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);


// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n5; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_tipoA5[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA5[$i]['nombres']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA5[$i]['pa']), 1, 0, 'C', 0);

//     //para saber la categoria
//     $temporal = strval($rows_tipoA5[$i]['tipo']);

//     if ($temporal == 1) {
//         $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
//     } elseif ($temporal == 2) {
//         $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
//     } elseif ($temporal == 3) {
//         $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
//     } elseif ($temporal == 4) {
//         $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
//     } else {
//         $PDF->SetFont('Arial', '', 8);
//         $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
//     }
// }

// $PDF->Ln(6);//Salto de línea

// ///LISTA DE LOS QUE fueron consultados por tipo 5
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(190, 10, utf8_decode('Atención Familiar '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
// $PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);


// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n6; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_tipoA6[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA6[$i]['nombres']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_tipoA6[$i]['pa']), 1, 0, 'C', 0);

//     //para saber la categoria
//     $temporal = strval($rows_tipoA6[$i]['tipo']);

//     if ($temporal == 1) {
//         $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
//     } elseif ($temporal == 2) {
//         $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
//     } elseif ($temporal == 3) {
//         $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
//     } elseif ($temporal == 4) {
//         $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
//     } else {
//         $PDF->SetFont('Arial', '', 8);
//         $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
//     }
// }

// $PDF->Ln(6);//Salto de línea

$PDF ->Output();

mysqli_close($link);

?>