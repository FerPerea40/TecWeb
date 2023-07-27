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
$consultaTipo4 =  "SELECT count(tipo) FROM `paciente` WHERE borrar = '0' AND tipo= '4' ";
$consultaTipoN =  "SELECT `tipo` FROM `paciente` WHERE borrar = '0' ";

 /// consulta correcta en sql es SELECT count(boleta) FROM `paciente` WHERE borrar = 0 AND nss IS NULL
 $consulta_n_SinNSS =  "SELECT count(boleta) FROM `paciente` WHERE borrar = '0' AND nss = '0' ";
 $consulta_SinNSS = "SELECT * FROM `paciente` WHERE borrar = '0' AND nss = '0' ";

 /// consulta correcta en sql es SELECT count(boleta) FROM `paciente` WHERE borrar = 0 AND curp IS NULL
 $consulta_n_SinCURP =  "SELECT count(boleta) FROM `paciente` WHERE borrar = '0' AND curp = '' ";
 $consulta_SinCURP = "SELECT * FROM `paciente` WHERE borrar = '0' AND curp ='' ";

 /// consulta correcta en sql es SELECT count(boleta) FROM `paciente` WHERE borrar = 0 AND vigencia = 0
 $consulta_n_SinVIGENCIA =  "SELECT count(boleta) FROM `paciente` WHERE borrar = '0' AND vigencia = '0' ";
 $consulta_SinVIGENCIA = "SELECT * FROM `paciente` WHERE borrar = '0' AND vigencia = '0' ";

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
$n_pacientesExterno= mysqli_query($link, $consultaTipo4) or die("Error al ejecutar la consulta de cantidad de pacientes Tipo 4");
$tipoN = mysqli_query($link, $consultaTipoN) or die("Error al ejecutar la consulta del tipo de paciente");

$n_SinNSS  = mysqli_query($link, $consulta_n_SinNSS) or die("Error al ejecutar la consulta de cantidad de pacientes sin NSS ");
$SinNSS = mysqli_query($link, $consulta_SinNSS) or die("Error al ejecutar la consulta de pacientes sin NSS ");

$n_SinCURP = mysqli_query($link, $consulta_n_SinCURP) or die("Error al ejecutar la consulta de cantidad de pacientes sin CURP ");
$SinCURP = mysqli_query($link, $consulta_SinCURP) or die("Error al ejecutar la consulta de pacientes sin CURP ");

$n_SinVIGENCIA = mysqli_query($link, $consulta_n_SinVIGENCIA) or die("Error al ejecutar la consulta de cantidad de pacientes sin vigencia de derechos ");
$SinVIGENCIA = mysqli_query($link, $consulta_SinVIGENCIA) or die("Error al ejecutar la consulta de pacientes sin vigencia de derechos ");

 $fecha_inicial = $_GET['fecha1'];
 $fecha_final = $_GET['fecha2'];
 $consultas_fecha = "SELECT count(id_consulta) FROM `consulta` WHERE `fecha` <= '". $fecha_final ."' AND `fecha` >= '". $fecha_inicial ."'";
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
while ($r = mysqli_fetch_assoc($tipoN)) {
    $rows_tipoN[] = $r;
}

//COLUMNAS QUE SE MUESTRAN
$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(182, 10, 'Cantidad de consultas en el periodo de tiempo seleccionado', 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(60, 8, 'Desde', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Hasta', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Total de consultas realizadas', 1, 1, 'C', 0);// el ultimo crea un salto de linea
$PDF->SetFont('Arial', '', 12);
$PDF->Cell(60, 8, $fecha_inicial, 1, 0, 'C', 0);
$PDF->Cell(60, 8, $fecha_final, 1, 0, 'C', 0);
$PDF->Cell(60, 8, implode($rows_n_consultas_fechas[0]), 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->Ln(6);//Salto de línea

//COLUMNAS QUE SE MUESTRAN
$PDF->SetFont('Arial', 'B', 18);
$PDF->Cell(88, 8, 'Cantidad de pacientes activos', 0, 1, 'C', 0);

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

//COLUMNAS QUE SE MUESTRAN
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(190, 10, utf8_decode('Cantidad de pacientes con datos faltantes (NSS, CURP o vigencia de derechos)'), 0, 1, 'C', 0);

$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(60, 8, 'NSS', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'CURP', 1, 0, 'C', 0);
$PDF->Cell(60, 8, 'Vigencia de derechos', 1, 1, 'C', 0);// el ultimo crea un salto de linea
$PDF->SetFont('Arial', '', 15);
$PDF->Cell(60, 8, implode($rows_n_SinNSS[0]), 1, 0, 'C', 0);
$PDF->Cell(60, 8, implode($rows_n_SinCURP[0]), 1, 0, 'C', 0);
$PDF->Cell(60, 8, ''.implode($rows_n_SinVIGENCIA[0]).'', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF ->Addpage();
///Sacamos cuantos no tienen NSS en una variable entera
$n1= strval(implode($rows_n_SinNSS[0]));//valor en int para el ciclo
$n2= strval(implode($rows_n_SinCURP[0]));//valor en int para el ciclo
$n3= strval(implode($rows_n_SinVIGENCIA[0]));//valor en int para el ciclo

///LISTA DE LOS QUE NO TIENEN SU NSS REGISTRADO
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(190, 10, utf8_decode('Lista de pacientes sin NSS registrado'), 0, 1, 'C', 0);
$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
$PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
$PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);

$PDF->SetFont('Arial', '', 10);
for ($i = 0; $i < $n1; $i++) {
    $PDF->Cell(55, 10, utf8_decode($rows_SinNSS[$i]['boleta']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_SinNSS[$i]['nombres']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_SinNSS[$i]['pa']), 1, 0, 'C', 0);

    //para saber la categoria
    $temporal = strval($rows_SinNSS[$i]['tipo']);

    if ($temporal == 1) {
        $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
    } elseif ($temporal == 2) {
        $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
    } elseif ($temporal == 3) {
        $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
    } elseif ($temporal == 4) {
        $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
    } else {
        $PDF->SetFont('Arial', '', 8);
        $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
    }
}
$PDF->Ln(8);//Salto de línea

///LISTA DE LOS QUE NO TIENEN SU CURP REGISTRADO
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(190, 10, utf8_decode('Lista de pacientes sin CURP registrada'), 0, 1, 'C', 0);
$PDF->SetFont('Arial', 'B', 12);
$PDF->Cell(55, 10, 'Boleta / Num. trabajador', 1, 0, 'C', 0);
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
$PDF->Cell(45, 10, 'Apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
$PDF->Cell(45, 10, 'Categoria', 1, 1, 'C', 0);

$PDF->SetFont('Arial', '', 10);
for ($i = 0; $i < $n2; $i++) {
    $PDF->Cell(55, 10, utf8_decode($rows_SinCURP[$i]['boleta']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_SinCURP[$i]['nombres']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_SinCURP[$i]['pa']), 1, 0, 'C', 0);

    //para saber la categoria
    $temporal = strval($rows_SinCURP[$i]['tipo']);

    if ($temporal == 1) {
        $PDF->Cell(45, 10, 'Alumno', 1, 1, 'C', 0);
    } elseif ($temporal == 2) {
        $PDF->Cell(45, 10, 'Docente', 1, 1, 'C', 0);
    } elseif ($temporal == 3) {
        $PDF->Cell(45, 10, 'PAAE', 1, 1, 'C', 0);
    } elseif ($temporal == 4) {
        $PDF->Cell(45, 10, 'Externo', 1, 1, 'C', 0);
    } else {
        $PDF->SetFont('Arial', '', 8);
        $PDF->Cell(45, 10, 'Revisa tipo de paciente', 1, 1, 'C', 0);
    }
}
$PDF->Ln(8);//Salto de línea

///LISTA DE LOS QUE NO TIENEN SU VIGENCIA REGISTRADa
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(190, 10, utf8_decode('Lista de pacientes sin vigencia de derechos registrada'), 0, 1, 'C', 0);
$PDF->SetFont('Arial', 'B', 15);
$PDF->Cell(45, 10, 'Boleta', 1, 0, 'C', 0);
$PDF->Cell(45, 10, 'Nombre', 1, 0, 'C', 0);
$PDF->Cell(50, 10, 'Primer apellido', 1, 0, 'C', 0);// el ultimo crea un salto de linea
$PDF->Cell(50, 10, 'Segundo apellido', 1, 1, 'C', 0);// el ultimo crea un salto de linea

$PDF->SetFont('Arial', '', 10);
for ($i = 0; $i < $n3; $i++) {
    $PDF->Cell(45, 10, utf8_decode($rows_SinVIGENCIA[$i]['boleta']), 1, 0, 'C', 0);
    $PDF->Cell(45, 10, utf8_decode($rows_SinVIGENCIA[$i]['nombres']), 1, 0, 'C', 0);
    $PDF->Cell(50, 10, utf8_decode($rows_SinVIGENCIA[$i]['pa']), 1, 0, 'C', 0);
    $PDF->Cell(50, 10, utf8_decode($rows_SinVIGENCIA[$i]['sa']), 1, 1, 'C', 0);
}
$PDF->Ln(8);//Salto de línea

$PDF ->Output();

mysqli_close($link);
