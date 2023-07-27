document.getElementById("form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    if (
      document.getElementById("fecha_i").value >
      document.getElementById("fecha_f").value
    ) {
      alert("Error: La fecha de inicio es mas reciente que la final");
    } else {
      switch (getDepartameto(sessionStorage.getItem("tipo"))) {
        case 1:
          window.open(
            "../Generar_Reportes_PDF/Reporte_Citas_Gestion_escolar.php?fecha1=" +
              document.getElementById("fecha_i").value +
              "&fecha2=" +
              document.getElementById("fecha_f").value,
            "_blank"
          );

          break;

        case 2:
          window.open(
            "../Generar_Reportes_PDF/Reporte_Citas_Servicios_estudiantiles.php?fecha1=" +
              document.getElementById("fecha_i").value +
              "&fecha2=" +
              document.getElementById("fecha_f").value,
            "_blank"
          );
          break;

        case 3:
          window.open(
            "../Generar_Reportes_PDF/Reporte_Citas_Servicio_medico.php?fecha1=" +
              document.getElementById("fecha_i").value +
              "&fecha2=" +
              document.getElementById("fecha_f").value,
            "_blank"
          );
          break;

        case 4:
          window.open(
            "../Generar_Reportes_PDF/Reporte_Citas_Orientacion_juvenil.php?fecha1=" +
              document.getElementById("fecha_i").value +
              "&fecha2=" +
              document.getElementById("fecha_f").value,
            "_blank"
          );
          break;

        case 5:
          window.open(
            "../Generar_Reportes_PDF/Reporte_Citas_Extension_apoyo.php?fecha1=" +
              document.getElementById("fecha_i").value +
              "&fecha2=" +
              document.getElementById("fecha_f").value,
            "_blank"
          );
          break;

        case 6:
          window.open(
            "../Generar_Reportes_PDF/Reporte_Citas_Unidad_politecnica.php?fecha1=" +
              document.getElementById("fecha_i").value +
              "&fecha2=" +
              document.getElementById("fecha_f").value,
            "_blank"
          );
          break;
      }
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
