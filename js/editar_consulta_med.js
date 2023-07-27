if (sessionStorage.getItem("tipo") === "1") {
    alert(
      "Usted es un usuario administrador, por temas de confidencialidad doctor-paciente no tiene acceso a esta página."
    );
    location.href = "inicio.html";
  }
  var id_consulta = getParameterByName('id_consulta');
 
  //alert(id_consulta);
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

  datitos();
  function datitos() {
    //const id_consulta = document.getElementById("id_consulta").value;
    //alert(id_consulta);
    const xml3 = new XMLHttpRequest();
    xml3.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(xml3.response);
        const respuesta = JSON.parse(xml3.responseText);
        if (JSON.stringify(respuesta) !== "[]") {
          const res = respuesta[0];
          document.getElementById("tension_arterial").value = res.tension_arterial;
          document.getElementById("frecuencia_cardiaca").value = res.frecuencia_cardiaca;
          document.getElementById("frecuencia_respiratoria").value = res.frecuencia_respiratoria;
          document.getElementById("temperatura_corp").value = res.temperatura_corp;
          document.getElementById("oxigeno_sangre").value = res.oxigeno_sangre;
          document.getElementById("glucosa").value = res.glucosa;
          document.getElementById("otros").value = res.otros;
          document.getElementById("padecimiento_actual").value = res.padecimiento_actual;
          document.getElementById("resumen_interrogatorio").value = res.resumen_interrogatorio;
          document.getElementById("resultados_servicios_aux").value = res.resultados_servicios_aux;
          document.getElementById("diagnostico").value = res.diagnostico;
          document.getElementById("tratamiento").value = res.tratamiento;
 
          document.getElementById("id_consulta").value = res.id_consulta;
         
        } else {
          alert("Paciente no encontrado");
        }
      }
    };
    xml3.open("POST", "php/editar_consulta_med.php", true);

    const datos = new FormData();
    datos.append("id_consulta", id_consulta);
    xml3.send(datos);
  }

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
      xml2.open("POST", "php/editar_consulta_med2.php", true);
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

    
    //alert(id_consulta);
    
    

    


    
   /*
   document.getElementById("selecionar").addEventListener(
  "click",
  function () {
   const xml3 = new XMLHttpRequest();
    xml3.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        const respuesta = JSON.parse(xml.responseText);
        if (JSON.stringify(respuesta) !== "[]") {
          const res = respuesta[0];
          document.getElementById("tension_arterial").value = res.tension_arterial;
          document.getElementById("frecuencia_cardiaca").value = res.frecuencia_cardiaca;
          document.getElementById("frecuencia_respiratoria").value = res.frecuencia_respiratoria;
          document.getElementById("temperatura_corp").value = res.temperatura_corp;
          document.getElementById("oxigeno_sangre").value = res.oxigeno_sangre;
          document.getElementById("glucosa").value = res.glucosa;
          document.getElementById("otros").value = res.otros;
          document.getElementById("padecimiento_actual").value = res.padecimiento_actual;
          document.getElementById("resumen_interrogatorio").value = res.resumen_interrogatorio;
          document.getElementById("resultados_servicios_aux").value = res.resultados_servicios_aux;
          document.getElementById("diagnostico").value = res.diagnostico;
          document.getElementById("tratamiento").value = res.tratamiento;
         
          actualizar_GUI();
        } else {
          alert("Paciente no encontrado");
        }
      }
    };
    xml3.open("POST", "php/editar_consulta_med.php", true);

    const datos = new FormData();
    datos.append("id_consulta", id_consulta);
    xml3.send(datos);
    );
  */

