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
      window.open(
        "../Generar_Reportes_PDF/Reporte_Consultas_orient.php?fecha1=" +
          document.getElementById("fecha_i").value+"&fecha2="+document.getElementById("fecha_f").value,
        "_blank"
      );
    }
  },
  false
);
