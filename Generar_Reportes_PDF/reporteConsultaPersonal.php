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
    function Header()
    {
        //(nombre, coordenadas x, coordenadas y, tamaño)
        $this->Image('logoIPN.jpg',0,5,30);


        $this->SetFont('Arial','B',25);

        //Movernos a la derecha
        $this->Cell(80);

        //titulo (ancho de celda, alto de celda, texto, borde o no )
        $this->Cell(30,18,utf8_decode('Reporte de consulta'),0,0,'C');
     

        //Salto de línea
        $this->Ln(20);

    }
    
    
    //Pie pag
    function Footer()
    {
        //posicion final
        $this->SetY(-15);
        //Arial
        $this->SetFont('Arial','I',8);
        //Num pag
        $this->Cell(0,10,utf8_decode('Página ').$this->PageNo().'/{nb}',0,0,'C');
        
    }
}



$link=connect();

$PDF = new PDF();
$PDF -> AliasNbPages();
$PDF ->Addpage();


//$idConsulta=39;
$idConsulta = $_GET['id_consulta'];

///aqui podriamos enviar el id de consulta para sacar una consulta especifica, pero checa que parametro quieres enviar
$consultaTABLA = "SELECT * FROM `paciente` INNER JOIN `consulta` INNER JOIN `medico min` ON `consulta`.`id_paciente` = `paciente`.`id_paciente` AND `consulta`.`id_consulta` = $idConsulta AND `consulta`.`id_medico` = `medico min`.`Id_med`"; 
$consultaREALIZAR = mysqli_query($link, $consultaTABLA) or die("Error al ejecutar consulta de tabla: consulta"); 


$rows_consultaREALIZAR = array();


while ($r = mysqli_fetch_assoc($consultaREALIZAR)) {
    $rows_consultaREALIZAR[] = $r;
}


$PDF->SetFont('Arial','B',16);
$PDF->Cell(95,10,utf8_decode("Medico que consultó"), 0, 0, 'C', 0);
$PDF->Cell(55,10,utf8_decode(""), 0, 0, 'C', 0);
$PDF->Cell(55,10,utf8_decode("Fecha"), 0, 1, 'C', 0);

$PDF->SetFont('Arial','',14);
$PDF->Cell(40,10,utf8_decode($rows_consultaREALIZAR[0]['Nom_med']), 0, 0, 'C', 0);
$PDF->Cell(30,10,utf8_decode($rows_consultaREALIZAR[0]['Ape_pat']), 0, 0, 'C', 0);
$PDF->Cell(30,10,utf8_decode($rows_consultaREALIZAR[0]['Ape_mat']), 0, 0, 'C', 0);
$PDF->Cell(55,10,utf8_decode(""), 0, 0, 'C', 0);
$PDF->Cell(35,10,utf8_decode($rows_consultaREALIZAR[0]["fecha"]), 0, 1, 'C', 0);
$PDF->Ln(7);//Salto de línea


$PDF->SetFont('Arial','B',16);
$PDF->Cell(95,10,utf8_decode("Nombre del paciente "), 0, 0, 'C', 0);
$PDF->Cell(35,10,utf8_decode(""), 0, 0, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Boleta / Numero de trabajador"), 0, 1, 'C', 0);

$PDF->SetFont('Arial','',14);
$PDF->Cell(40,10,utf8_decode($rows_consultaREALIZAR[0]['nombres']), 0, 0, 'C', 0);
$PDF->Cell(30,10,utf8_decode($rows_consultaREALIZAR[0]['pa']), 0, 0, 'C', 0);
$PDF->Cell(30,10,utf8_decode($rows_consultaREALIZAR[0]['sa']), 0, 0, 'C', 0);
$PDF->Cell(55,10,utf8_decode(""), 0, 0, 'C', 0);
$PDF->Cell(35,10,utf8_decode($rows_consultaREALIZAR[0]['boleta']), 0, 1, 'C', 0);
$PDF->Ln(7);//Salto de línea

$PDF->SetFont('Arial','B',16);
$PDF->Cell(110,10,utf8_decode("Datos de la consulta"), 0, 1, 'C', 0);

$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Tensión arterial"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['tension_arterial']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Frecuencia cardiaca"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['frecuencia_cardiaca']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Frecuencia respiratoria"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['frecuencia_respiratoria']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Temperatura corporal"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['temperatura_corp']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Glucosa"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['glucosa']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Saturación de óxigeno"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['oxigeno_sangre']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Otro"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['otros']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Padecimiento actual"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(55,10,utf8_decode($rows_consultaREALIZAR[0]['padecimiento_actual']), 1, 1, 'C', 0);
$PDF->Ln(5);//Salto de línea


$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Diagnostico "), 0, 1, 'C', 0);
$PDF->SetFont('Arial','',10);
$PDF->Cell(160,10,utf8_decode($rows_consultaREALIZAR[0]['diagnostico']), 0, 1, 'C', 0);
$PDF->Ln(5);//Salto de línea


$PDF->SetFont('Arial','B',12);
$PDF->Cell(55,10,utf8_decode("Tratamiento"), 0, 1, 'C', 0);
$PDF->SetFont('Arial','',10);
$PDF->Cell(160,10,utf8_decode($rows_consultaREALIZAR[0]['tratamiento']), 0, 1, 'C', 0);
$PDF->Ln(5);//Salto de línea


$PDF->SetFont('Arial','B',12);
$PDF->Cell(80,10,utf8_decode("Resumen de la consulta"), 0, 1, 'C', 0);
$PDF->SetFont('Arial','',10);
$PDF->Cell(160,10,utf8_decode($rows_consultaREALIZAR[0]['resumen_interrogatorio']), 0, 1, 'C', 0);
$PDF->Ln(5);//Salto de línea


$PDF->SetFont('Arial','B',12);
$PDF->Cell(95,10,utf8_decode("Resultados servicios auxiliares"), 0, 1, 'C', 0);
$PDF->SetFont('Arial','',10);
$PDF->Cell(160,10,utf8_decode($rows_consultaREALIZAR[0]['resultados_servicios_aux']), 0, 1, 'C', 0);
$PDF->Ln(6);//Salto de línea





$PDF ->Output();

mysqli_close($link);

?>