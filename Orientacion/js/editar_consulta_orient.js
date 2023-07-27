if (sessionStorage.getItem("tipo") === "1") {
    alert(
      "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
    );
    location.href = "inicio.html";
  }
  
  document.getElementById("fecha").innerText =
    "Fecha de hoy: " + new Date().toLocaleDateString();
    
  function calcularEdad(fecha) {
    var hoy = new Date();
    var cumpleanos = new Date(fecha);
    var edad = hoy.getFullYear() - cumpleanos.getFullYear();
    var m = hoy.getMonth() - cumpleanos.getMonth();
  
    if (m < 0 || (m === 0 && hoy.getDate() < cumpleanos.getDate())) {
      edad--;
    }
    document.getElementById("edad").innerHTML = "Edad: " + edad + " años";
  }

  var id_consulta = getParameterByName('id_consulta');
  mostrar();
 

  document.querySelector("#form_login").addEventListener(
    "submit",
    function (event) {
      event.preventDefault();
      const xml2 = new XMLHttpRequest();
      xml2.onreadystatechange = function () {
        if (this.readyState == 4 && this.status == 200) {
          let respuesta2 = JSON.parse(xml2.responseText);
          if (respuesta2.resultado == "si") {
            alert("El registro fue exitoso");
            location.href = "inicio.html";
          } else {
            alert("El registro no fue exitoso");
          }
        }
      };
      xml2.open("POST", "../Orientacion/php/editar_consulta_orient2.php", true);
  
  
  
      const datos2 = document.querySelector("#form_login");
      data = new FormData(datos2);
        xml2.send(data);
     
    },
    false
  );
  
  function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

  function mostrar() {
   const xml3 = new XMLHttpRequest();
    xml3.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml3.responseText);
         if (JSON.stringify(respuesta) !== "[]") {
          const res = respuesta[0];
          document.getElementById("Tipo_atencion").value = res.tipo_atenc;
          document.getElementById("nombre_1").value = res.Nom_asis1;
          document.getElementById("TEL_1").value = res.Tel_asis1;
          document.getElementById("nombre_2").value = res.Nom_asis2;
          document.getElementById("TEL_2").value = res.Tel_asis2;
          document.getElementById("rela").value = res.Relac;
          document.getElementById("anotaciones").value = res.Anota;
          document.getElementById("conclusiones").value = res.Conclu;
          document.getElementById("id_consulta").value = res.id_consulta;
        } else {
          alert("Paciente no encontrado");
        }
      }
    };
    xml3.open("POST", "../Orientacion/php/editar_consulta_orient.php", true);

    const datos = new FormData();
    datos.append("id_consulta", id_consulta);
    xml3.send(datos);
  }

