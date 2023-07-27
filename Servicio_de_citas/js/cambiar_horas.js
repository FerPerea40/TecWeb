cita = new Cita(getDepartameto(sessionStorage.getItem("tipo")));
cita.get_hora_inicio_departamento();
cita.get_hora_fin_departamento();

var hora_cambio_i;
var hora_cambio_f;
var hora = moment();
var horaMexico = hora.clone().tz("America/Mexico_City");

var hora_cambio_f = horaMexico.clone();
hora_cambio_f.day(5);
hora_cambio_f.hour(16);
hora_cambio_f.minute(0);
hora_cambio_f.second(0);
hora_cambio_f.millisecond(0);

var hora_cambio_i = horaMexico.clone();
hora_cambio_i.day(4);
hora_cambio_i.hour(13);
hora_cambio_i.minute(59);
hora_cambio_i.second(59);
hora_cambio_i.millisecond(59);

document.getElementById("form_login").addEventListener(
  "submit",
  function () {
    event.preventDefault();
    if (
      document.getElementById("fecha_f").value <=
      document.getElementById("fecha_i").value
    ) {
      alert("Error: Hora de entrada es posterior a la hora de salida.");
    } else if (!is_hora_para_cambiar()) {
      alert(
        "No es momento para cambiar la hora de entrada y salida, debido a que puede haber citas ya asignadas en ese horario.\nEl momento adecuado para cambiar la hora de entrada y salida es el jueves después de las 14 hrs hasta el viertes antes de las 16 hrs."
      );
    } else {
      cita.set_hora_inicio_departamento(
        document.getElementById("fecha_i").value
      );
      cita.set_hora_fin_departamento(document.getElementById("fecha_f").value);
      alert("Se guardó correctamente");
    }
  },
  false
);

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

function is_hora_para_cambiar() {
  return horaMexico.isBefore(hora_cambio_f) && horaMexico.isAfter(hora_cambio_i);
}
