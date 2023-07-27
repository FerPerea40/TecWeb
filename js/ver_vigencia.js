if (sessionStorage.getItem("tipo") === "1") {
  alert(
    "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

var id_paciente = "";
document.getElementById("dato").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var mensaje = document.getElementById("m_dato");
    var mensaje2 = document.getElementById("mensaje");
    var xml;
    xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if(respuesta.borrar==1){
          mensaje.innerHTML = "Paciente borrado, nombre Expaciente:";
          mensaje2.innerHTML = "" + respuesta.nombre;
          id_paciente = respuesta.id;
        }else if (respuesta.resultado == "si") {
          mensaje.innerHTML = "Paciente encontrado:";
          mensaje2.innerHTML = "" + respuesta.nombre;
          id_paciente = respuesta.id;
        } else {
          mensaje.innerHTML = "Paciente no encontrado";
          mensaje2.innerHTML = "";
        }
      }
    };
    xml.open("POST", "php/verificar_existencia_paciente.php", true);

    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);

document.getElementById("ver").addEventListener(
  "click",
  function (event) {
    event.preventDefault();
    if (document.getElementById("m_dato").innerHTML != "Paciente encontrado:") {
      alert("Paciente no encontrado");
    } else {
      var xml;
      xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const respuesta = JSON.parse(xml.responseText);
          if (respuesta.vigencia == "no") {
            alert("Este paciente no tiene vigencia de derechos");
          } else {
            document.getElementById("visor_archivos").innerHTML =
              '<embed src="php/' +
              respuesta.directorio +
              '" type="application/pdf" width="1100" height="480" />';
          }
        }
      };
      xml.open("POST", "php/ver_vigencia.php", true);
      const datos = document.querySelector("#form_login");
      xml.send(new FormData(datos));
    }
  },
  false
);
