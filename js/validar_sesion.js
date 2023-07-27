if (sessionStorage.getItem("tipo") === null) {
  alert("No ha iniciado sesión");
  location.href = "login.html";
}

window.onload = function () {
  if (sessionStorage.getItem("tipo") != null) {
    const tipo = sessionStorage.getItem("tipo");
    document.getElementById("cita").style.display = "none";
    if (tipo === "0") {
      ///Quitar las opciones que no son de un medico
      document.getElementById("medico").style.display = "none";
      document.getElementById("orientador").style.display = "none";
      document.getElementById("consultar_Orientacion").style.display = "none";
      document.getElementById("paciente_Orientacion").style.display = "none";
      document.getElementById("reportes_Orientacion").style.display = "none";

    }else if(tipo == "1"){
      ///Quitar las opciones que no son de un administrador
      document.getElementById("paciente").style.display = "none";
      document.getElementById("consultar").style.display = "none";
      document.getElementById("insumos").style.display = "none";
      document.getElementById("consultar_Orientacion").style.display = "none";
      document.getElementById("paciente_Orientacion").style.display = "none";
    }
    else {
      ///Quitar las opciones que no son del Orientador
      document.getElementById("medico").style.display = "none";
      document.getElementById("orientador").style.display = "none";
      document.getElementById("paciente").style.display = "none";
      document.getElementById("consultar").style.display = "none";
      document.getElementById("insumos").style.display = "none";
      document.getElementById("reportes").style.display = "none";
    }
  }
};
