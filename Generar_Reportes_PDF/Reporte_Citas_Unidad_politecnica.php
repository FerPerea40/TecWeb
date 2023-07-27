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
        $this->Cell(30, 18, utf8_decode('Reporte de citas'), 0, 0, 'C');
     
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

// Consulta para saber cuantos fueron consultados en esas fechas de cada departamento
$fecha_inicial = $_GET['fecha1'];
$fecha_final = $_GET['fecha2'];

//gestion escolar
//$n_consultados_gestion_es= "SELECT count(id) FROM `cita_gestion_escolar` WHERE `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

//extension y apoyos 
//$n_consultados_extension_apoy= "SELECT count(id) FROM `extension_y_apoyos` WHERE `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

//orientacion juvenil
// $n_consultados_orientacion_juvenil= "SELECT count(id) FROM `unidad_politecnica` WHERE `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

//servicios estudiantiles
//$n_consultados_servicio_estud= "SELECT count(id) FROM `orientacón_juvenil` WHERE `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

//servicio medico
//$n_consultados_servicio_medico= "SELECT count(id) FROM `servicio_medico` WHERE `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

//unidad politecnica 
$n_consultados_unidad_poli= "SELECT count(id) FROM `unidad_politecnica` WHERE `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";
$npacientes_12345="SELECT count(motivo) FROM `unidad_politecnica` WHERE motivo = '12345' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

//Sentencia para contar cuantos son de cada motivo 
$n_m1 = "SELECT count(motivo) FROM `unidad_politecnica` WHERE motivo = '1' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'" ;
$motivo1 = "SELECT *FROM `unidad_politecnica` WHERE motivo = '1' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

$n_m2 = "SELECT count(motivo) FROM `unidad_politecnica` WHERE motivo = '2' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'" ;
$motivo2 = "SELECT *FROM `unidad_politecnica` WHERE motivo = '2' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

$n_m3 = "SELECT count(motivo) FROM `unidad_politecnica` WHERE motivo = '3' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'" ;
$motivo3 = "SELECT *FROM `unidad_politecnica` WHERE motivo = '3' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

// $n_m4 = "SELECT count(motivo) FROM `unidad_politecnica` WHERE motivo = '4' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'" ;
// $motivo4 = "SELECT *FROM `unidad_politecnica` WHERE motivo = '4' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";

// $n_m5 = "SELECT count(motivo) FROM `unidad_politecnica` WHERE motivo = '5' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'" ;
// $motivo5 = "SELECT *FROM `unidad_politecnica` WHERE motivo = '5' AND `dia` <= '". $fecha_final ."' AND `dia` >= '". $fecha_inicial ."'";


$n_citas = mysqli_query($link, $n_consultados_unidad_poli) or die("Error al ejecutar la consulta de cantidad de citas totales");
$n_12345 = mysqli_query($link, $npacientes_12345) or die("Error al ejecutar la consulta de cantidad de pacientes 12345");

$n_motivo1 = mysqli_query($link, $n_m1) or die("Error al ejecutar la consulta de cantidad de motivo 1");
$mot1 = mysqli_query($link, $motivo1) or die("Error al ejecutar la consulta de motivo 1");

$n_motivo2 = mysqli_query($link, $n_m2) or die("Error al ejecutar la consulta de cantidad de motivo 2");
$mot2 = mysqli_query($link, $motivo2) or die("Error al ejecutar la consulta de motivo 2");

$n_motivo3 = mysqli_query($link, $n_m3) or die("Error al ejecutar la consulta de cantidad de motivo 3");
$mot3 = mysqli_query($link, $motivo3) or die("Error al ejecutar la consulta de motivo 3");

// $n_motivo4 = mysqli_query($link, $n_m4) or die("Error al ejecutar la consulta de cantidad de motivo 4");
// $mot4 = mysqli_query($link, $motivo4) or die("Error al ejecutar la consulta de motivo 4");

// $n_motivo5 = mysqli_query($link, $n_m5) or die("Error al ejecutar la consulta de cantidad de motivo 5");
// $mot5 = mysqli_query($link, $motivo5) or die("Error al ejecutar la consulta de motivo 5");

while ($r = mysqli_fetch_assoc($n_citas)) {
    $rows_n_citas[] = $r;
}

while ($r = mysqli_fetch_assoc($n_12345)) {
    $rows_n_12345[] = $r;
}

while ($r = mysqli_fetch_assoc($n_motivo1)) {
    $rows_n_motivo1[] = $r;
}

while ($r = mysqli_fetch_assoc($mot1)) {
    $rows_motivo1[] = $r;
}

while ($r = mysqli_fetch_assoc($n_motivo2)) {
    $rows_n_motivo2[] = $r;
}

while ($r = mysqli_fetch_assoc($mot2)) {
    $rows_motivo2[] = $r;
}

while ($r = mysqli_fetch_assoc($n_motivo3)) {
    $rows_n_motivo3[] = $r;
}

while ($r = mysqli_fetch_assoc($mot3)) {
    $rows_motivo3[] = $r;
}

// while ($r = mysqli_fetch_assoc($n_motivo4)) {
//     $rows_n_motivo4[] = $r;
// }

// while ($r = mysqli_fetch_assoc($mot4)) {
//     $rows_motivo4[] = $r;
// }

// while ($r = mysqli_fetch_assoc($n_motivo5)) {
//     $rows_n_motivo5[] = $r;
// }

// while ($r = mysqli_fetch_assoc($mot5)) {
//     $rows_motivo5[] = $r;
// }


//COLUMNAS QUE SE MUESTRAN
$n30= strval(implode($rows_n_citas[0]));//valor en int de citas totales segun fecha 
$n40= strval(implode($rows_n_12345[0]));//valor en int de citas tipo 12345
$n50=$n30 - $n40; //las restamos

$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(168, 10, 'Cantidad de citas en el periodo de tiempo seleccionado', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(60, 8, 'Desde', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Hasta', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Total de citas realizadas', 1, 1, 'C', 0);// el ultimo crea un salto de linea
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(60, 8, $fecha_inicial, 1, 0, 'C', 0);
$PDF->Cell(60, 8, $fecha_final, 1, 0, 'C', 0);
$PDF->Cell(60, 8, $n50, 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->Ln(6);//Salto de línea

//COLUMNAS por tipo de motivo 
$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(125, 10, 'Cantidad de pacientes por tipo de motivo ', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Poliemprende'), 1, 0, 'C', 0);//tipo1
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_motivo1[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Egresados '), 1, 0, 'C', 0);//tipo2
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_motivo2[0]), 1, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 9.4);
$PDF->Cell(70, 10, utf8_decode('Otro'), 1, 0, 'C', 0);//tipo3
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(25, 10, implode($rows_n_motivo3[0]), 1, 1, 'C', 0);

// $PDF->SetFont('Arial', 'B', 9.4);
// $PDF->Cell(70, 10, utf8_decode('motivo 4'), 1, 0, 'C', 0);//tipo4 
// $PDF->SetFont('Arial', '', 12);
// $PDF->Cell(25, 10, implode($rows_n_motivo4[0]), 1, 1, 'C', 0);

// $PDF->SetFont('Arial', 'B', 9.4);
// $PDF->Cell(70, 10, utf8_decode('motivo 5'), 1, 0, 'C', 0);//tipo5
// $PDF->SetFont('Arial', '', 12);
// $PDF->Cell(25, 10, implode($rows_n_motivo5[0]), 1, 1, 'C', 0);

$PDF->Ln(6);//Salto de línea

//Ahora tenemos que utilizar la variable del total de alumnos citados por cada tipo de motivo
$n1= strval(implode($rows_n_motivo1[0]));//valor en int para el ciclo
$n2= strval(implode($rows_n_motivo2[0]));//valor en int para el ciclo
$n3= strval(implode($rows_n_motivo3[0]));//valor en int para el ciclo
// $n4= strval(implode($rows_n_motivo4[0]));//valor en int para el ciclo
// $n5= strval(implode($rows_n_motivo5[0]));//valor en int para el ciclo


///LISTA DE LOS QUE fueron consultados por tipo 1
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(78, 10, utf8_decode('Lista de citas de poliemprende '), 0, 1, 'C', 0);
$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(60, 10, 'Nombre', 1, 0, 'C', 0);
$PDF->Cell(45, 10, 'Fecha', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->SetFont('Arial', '', 10);
for ($i = 0; $i < $n1; $i++) {
    $PDF->Cell(55, 10, utf8_decode($rows_motivo1[$i]['boleta']), 1, 0, 'C', 0);
    $PDF->Cell(60, 10, utf8_decode($rows_motivo1[$i]['nombre']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_motivo1[$i]['dia']), 1, 1, 'C', 0);
}

$PDF->Ln(6);//Salto de línea

///LISTA DE LOS QUE fueron consultados por tipo 2
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(69, 10, utf8_decode('Lista de citas de egresados '), 0, 1, 'C', 0);
$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(60, 10, 'Nombre', 1, 0, 'C', 0);
$PDF->Cell(45, 10, 'Fecha', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->SetFont('Arial', '', 10);
for ($i = 0; $i < $n2; $i++) {
    $PDF->Cell(55, 10, utf8_decode($rows_motivo2[$i]['boleta']), 1, 0, 'C', 0);
    $PDF->Cell(60, 10, utf8_decode($rows_motivo2[$i]['nombre']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_motivo2[$i]['dia']), 1, 1, 'C', 0);
}

$PDF->Ln(6);//Salto de línea

///LISTA DE LOS QUE fueron consultados por tipo 3
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(54, 10, utf8_decode('Lista de citas por otro'), 0, 1, 'C', 0);
$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(60, 10, 'Nombre', 1, 0, 'C', 0);
$PDF->Cell(45, 10, 'Fecha', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->SetFont('Arial', '', 10);
for ($i = 0; $i < $n3; $i++) {
    $PDF->Cell(55, 10, utf8_decode($rows_motivo3[$i]['boleta']), 1, 0, 'C', 0);
    $PDF->Cell(60, 10, utf8_decode($rows_motivo3[$i]['nombre']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_motivo3[$i]['dia']), 1, 1, 'C', 0);
}

$PDF->Ln(6);//Salto de línea

///LISTA DE LOS QUE fueron consultados por tipo 4
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(67, 10, utf8_decode('Lista de citas por motivo 4 '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Fecha', 1, 1, 'C', 0);// el ultimo crea un salto de linea

// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n4; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_motivo4[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_motivo4[$i]['nombre']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_motivo4[$i]['dia']), 1, 1, 'C', 0);
// }

// $PDF->Ln(6);//Salto de línea

// ///LISTA DE LOS QUE fueron consultados por tipo 5
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(67, 10, utf8_decode('Lista de citas por motivo 5 '), 0, 1, 'C', 0);
// $PDF->SetFont('Arial', 'B', 12);
// $PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
// $PDF->SetFont('Arial', 'B', 15);
// $PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
// $PDF->Cell(45, 10, 'Fecha', 1, 1, 'C', 0);// el ultimo crea un salto de linea

// $PDF->SetFont('Arial', '', 10);
// for ($i = 0; $i < $n5; $i++) {
//     $PDF->Cell(55, 10, utf8_decode($rows_motivo5[$i]['boleta']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_motivo5[$i]['nombre']), 1, 0, 'C', 0);
//     $PDF->Cell(45, 10, utf8_decode($rows_motivo5[$i]['dia']), 1, 1, 'C', 0);
// }

$PDF->Ln(6);//Salto de línea

$PDF ->Output();

mysqli_close($link);

?>