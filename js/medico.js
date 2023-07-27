if (sessionStorage.getItem("tipo") === "0") {
  alert(
    "Usted es un usuario tipo médico, por lo cual no tiene acceso a esta página."
  );
  location.href = "inicio.html";
}
