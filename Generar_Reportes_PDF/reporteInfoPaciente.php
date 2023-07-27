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
        $this->Cell(30,18,utf8_decode('Información del paciente'),0,0,'C');
     

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

//$boletaPaciente="2019670113";///temporal

$boletaPaciente=$_GET['boletaPaciente'];

$consultaTABLA = "SELECT * FROM `paciente` WHERE `borrar`= 0 AND `boleta` = $boletaPaciente";///aqui falta poner como lo vamos a buscar, si por boleta o k 
$consultaREALIZAR = mysqli_query($link, $consultaTABLA) or die("Error al ejecutar consulta de tabla: consulta"); 

$rows_consultaREALIZAR = array();


while ($r = mysqli_fetch_assoc($consultaREALIZAR)) {
    $rows_consultaREALIZAR[] = $r;
}



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



$PDF->SetFont('Arial','B',20);
$PDF->Cell(70,10,utf8_decode("Datos generales"), 0, 1, 'C', 0);
$PDF->Ln(5);//Salto de línea

$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Fecha de nacimiento"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['fecha']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);

$PDF->Cell(85,10,utf8_decode("Sexo"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
if($rows_consultaREALIZAR[0]['sexo'] == "H"){
    $PDF->Cell(108,10,utf8_decode("Hombre"), 1, 1, 'C', 0);
}elseif($rows_consultaREALIZAR[0]['sexo'] == "M"){
    $PDF->Cell(108,10,utf8_decode("Mujer"), 1, 1, 'C', 0);
}else{
    $PDF->Cell(108,10,utf8_decode("No definido"), 1, 1, 'C', 0);
}

$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Masa"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['masa']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Altura"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['altura']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Tipo de sangre"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['sangre']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("NSS"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['nss']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Curp"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['curp']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Telefono"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['tel']), 1, 1, 'C', 0);


$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Contacto de emergencia"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['contacto_e']), 1, 1, 'C', 0);

$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Telefono de emergencia"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['tel_e']), 1, 1, 'C', 0);

$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Tipo de paciente"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);

if(strval($rows_consultaREALIZAR[0]['tipo']) == 1 ){
    $PDF->Cell(108,10,utf8_decode("Alumno"), 1, 1, 'C', 0);


   
    $PDF->SetFont('Arial','B',12);
    $PDF->Cell(85,10,utf8_decode("Carrera"), 1, 0, 'C', 0);
    $PDF->SetFont('Arial','',12);
    if((strval($rows_consultaREALIZAR[0]['carrera'])) == 1){
        $PDF->Cell(108,10,utf8_decode("Metalúrgica"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 2){
        $PDF->Cell(108,10,utf8_decode("Mecatrónica"), 1, 1, 'C', 0);
    }
    elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 3){
        $PDF->Cell(108,10,utf8_decode("Alimentos"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 4){
        $PDF->Cell(108,10,utf8_decode("Ambiental"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 5){
        $PDF->Cell(108,10,utf8_decode("Sistemas computacionales"), 1, 1, 'C', 0);
    }else{
        $PDF->Cell(108,10,utf8_decode("No definida"), 1, 1, 'C',0);
    }




   

}elseif(strval($rows_consultaREALIZAR[0]['tipo']) == 2 ){
    $PDF->Cell(108,10,utf8_decode("Docente"), 1, 1, 'C', 0);

    if((strval($rows_consultaREALIZAR[0]['carrera'])) == 1){
        $PDF->Cell(108,10,utf8_decode("Bioingeniería"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 2){
        $PDF->Cell(108,10,utf8_decode("Físico - Matemáticas"), 1, 1, 'C', 0);
    }
    elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 3){
        $PDF->Cell(108,10,utf8_decode("Mecatrónica"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 4){
        $PDF->Cell(108,10,utf8_decode("Químico - Biológicas"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 5){
        $PDF->Cell(108,10,utf8_decode("Sociales e Inglés"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 6){
        $PDF->Cell(108,10,utf8_decode("Metalúrgica"), 1, 1, 'C', 0);
    }elseif((strval($rows_consultaREALIZAR[0]['carrera'])) == 7){
        $PDF->Cell(108,10,utf8_decode("Ciencias de la computación"), 1, 1, 'C', 0);
    }
    else{
        $PDF->Cell(108,10,utf8_decode("No definida"), 1, 1, 'C',0);
    }


    
}elseif(strval($rows_consultaREALIZAR[0]['tipo']) == 3 ){
    $PDF->Cell(108,10,utf8_decode("PAAE"), 1, 1, 'C', 0);
}elseif(strval($rows_consultaREALIZAR[0]['tipo']) == 4 ){
    $PDF->Cell(108,10,utf8_decode("Externo"), 1, 1, 'C', 0);
}else{
    $PDF->Cell(108,10,utf8_decode("No definido"), 1, 1, 'C', 0);
}

$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Vigencia de derechos"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',12);

if(strval($rows_consultaREALIZAR[0]['vigencia']==0)){
    $PDF->Cell(108,10,utf8_decode("NO tiene registrada la vigencia de derechos"), 1, 1, 'C', 0);
}elseif(strval($rows_consultaREALIZAR[0]['vigencia']==1)){
    $PDF->Cell(108,10,utf8_decode("Si tiene vigencia registrada"), 1, 1, 'C', 0);
}else{
    $PDF->Cell(108,10,utf8_decode("Error de lectura de vigencia"), 1, 1, 'C', 0);
}


$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Antecedentes heredofamiliares"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',8);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['ah']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',10);
$PDF->Cell(85,10,utf8_decode("Antecedentes personales no patológicos"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',8);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['apnp']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Antecedentes personales patológicos"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',8);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['app']), 1, 1, 'C', 0);
$PDF->SetFont('Arial','B',12);
$PDF->Cell(85,10,utf8_decode("Observaciones adicionales"), 1, 0, 'C', 0);
$PDF->SetFont('Arial','',8);
$PDF->Cell(108,10,utf8_decode($rows_consultaREALIZAR[0]['od']), 1, 1, 'C', 0);

$PDF->Ln(5);//Salto de línea





$PDF ->Output();

mysqli_close($link);

?>