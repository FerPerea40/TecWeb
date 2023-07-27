document.getElementById("fecha_i").style.display = "none";
document.getElementById("fecha_f").style.display = "none";
document.getElementById("text_fecha_i").style.display = "none";
document.getElementById("text_fecha_f").style.display = "none";

document.getElementById("tipo_reporte").addEventListener(
  "change",
  function (event) {
    if (event.target.value === "medicamentos") {
      document.getElementById("fecha_i").style.display = "none";
      document.getElementById("fecha_f").style.display = "none";

      document.getElementById("text_fecha_i").style.display = "none";
      document.getElementById("text_fecha_f").style.display = "none";

      document.getElementById("fecha_i").required = false;
      document.getElementById("fecha_f").required = false;
    } else if (event.target.value === "consultas") {
      document.getElementById("fecha_i").style.display = "block";
      document.getElementById("fecha_f").style.display = "block";

      document.getElementById("text_fecha_i").style.display = "block";
      document.getElementById("text_fecha_f").style.display = "block";

      document.getElementById("fecha_i").required = true;
      document.getElementById("fecha_f").required = true;
    }
  },
  false
);
