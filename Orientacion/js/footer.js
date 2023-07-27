const xml = new XMLHttpRequest();
xml.open("POST", "../Orientacion/php/footer.php", true);
xml.send();

xml.onreadystatechange = function () {
  if (this.readyState == 4 && this.status == 200) {
    const respuesta = xml.responseText;
    document.getElementById("footer_text").append(respuesta);
  }
};
