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
        }
        else if (respuesta.resultado == "si") {
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

document.getElementById("file").addEventListener(
  "change",
  function (event) {
    event.preventDefault();
    var mensaje = document.getElementById("m_file");
    var archivo = document.getElementById("file");
    var ruta = archivo.value;
    var extpermitida = /(.pdf)$/i;
    if (!extpermitida.exec(ruta)) {
      mensaje.innerHTML = "Extención no permitida";
      archivo.value = "";
    } else {
      mensaje.innerHTML = "";
    }
  },
  false
);

document.getElementById("subir").addEventListener(
  "click",
  function (event) {
    event.preventDefault();
    if (document.getElementById("m_dato").innerHTML != "Paciente encontrado:") {
      alert("El paciente no se encontro");
    }else if (document.getElementById("m_file").innerHTML != "") {
      alert("Formato no soportado");
    } else if (document.getElementById("file").value == "") {
      alert("No se ha seleccionado ningun archivo");
    } else {
      var mensaje = document.getElementById("mensaje");
      var xml;
      xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const respuesta = JSON.parse(xml.responseText);
          if (respuesta.resultado == "Correcto") {
            if (respuesta.eliminado == "si") {
              alert("La vigencia anterior ha sido sustituida");
            }
            alert("Vigencia subida con exito");
            location.href = "subir_vigencia.html";
          } else {
            alert("Fallo al subir la vigencia");
          }
        }
      };
      xml.open("POST", "php/subir_vigencia.php", true);

      const datos = document.querySelector("#form_login");
      xml.send(new FormData(datos));
    }
  },
  false
);
