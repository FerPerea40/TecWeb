if (sessionStorage.getItem("tipo") === "1") {
  alert(
    "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

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
            var x = document.getElementById("select");
            var option = document.createElement("option");
            option.text =
              valor.nombre +
              " " +
              valor.Lab_Empresa +
              " " +
              valor.componente_quimico +
              " " +
              valor.concentracion +
              " Cantidad: " +
              valor.Cantidad +
              " Fecha de caducidad:" +
              valor.Fecha_caducidad;
            option.value = valor.Id_bloque;
            x.add(option);

            var input_cantidad = document.getElementById("Cantidad");
            var index = x.selectedIndex;
            input_cantidad.max = respuesta[index].Cantidad;
          });
        } else {
          alert("No hay medicamnetos registrados");
        }
      }
    };
    xml.open("POST", "php/traer_todos_bloques_medicamentos.php", true);
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
        if ((respuesta2.resultado = "si")) {
          alert("El registro fue exitoso");
          location.reload();
        } else {
          alert("El registro no fue exitoso");
        }
      }
    };
    xml2.open("POST", "php/registrar_uso_medicamento.php", true);

    let sel = document.getElementById("select");
    var index = sel.selectedIndex;

    const datos2 = new FormData();
    const cantidad_final =
      respuesta[index].Cantidad - document.getElementById("Cantidad").value;
    datos2.append("Cantidad", cantidad_final);
    datos2.append("Id_bloque", sel.value);
    xml2.send(datos2);
  },
  false
);

document.querySelector("#select").addEventListener(
  "change",
  function (event) {
    var input_cantidad = document.getElementById("Cantidad");
    let sel = document.getElementById("select");
    var index = sel.selectedIndex;

    input_cantidad.max = respuesta[index].Cantidad;
  },
  false
);
