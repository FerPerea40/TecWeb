//Listener al enviar formulario, para hacer la Peticion para agregar el paciente a la Base de datos.
document.querySelector("#form_reg_paciente").addEventListener("submit", function(){
    event.preventDefault();
    var respuesta;
    var xml = new XMLHttpRequest();
    xml.onreadystatechange = function(){
        if (this.readyState == 4 && this.status == 200){
            respuesta = JSON.parse(xml.responseText);
            if(respuesta.resultado= "si"){
                alert("Registro exitoso");
            }else{
                alert("Falla en el registro");
            }
        }
    }
    xml.open("POST", "../Orientacion/php/registrar_paciente_orientacion.php", true);
    const datos = document.querySelector("#form_reg_paciente");
    xml.send(new FormData(datos));
    
}, false);
//Modificaciones visuales en la pagina, Para la seleccion del tipo de paciente.
document.getElementById("academia").style.display = "none";
document.getElementById("text_academia").style.display = "none";
document.querySelector("#tipo_paciente").addEventListener(
    "change",
    function (event) {
      if (event.target.value === "1") {
        document.getElementById("carrera").style.display = "block";
        document.getElementById("text_carrera").style.display = "block";
  
        document.getElementById("academia").style.display = "none";
        document.getElementById("text_academia").style.display = "none";
      } else if (event.target.value === "2") {
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
    },
    false
  );