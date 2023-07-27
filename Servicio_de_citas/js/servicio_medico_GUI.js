document.getElementById("signo_pregunta").addEventListener(
  "click",
  function () {
    alert(
      "\nGenerar un código que deberá ser formulado de la siguiente manera: \n➜ Las 𝟯 primeras letras del 𝗽𝗿𝗶𝗺𝗲𝗿 𝗻𝗼𝗺𝗯𝗿𝗲 \n➜ Las 𝟯 primeras letras del 𝗽𝗿𝗶𝗺𝗲𝗿 𝗮𝗽𝗲𝗹𝗹𝗶𝗱𝗼 \n➜ Las 𝟯 primeras letras del 𝘀𝗲𝗴𝘂𝗻𝗱𝗼 𝗮𝗽𝗲𝗹𝗹𝗶𝗱𝗼 \n➜ 𝗙𝗲𝗰𝗵𝗮 𝗱𝗲 𝗻𝗮𝗰𝗶𝗺𝗶𝗲𝗻𝘁𝗼 (DD/MM/AAAA) \n\n𝗘𝗷𝗲𝗺𝗽𝗹𝗼 de código: 𝗖𝗔𝗥𝗠𝗢𝗡𝗟𝗘𝗬𝟭𝟳𝟬𝟳𝟮𝟬𝟬𝟬"
    );
    alert(
      "⚠En caso de: \n ➜Tener un nombre o apellido menor a 3 letras solo poner una o dos letras según sea el caso. \n ➜No tener un segundo apellido omitir estas 3 letras. "
    );
  },
  false
);

var diaSeleccionado;

var lunes;
var martes;
var miercoles;
var jueves;
var viernes;

//Dia y hora limite para poder hacer una cita en ese dia
var limite_lunes;
var limite_martes;
var limite_miercoles;
var limite_jueves;
var limite_viernes;

var hora = moment();
var horaMexico = hora.clone().tz("America/Mexico_City");

/*horaMexico.day(0);
  horaMexico.hour(15);
  horaMexico.minute(59);
  horaMexico.second(0);
  horaMexico.millisecond(0);
  alert(horaMexico.format('MMMM Do YYYY, h:mm:ss a'));*/

var horaCambio = horaMexico.clone();

if (horaMexico.day() > 5) {
  horaCambio.day(7 + 5);
} else {
  horaCambio.day(5);
}

horaCambio.hour(16);
horaCambio.minute(0);
horaCambio.second(0);
horaCambio.millisecond(0);

if (horaCambio.diff(horaMexico, "minutes") <= 0) {
  horaCambio.day(7 + 5);
}

var cambioDia2 = moment();
var cambioDia = cambioDia2.clone().tz("America/Mexico_City");
cambioDia.day(5);
cambioDia.hour(16);
cambioDia.minute(0);
cambioDia.second(0);
cambioDia.millisecond(0);

if (cambioDia.diff(horaMexico, "minutes") <= 0) {
  lunes = cambioDia.clone();
  lunes.day(1 + 7);

  martes = cambioDia.clone();
  martes.day(2 + 7);

  miercoles = cambioDia.clone();
  miercoles.day(3 + 7);

  jueves = cambioDia.clone();
  jueves.day(4 + 7);

  viernes = cambioDia.clone();
  viernes.day(5 + 7);

  GUI_Fecha();
} else {
  lunes = cambioDia.clone();
  lunes.day(1);

  martes = cambioDia.clone();
  martes.day(2);

  miercoles = cambioDia.clone();
  miercoles.day(3);

  jueves = cambioDia.clone();
  jueves.day(4);

  viernes = cambioDia.clone();
  viernes.day(5);

  GUI_Fecha();
}

limite_lunes = dia_limite(lunes.clone());
limite_martes = dia_limite(martes.clone());
limite_miercoles = dia_limite(miercoles.clone());
limite_jueves = dia_limite(jueves.clone());
limite_viernes = dia_limite(viernes.clone());

//alert(horaCambio.format('MMMM Do YYYY, h:mm:ss a'));

function GUI_Fecha() {
  document.getElementById("btn_lunes").innerText =
    "Lunes " + lunes.format("DD/MM/YYYY");
  document.getElementById("btn_martes").innerText =
    "Martes " + martes.format("DD/MM/YYYY");
  document.getElementById("btn_miercoles").innerText =
    "Miércoles " + miercoles.format("DD/MM/YYYY");
  document.getElementById("btn_jueves").innerText =
    "Jueves " + jueves.format("DD/MM/YYYY");
  document.getElementById("btn_viernes").innerText =
    "Viernes " + viernes.format("DD/MM/YYYY");
}

document.getElementById("btn_lunes").addEventListener(
  "click",
  function () {
    if (limite_lunes.diff(horaMexico, "minutes") <= 0) {
      alert(
        "⚠La fecha límite para agendar una cita en este día ya ha sido superada. Recuerde que la fecha límite es a más tardar a las 13:59 hrs del día anterior de la fecha deseada."
      );
      return false;
    }

    document.getElementById("div_botones").style.display = "none";
    document.getElementById("div_datos").style.display = "block";

    diaSeleccionado = lunes.format("YYYY-MM-DD");
    GUI_horario();
  },
  false
);

document.getElementById("btn_martes").addEventListener(
  "click",
  function () {
    if (limite_martes.diff(horaMexico, "minutes") <= 0) {
      alert(
        "⚠La fecha límite para agendar una cita en este día ya ha sido superada. Recuerde que la fecha límite es a más tardar a las 13:59 hrs del día anterior de la fecha deseada."
      );
      return false;
    }

    document.getElementById("div_botones").style.display = "none";
    document.getElementById("div_datos").style.display = "block";

    diaSeleccionado = martes.format("YYYY-MM-DD");
    GUI_horario();
  },
  false
);

document.getElementById("btn_miercoles").addEventListener(
  "click",
  function () {
    if (limite_miercoles.diff(horaMexico, "minutes") <= 0) {
      alert(
        "⚠La fecha límite para agendar una cita en este día ya ha sido superada. Recuerde que la fecha límite es a más tardar a las 13:59 hrs del día anterior de la fecha deseada."
      );
      return false;
    }

    document.getElementById("div_botones").style.display = "none";
    document.getElementById("div_datos").style.display = "block";

    diaSeleccionado = miercoles.format("YYYY-MM-DD");
    GUI_horario();
  },
  false
);

document.getElementById("btn_jueves").addEventListener(
  "click",
  function () {
    if (limite_jueves.diff(horaMexico, "minutes") <= 0) {
      alert(
        "⚠La fecha límite para agendar una cita en este día ya ha sido superada. Recuerde que la fecha límite es a más tardar a las 13:59 hrs del día anterior de la fecha deseada."
      );
      return false;
    }
    document.getElementById("div_botones").style.display = "none";
    document.getElementById("div_datos").style.display = "block";

    diaSeleccionado = jueves.format("YYYY-MM-DD");
    GUI_horario();
  },
  false
);

document.getElementById("btn_viernes").addEventListener(
  "click",
  function () {
    if (limite_viernes.diff(horaMexico, "minutes") <= 0) {
      alert(
        "⚠La fecha límite para agendar una cita en este día ya ha sido superada. Recuerde que la fecha límite es a más tardar a las 13:59 hrs del día anterior de la fecha deseada."
      );
      return false;
    }

    document.getElementById("div_botones").style.display = "none";
    document.getElementById("div_datos").style.display = "block";

    diaSeleccionado = viernes.format("YYYY-MM-DD");
    GUI_horario();
  },
  false
);

var cita = new Cita(DEPARTAMENTO.servicio_medico);

function GUI_horario() {
  cita.get_Horarios_Disponibles();
}

document.getElementById("form").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();

    /****Comprobar que el horario aun este libre ****/
    let xml = new XMLHttpRequest();
    xml.open("POST", "php/citas.php", true);
    let duracion_cita = duracion(
      document.getElementById("motivo").value,
      cita.departamento
    );
    let datos = new FormData();
    datos.append("departamento", cita.departamento);
    datos.append("duracion", duracion_cita);
    datos.append("dia", diaSeleccionado);
    datos.append("hora", document.getElementById("horario").value);
    datos.append("php_num_funcion", "7");
    xml.send(datos);

    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //console.log(xml.responseText);
        const respuesta = JSON.parse(xml.responseText);
        //console.log(respuesta);
        if (respuesta) {
          //Guardar cita
          let xml2 = new XMLHttpRequest();
          xml2.open("POST", "php/citas.php", true);

          let duracion_cita2 = duracion(
            document.getElementById("motivo").value,
            cita.departamento
          );

          const datos2 = new FormData();
          datos2.append("departamento", cita.departamento);
          datos2.append("nombre", document.getElementById("nombre").value);
          datos2.append("boleta", document.getElementById("boleta").value);
          datos2.append("motivo", document.getElementById("motivo").value);
          datos2.append("horario", document.getElementById("horario").value);
          datos2.append("email", document.getElementById("email").value);
          datos2.append("duracion", duracion_cita2);
          datos2.append("dia", diaSeleccionado);
          datos2.append("php_num_funcion", "6");
          xml2.send(datos2);

          xml2.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              console.log(xml2.responseText);
              const respuesta2 = JSON.parse(xml2.responseText);
              if (respuesta2.resultado == "si") {
                alert("La cita se agendó correctamente ");
                location.href = "index.html";
              } else {
                alert("Error al agendar la cita");
              }
            }
          };
        } else {
          var x = document.getElementById("horario");
          x.remove(x.selectedIndex);
          alert(
            "Esa hora ha sido ocupada recientemente, ya se actualizaron los horarios nuevamente."
          );
        }
      }
    };
  },
  false
);

function dia_limite(dia) {
  dia.subtract(1, "days");
  dia.hour(13);
  dia.minute(59);
  dia.second(59);
  dia.millisecond(59);

  return dia;
}

document.getElementById("motivo").addEventListener(
  "change",
  function () {
    document.getElementById("horario").options.length = 0;
    GUI_horario();
  },
  false
);
