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
document.getElementById("boleta").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var mensaje = document.getElementById("m_boleta");
    var mensaje2 = document.getElementById("m2_boleta");
    var xml;
    xml = new XMLHttpRequest();
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        console.log(xml.responseText);
        const respuesta = JSON.parse(xml.responseText);
        if (respuesta.borrar == 1) {
          mensaje.innerHTML = "Paciente borrado, nombre Expaciente:";
          mensaje2.innerHTML = "" + respuesta.nombre;
          id_paciente = respuesta.id;
        } else if (respuesta.resultado == "si") {
          mensaje.innerHTML = "Paciente encontrado:";
          mensaje2.innerHTML = "" + respuesta.nombre;
          id_paciente = respuesta.id;
        } else {
          mensaje.innerHTML = "Boleta sin registrar";
          mensaje2.innerHTML = "";
        }
      }
    };
    xml.open("POST", "php/verificar_boleta_reg.php", true);

    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);

document.getElementById("nss").addEventListener(
  "keyup",
  function (event) {
    event.preventDefault();
    var resultado;
    var xml;
    xml = new XMLHttpRequest();
    var mensaje2 = document.getElementById("m_nss");
    xml.onreadystatechange = function () {
      if (this.readyState == 4 && this.status == 200) {
        resultado = JSON.parse(xml.responseText);
        if (resultado.resultado == "no") {
          mensaje2.innerHTML = "NSS ya registrado";
        } else {
          mensaje2.innerHTML = "NSS correcto";
        }
      }
    };
    xml.open("POST", "php/verificar_nss.php", true);
    const datos = document.querySelector("#form_login");
    xml.send(new FormData(datos));
  },
  false
);

document.getElementById("signo_pregunta").addEventListener(
  "click",
  function () {
    alert(
      "\nEl código de trabajador deberá ser formulado de la siguiente manera: \n➜ Las 𝟯 primeras letras del 𝗽𝗿𝗶𝗺𝗲𝗿 𝗻𝗼𝗺𝗯𝗿𝗲 \n➜ Las 𝟯 primeras letras del 𝗽𝗿𝗶𝗺𝗲𝗿 𝗮𝗽𝗲𝗹𝗹𝗶𝗱𝗼 \n➜ Las 𝟯 primeras letras del 𝘀𝗲𝗴𝘂𝗻𝗱𝗼 𝗮𝗽𝗲𝗹𝗹𝗶𝗱𝗼 \n➜ 𝗙𝗲𝗰𝗵𝗮 𝗱𝗲 𝗻𝗮𝗰𝗶𝗺𝗶𝗲𝗻𝘁𝗼 (DD/MM/AAAA) \n\n𝗘𝗷𝗲𝗺𝗽𝗹𝗼 de código de empleado: 𝗖𝗔𝗥𝗠𝗢𝗡𝗟𝗘𝗬𝟭𝟳𝟬𝟳𝟮𝟬𝟬𝟬"
    );
    alert(
      "⚠En caso de: \n ➜Tener un nombre o apellido menor a 3 letras solo poner una o dos letras según sea el caso. \n ➜No tener un segundo apellido omitir estas 3 letras. "
    );
  },
  false
);
