if (sessionStorage.getItem("tipo") === null) {
  alert("No ha iniciado sesión");
  location.href = "login.html";
}else if(sessionStorage.getItem("tipo") === "1"){
  alert("No tiene acceso al sistema de citas");
  location.href = "login.html";
} else {
  const xml = new XMLHttpRequest();
  xml.open("POST", "php/validar_token.php", true);
  const datos = new FormData();
  datos.append("token", sessionStorage.getItem("token"));
  xml.send(datos);
  xml.onreadystatechange = function () {
    if (this.readyState == 4 && this.status == 200) {
      const respuesta = JSON.parse(xml.responseText);
      let cantidad = respuesta["COUNT(`token`)"];
      if (cantidad == "0") {
        sessionStorage.clear();
        alert("No ha iniciado sesión");
        location.href = "login.html";
      }
    }
  };
}
