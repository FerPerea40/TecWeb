if (sessionStorage.getItem("tipo") === "0") {
  alert(
    "Usted es un usuario tipo médico, por lo cual no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    if (document.getElementById("m_ced").innerHTML != "Cedula correcta") {
      alert("La Cedula ingresada ya fue registrada anteriormente");
    } else if (
      document.getElementById("validacion").innerHTML !=
        "Las contraseñas coinciden" ||
      document.getElementById("vPass1").innerHTML != "" ||
      document.getElementById("m_user").innerHTML != "" ||
      document.getElementById("usuarioRepetido").innerHTML != ""
    ) {
      alert("Error en los datos de Usuario");
    } else {
      var xml;
      xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const respuesta = JSON.parse(xml.responseText);
          if (respuesta.resultado == "si") {
            alert("El registro fue exitoso");
            location.href = "registrar_medico.html";
          } else {
            alert("El registro no fue exitoso");
          }
        }
      };
      xml.open("POST", "php/registrar_medico.php", true);
      const datos = document.querySelector("#form_login");
      xml.send(new FormData(datos));
    }
  },
  false
);
