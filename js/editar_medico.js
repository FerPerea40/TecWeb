if (sessionStorage.getItem("tipo") === "0") {
  alert(
    "Usted es un usuario tipo médico, por lo cual no tiene acceso a esta página. "
  );
  location.href = "inicio.html";
}
var user;
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

document.getElementById("seleccionado").addEventListener(
  "click",
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
            user = respuesta.user;
            document.getElementById("Nom_med").value = respuesta.Nom_med;
            document.getElementById("Ape_pat").value = respuesta.Ape_pat;
            document.getElementById("Ape_mat").value = respuesta.Ape_mat;
            document.getElementById("F_nacimiento").value =
              respuesta.F_nacimiento;
            document.getElementById("Sexo").value = respuesta.Sexo;
            document.getElementById("CURP").value = respuesta.CURP;
            document.getElementById("Ced_prof").value = respuesta.Ced_prof;
            document.getElementById("Tel_per").value = respuesta.Tel_per;
            document.getElementById("Tel_emer").value = respuesta.Tel_emer;
          }
        }
      };
      xml.open("POST", "php/editar_medico_p1.php", true);
      const datos = document.querySelector("#form_login");
      xml.send(new FormData(datos));
    } else {
      alert("No se ha seleccionado ningun médico");
    }
  },
  false
);

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();
    document.getElementById("select").value = user;
    var xml;
    xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(xml.responseText);
        const respuesta = JSON.parse(xml.responseText);
        if (respuesta.resultado == "Correcto") {
          alert("La informacion fue actualizada correctamente");
          location.href = "editar_medico.html";
        }
      }
    };
    xml.open("POST", "php/editar_medico_p2.php", true);
    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);
