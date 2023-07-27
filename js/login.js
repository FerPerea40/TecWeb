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
            if (respuesta.tipo == "0") {
              ///Medico
              sessionStorage.setItem("tipo", "0");
              location.href = "inicio.html";
            } else if(respuesta.tipo == "1"){
              sessionStorage.setItem("tipo","1");
              location.href = "inicio.html";
            }else {
              ///Administrador
              sessionStorage.setItem("tipo", "2");
              location.href = "inicio.html";
            }
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
