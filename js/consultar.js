if (sessionStorage.getItem("tipo") === "1") {
  alert(
    "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

document.getElementById("fecha").innerText =
  "Fecha de hoy: " + new Date().toLocaleDateString();

document.getElementById("selecionar").addEventListener(
  "click",
  function () {
    if(document.getElementById("m_boleta").innerHTML == "Paciente borrado, nombre Expaciente:"){
      alert("Paciente no encontrado");
    }else{
    const boleta = document.getElementById("boleta").value;
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if (JSON.stringify(respuesta) !== "[]") {
          const res = respuesta[0];
          document.getElementById("masa").value = res.masa;
          document.getElementById("altura").value = res.altura;
          calcularEdad(res.fecha);
        } else {
          alert("Paciente no encontrado");
        }
      }
    };
    xml.open("POST", "php/editar_paciente.php", true);

    const datos = new FormData();
    datos.append("boleta", boleta);
    xml.send(datos);
  }
  },
  false
);

function calcularEdad(fecha) {
  var hoy = new Date();
  var cumpleanos = new Date(fecha);
  var edad = hoy.getFullYear() - cumpleanos.getFullYear();
  var m = hoy.getMonth() - cumpleanos.getMonth();

  if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
    edad--;
  }
  document.getElementById("edad").innerHTML = "Edad: " + edad + " años";
}

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    const xml2 = new XMLHttpRequest();
    xml2.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        let respuesta2 = JSON.parse(xml2.responseText);
        if (respuesta2.resultado == "si") {
          alert("El registro fue exitoso");
          location.href = "inicio.html";
        } else {
          alert("El registro no fue exitoso");
        }
      }
    };
    xml2.open("POST", "php/consultar.php", true);

    let date = new Date();
    let fecha_hoy;
    let day = date.getDate();
    let month = date.getMonth() + 1;
    let year = date.getFullYear();

    if (month < 10) {
      fecha_hoy = `${year}-0${month}-${day}`;
    } else {
      fecha_hoy = `${year}-${month}-${day}`;
    }
    //alert(fecha_hoy);

    const datos2 = document.querySelector("#form_login");
    data = new FormData(datos2);
    data.append("fecha", fecha_hoy);
    data.append("boleta", document.getElementById("boleta").value);
    data.append("usuario", sessionStorage.getItem("usuario"));
    xml2.send(data);
  },
  false
);

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
