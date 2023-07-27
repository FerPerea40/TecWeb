if (sessionStorage.getItem("tipo") == "0") {
    alert(
      "Usted no tiene acceso"
    );
    location.href = "../Orientacion/inicio.html";
  }