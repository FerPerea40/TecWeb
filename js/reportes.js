document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    if (
      document.getElementById("fecha_i").value >
      document.getElementById("fecha_f").value
    ) {
      alert("Error: La fecha de inicio es mas reciente que la final");
    } else {
      var resultado2;
      var xml2;
      xml2 = new XMLHttpRequest();
      xml2.onreadystatechange = function () {
        event.preventDefault();
        if (this.readyState == 4 && this.status == 200) {
          console.log(xml2.responseText);
          resultado2 = JSON.parse(xml2.responseText);
          console.log(resultado2);

          if (
            document.getElementById("tipo_reporte").value === "medicamentos"
          ) {
            cambiar_gui();
            reporte_medicamentos(resultado2);
          } else {
            var fecha_i;
            var fecha_f;

            fecha_i = document.getElementById("fecha_i").value;
            fecha_f = document.getElementById("fecha_f").value;
            cambiar_gui();
            let agregar = "<br>";
            agregar +=
              "<embed src='Generar_Reportes_PDF/Reporte_Pacientes.php?fecha1=" +
              fecha_i +
              "&fecha2=" +
              fecha_f +
              "' width='90%' height='900' type='application/pdf'>";
            document.getElementById("resultados").innerHTML = agregar;
          }
        }
      };

      if (document.getElementById("tipo_reporte").value === "medicamentos") {
        //alert('Medicamentos');
        xml2.open("POST", "php/medicamentos.php", true);
        xml2.send();
      } else {
        //alert('vigencias');
        xml2.open("POST", "php/reporte.php", true);
        var fecha_inicial;
        var fecha_final;

        fecha_inicial = document.getElementById("fecha_i").value;
        fecha_final = document.getElementById("fecha_f").value;

        datos = new FormData();
        datos.append("fecha_inicial", fecha_inicial);
        datos.append("fecha_final", fecha_final);
        xml2.send(datos);
      }
    }
  },
  false
);

function cambiar_gui() {
  document.getElementById("form_login").style.display = "none";
  document.getElementById("content").className = "container2";
}

function reporte_medicamentos(data) {
  var tabla = document.createElement("table");
  var tblBody = document.createElement("tbody");

  var hilera = document.createElement("tr");

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Nombre");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Compuesto químico");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Concentración");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Cantidad");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Fecha de caducidad");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  var celda = document.createElement("td");
  var textoCelda = document.createTextNode("Empresa o Laboratorio");
  celda.appendChild(textoCelda);
  hilera.appendChild(celda);

  tblBody.appendChild(hilera);
  //alert(data.length);
  var tam = data.length;
  for (var i = 0; i < tam; i++) {
    var hilera = document.createElement("tr");

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].nombre);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].componente_quimico);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].concentracion);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].Cantidad);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].Fecha_caducidad);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    var celda = document.createElement("td");
    var textoCelda = document.createTextNode(data[i].Lab_Empresa);
    celda.appendChild(textoCelda);
    hilera.appendChild(celda);

    tblBody.appendChild(hilera);
  }

  // posiciona el <tbody> debajo del elemento <table>
  tabla.appendChild(tblBody);
  // appends <table> into <body>
  document.getElementById("resultados").appendChild(tabla);
  // modifica el atributo "border" de la tabla y lo fija a "2";
  tabla.setAttribute("border", "2");
  tabla.className = "tabla_medicamento";

  const button = document.createElement("button");
  button.type = "button";
  button.className = "btn_submit";
  button.innerText = "Ordenado alfabéticamente";
  button.id = "btn_1";

  const button2 = document.createElement("button");
  button2.type = "button";
  button2.className = "btn_submit";
  button2.innerText = "Ordenado por fecha de caducidad";
  button2.id = "btn_2";

  document.getElementById("resultados").innerHTML +=
    "<h2><span> Generar PDFs </span></h2>";
  document.getElementById("resultados").appendChild(button);
  document.getElementById("resultados").innerHTML += "<br>";
  document.getElementById("resultados").appendChild(button2);

  document.getElementById("btn_1").addEventListener(
    "click",
    function () {
      window.open('Generar_Reportes_PDF/Reporte_Medicamentos_Alfabetico.php', '_blank');
    },
    false
  );

  document.getElementById("btn_2").addEventListener(
    "click",
    function () {
      window.open('Generar_Reportes_PDF/Reporte_Medicamentos.php', '_blank');
    },
    false
  );
}
