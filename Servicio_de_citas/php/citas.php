<?php
include("conexion.php");

$funcion=$_POST['php_num_funcion'];

//$funcion = 7;
/**
 * 1 = set_hora_inicio_departamento
 * 2 = get_hora_inicio_departamento
 * 3 = set_hora_fin_departamento
 * 4 = get_hora_fin_departamento
 * 5 = get_horarios_disponibles
 * 6 = guardar_cita
 * 7 = is_hora_libre
 * 8 = get_Citas
 * 9 = borrarCita
 * 10 = ocuparCita
 * 11 = reservar
 **/

switch ($funcion) {
    case 1:
        set_hora_inicio_departamento();
        break;
    case 2:
        get_hora_inicio_departamento();
        break;
    case 3:
        set_hora_fin_departamento();
        break;
    case 4:
        get_hora_fin_departamento();
        break;
    case 5:
        get_horario();
        break;
    case 6:
        guardar_cita();
        break;
    case 7:
        is_hora_libre();
        break;
    case 8:
        get_Citas();
        break;
    case 9:
        borrarCita();
        break;
    case 10:
        ocuparCita();
        break;
    case 11:
        reservar();
        break;
}

function set_hora_inicio_departamento()
{
    $hora=$_POST['hora'];
    $departamento = $_POST['departamento'];
    $consulta = "UPDATE `horario` SET `hora_entrada` = '".$hora."' WHERE `horario`.`id_departamento` = '".$departamento."'";

    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);
}

function get_hora_inicio_departamento()
{
    $consulta  = "SELECT `hora_entrada` FROM `horario` WHERE `id_departamento` LIKE '". $_POST['departamento'] ."'";

    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $registro=mysqli_fetch_array($result);

    $respuesta = array();
    if (isset($registro['hora_entrada'])) {
        $respuesta['hora']= $registro['hora_entrada'];
        $respuesta['error'] = false;
    } else {
        $respuesta['error'] = true;
    }

    echo json_encode($respuesta);
}

function set_hora_fin_departamento()
{
    $hora=$_POST['hora'];
    $departamento = $_POST['departamento'];
    $consulta = "UPDATE `horario` SET `hora_salida` = '".$hora."' WHERE `horario`.`id_departamento` = '".$departamento."'";

    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);
}

function get_hora_fin_departamento()
{
    $consulta  = "SELECT `hora_salida` FROM `horario` WHERE `id_departamento` LIKE '". $_POST['departamento'] ."'";

    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $registro=mysqli_fetch_array($result);

    $respuesta = array();
    if (isset($registro['hora_salida'])) {
        $respuesta['hora']= $registro['hora_salida'];
        $respuesta['error'] = false;
    } else {
        $respuesta['error'] = true;
    }

    echo json_encode($respuesta);
}

function correo_confirmacion($NDepartamento, $NMotivo, $dia, $nombre, $string_hora_inicio, $string_hora_final, $email){
    $from = "upiiz.citas@gmail.com";
        $to= $email;
        $subject = "Confirmacion de cita en $NDepartamento en UPIIZ";
        $message = '<html>
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta lang="es" />
          <title>Confirmacion de cita UPIIZ</title>
        </head>
        <body>
          <img src="http://pruebasseisupiiz.com/Servicio_de_citas/Img_C/Cabeza.JPG">
          <div style="width:  auto;
                height: auto;
                background-color: #6c6c6cd9;
                margin: 0% auto;
                padding-bottom: 1rem;">
          <p style="text-align: left; font-weight: bold; color: #5e2129; font-size: 3em; padding-top: 1.2em; padding-left: 0.3em;">
          Confirmación de cita para el departamento de '.$NDepartamento.' </p>
          </div>
          <div style="width:  auto;
            height: auto;
            background-color: #6c6c6cd9;
            margin: 0% auto;
            padding-bottom: 1rem;">
          <p style="text-align: left; font-weight: bold; color: #ffffff; font-size: 1em; padding-top: 1.2em; padding-left: 0.3em;">
          Se le confirma su cita para el '.$dia.' (Formato: Año/mes/día) a nombre de '.$nombre.'</p>
          <p style="text-align: left; font-weight: bold; color: #ffffff; font-size: 1em; padding-top: 1.2em; padding-left: 0.3em;">
          Reservada por el siguiente motivo: '.$NMotivo.' en del departamento de '.$NDepartamento.'</p>
          <p style="text-align: left; font-weight: bold; color: #ffffff; font-size: 1em; padding-top: 1.2em; padding-left: 0.3em;">
          Su cita tiene como hora de inicio '.$string_hora_inicio.' y hora de final '.$string_hora_final.' del dia '.$dia.'</p>
        </div>
        <img src="http://pruebasseisupiiz.com/Servicio_de_citas/Img_C/Footer.JPG">
        </body>
        </html>';
        $cabeceras = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= "From:" . $from;
        mail($to, $subject, $message, $cabeceras);
}

function guardar_cita()
{
    $departamento = $_POST['departamento'];
    $nombre = $_POST['nombre'];
    $boleta = $_POST['boleta'];
    $motivo = $_POST['motivo'];
    $horario = $_POST['horario'];
    $duracion = $_POST['duracion'];
    $dia = $_POST['dia'];
    $email = $_POST['email'];

    $hora_inicio = new DateTime($horario);
    $hora_final = clone $hora_inicio;
    $hora_final -> add(new DateInterval('PT'.$duracion.'M'));

    //echo $hora_inicio;
    //echo $hora_final;

    $string_hora_inicio = $hora_inicio->format('H:i:s');
    $string_hora_final = $hora_final->format('H:i:s');

    //print $string_hora_inicio;
    //print $string_hora_final;

    $name_db;
    $NDepartamento;
    $NMotivo;
    switch ($departamento) {
        case "1":
            $NDepartamento = "Gestión escolar";
            switch($motivo){
                case "1":
                    $NMotivo= "Reinscripción";
                    break;
                case "2":
                    $NMotivo= "Trámite recoger boletas y constancias";
                break;
                case "3";
                    $NMotivo= "Trámite de reposición de credencial";
                break;
                case "4";
                    $NMotivo= "COSIE CTCE";
                break;
                case "5";
                    $NMotivo= "COSIE CGC";
                break;
                case "6";
                    $NMotivo= "Aclaración de situación académica";
                break;
                case "7";
                    $NMotivo= "Certificado parcial";
                break;
                case "8";
                    $NMotivo= "Certificado total y carta pasante";
                break;
                case "9";
                    $NMotivo= "Baja Temporal";
                break;
                case "10";
                    $NMotivo= "Baja definitiva";
                break;
                case "11";
                    $NMotivo= "Cambio de programa académico";
                break;
                case "12";
                    $NMotivo= "Baja de unidades de aprendizaje";
                break;
                case "13";
                    $NMotivo= "Trámite de saberes previamente adquiridos";
                break;
                case "14";
                    $NMotivo= "Otro";
                break;

            }
            break;
        case "2":
            $NDepartamento = "Servicios estudiantiles";
            switch($motivo){
                case "1":
                    $NMotivo= "Recoger carta de no adeudo de libro";
                break;
                case "2";
                    $NMotivo= "Recoger oficio de entrega de material bibliográfico";
                break;
                case "3";
                    $NMotivo= "Recoger oficio de entrega de tesis o trabajo terminal";
                break;
                case "4";
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "3":
            $NDepartamento = "Servicio médico";
            switch($motivo){
                case "1":
                    $NMotivo= "Servicio de información de altas y bajas";
                break;
                case "2":
                    $NMotivo= "Vigencias";
                break;
                case "3":
                    $NMotivo= "Seguros de vida";
                break;
                case "4":
                    $NMotivo= "Área de lactancia";
                break;
                case "5":
                    $NMotivo= "Consulta médica";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "4":
            $NDepartamento = "Orientación juvenil";
            switch($motivo){
                case "1":
                    $NMotivo= "Consulta individual";
                break;
                case "2":
                    $NMotivo= "Atención a padres de familia";
                break;
                case "3":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "5":
            $NDepartamento = "Extensión y apoyos educativos";
            switch($motivo){
                case "1":
                    $NMotivo= "Becas";
                break;
                case "2":
                    $NMotivo= "Servicio social";
                break;
                case "3":
                    $NMotivo= "Movilidad";
                break;
                case "4":
                    $NMotivo= "Cultura";
                break;
                case "5":
                    $NMotivo= "Deportes";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "6":
            $NDepartamento = "Biblioteca";
            switch($motivo){
                case "1":
                    $NMotivo= "Entregar material bibliográfico";
                break;
                case "2":
                    $NMotivo= "Renovar credencial";
                break;
                case "3":
                    $NMotivo= "Solicitar un préstamo";
                break;
                case "4":
                    $NMotivo= "Regresar material de préstamo";
                break;
                case "5":
                    $NMotivo= "Solicitar constancia de no adeudo";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
    }
    switch ($departamento) {
        case "1":
            $name_db = "cita_gestion_escolar";
            break;
        case "2":
            $name_db = "servicios_estudiantiles";
            break;
        case "3":
            $name_db = "servicio_medico";
            break;
        case "4":
            $name_db = "orientación_juvenil";
            break;
        case "5":
            $name_db = "extension_y_apoyos";
            break;
        case "6":
            $name_db = "unidad_politecnica";
            break;
    }

    $consulta = "INSERT INTO `". $name_db ."` (`id`, `motivo`, `dia`, `nombre`, `boleta`, `hora_inicio`, `hora_fin`, `email`) VALUES (NULL, '".$motivo."', '".$dia."', '".$nombre."', '".$boleta."', '".$string_hora_inicio."', '".$string_hora_final."', '".$email."')";
    
    $respuesta = array();
    $link=connect();
    if (mysqli_query($link, $consulta)) {
        $respuesta['resultado'] = "si";
        correo_confirmacion($NDepartamento, $NMotivo, $dia, $nombre, $string_hora_inicio, $string_hora_final, $email);
    } else {
        $respuesta['resultado'] = "no";
    }
    mysqli_close($link);

    echo json_encode($respuesta);
}

function get_horario()
{
    $departamento = $_POST['departamento'];
    $duracion = $_POST['duracion'];
    $dia = $_POST['dia'];
    $separacion = $_POST['separaciones'];

    //$departamento = "1";
    //$duracion = "30";
    //$dia = "2020-09-01";
    //$separacion = 15;

    $hora_i = get_hora_i($departamento);
    $hora_f = get_hora_f($departamento);
    
    $respuesta = array();
    if (($hora_i == false) || ($hora_f == false)) {
        $respuesta['error'] = true;
        echo json_encode($respuesta);
        return 1;
    }

    $hora_inicio = new DateTime($hora_i);
    $hora_final = new DateTime($hora_f);
    $hora_final -> sub(new DateInterval('PT'.$duracion.'M'));

    $horas_disponibles = array();
    $i = 0;
    while ($hora_inicio<=$hora_final) {
        $hora_fin = clone $hora_inicio;
        $hora_fin->add(new DateInterval('PT'.$duracion.'M'));
        if (hora_libre($departamento, $dia, $hora_inicio, $hora_fin)) {
            $horas_disponibles[] = clone $hora_inicio;
        }

        $hora_inicio->add(new DateInterval('PT'.$separacion.'M'));
        $i++;
    }
    //hora_libre($departamento, $dia, new DateTime("10:00"), new DateTime("13:00"));
    
    echo json_encode($horas_disponibles);
    //echo($hora_inicio->format('Y-m-d h:i:s'));
}

function hora_libre($departamento, $dia, $hora_inicio, $hora_fin)
{
    $name_db;

    switch ($departamento) {
        case "1":
            $name_db = "cita_gestion_escolar";
            break;
        case "2":
            $name_db = "servicios_estudiantiles";
            break;
        case "3":
            $name_db = "servicio_medico";
            break;
        case "4":
            $name_db = "orientación_juvenil";
            break;
        case "5":
            $name_db = "extension_y_apoyos";
            break;
        case "6":
            $name_db = "unidad_politecnica";
            break;
    }

    $consulta = "SELECT `hora_inicio`,`hora_fin` FROM `".$name_db."` WHERE `dia` = '".$dia."'";
    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $rows = array();
    while ($r = mysqli_fetch_assoc($result)) {
        $hora_i = new DateTime($r['hora_inicio']);
        $hora_f = new DateTime($r['hora_fin']);
        if ((($hora_i>=$hora_fin && $hora_i>=$hora_inicio) || ($hora_f<=$hora_inicio && $hora_f<=$hora_fin))) {
        } else {
            return false;
        }
    }
    return true;
}

function get_hora_i($departamento)
{
    $consulta  = "SELECT `hora_entrada` FROM `horario` WHERE `id_departamento` LIKE '". $departamento ."'";
    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $registro=mysqli_fetch_array($result);

    if (isset($registro['hora_entrada'])) {
        return $registro['hora_entrada'];
    } else {
        return false;
    }
}

function get_hora_f($departamento)
{
    $consulta  = "SELECT `hora_salida` FROM `horario` WHERE `id_departamento` LIKE '". $departamento ."'";
    $link=connect();
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $registro=mysqli_fetch_array($result);

    if (isset($registro['hora_salida'])) {
        return $registro['hora_salida'];
    } else {
        return false;
    }
}


function is_hora_libre()
{
    $departamento = $_POST['departamento'];
    $duracion = $_POST['duracion'];
    $dia = $_POST['dia'];
    $hora = $_POST['hora'];

    $hora_inicio = new DateTime($hora);

    $hora_final = clone $hora_inicio;
    $hora_final -> add(new DateInterval('PT'.$duracion.'M'));
    

    $resultado = hora_libre($departamento, $dia, $hora_inicio, $hora_final);

    echo json_encode($resultado);
}

function get_Citas()
{
    $departamento = $_POST['departamento'];
    $dia = $_POST['dia'];
    $name_db;
    switch ($departamento) {
        case "1":
            $name_db = "cita_gestion_escolar";
            break;
        case "2":
            $name_db = "servicios_estudiantiles";
            break;
        case "3":
            $name_db = "servicio_medico";
            break;
        case "4":
            $name_db = "orientación_juvenil";
            break;
        case "5":
            $name_db = "extension_y_apoyos";
            break;
        case "6":
            $name_db = "unidad_politecnica";
            break;
    }

    $consulta = "SELECT * FROM `". $name_db ."` WHERE `dia` = '".$dia."' ORDER BY `hora_inicio` ASC";
    $link=connect();
    $respuesta = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    mysqli_close($link);

    $rows = array();
    while ($r = mysqli_fetch_assoc($respuesta)) {
        $rows[] = $r;
    }
    echo json_encode($rows);
}

function correo_cancelacion($NDepartamento, $NMotivo, $dia, $nombre, $string_hora_inicio, $string_hora_final, $email, $razon){
    $from = "upiiz.citas@gmail.com";
        $to= $email;
        $subject = "Cancelacion de cita en $NDepartamento en UPIIZ";
        $message = '<html>
        <head>
          <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
          <meta lang="es" />
          <title>Cancelacion de cita UPIIZ</title>
        </head>
        <body>
          <img src="http://pruebasseisupiiz.com/Servicio_de_citas/Img_C/Cabeza.JPG">
          <div style="width:  auto;
                height: auto;
                background-color: #6c6c6cd9;">
          <p style="text-align: left; font-weight: bold; color: #5e2129; font-size: 3em; padding-top: 1.2em; padding-left: 0.3em;">
          Cancelacion de cita para el departamento de '.$NDepartamento.' </p>
          </div>
          <div style="width:  auto;
            height: auto;
            background-color: #6c6c6cd9;">
          <p style="text-align: left; font-weight: bold; color: #ffffff; font-size: 1em; padding-top: 1.2em; padding-left: 0.3em;">
          Se le informa de la cancelacion de su cita del el dia '.$dia.' (Formato: Año/mes/día) a nombre de '.$nombre.' por la siguiente razon:'.$razon.'</p>
          <p style="text-align: left; font-weight: bold; color: #ffffff; font-size: 1em; padding-top: 1.2em; padding-left: 0.3em;">
          Informacion de la cita:
          Reservada por el siguiente motivo: '.$NMotivo.' en del departamento de '.$NDepartamento.'</p>
          <p style="text-align: left; font-weight: bold; color: #ffffff; font-size: 1em; padding-top: 1.2em; padding-left: 0.3em;">
          La cita tenia como hora de inicio '.$string_hora_inicio.' y hora de final '.$string_hora_final.' del dia '.$dia.'</p>
        </div>
            <img src="http://pruebasseisupiiz.com/Servicio_de_citas/Img_C/Footer.JPG">
        </body>
        </html>';
        $cabeceras = 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
        $cabeceras .= "From:" . $from;
        mail($to, $subject, $message, $cabeceras);
}

function borrarCita()
{
    //Llamar a función de mandar correo avisando que se cancelo la cita
    $departamento = $_POST['departamento'];
    $id = $_POST['id'];
    $name_db;
    switch ($departamento) {
        case "1":
            $name_db = "cita_gestion_escolar";
            break;
        case "2":
            $name_db = "servicios_estudiantiles";
            break;
        case "3":
            $name_db = "servicio_medico";
            break;
        case "4":
            $name_db = "orientación_juvenil";
            break;
        case "5":
            $name_db = "extension_y_apoyos";
            break;
        case "6":
            $name_db = "unidad_politecnica";
            break;
    }    
    $link=connect();
    //Obtencion de informacion de la cita a cancelar, para datos de correo.
    $consulta  = "SELECT * FROM `".$name_db."` WHERE `id` LIKE '". $id ."'";
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    $datos_cita= mysqli_fetch_assoc($result);
    $motivo= $datos_cita['motivo'];
    $dia= $datos_cita['dia'];
    $nombre= $datos_cita['nombre'];
    $hora_inicio= $datos_cita['hora_inicio'];
    $hora_final= $datos_cita['hora_fin'];
    $email= $datos_cita['email'];
    $NDepartamento;
    $NMotivo;
    switch ($departamento) {
        case "1":
            $NDepartamento = "Gestión escolar";
            switch($motivo){
                case "1":
                    $NMotivo= "Reinscripción";
                    break;
                case "2":
                    $NMotivo= "Trámite recoger boletas y constancias";
                break;
                case "3";
                    $NMotivo= "Trámite de reposición de credencial";
                break;
                case "4";
                    $NMotivo= "COSIE CTCE";
                break;
                case "5";
                    $NMotivo= "COSIE CGC";
                break;
                case "6";
                    $NMotivo= "Aclaración de situación académica";
                break;
                case "7";
                    $NMotivo= "Certificado parcial";
                break;
                case "8";
                    $NMotivo= "Certificado total y carta pasante";
                break;
                case "9";
                    $NMotivo= "Baja Temporal";
                break;
                case "10";
                    $NMotivo= "Baja definitiva";
                break;
                case "11";
                    $NMotivo= "Cambio de programa académico";
                break;
                case "12";
                    $NMotivo= "Baja de unidades de aprendizaje";
                break;
                case "13";
                    $NMotivo= "Trámite de saberes previamente adquiridos";
                break;
                case "14";
                    $NMotivo= "Otro";
                break;

            }
            break;
        case "2":
            $NDepartamento = "Servicios estudiantiles";
            switch($motivo){
                case "1":
                    $NMotivo= "Recoger carta de no adeudo de libro";
                break;
                case "2";
                    $NMotivo= "Recoger oficio de entrega de material bibliográfico";
                break;
                case "3";
                    $NMotivo= "Recoger oficio de entrega de tesis o trabajo terminal";
                break;
                case "4";
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "3":
            $NDepartamento = "Servicio médico";
            switch($motivo){
                case "1":
                    $NMotivo= "Servicio de información de altas y bajas";
                break;
                case "2":
                    $NMotivo= "Vigencias";
                break;
                case "3":
                    $NMotivo= "Seguros de vida";
                break;
                case "4":
                    $NMotivo= "Área de lactancia";
                break;
                case "5":
                    $NMotivo= "Consulta médica";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "4":
            $NDepartamento = "Orientación juvenil";
            switch($motivo){
                case "1":
                    $NMotivo= "Consulta individual";
                break;
                case "2":
                    $NMotivo= "Atención a padres de familia";
                break;
                case "3":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "5":
            $NDepartamento = "Extensión y apoyos educativos";
            switch($motivo){
                case "1":
                    $NMotivo= "Becas";
                break;
                case "2":
                    $NMotivo= "Servicio social";
                break;
                case "3":
                    $NMotivo= "Movilidad";
                break;
                case "4":
                    $NMotivo= "Cultura";
                break;
                case "5":
                    $NMotivo= "Deportes";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "6":
            $NDepartamento = "Biblioteca";
            switch($motivo){
                case "1":
                    $NMotivo= "Entregar material bibliográfico";
                break;
                case "2":
                    $NMotivo= "Renovar credencial";
                break;
                case "3":
                    $NMotivo= "Solicitar un préstamo";
                break;
                case "4":
                    $NMotivo= "Regresar material de préstamo";
                break;
                case "5":
                    $NMotivo= "Solicitar constancia de no adeudo";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
    }
    
    $consulta = "DELETE FROM `".$name_db."` WHERE `".$name_db."`.`id` = ". $id;

    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    $razon= 'Cancelacion realizada por el administrador del departamento.';
    correo_cancelacion($NDepartamento, $NMotivo, $dia, $nombre, $hora_inicio, $hora_final, $email, $razon);

    mysqli_close($link);
}

function ocuparCita()
{
    //Llamar a función de mandar correo avisando que se cancelo la cita
    $departamento = $_POST['departamento'];
    $id = $_POST['id'];
    $name_db;
    switch ($departamento) {
        case "1":
            $name_db = "cita_gestion_escolar";
            break;
        case "2":
            $name_db = "servicios_estudiantiles";
            break;
        case "3":
            $name_db = "servicio_medico";
            break;
        case "4":
            $name_db = "orientación_juvenil";
            break;
        case "5":
            $name_db = "extension_y_apoyos";
            break;
        case "6":
            $name_db = "unidad_politecnica";
            break;
    }
    $link=connect();
    //Obtencion de informacion de la cita a cancelar, para datos de correo.
    $consulta  = "SELECT * FROM `".$name_db."` WHERE `id` LIKE '". $id ."'";
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    $datos_cita= mysqli_fetch_assoc($result);
    $motivo= $datos_cita['motivo'];
    $dia= $datos_cita['dia'];
    $nombre= $datos_cita['nombre'];
    $hora_inicio= $datos_cita['hora_inicio'];
    $hora_final= $datos_cita['hora_fin'];
    $email= $datos_cita['email'];
    $NDepartamento;
    $NMotivo;
    switch ($departamento) {
        case "1":
            $NDepartamento = "Gestión escolar";
            switch($motivo){
                case "1":
                    $NMotivo= "Reinscripción";
                    break;
                case "2":
                    $NMotivo= "Trámite recoger boletas y constancias";
                    break;
                break;
                case "3";
                    $NMotivo= "Trámite de reposición de credencial";
                break;
                case "4";
                    $NMotivo= "COSIE CTCE";
                break;
                case "5";
                    $NMotivo= "COSIE CGC";
                break;
                case "6";
                    $NMotivo= "Aclaración de situación académica";
                break;
                case "7";
                    $NMotivo= "Certificado parcial";
                break;
                case "8";
                    $NMotivo= "Certificado total y carta pasante";
                break;
                case "9";
                    $NMotivo= "Baja Temporal";
                break;
                case "10";
                    $NMotivo= "Baja definitiva";
                break;
                case "11";
                    $NMotivo= "Cambio de programa académico";
                break;
                case "12";
                    $NMotivo= "Baja de unidades de aprendizaje";
                break;
                case "13";
                    $NMotivo= "Trámite de saberes previamente adquiridos";
                break;
                case "14";
                    $NMotivo= "Otro";
                break;

            }
            break;
        case "2":
            $NDepartamento = "Servicios estudiantiles";
            switch($motivo){
                case "1":
                    $NMotivo= "Recoger carta de no adeudo de libro";
                break;
                case "2";
                    $NMotivo= "Recoger oficio de entrega de material bibliográfico";
                break;
                case "3";
                    $NMotivo= "Recoger oficio de entrega de tesis o trabajo terminal";
                break;
                case "4";
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "3":
            $NDepartamento = "Servicio médico";
            switch($motivo){
                case "1":
                    $NMotivo= "Servicio de información de altas y bajas";
                break;
                case "2":
                    $NMotivo= "Vigencias";
                break;
                case "3":
                    $NMotivo= "Seguros de vida";
                break;
                case "4":
                    $NMotivo= "Área de lactancia";
                break;
                case "5":
                    $NMotivo= "Consulta médica";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "4":
            $NDepartamento = "Orientación juvenil";
            switch($motivo){
                case "1":
                    $NMotivo= "Consulta individual";
                break;
                case "2":
                    $NMotivo= "Atención a padres de familia";
                break;
                case "3":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "5":
            $NDepartamento = "Extensión y apoyos educativos";
            switch($motivo){
                case "1":
                    $NMotivo= "Becas";
                break;
                case "2":
                    $NMotivo= "Servicio social";
                break;
                case "3":
                    $NMotivo= "Movilidad";
                break;
                case "4":
                    $NMotivo= "Cultura";
                break;
                case "5":
                    $NMotivo= "Deportes";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
        case "6":
            $NDepartamento = "Biblioteca";
            switch($motivo){
                case "1":
                    $NMotivo= "Entregar material bibliográfico";
                break;
                case "2":
                    $NMotivo= "Renovar credencial";
                break;
                case "3":
                    $NMotivo= "Solicitar un préstamo";
                break;
                case "4":
                    $NMotivo= "Regresar material de préstamo";
                break;
                case "5":
                    $NMotivo= "Solicitar constancia de no adeudo";
                break;
                case "6":
                    $NMotivo= "Otro";
                break;
            }
            break;
    }

    $consulta = "UPDATE `".$name_db."` SET `motivo` = '12345', `boleta` = '', `nombre` = '', `email` = '' WHERE `".$name_db."`.`id` = ". $id;

    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    $razon= 'Su cita fue cancelada por el administrador, ya que requiere disponer este tiempo para otra actividad, se le ofrece una disculpa, puede reservar una nueva cita.';
    correo_cancelacion($NDepartamento, $NMotivo, $dia, $nombre, $hora_inicio, $hora_final, $email, $razon);
    mysqli_close($link);
}

function correos_multiples($name_db, $departamento, $hora_i, $hora_f, $dia){
    $consulta= "SELECT * FROM `".$name_db."` WHERE `dia` = '".$dia."' AND ((`hora_inicio` >= '".$hora_i."' AND `hora_fin` <= '".$hora_f."') OR (`hora_fin` > '".$hora_i."' AND `hora_fin`< '".$hora_f."'))";
    $link= connect();
    $respuesta=mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    while($datos_cita=mysqli_fetch_assoc($respuesta)){
        $motivo= $datos_cita['motivo'];
        $dia= $datos_cita['dia'];
        $nombre= $datos_cita['nombre'];
        $hora_inicio= $datos_cita['hora_inicio'];
        $hora_final= $datos_cita['hora_fin'];
        $email= $datos_cita['email'];
        $NDepartamento;
        $NMotivo;
        switch ($departamento) {
            case "1":
                $NDepartamento = "Gestión escolar";
                switch($motivo){
                    case "1":
                        $NMotivo= "Reinscripción";
                        break;
                    case "2":
                        $NMotivo= "Trámite recoger boletas y constancias";
                    break;
                    case "3";
                        $NMotivo= "Trámite de reposición de credencial";
                    break;
                    case "4";
                        $NMotivo= "COSIE CTCE";
                    break;
                    case "5";
                        $NMotivo= "COSIE CGC";
                    break;
                    case "6";
                        $NMotivo= "Aclaración de situación académica";
                    break;
                    case "7";
                        $NMotivo= "Certificado parcial";
                    break;
                    case "8";
                        $NMotivo= "Certificado total y carta pasante";
                    break;
                    case "9";
                        $NMotivo= "Baja Temporal";
                    break;
                    case "10";
                        $NMotivo= "Baja definitiva";
                    break;
                    case "11";
                        $NMotivo= "Cambio de programa académico";
                    break;
                    case "12";
                        $NMotivo= "Baja de unidades de aprendizaje";
                    break;
                    case "13";
                        $NMotivo= "Trámite de saberes previamente adquiridos";
                    break;
                    case "14";
                        $NMotivo= "Otro";
                    break;
    
                }
                break;
            case "2":
                $NDepartamento = "Servicios estudiantiles";
                switch($motivo){
                    case "1":
                        $NMotivo= "Recoger carta de no adeudo de libro";
                    break;
                    case "2";
                        $NMotivo= "Recoger oficio de entrega de material bibliográfico";
                    break;
                    case "3";
                        $NMotivo= "Recoger oficio de entrega de tesis o trabajo terminal";
                    break;
                    case "4";
                        $NMotivo= "Otro";
                    break;
                }
                break;
            case "3":
                $NDepartamento = "Servicio médico";
                switch($motivo){
                    case "1":
                        $NMotivo= "Servicio de información de altas y bajas";
                    break;
                    case "2":
                        $NMotivo= "Vigencias";
                    break;
                    case "3":
                        $NMotivo= "Seguros de vida";
                    break;
                    case "4":
                        $NMotivo= "Área de lactancia";
                    break;
                    case "5":
                        $NMotivo= "Consulta médica";
                    break;
                    case "6":
                        $NMotivo= "Otro";
                    break;
                }
                break;
            case "4":
                $NDepartamento = "Orientación juvenil";
                switch($motivo){
                    case "1":
                        $NMotivo= "Consulta individual";
                    break;
                    case "2":
                        $NMotivo= "Atención a padres de familia";
                    break;
                    case "3":
                        $NMotivo= "Otro";
                    break;
                }
                break;
            case "5":
                $NDepartamento = "Extensión y apoyos educativos";
                switch($motivo){
                    case "1":
                        $NMotivo= "Becas";
                    break;
                    case "2":
                        $NMotivo= "Servicio social";
                    break;
                    case "3":
                        $NMotivo= "Movilidad";
                    break;
                    case "4":
                        $NMotivo= "Cultura";
                    break;
                    case "5":
                        $NMotivo= "Deportes";
                    break;
                    case "6":
                        $NMotivo= "Otro";
                    break;
                }
                break;
            case "6":
                $NDepartamento = "Biblioteca";
                switch($motivo){
                    case "1":
                        $NMotivo= "Entregar material bibliográfico";
                    break;
                    case "2":
                        $NMotivo= "Renovar credencial";
                    break;
                    case "3":
                        $NMotivo= "Solicitar un préstamo";
                    break;
                    case "4":
                        $NMotivo= "Regresar material de préstamo";
                    break;
                    case "5":
                        $NMotivo= "Solicitar constancia de no adeudo";
                    break;
                    case "6":
                        $NMotivo= "Otro";
                    break;
                }
                break;
        }
            $razon= 'Su cita fue cancelada por el administrador, ya que ha reservado este horario para otras actividades';
            if(!empty($email)){
                correo_cancelacion($NDepartamento, $NMotivo, $dia, $nombre, $hora_inicio, $hora_final, $email, $razon);
            }
    }
}

function reservar() 
{
    $departamento = $_POST['departamento'];
    $hora_i = $_POST['hora_i'];
    $hora_f = $_POST['hora_f'];
    $dia = $_POST['dia'];
    $name_db;
    switch ($departamento) {
        case "1":
            $name_db = "cita_gestion_escolar";
            break;
        case "2":
            $name_db = "servicios_estudiantiles";
            break;
        case "3":
            $name_db = "servicio_medico";
            break;
        case "4":
            $name_db = "orientación_juvenil";
            break;
        case "5":
            $name_db = "extension_y_apoyos";
            break;
        case "6":
            $name_db = "unidad_politecnica";
            break;
    }

    $link=connect();
    
    //Mandar correos avisando que sus citas quedaron eliminadas
    correos_multiples($name_db, $departamento, $hora_i, $hora_f, $dia);
    $consulta = "DELETE FROM `".$name_db."` WHERE `dia` = '".$dia."' AND ((`hora_inicio` >= '".$hora_i."' AND `hora_inicio` < '".$hora_f."') OR (`hora_fin` > '".$hora_i."' AND `hora_fin` < '".$hora_f."'))";
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    
    $consulta = "INSERT INTO `".$name_db."` (`id`, `motivo`, `dia`, `nombre`, `boleta`, `hora_inicio`, `hora_fin`, `email`) VALUES (NULL, '12345', '".$dia."', '', '', '".$hora_i."', '".$hora_f."', '');";
    $result = mysqli_query($link, $consulta) or die("Error al ejecutar la consulta");
    
    mysqli_close($link);
}