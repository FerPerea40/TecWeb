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
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if (respuesta.resultado == "si") {
          alert("El registro fue exitoso");
          location.href = "registrar_medicamento.html";
        } else {
          alert("El registro no fue exitoso");
        }
      }
    };
    xml.open("POST", "php/registrar_medicamento.php", true);

    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);
