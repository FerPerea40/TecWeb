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
        $this->Cell(30,18,utf8_decode('Reporte de medicamentos'),0,0,'C');
     

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

$consulta_nBloquesMedicamento = " SELECT count(Id_bloque) FROM `bloquematerialmedico` ";
$consulta  = "SELECT * FROM `bloquematerialmedico` INNER JOIN `tipomedicamento` ON `bloquematerialmedico`.`Id_Mat_Med` = `tipomedicamento`.`Id_Mat_Med` ORDER BY nombre ASC ";

$nBloquesMedicamento = mysqli_query($link, $consulta_nBloquesMedicamento) or die("Error al contar los bloques de medicamento");
$consultaREALIZAR = mysqli_query($link, $consulta) or die("Error al ejecutar consulta"); 

//$fecha_inicial = $_POST['fecha_inicial'];
//$fecha_final = $_POST['fecha_final'];
//$consultas_fecha = "SELECT count(id_consulta) FROM `consulta` WHERE `fecha` <= '". $fecha_final ."' AND `fecha` >= '". $fecha_inicial ."'";
//$n_consultas_fechas = mysqli_query($link, $consultas_fecha) or die("Error al ejecutar la consulta de pacientes sin vigencia de derechos ");

$rows_nBloquesMedicamento = array();
$rows_consultaREALIZAR = array();


while ($r = mysqli_fetch_assoc($consultaREALIZAR)) {
    $rows_consultaREALIZAR[] = $r;
}
while ($r = mysqli_fetch_assoc($nBloquesMedicamento)) {
    $rows_nBloquesMedicamento[] = $r;
}


///Sacamos cuantos bloques distintos hay
$n1= strval(implode($rows_nBloquesMedicamento[0]));//valor en int para el ciclo

$PDF->SetFont('Arial','B',10);
$PDF->Cell(35,10,utf8_decode("Nombre"), 1, 0, 'C', 0);
$PDF->Cell(40,10,utf8_decode("Compuesto químico"), 1, 0, 'C', 0);
$PDF->Cell(35,10,utf8_decode("Concentración"), 1, 0, 'C', 0);
$PDF->Cell(18,10,utf8_decode("Cantidad"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','B',7);
$PDF->Cell(30,10,utf8_decode("Caducidad (año/mes/dia) "), 1, 0, 'C', 0);
$PDF->SetFont('Arial','B',10);
$PDF->Cell(40,10,utf8_decode("Fabricante"), 1, 1, 'C', 0);

$PDF->SetFont('Arial','',8);
for ($i = 0; $i < $n1; $i++) {
 
    
    $PDF->Cell(35,10,utf8_decode($rows_consultaREALIZAR[$i]['nombre']), 1, 0, 'C', 0);
    $PDF->Cell(40,10,utf8_decode($rows_consultaREALIZAR[$i]['componente_quimico']), 1, 0, 'C', 0);
    $PDF->Cell(35,10,utf8_decode($rows_consultaREALIZAR[$i]['concentracion']), 1, 0, 'C', 0);
    $PDF->SetFont('Arial','',10);
    $PDF->Cell(18,10,utf8_decode($rows_consultaREALIZAR[$i]['Cantidad']), 1, 0, 'C', 0);
    $PDF->SetFont('Arial','',8);
    $PDF->Cell(30,10,utf8_decode($rows_consultaREALIZAR[$i]['Fecha_caducidad']), 1, 0, 'C', 0);
    $PDF->Cell(40,10,utf8_decode($rows_consultaREALIZAR[$i]['Lab_Empresa']), 1, 1, 'C', 0);
    
}
$PDF->Ln(8);//Salto de línea

//$PDF->Cell(60,8,$fecha_inicial, 1, 0, 'C', 0); 
//$PDF->Cell(60,8,$fecha_final, 1, 0, 'C', 0);
//$PDF->Cell(60,8,implode($rows_n_consultas_fechas[0]), 1, 1, 'C', 0);// el ultimo crea un salto de linea  

$PDF ->Output();

mysqli_close($link);

?>