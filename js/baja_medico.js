if (sessionStorage.getItem("tipo") === "0") {
  alert(
    "Usted es un usuario tipo médico, por lo cual no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}

iniciar();
function iniciar() {
  var resultado;
  var xml;
  xml = new XMLHttpRequest();
  $select = document.getElementById("select");
  xml.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      resultado = JSON.parse(xml.responseText);
      for (let i = $select.options.length; i >= 1; i--) {
        $select.remove(i);
      }
      for (i = 1; i <= resultado[0]; i++) {
        var option = document.createElement("option");
        option.value = resultado[i];
        option.text = resultado[i];
        $select.appendChild(option);
      }
    }
  };
  xml.open("POST", "php/revision_usuariosMed.php", true);
  const datos = document.querySelector("#form_login");
  xml.send(new FormData(datos));
}

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    if (document.getElementById("select").value != "0") {
      var option = document.getElementById("select").value;
      var xml;
      xml = new XMLHttpRequest();
      xml.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          const respuesta = JSON.parse(xml.responseText);
          if (respuesta.resultado == "Correcto") {
            alert("Médico dado de baja");
            location.href = "baja_medico.html";
          } else {
            alert("Error al dar baja");
          }
        }
      };
      xml.open("POST", "php/baja_medico.php", true);
      const datos = document.querySelector("#form_login");
      xml.send(new FormData(datos));
    } else {
      alert("No se ha seleccionado ningun médico");
    }
  },
  false
);
