window.onload = function () {
  document.querySelector("#form_login").addEventListener(
    "submit",
    function (event) {
      event.preventDefault();
      const xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const respuesta = JSON.parse(xml.responseText);
          if (respuesta.resultado == "si") {
            ///Contraseña correcta
            sessionStorage.setItem(
              "usuario",
              document.getElementById("usuario").value
            );
            sessionStorage.setItem("token", respuesta.token);
            sessionStorage.setItem("tipo", respuesta.tipo);
            location.href = "inicio.html";
          } else {
            alert("Usuario y/o contraseña incorrectos");
            document.getElementById("password").value = "";
          }
        }
      };
      xml.open("POST", "php/login.php", true);
      const datos = document.querySelector("#form_login");
      xml.send(new FormData(datos));
    },
    false
  );
};
