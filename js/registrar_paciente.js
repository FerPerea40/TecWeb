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
    boleta_unica();
  },
  false
);

function boleta_unica() {
  event.preventDefault();
  if (document.getElementById("m_boleta").innerHTML == "Paciente borrado, nombre Expaciente:") {
    alert("Boleta perteneciente a paciente borrado con anterioridad, favor de contactar a un administrador");
  } else if (
    document.getElementById("m_boleta").innerHTML != "Boleta sin registrar"
  ) {
    alert("La boleta ya esta registrada con anterioridad");
    
  } else if(
    document.getElementById("m_nss").innerHTML == "NSS ya registrado"
  ){
    alert("El NSS ya esta registrado con anterioridad");
  }else {
    var resultado2;
    var xml2;
    xml2 = new XMLHttpRequest();
    xml2.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //console.log(xml2.responseText);
        resultado2 = JSON.parse(xml2.responseText);
        terminardo = true;
        const xml = new XMLHttpRequest();
        xml.onreadystatechange = function () {
          if (this.readyState == 4 && this.status == 200) {
            const respuesta = JSON.parse(xml.responseText);
            if ((respuesta.resultado = "si")) {
              alert("El registro fue exitoso");
              location.href = "inicio.html";
            } else {
              alert("El registro no fue exitoso");
            }
          }
        };
        xml.open("POST", "php/registrar_paciente.php", true);

        const datos = document.querySelector("#form_login");
        xml.send(new FormData(datos));
      }
    };
    xml2.open("POST", "php/boleta_unica.php", true);
    datos = new FormData();
    datos.append("boleta", document.getElementById("boleta").value);
    xml2.send(datos);
  }
}
