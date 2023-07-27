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
    var resultado2;
    var xml2;
    xml2 = new XMLHttpRequest();
    xml2.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(xml2.responseText);
        resultado2 = JSON.parse(xml2.responseText);
        console.log(resultado2);
        document.getElementById("form_login").style.display = "none";

        var parrafo25 = document.createElement("p");

        parrafo25.className = "text_form";
        document.getElementById("resultados").appendChild(parrafo25);

        text_sin_vigencia =
          " Fecha: <br> <select class='input' name='fecha' id='fecha' required>";

        resultado2.forEach(function (valor, indice, array) {
          text_sin_vigencia +=
            "<option value='" +
            valor.id_consulta +
            " '>" +
            valor.fecha +
            " </option>";
        });
        text_sin_vigencia +=
          "</select> <br>" +
          "<input type='submit' class='btn_submit' value='Enviar'  id='enviar'/>";

        var parrafo26 = document.createElement("p");
        parrafo26.innerHTML = text_sin_vigencia;
        parrafo26.className = "text_form";
        document.getElementById("resultados").appendChild(parrafo26);

        document.getElementById("enviar").addEventListener(
          "click",
          function () {
            //alert(document.getElementById("fecha").options.length);
            if (document.getElementById("fecha").options.length == 0) {
              alert("Este paciente no tiene consultas registradas");
            } else {
              //Ir a pagina para modificar consultas
              location.href =
                "editar_consulta_orient.html?id_consulta=" +
                document.getElementById("fecha").value;
            }
          },
          false
        );
      }
    };

    xml2.open("POST", "../Orientacion/php/ver_consultas.php", true);
    //alert(document.getElementById('boleta').value);
    datos = new FormData();
    datos.append("boleta", document.getElementById("boleta").value);
    xml2.send(datos);
  },
  false
);
