document.getElementById("pass1").addEventListener(
  "keyup",
  function () {
    event.preventDefault();
    var pass1 = document.getElementById("pass1").value;
    var mensaje = document.getElementById("vPass1");
    if (pass1.length < 8) {
      mensaje.innerHTML =
        "Al menos 8 caracteres; caracteres actuales:" + pass1.length;
    } else {
      mensaje.innerHTML = "";
    }
    var pass2 = document.getElementById("pass2");
    if (pass2.value != "") {
      var validacion;
      validacion = document.getElementById("validacion");
      if (pass1 != pass2.value) {
        validacion.innerHTML = "Las contraseñas no coinciden";
      } else {
        validacion.innerHTML = "Las contraseñas coinciden";
      }
    }
  },
  false
);

document.getElementById("user").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var user = document.getElementById("user").value;
    var mensaje = document.getElementById("m_user");
    if (user.length < 5) {
      mensaje.innerHTML =
        "Al menos 5 caracteres; caracteres actuales:" + user.length;
    } else {
      mensaje.innerHTML = "";
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

document.getElementById("user").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var resultado;
    var xml;
    xml = new XMLHttpRequest();
    var mensaje2 = document.getElementById("usuarioRepetido");
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        resultado = JSON.parse(xml.responseText);
        if (resultado.resultado == "no") {
          mensaje2.innerHTML = "Usuario Repetido";
        } else {
          mensaje2.innerHTML = "";
        }
      }
    };
    xml.open("POST", "php/verificar_usuario.php", true);
    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);

document.getElementById("CEDULA").addEventListener(
  "change",
  function (event) {
    event.preventDefault();
    var resultado;
    var xml;
    xml = new XMLHttpRequest();
    var mensaje2 = document.getElementById("m_ced");
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        resultado = JSON.parse(xml.responseText);
        if (resultado.resultado == "no") {
          mensaje2.innerHTML = "Cedula profesional ya registrada";
        } else {
          mensaje2.innerHTML = "Cedula correcta";
        }
      }
    };
    xml.open("POST", "php/verificar_ced.php", true);
    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);
