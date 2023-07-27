cita = new Cita(getDepartameto(sessionStorage.getItem("tipo")));

document.getElementById("form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    if (
      document.getElementById("fecha_f").value <=
      document.getElementById("fecha_i").value
    ) {
      alert("Error: Hora de Inicio es posterior a la hora de Fin.");
    } else {
      cita.reservar();
      alert("El espacio ha sido reservado para usted.");
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
