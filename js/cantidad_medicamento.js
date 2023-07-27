if (sessionStorage.getItem("tipo") === "1") {
  alert(
    "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

var respuesta;

window.addEventListener(
  "load",
  function () {
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        respuesta = JSON.parse(xml.responseText);
        console.log(respuesta);
        if (JSON.stringify(respuesta) !== "[]") {
          respuesta.forEach(function (valor, indice, array) {
            //console.log("En el índice " + indice + " hay este valor: " + valor.nombre);
            var x = document.getElementById("select");
            var option = document.createElement("option");
            option.text =
              valor.nombre +
              " " +
              valor.Lab_Empresa +
              " " +
              valor.componente_quimico +
              " " +
              valor.concentracion;
            option.value = valor.Id_Mat_Med;
            x.add(option);
          });
        } else {
          alert("No hay medicamnetos registrados");
        }
      }
    };
    xml.open("POST", "php/traer_todos_medicamentos.php", true);
    xml.send();
  },
  false
);

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    const xml2 = new XMLHttpRequest();
    xml2.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        //console.log(xml2.responseText);
        let respuesta2 = JSON.parse(xml2.responseText);
        if (respuesta2.resultado == "si") {
          alert("El registro fue exitoso");
          location.href = "cantidad_medicamento.html";
        } else {
          alert("El registro no fue exitoso");
        }
      }
    };
    xml2.open("POST", "php/cantidad_medicamento.php", true);

    const datos2 = document.querySelector("#form_login");
    xml2.send(new FormData(datos2));
  },
  false
);
