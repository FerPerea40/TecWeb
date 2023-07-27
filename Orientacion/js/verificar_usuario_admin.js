if (sessionStorage.getItem("tipo") != "1") {
    alert(
      "Usted no tiene acceso"
    );
    location.href = "../Orientacion/inicio.html";
  }