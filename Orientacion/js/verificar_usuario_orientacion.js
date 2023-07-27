if (sessionStorage.getItem("tipo") != "2") {
    alert(
      "Usted no tiene acceso"
    );
    location.href = "../Orientacion/inicio.html";
  }