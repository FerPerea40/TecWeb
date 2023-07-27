if (sessionStorage.getItem("tipo") === "1") {
  alert(
    "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    const boleta = document.getElementById("boleta").value;
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if (JSON.stringify(respuesta) !== "[]") {
          //alert("Si encontrado");
          borrar();
        } else {
          alert("Paciente no encontrado");
        }
      }
    };
    xml.open("POST", "php/editar_paciente.php", true);

    const datos = new FormData();
    datos.append("boleta", boleta);
    xml.send(datos);
  },
  false
);

function borrar() {
  if(document.getElementById("m_boleta").innerHTML== "Paciente borrado, nombre Expaciente:"){
    alert("El paciente se encuentra eliminado");
  }
  else{
  const boleta = document.getElementById("boleta").value;
  const xml2 = new XMLHttpRequest();
  xml2.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const respuesta2 = JSON.parse(xml2.responseText);
      if (respuesta2.resultado == "si") {
        alert("La baja fue exitosa");
        location.href = "baja_paciente.html";
      } else {
        alert("La baja no fue exitosa");
      }
    }
  };
  xml2.open("POST", "php/baja_paciente.php", true);

  const datos = new FormData();
  datos.append("boleta", boleta);
  xml2.send(datos);
}
}

document.getElementById("boleta").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var mensaje = document.getElementById("m_boleta");
    var mensaje2 = document.getElementById("m2_boleta");
    var xml;
    xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(xml.responseText);
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
          mensaje.innerHTML = "Boleta sin registrar";
          mensaje2.innerHTML = "";
        }
      }
    };
    xml.open("POST", "php/verificar_boleta_reg.php", true);

    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);
