document.querySelector("#form_login").addEventListener(
  "submit",
  function () {
    event.preventDefault();
    const pass1 = document.getElementById("pass1").value;
    const pass2 = document.getElementById("pass2").value;
    if (pass1 === pass2) {
      const xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const respuesta = JSON.parse(xml.responseText);
          if (respuesta.resultado == "si") {
            alert("Actualización de la contraseña fue exitosa");
            location.href = "inicio.html";
          } else {
            alert("Actualización de la contraseña no fue exitosa");
          }
        }
      };
      xml.open("POST", "php/contrasena.php", true);

      const datos = new FormData();
      datos.append("username", sessionStorage.getItem("usuario"));
      datos.append("pass", pass1);
      xml.send(datos);
    } else {
      alert("Entradas distintas.");
      document.getElementById("pass1").value = "";
      document.getElementById("pass2").value = "";
    }
  },
  false
);

document.getElementById("pass2").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var validacion;
    validacion = document.getElementById("validacion");
    var pass1 = document.getElementById("pass1");
    var pass2 = document.getElementById("pass2");
    if (pass1.value != pass2.value) {
      validacion.innerHTML = "Las contraseñas no coinciden";
    } else {
      validacion.innerHTML = "Las contraseñas coinciden";
    }
  },
  false
);
