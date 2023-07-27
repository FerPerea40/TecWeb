document.getElementById("selecionar").addEventListener(
  "click",
  function () {
    const boleta = document.getElementById("boleta").value;
    const xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if (JSON.stringify(respuesta) !== "[]") {
          const res = respuesta[0];
          document.getElementById("boleta2").value = res.boleta;
          document.getElementById("nombre").value = res.nombres;
          document.getElementById("p_apellido").value = res.pa;
          document.getElementById("s_apellido").value = res.sa;
          document.getElementById("fecha").value = res.fecha;
          document.getElementById("sexo").value = res.sexo;
          document.getElementById("TEL").value = res.tel;
          document.getElementById("TEL_EMERGENCIA").value = res.tel_e;
          document.getElementById("NOM_TEL_EMERGENCIA").value =res.contacto_e;
          document.getElementById("tipo_paciente").value = res.tipo;
          document.getElementById("academia").value = res.academia;
          document.getElementById("carrera").value = res.carrera;
          document.getElementById("id_paciente").value = res.id_paciente;
          document.getElementById("")
          actualizar_GUI();
        } else {
          alert("Paciente no encontrado");
        }
      }
    };
    xml.open("POST", "php/editar_paciente.php", true);

    const datos = new FormData();
    datos.append("boleta", boleta);
    xml.send(datos);
  },
  false
);

document.querySelector("#form_login").addEventListener(
  "submit",
  function (event) {
    event.preventDefault();

    var resultado2;
    var xml2;
    xml2 = new XMLHttpRequest();
    xml2.onreadystatechange = function () {
      event.preventDefault();
      if (this.readyState == 4 && this.status == 200) {
        //console.log(xml2.responseText);
        resultado2 = JSON.parse(xml2.responseText);
        terminardo = true;
        if (
          resultado2.resultado == "no" &&
          document.getElementById("boleta2").value !=
            document.getElementById("boleta").value
        ) {
          alert("Boleta repetida");
        } else {
          const xml = new XMLHttpRequest();
          xml.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
              const respuesta = JSON.parse(xml.responseText);
              if ((respuesta.resultado = "si")) {
                alert("El registro fue exitoso");
                location.href = "inicio.html";
              } else {
                alert("El registro no fue exitoso");
              }
            }
          };
          xml.open("POST", "php/editar_paciente2.php", true);

          const datos = document.querySelector("#form_login");
          xml.send(new FormData(datos));
        }
      }
    };

    xml2.open("POST", "php/boleta_unica.php", true);
    datos = new FormData();
    datos.append("boleta", document.getElementById("boleta2").value);
    xml2.send(datos);
  },
  false
);

function actualizar_GUI() {
  ///Habilitar opciones unicas de Academia, carrera, parte Grafica.
  if (document.getElementById("tipo_paciente").value === "1") {
    document.getElementById("carrera").style.display = "block";
    document.getElementById("text_carrera").style.display = "block";

    document.getElementById("academia").style.display = "none";
    document.getElementById("text_academia").style.display = "none";
  } else if (document.getElementById("tipo_paciente").value === "2") {
    document.getElementById("academia").style.display = "block";
    document.getElementById("text_academia").style.display = "block";

    document.getElementById("carrera").style.display = "none";
    document.getElementById("text_carrera").style.display = "none";
  } else {
    document.getElementById("academia").style.display = "none";
    document.getElementById("carrera").style.display = "none";
    document.getElementById("text_academia").style.display = "none";
    document.getElementById("text_carrera").style.display = "none";
  }
}
