const DEPARTAMENTO = {
  gestion_escolar: 1,
  servicios_estudiantiles: 2,
  servicio_medico: 3,
  orientacion_juvenil: 4,
  extension_y_Apoyos: 5,
  UPIS: 6, //Biblioteca
};

class Cita {
  constructor(departamento) {
    this.departamento = departamento;
  }

  set_hora_inicio_departamento(hora) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);
    const datos = new FormData();
    datos.append("hora", hora);
    datos.append("departamento", this.departamento);
    datos.append("php_num_funcion", "1");
    xml.send(datos);
  }

  get_hora_inicio_departamento() {
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);

    const datos = new FormData();
    datos.append("departamento", this.departamento);
    datos.append("php_num_funcion", "2");
    xml.send(datos);
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //console.log(xml.responseText);
        const respuesta = JSON.parse(xml.responseText);
        if (!respuesta.error) {
          document.getElementById("fecha_i").value = respuesta.hora;
        } else {
          alert("Ocurrió un error inesperado al traer la hora de entrada.");
        }
      }
    };
  }

  set_hora_fin_departamento(hora) {
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);

    const datos = new FormData();
    datos.append("hora", hora);
    datos.append("departamento", this.departamento);
    datos.append("php_num_funcion", "3");
    xml.send(datos);
  }

  get_hora_fin_departamento() {
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);

    const datos = new FormData();
    datos.append("departamento", this.departamento);
    datos.append("php_num_funcion", "4");
    xml.send(datos);

    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if (!respuesta.error) {
          document.getElementById("fecha_f").value = respuesta.hora;
        } else {
          alert("Ocurrió un error inesperado al traer la hora de salida.");
        }
      }
    };
  }

  get_Horarios_Disponibles() {
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);
    //let diaSeleccionado = "2020-09-17"; // Esto es una dato de prueba, este valor se debe obtener segun el boton que se presiono
    let duracion_cita = duracion(
      document.getElementById("motivo").value,
      this.departamento
    );
    let separaciones = separacion(this.departamento);
    let datos = new FormData();
    datos.append("departamento", this.departamento);
    datos.append("duracion", duracion_cita);
    datos.append("dia", diaSeleccionado);
    datos.append("separaciones", separaciones);
    datos.append("php_num_funcion", "5");
    xml.send(datos);

    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(xml.responseText);
        const respuesta = JSON.parse(xml.responseText);
        console.log(respuesta);
        if (JSON.stringify(respuesta) !== "[]") {
          respuesta.forEach(function (valor, indice, array) {
            var x = document.getElementById("horario");
            var option = document.createElement("option");
            let hora = new Date(valor.date);
            let string_hora = cade_hora(hora);
            option.text = string_hora;
            option.value = string_hora;
            x.add(option);
          });
        } else {
          alert("No hay horas disponibles");
        }
      }
    };
  }

  get_Citas() {
    let depa = this.departamento;
    let actualizar = this;
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);
    let datos = new FormData();
    datos.append("departamento", this.departamento);
    datos.append("dia", document.getElementById("fecha").value);
    datos.append("php_num_funcion", "8");
    xml.send(datos);

    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //console.log(xml.responseText);
        const respuesta = JSON.parse(xml.responseText);
        //console.log(respuesta);
        if (JSON.stringify(respuesta) !== "[]") {
          tablaCitas(respuesta);
          var botones = document.querySelectorAll(".btn_citas");
          for (var i = 0; i < botones.length; i++) {
            botones[i].addEventListener(
              "click",
              function () {
                //Eliminar cita
                let id_cita = this.id;
                let xml2 = new XMLHttpRequest();
                xml2.open("POST", "php/citas.php", true);

                const datos2 = new FormData();
                datos2.append("id", id_cita);
                datos2.append("departamento", depa);
                datos2.append("php_num_funcion", "9");
                xml2.send(datos2);

                alert("Se eliminó la cita correctamente.");
                actualizar.get_Citas();
              },
              false
            );
          }

          var botones = document.querySelectorAll(".btn_citas2");
          for (var i = 0; i < botones.length; i++) {
            botones[i].addEventListener(
              "click",
              function () {
                //Ocupar cita
                let id_cita = this.id;
                let xml2 = new XMLHttpRequest();
                xml2.open("POST", "php/citas.php", true);

                const datos2 = new FormData();
                datos2.append("id", id_cita);
                datos2.append("departamento", depa);
                datos2.append("php_num_funcion", "10");
                xml2.send(datos2);

                alert("Se marcó como espacio ocupado.");
                actualizar.get_Citas();
              },
              false
            );
          }
        } else {
          alert("Aún no se han reservado citas en este día.");
          document.getElementById("resultados").innerHTML = "";
        }
      }
    };
  }

  reservar() {
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);
    const datos = new FormData();
    datos.append("hora_i", document.getElementById("fecha_i").value);
    datos.append("hora_f", document.getElementById("fecha_f").value);
    datos.append("dia", document.getElementById("fecha").value);
    datos.append("departamento", this.departamento);
    datos.append("php_num_funcion", "11");
    xml.send(datos);
  }
}

function duracion(motivo, departamento) {
  switch (departamento) {
    case 1:
      return 3///Gestion escolar
    case 2:
      return 10;
    case 3:
      if (motivo == "5") {
        return 30;
      } else {
        return 15;
      }
    case 4:
      return 45;
    case 5:
      return 5; ///Extension y apoyos
    case 6:
      return 15;
  }
}

function separacion(departamento) {
  switch (departamento) {
    case 1:
      return 3; /// Gestion escolar 
    case 2:
      return 10;
    case 3:
      return 15;
    case 4:
      return 45;
    case 5:
      return 5;/// Extension y apoyos
    case 6:
      return 15;
  }
}

function cade_hora(hora) {
  let resultado;
  if (hora.getHours() < 10) {
    resultado = "0" + hora.getHours() + ":";
  } else {
    resultado = "" + hora.getHours() + ":";
  }

  if (hora.getMinutes() < 10) {
    resultado += "0" + hora.getMinutes();
  } else {
    resultado += "" + hora.getMinutes();
  }

  return resultado;
}

function tablaCitas(data) {
  document.getElementById("resultados").innerHTML = "";
  var tabla = document.createElement("table");
  var tblBody = document.createElement("tbody");

  var hilera = document.createElement("tr");

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Nombre");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Boleta");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Motivo");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Hora de Inicio");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Hora de fin");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Eliminar cita");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Marcar como ocupado");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  tblBody.appendChild(hilera);
  //alert(data.length);
  var tam = data.length;
  for (var i = 0; i < tam; i++) {
    var hilera = document.createElement("tr");

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].nombre);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].boleta);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(get_motivo(data[i].motivo));
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].hora_inicio.substr(0, 5));
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].hora_fin.substr(0, 5));
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    const button = document.createElement("button");
    button.type = "button";
    button.className = "btn_citas";
    button.innerText = "Eliminar cita";
    button.id = data[i].id;

    var celda = document.createElement("td");
    celda.appendChild(button);
    hilera.appendChild(celda);

    const button2 = document.createElement("button");
    button2.type = "button";
    button2.className = "btn_citas2";
    button2.innerText = "Marcar ocupado";
    button2.id = data[i].id;

    var celda = document.createElement("td");
    celda.appendChild(button2);
    hilera.appendChild(celda);

    tblBody.appendChild(hilera);
  }

  // posiciona el <tbody> debajo del elemento <table>
  tabla.appendChild(tblBody);
  // appends <table> into <body>
  document.getElementById("resultados").appendChild(tabla);
  // modifica el atributo "border" de la tabla y lo fija a "2";
  tabla.setAttribute("border", "2");
  tabla.className = "tabla_medicamento";
}

function get_motivo(num_motivo) {
  let dep = getDepartameto(sessionStorage.getItem("tipo"));
  switch (dep) {
    case 1: //Gestion
      switch (num_motivo) {
        case "1":
          return "Reinscripción";
        case "2":
          return "Trámite recoger boletas y constancias";
        case "3":
          return "Trámite de reposición de credencial";
        case "4":
          return "COSIE CTCE";
        case "5":
          return "COSIE CGC";
        case "6":
          return "Aclaración de situación académica";
        case "7":
          return "Certificado parcial";
        case "8":
          return "Certificado total y carta pasante";
        case "9":
          return "Baja Temporal";
        case "10":
          return "Baja definitiva";
        case "11":
          return "Cambio de programa académico";
        case "12":
          return "Baja de unidades de aprendizaje";
        case "13":
          return "Trámite de saberes previamente adquiridos";
        case "14":
          return "Otro";
        case "12345":
          return "Este momento ha sido reservado por usted";
      }

    case 2: //Servicios estudiantiles
      switch (num_motivo) {
        case "1":
          return "Recoger carta de no adeudo de libro";
        case "2":
          return "Recoger oficio de entrega de material bibliográfico";
        case "3":
          return "Recoger oficio de entrega de tesis o trabajo terminal";
        case "4":
          return "Otro";
        case "12345":
          return "Este momento ha sido reservado por usted ";
      }
    case 3: //Servicio Medico
      switch (num_motivo) {
        case "1":
          return "Servicio de información de altas y bajas";
        case "2":
          return "Vigencias";
        case "3":
          return "Seguros de vida";
        case "4":
          return "Área de lactancia";
        case "5":
          return "Consulta médica";
        case "6":
          return "Otro";
        case "12345":
          return "Este momento ha sido reservado por usted";
      }
    case 4: //Orientacion
      switch (num_motivo) {
        case "1":
          return "Consulta individual";
        case "2":
          return "Atención a padres de familia";
        case "3":
          return "Otro";
        case "12345":
          return "Este momento ha sido reservado por usted ";
      }
    case 5: //Extencion y apoyos
      switch (num_motivo) {
        case "1":
          return "Becas";
        case "2":
          return "Servicio social";
        case "3":
          return "Movilidad";
        case "4":
          return "Cultura";
        case "5":
          return "Deportes";
        case "6":
          return "Otro";
        case "12345":
          return "Este momento ha sido reservado por usted ";
      }
    case 6: //Biblioteca
      switch (num_motivo) {
        case "1":
          return "Entregar material bibliográfico";
        case "2":
          return "Renovar credencial";
        case "3":
          return "Solicitar un préstamo";
        case "4":
            return "Regresar material de préstamo";
        case "5":
            return "Solicitar constancia de no adeudo";
        case "6":
            return "Otro";            
        case "12345":
          return "Este momento ha sido reservado por usted ";
      }
  }
}

function getDepartameto(tipo) {
  //Devuelve el departamento segun el tipo se usuarios
  switch (tipo) {
    case "0":
      return 3;
      break;

    case "2":
      return 4;
      break;

    case "3":
      return 1;
      break;

    case "4":
      return 2;
      break;

    case "5":
      return 5;
      break;

    case "6":
      return 6;
      break;
  }
}
